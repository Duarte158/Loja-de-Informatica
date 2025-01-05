<?php

namespace backend\controllers;

use backend\models\Compras;
use backend\models\Fornecedor;
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
