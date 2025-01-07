<?php

namespace frontend\controllers;

use backend\models\Linhacarrinho;
use common\models\CarrinhoCompras;
use common\models\Entregas;
use common\models\Fatura;
use common\models\Metodopagamento;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarrinhoComprasController implements the CRUD actions for CarrinhoCompras model.
 */
class CarrinhoComprasController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all CarrinhoCompras models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!\Yii::$app->user->isGuest) {
            $carrinho = CarrinhoCompras::find()
                ->where([
                    'user_id' => \Yii::$app->user->id,
                    'estado' => 'ativo'
                ])
                ->orderBy(['data' => SORT_DESC]) //
                ->one();

            if ($carrinho !== null) {
                // Encontrar todas as linhas de carrinho associadas a esse carrinho
                $linhasCarrinho = \common\models\LinhaCarrinho::find()
                    ->where(['carrinho_id' => $carrinho->id])
                    ->all();

                return $this->render('index', [
                    'linhasCarrinho' => $linhasCarrinho,
                    'model' => $carrinho,
                ]);
            } else {

                return $this->render('pagina-sem-carrinho');
            }
        } else {
            // O usuário não está logado, redirecione para a página de login ou mostre uma mensagem de erro
            return $this->redirect(['site/login']);
        }
    }


    public function actionCheckout()
    {
        // Verifica se o usuário está logado
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $metodo = Metodopagamento::find()->all();

        // Obtém o carrinho "ativo" do usuário logado
        $carrinho = CarrinhoCompras::find()
            ->where(['user_id' => Yii::$app->user->id, 'estado' => 'ativo'])
            ->one();

        // Se o carrinho não existir ou estiver vazio, redireciona o usuário
        if ($carrinho === null) {
            Yii::$app->session->setFlash('info', 'Seu carrinho está vazio.');
            return $this->redirect(['site/index']); // Redireciona para uma página apropriada
        }

        // Obtém as linhas do carrinho para listar os itens no checkout
        $linhasCarrinho = \common\models\Linhacarrinho::find()
            ->where(['carrinho_id' => $carrinho->id])
            ->all();

        $user = Yii::$app->user->identity;

        // Renderiza a página de checkout, passando as linhas do carrinho
        return $this->render('checkout', [
            'linhasCarrinho' => $linhasCarrinho,
            'carrinho' => $carrinho,
            'user' => $user,
            'metodos' => $metodo
        ]);
    }


    public function actionFinalizar()
    {
        // Receber os dados do formulário
        $request = Yii::$app->request;

        // Verifica se o método é POST
        if ($request->isPost) {
            // Obter o usuário logado
            $user = Yii::$app->user->identity;

            // Verifica se o usuário está logado
            if (!$user) {
                Yii::$app->session->setFlash('error', 'Você precisa estar logado para finalizar a compra.');
                return $this->redirect(['site/login']);
            }

            // Obter o carrinho associado ao usuário logado
            $carrinho = CarrinhoCompras::find()
                ->where(['user_id' => $user->id, 'estado' => 'ativo'])
                ->one();

            if (!$carrinho) {
                Yii::$app->session->setFlash('error', 'O carrinho está vazio ou não foi encontrado.');
                return $this->redirect(['site/checkout']);
            }

            // Verificar se o método de pagamento foi selecionado
            $metodoPagamentoID = $request->post('metodoPagamento_id');
            if (!$metodoPagamentoID) {
                Yii::$app->session->setFlash('error', 'Por favor, selecione um método de pagamento.');
                return $this->redirect(['site/checkout']);
            }

            // Criar uma nova instância da model "Encomenda"
            $encomenda = new Entregas();

            // Verificar se o endereço de cobrança é o mesmo que o de envio
            $mesmoEndereco = $request->post('mesmoEndereco', true); // "true" se a checkbox estiver marcada
            Yii::$app->session->setFlash('endereço', 'Valor de mesmoEndereco: ' . ($mesmoEndereco ? 'true' : 'false'));

            if ($mesmoEndereco) {
                // Usar os dados do perfil do usuário
                $perfil = $user->profile;
                if (!$perfil) {
                    Yii::$app->session->setFlash('error', 'Erro ao carregar os dados do perfil do usuário.');
                    return $this->redirect(['site/checkout']);
                }

                $encomenda->nome = $perfil->nome;
                $encomenda->morada = $perfil->morada;
                $encomenda->cidade = $perfil->cidade;
                $encomenda->contacto = $perfil->contacto;
                $encomenda->codPostal = $perfil->codPostal;
            } else {
                // Usar os dados do formulário de endereço de envio
                $encomenda->nome = $request->post('nomeEnvio');
                $encomenda->morada = $request->post('enderecoEnvio');
                $encomenda->cidade = $request->post('cidadeEnvio');
                $encomenda->contacto = $request->post('contactoEnvio');
                $encomenda->codPostal = $request->post('codpostalEnvio');
            }

            // Criar uma nova instância da model "Fatura"
            $fatura = new Fatura();
            $fatura->data = date('Y-m-d H:i:s'); // Data da fatura
            $fatura->user_id = $user->id; // Usuário logado
            $fatura->metodoPagamento_id = $metodoPagamentoID;
            $fatura->carrinho_id = $carrinho->id; // Relacionar a fatura ao carrinho

            // Salvar a fatura
            if (!$fatura->save()) {
                Yii::$app->session->setFlash('error', 'Erro ao criar a fatura. Verifique os dados.');
                Yii::debug($fatura->errors); // Log dos erros
                return $this->redirect(['site/checkout']);
            }

            // Preencher os outros dados da encomenda
            $encomenda->estado = 'Por entregar'; // Estado inicial da encomenda
            $encomenda->data = date('Y-m-d H:i:s'); // Data atual
            $encomenda->carrinho_id = $carrinho->id; // Relacionar a encomenda ao carrinho

            // Salvar a encomenda
            if ($encomenda->save()) {
                // Atualizar o estado do carrinho para "finalizado"
                $carrinho->estado = 'finalizado';
                if (!$carrinho->save()) {
                    Yii::$app->session->setFlash('error', 'Erro ao atualizar o estado do carrinho.');
                    Yii::debug($carrinho->errors); // Log dos erros
                    return $this->redirect(['site/checkout']);
                }

                // Iterar pelas linhas do carrinho e descontar o estoque
                foreach ($carrinho->linhacarrinhos as $linha) {
                    $produto = $linha->artigo; // Supondo que a linha do carrinho tem a relação com o produto
                    if ($produto) {
                        $produto->stock -= $linha->quantidade; // Desconta a quantidade comprada

                        if (!$produto->save()) {
                            // Caso falhe ao salvar o produto (descontar o estoque)
                            Yii::$app->session->setFlash('error', 'Erro ao atualizar o estoque do produto: ' . $produto->nome);
                            Yii::debug($produto->errors); // Log dos erros
                            return $this->redirect(['site/checkout']);
                        }
                    }
                }

                // Redireciona para a página de confirmação
                return $this->redirect(['carrinho-compras/confirmacao']);
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao salvar a encomenda.');
                Yii::debug($encomenda->errors); // Log dos erros
            }
        }

        // Caso o método não seja POST ou algo falhe
        Yii::$app->session->setFlash('error', 'Erro ao processar o pedido. Tente novamente.');
        return $this->redirect(['site/checkout']);
    }




    public function actionConfirmacao(){

        return $this->render('confirmacao');


    }




    public function actionAtualizarQuantidade()
    {
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $itemId = $request->post('itemId');
            $newQuantity = $request->post('newQuantity');

            // Verifica se o item existe e pertence ao carrinho do usuário
            $item = \common\models\Linhacarrinho::findOne($itemId);
            if ($item && $newQuantity > 0) {
                $item->quantidade = $newQuantity;
                $item->valorTotal = $item->valor * $newQuantity;

                if ($item->save()) {
                    // Atualiza o carrinho com o novo total
                    $carrinho = Carrinhocompras::findOne(['user_id' => \Yii::$app->user->id, 'estado' => 'ativo']);
                    if ($carrinho) {
                        $carrinho->valorIva = $carrinho->getTotalIva();
                        $carrinho->valorTotal = $carrinho->getTotalValue();
                        $carrinho->save();

                        \Yii::$app->session->setFlash('success', 'Quantidade atualizada com sucesso.');
                    }
                } else {
                    \Yii::$app->session->setFlash('error', 'Erro ao salvar a nova quantidade.');
                }
            } else {
                \Yii::$app->session->setFlash('error', 'Item não encontrado ou quantidade inválida.');
            }
        }

        return $this->redirect(['carrinho-compras/index']); // Redireciona de volta ao carrinho
    }

    public function actionRemover()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $id = $request->post('id'); // ID do artigo que desejamos remover

            if (!Yii::$app->user->isGuest) {
                // Obter o carrinho ativo do usuário
                $carrinho = Carrinhocompras::find()
                    ->where([
                        'user_id' => Yii::$app->user->id,
                        'estado' => 'ativo'
                    ])
                    ->andWhere(['not', ['estado' => 'finalizado']])
                    ->one();

                if ($carrinho == null) {
                    Yii::$app->session->setFlash('error', 'Carrinho não encontrado.');
                    return $this->redirect(['artigo/index']);
                }

                // Encontrar a linha do carrinho correspondente ao item
                $linhaCarrinho = \common\models\Linhacarrinho::find()
                    ->where([
                        'carrinho_id' => $carrinho->id,
                        'artigo_id' => $id
                    ])
                    ->one();

                if ($linhaCarrinho) {
                    // Remover a linha do carrinho (item do carrinho)
                    if ($linhaCarrinho->delete()) {
                        $carrinho->valorIva = $carrinho->getTotalIva();
                        $carrinho->valorTotal = $carrinho->getTotalValue();
                        $carrinho->save();

                        Yii::$app->session->setFlash('success', 'Artigo removido do carrinho com sucesso.');
                    } else {
                        Yii::$app->session->setFlash('error', 'Erro ao remover o artigo do carrinho.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Artigo não encontrado no carrinho.');
                }

                return $this->redirect(['carrinho-compras/index']);
            } else {
                return $this->redirect(['site/login']);
            }
        }
    }



    /**
     * Displays a single CarrinhoCompras model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CarrinhoCompras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CarrinhoCompras();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CarrinhoCompras model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CarrinhoCompras model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CarrinhoCompras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CarrinhoCompras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CarrinhoCompras::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
