<?php

namespace frontend\controllers;

use backend\models\Linhacarrinho;
use common\models\CarrinhoCompras;
use common\models\Entregas;
use common\models\Fatura;
use common\models\Metodopagamento;
use common\models\Precoentrega;
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
        // Verifica se o usuário está logado
        if (!\Yii::$app->user->isGuest) {
            $user = \Yii::$app->user->identity;

            // Obtém o carrinho ativo do usuário
            $carrinho = CarrinhoCompras::find()
                ->where([
                    'user_id' => $user->id,
                    'estado' => 'ativo'
                ])
                ->orderBy(['data' => SORT_DESC])
                ->one();

            if ($carrinho !== null) {
                // Encontrar todas as linhas de carrinho associadas a esse carrinho
                $linhasCarrinho = \common\models\LinhaCarrinho::find()
                    ->where(['carrinho_id' => $carrinho->id])
                    ->all();

                // Obtém o endereço do usuário (supondo que seja um campo no modelo User)
                $moradaCliente = $user->profile->morada;  // Substitua 'endereco' com o campo correto do modelo User

                // Passa os dados para a view
                return $this->render('index', [
                    'linhasCarrinho' => $linhasCarrinho,
                    'model' => $carrinho,

                ]);
            } else {
                return $this->render('pagina-sem-carrinho');
            }
        } else {
            // O usuário não está logado, redireciona para a página de login
            return $this->redirect(['site/login']);
        }
    }




/*

    function geocodeEndereco($endereco)
    {
        $endereco = urlencode($endereco); // Codifica o endereço para a URL
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$endereco}&key=AIzaSyDcXQfDRy6fgC5G0JOcM_XCOZCq_V90Hyk"; // Substitua sua chave de API

        $response = file_get_contents($url); // Fazendo a requisição para a API
        $data = json_decode($response, true); // Decodificando a resposta em JSON

        if (isset($data['results'][0])) {
            // Retorna a latitude e longitude da primeira resposta encontrada
            $latitude = $data['results'][0]['geometry']['location']['lat'];
            $longitude = $data['results'][0]['geometry']['location']['lng'];
            return [$latitude, $longitude];
        }

        return null; // Retorna null se não conseguir geocodificar o endereço
    }

*/
   /* private function calcularDistancia($lat_empresa, $lon_empresa, $moradaCliente)
    {
        $coordenadas = $this->geocodeEndereco($moradaCliente);

        if ($coordenadas !== null) {
            $lat_cliente = $coordenadas[0];
            $lon_cliente = $coordenadas[1];

            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$lat_empresa},{$lon_empresa}&destinations={$lat_cliente},{$lon_cliente}&key=AIzaSyDcXQfDRy6fgC5G0JOcM_XCOZCq_V90Hyk";

            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if ($data['status'] == 'OK') {
                $distancia = $data['rows'][0]['elements'][0]['distance']['value'];
                return $distancia / 1000; // Retorna em quilômetros
            }
        }

        return 0;
    }*/


    public function actionCheckout()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $metodosEnvio = \common\models\Metodoenvio::find()->all();
        $carrinho = CarrinhoCompras::findOne(['user_id' => Yii::$app->user->id, 'estado' => 'ativo']);

        if (!$carrinho) {
            Yii::$app->session->setFlash('info', 'Seu carrinho está vazio.');
            return $this->redirect(['site/index']);
        }

        $linhasCarrinho = \common\models\Linhacarrinho::findAll(['carrinho_id' => $carrinho->id]);
        $user = Yii::$app->user->identity;

        if (Yii::$app->request->isPost) {
            $dadosCheckout = Yii::$app->request->post();

            if (isset($dadosCheckout['primeiroNome'], $dadosCheckout['endereco'], $dadosCheckout['envio_id'],   $dadosCheckout['cidade'], $dadosCheckout['cep'])) {
                Yii::$app->session->set('dadosEntrega', $dadosCheckout);
                return $this->redirect(['carrinho-compras/pagamento']);
            } else {
                Yii::$app->session->setFlash('error', 'Por favor, preencha todos os campos obrigatórios.');
            }

        }

        return $this->render('checkout', [
            'linhasCarrinho' => $linhasCarrinho,
            'carrinho' => $carrinho,
            'user' => $user,
            'metodosEnvio' => $metodosEnvio
        ]);
    }

    public function actionAtualizarTotal()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Tente obter os dados com getBodyParams()
        $data = Yii::$app->request->getBodyParams();

        // Se estiver vazio, use file_get_contents
        if (empty($data)) {
            $data = json_decode(file_get_contents('php://input'), true);
        }

        Yii::error($data, __METHOD__); // Registra os dados recebidos para debug

        // Verifica se as chaves existem
        if (!isset($data['envio_id']) || !isset($data['novo_total'])) {
            return [
                'success' => false,
                'message' => 'Dados incompletos',
                'data_recebido' => $data
            ];
        }

        $envioId = $data['envio_id'];
        $novoTotal = $data['novo_total'];

        $carrinho = CarrinhoCompras::findOne(['user_id' => Yii::$app->user->id, 'estado' => 'ativo']);
        if ($carrinho) {
            $carrinho->envio_id = $envioId;
            // Atenção: verifique se o atributo do seu modelo é 'valorTotal' ou 'valor_total'
            $carrinho->valorTotal = $novoTotal;
            if (!$carrinho->save(false)) {
                Yii::error($carrinho->getErrors(), __METHOD__);
                return ['success' => false, 'errors' => $carrinho->getErrors()];
            }
        } else {
            return ['success' => false, 'message' => 'Carrinho não encontrado.'];    }
        return ['success' => true];}






    /*    private function calcularPrecoEntrega($distancia)
        {
            // Buscar a faixa de distância na base de dados
            $faixa = PrecoEntrega::find()
                ->where(['<=', 'distancia_min', $distancia])
                ->andWhere(['>=', 'distancia_max', $distancia])
                ->one();

            // Retorna o preço da entrega
            return $faixa ? $faixa->preco : 0;
        }*/






    public function actionPagamento()
    {
        $dadosEntrega = Yii::$app->session->get('dadosEntrega');
        $metodos = Metodopagamento::find()->all();


        Yii::$app->session->set('dadosEntrega', [
            'primeiroNome' => Yii::$app->request->post('primeiroNome'),
            'cidade' => Yii::$app->request->post('cidade'),
            'endereco' => Yii::$app->request->post('endereco'),
            'cep' => Yii::$app->request->post('cep'),
            'envio_id' => Yii::$app->request->post('envio_id'),
        ]);

        if (!$dadosEntrega) {
            Yii::$app->session->setFlash('error', 'Dados de entrega não encontrados. Por favor, preencha o formulário de checkout novamente.');
            return $this->redirect(['carrinho-compras/checkout']);
        }

        return $this->render('pagamento', [
            'dadosEntrega' => $dadosEntrega,
            'metodos' => $metodos,
        ]);
    }


    public function actionFinalizar()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            Yii::$app->session->setFlash('error', 'Você precisa estar logado para finalizar a compra.');
            return $this->redirect(['site/login']);
        }

        $carrinho = CarrinhoCompras::findOne(['user_id' => $user->id, 'estado' => 'ativo']);

        if (!$carrinho) {
            Yii::$app->session->setFlash('error', 'O carrinho está vazio ou não foi encontrado.');
            return $this->redirect(['carrinho-compras/checkout']);
        }

        $metodoPagamentoID = Yii::$app->request->post('metodoPagamento_id');
        if (!$metodoPagamentoID) {
            Yii::$app->session->setFlash('error', 'Por favor, selecione um método de pagamento.');
            return $this->redirect(['carrinho-compras/pagamento']);
        }


        $dadosEntrega = Yii::$app->session->get('dadosEntrega');


        $encomenda = new Entregas([
            'nome' => $dadosEntrega['primeiroNome'],
            'morada' => $dadosEntrega['endereco'],
            'cidade' => $dadosEntrega['cidade'] ?? '',
            'codPostal' => $dadosEntrega['cep'],
            'estado' => 'Por entregar',
            'data' => date('Y-m-d H:i:s'),
            'carrinho_id' => $carrinho->id,
            'user_id' => $user->id,
            'envio_id' => $dadosEntrega['envio_id']
        ]);

        $fatura = new Fatura([
            'data' => date('Y-m-d H:i:s'),
            'user_id' => $user->id,
            'metodoPagamento_id' => $metodoPagamentoID,
            'carrinho_id' => $carrinho->id
        ]);

        if ($fatura->save() && $encomenda->save()) {
            $carrinho->estado = 'finalizado';

            if ($carrinho->save()) {
                foreach ($carrinho->linhacarrinhos as $linha) {
                    $produto = $linha->artigo;

                    if ($produto) {
                        $produto->stock -= $linha->quantidade;

                        if (!$produto->save()) {
                            Yii::$app->session->setFlash('error', 'Erro ao atualizar o estoque do produto: ' . $produto->nome);
                            return $this->redirect(['carrinho-compras/checkout']);
                        }
                    }
                }

                Yii::$app->session->remove('dadosEntrega');
                return $this->redirect(['carrinho-compras/confirmacao']);
            }
        }

        Yii::$app->session->setFlash('error', 'Erro ao finalizar a encomenda.');
        return $this->redirect(['carrinho-compras/checkout']);
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
