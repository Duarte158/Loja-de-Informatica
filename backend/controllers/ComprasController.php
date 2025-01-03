<?php

namespace backend\controllers;

use backend\models\Compras;
use backend\models\Fornecedor;
use backend\models\Linhafaturafornecedor;
use common\models\Artigos;
use yii\base\Model;
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
        $linhasFatura = [new Linhafaturafornecedor()];

        // Carregar fornecedores e artigos do banco de dados
        $fornecedores = Fornecedor::find()
            ->select(['designacaoSocial', 'ID']) // Seleciona o nome e o ID
            ->indexBy('ID') // Usa o ID como índice
            ->column(); // Cria um array (id => nome)

        $artigos = Artigos::find()
            ->select(['nome', 'Id']) // Seleciona o nome e o ID
            ->indexBy('Id') // Usa o ID como índice
            ->column(); // Cria um array (id => nome)

        // Se o formulário foi submetido
        if ($model->load(\Yii::$app->request->post()) && Model::loadMultiple($linhasFatura, \Yii::$app->request->post())) {
            // Validar todos os dados
            $isValid = $model->validate();
            $isValid = Model::validateMultiple($linhasFatura) && $isValid;

            if ($isValid) {
                // Iniciar uma transação
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    // Salvar o modelo principal (fatura)
                    if ($model->save(false)) {
                        foreach ($linhasFatura as $linha) {
                            $linha->fatura_fornecedor_id = $model->id; // Associa a linha à fatura
                            if (!$linha->save(false)) {
                                $transaction->rollBack();
                                break;
                            }

                            // Atualizar o estoque do artigo
                            $artigo = Artigos::findOne($linha->artigo_id);
                            if ($artigo) {
                                $artigo->stock -= $linha->quantidade; // Atualiza o estoque
                                $artigo->save(false);
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }

        $total = 0;
        foreach ($linhasFatura as $linha) {
            $total += $linha->quantidade * $linha->valor;
        }

// Passar os totais para a view
        return $this->render('create', [
            'model' => $model,
            'linhasFatura' => $linhasFatura,
            'fornecedores' => $fornecedores,
            'artigos' => $artigos,
            'total' => $total, // Passando o total para a view
        ]);
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
