<?php

namespace backend\controllers;

use backend\models\Compras;
use backend\models\Fornecedor;
use backend\models\Linhafaturafornecedor;
use common\models\Artigos;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComprasController implements the CRUD actions for Compras model.
 */
class ComprasController extends Controller
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
     * Lists all Compras models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Compras::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Compras model.
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
     * Creates a new Compras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        $model = new Compras();

        // Define a data atual
        $model->data = date('Y-m-d'); // Ajuste o formato conforme necessário

        // Define o estado inicial como 'Em Lançamento'
        $model->estado = 'Em Lançamento';

        // Salva o modelo automaticamente assim que a ação é chamada
        if ($model->save()) {
            // Redireciona para a página de visualização do registro recém-criado
            return $this->redirect(['formulario', 'id' => $model->id]);
        }

        // Caso o salvamento falhe (por exemplo, erro de validação), renderiza o formulário
        return $this->render('create', [
            'model' => $model,

        ]);
    }




    public function actionFormulario($id)
    {
        $model = Compras::findOne($id);

        $linhas = Linhafaturafornecedor::find()
            ->where(['faturafornecedor_id' => $model->id])
            ->all();



        if (!$model) {
            throw new NotFoundHttpException('A compra solicitada não foi encontrada.');
        }

        // Verificar se há um fornecedor pesquisado
        $fornecedores = [];
        if ($this->request->get('fornecedores_id')) {
            $fornecedores = Fornecedor::find()
                ->where(['id' => $this->request->get('fornecedores_id')])
                ->all();
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $fornecedorId = $this->request->post('fornecedores_id');
            if ($fornecedorId) {
                $model->fornecedores_id = $fornecedorId;
            }

            if ($model->save()) {
                return $this->redirect(['compras/formulario', 'id' => $model->id]);
            }
        }

        return $this->render('formulario', [
            'model' => $model,
            'fornecedores' => $fornecedores, // Passando os fornecedores encontrados
            'linhas' => $linhas
        ]);
    }


    public function actionSearch($id)
    {
        // Verifica se o ID foi passado corretamente
        if (!$id) {
            throw new NotFoundHttpException('ID da compra não encontrado.');
        }

        // Busca todos os fornecedores
        $fornecedores = Fornecedor::find()->all();
        $model = Compras::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('A compra solicitada não foi encontrada.');
        }

        return $this->render('searchFornecedor', [
            'fornecedores' => $fornecedores,
            'model' => $model,
        ]);
    }


    public function actionSelect($id, $fornecedor_id)
    {
        // Associa o fornecedor à compra
        $model = Compras::findOne($id);
        if ($model) {
            $model->fornecedores_id = $fornecedor_id;
            $model->save();
        }

        // Redireciona de volta para a edição da compra
        return $this->redirect(['compras/formulario', 'id' => $id]);
    }


    //Artigos

    public function actionValidarArtigo($id)
    {
        $referencia = Yii::$app->request->post('referencia');
        $quantidade = Yii::$app->request->post('quantidade');

        // Debug: Verificar se os dados estão chegando corretamente
        Yii::debug('Referência: ' . $referencia, __METHOD__);
        Yii::debug('Quantidade: ' . $quantidade, __METHOD__);

        // Verificar se o ID da compra é válido
        $compra = Compras::findOne($id);
        if (!$compra) {
            throw new NotFoundHttpException('A compra solicitada não foi encontrada.');
        }

        if (!$referencia) {
            Yii::$app->session->setFlash('info', 'Nenhuma referência inserida. Redirecionando para a pesquisa de artigos.');
            return $this->redirect(['compras/artigo', 'id' => $id]);
        }

        // Procurar pelo artigo com a referência fornecida
        $artigo = Artigos::find()->where(['referencia' => $referencia])->one();

        if (!$artigo) {
            Yii::$app->session->setFlash('error', 'Artigo com a referência "' . $referencia . '" não foi encontrado. Por favor, selecione um artigo.');
            return $this->redirect(['compras/artigo', 'id' => $id]);
        }

        // Caso o artigo seja encontrado, criar uma linha de compra associada
        $linhaFaturaFornecedor = new LinhaFaturaFornecedor();
        $linhaFaturaFornecedor->faturafornecedor_id = $id;
        $linhaFaturaFornecedor->artigo_id = $artigo->Id;
        $linhaFaturaFornecedor->quantidade = $quantidade;
        $linhaFaturaFornecedor->valor = $artigo->precoUni;
        $linhaFaturaFornecedor->total = $linhaFaturaFornecedor->quantidade * $linhaFaturaFornecedor->valor;

        if ($linhaFaturaFornecedor->save()) {
            Yii::debug('Linha de fatura criada com sucesso: ' . json_encode($linhaFaturaFornecedor->toArray()), __METHOD__);
            Yii::$app->session->setFlash('success', 'Artigo adicionado com sucesso.');
        } else {
            Yii::debug('Erro ao salvar linha de fatura: ' . json_encode($linhaFaturaFornecedor->getErrors()), __METHOD__);
            Yii::$app->session->setFlash('error', 'Erro ao associar o artigo. Verifique os dados e tente novamente.');
        }


        // Redirecionar de volta para o formulário da compra
        return $this->redirect(['compras/formulario', 'id' => $id]);
    }





    public function actionArtigo($id)
    {
        // Verifica se o ID foi passado corretamente
        if (!$id) {
            throw new NotFoundHttpException('ID da compra não encontrado.');
        }

        // Busca todos os artigos
        $artigos = Artigos::find()->all();

        // Busca a compra pelo ID
        $model = Compras::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('A compra solicitada não foi encontrada.');
        }

        return $this->render('searchArtigo', [
            'artigos' => $artigos,
            'model' => $model,
        ]);
    }


    public function actionAdicionarVariosArtigos($id)
    {
        $compra = Compras::findOne($id);

        if (!$compra) {
            throw new NotFoundHttpException('A compra solicitada não foi encontrada.');
        }

        // Recupera os dados enviados pelo formulário
        $artigosSelecionados = Yii::$app->request->post('artigos', []);

        if (empty($artigosSelecionados)) {
            Yii::$app->session->setFlash('error', 'Nenhum artigo foi selecionado.');
            return $this->redirect(['compras/search-artigos', 'id' => $id]);
        }

        $erros = [];
        $sucessos = 0;

        foreach ($artigosSelecionados as $artigo_id => $dados) {
            if (isset($dados['selecionado']) && $dados['selecionado']) {
                $artigo = Artigos::findOne($artigo_id);

                if (!$artigo) {
                    $erros[] = "Artigo ID {$artigo_id} não encontrado.";
                    continue;
                }

                $quantidade = $dados['quantidade'] ?? 1;

                // Cria a linha de compra
                $linha = new Linhafaturafornecedor();
                $linha->faturafornecedor_id = $compra->id;
                $linha->referencia = $artigo->referencia;
                $linha->artigo_id = $artigo->Id;
                $linha->quantidade = $quantidade;
                $linha->valor = $artigo->precoUni;
                $linha->total = $linha->quantidade * $linha->valor;

                if ($linha->validate() && $linha->save()) {
                    $sucessos++;
                } else {
                    $erros[] = "Erro ao adicionar o artigo '{$artigo->referencia}': " . json_encode($linha->errors);
                }
            }
        }

        if ($sucessos > 0) {
            Yii::$app->session->setFlash('success', "{$sucessos} artigo(s) foram adicionados com sucesso.");
        }

        if (!empty($erros)) {
            Yii::$app->session->setFlash('error', implode('<br>', $erros));
        }

        return $this->redirect(['compras/formulario', 'id' => $id]);
    }



    public function actionFinalizarCompra($id)
    {
        // Encontra a compra pelo ID
        $compra = Compras::findOne($id);

        if (!$compra) {
            throw new NotFoundHttpException('A compra solicitada não foi encontrada.');
        }

        // Verifica se a compra já foi finalizada
        if ($compra->estado === 'Finalizado') {
            Yii::$app->session->setFlash('error', 'Esta compra já foi finalizada.');
            return $this->redirect(['compras/formulario', 'id' => $id]);
        }

        // Recupera todas as linhas da compra
        $linhas = Linhafaturafornecedor::find()->where(['faturafornecedor_id' => $id])->all();

        if (empty($linhas)) {
            Yii::$app->session->setFlash('error', 'A compra não possui linhas de compra para processar.');
            return $this->redirect(['compras/formulario', 'id' => $id]);
        }

        $transaction = Yii::$app->db->beginTransaction(); // Inicia uma transação

        try {
            foreach ($linhas as $linha) {
                $artigo = Artigos::findOne($linha->artigo_id);

                if (!$artigo) {
                    throw new \Exception('Artigo não encontrado para a linha com ID: ' . $linha->id);
                }

                // Atualiza o stock do artigo
                $artigo->stock += $linha->quantidade;

                if (!$artigo->save()) {
                    throw new \Exception('Erro ao atualizar o stock do artigo: ' . json_encode($artigo->errors));
                }
            }

            // Atualiza o estado da compra para "Finalizado"
            $compra->estado = 'Finalizado';

            if (!$compra->save()) {
                throw new \Exception('Erro ao atualizar o estado da compra: ' . json_encode($compra->errors));
            }

            // Confirma a transação
            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Compra finalizada com sucesso.');
        } catch (\Exception $e) {
            // Reverte a transação em caso de erro
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Erro ao finalizar a compra: ' . $e->getMessage());
        }

        return $this->redirect(['compras/formulario', 'id' => $id]);
    }




    /**
     * Updates an existing Compras model.
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
     * Deletes an existing Compras model.
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
     * Finds the Compras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Compras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Compras::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
