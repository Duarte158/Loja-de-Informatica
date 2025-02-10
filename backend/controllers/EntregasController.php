<?php

namespace backend\controllers;

use app\models\EntregasSearch;
use common\models\Entregas;
use common\models\Fatura;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EntregasController implements the CRUD actions for Entregas model.
 */
class EntregasController extends Controller
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
     * Lists all Entregas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EntregasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Entregas model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $entregas = Entregas::findOne($id);


        $linhasCarrinho = \common\models\LinhaCarrinho::find()
            ->where(['carrinho_id' => $entregas->carrinho_id])
            ->all();


        return $this->render('view', [
            'model' =>$entregas,
            'linhasCarrinho' => $linhasCarrinho
        ]);
    }


    /**
     * Altera o estado de uma entrega.
     *
     * Permite somente as seguintes transições:
     * - de "por entregar" para "em preparação"
     * - de "em preparação" para "entregue"
     *
     * @param integer $id O ID da entrega
     * @param string $estado O novo estado desejado
     * @return \yii\web\Response
     * @throws BadRequestHttpException Se o método não for POST
     * @throws NotFoundHttpException Se a entrega não for encontrada
     */
    public function actionAlterarEstado($id, $estado)
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            throw new BadRequestHttpException('Método inválido.');
        }

        $model = Entregas::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Entrega não encontrada.');
        }

        // Valida a transição permitida
        if ($model->estado === 'Por entregar' && $estado === 'em preparação') {
            $model->estado = 'em preparação';
        } elseif ($model->estado === 'em preparação' && $estado === 'entregue') {
            $model->estado = 'entregue';
        } else {
            Yii::$app->session->setFlash('error', 'Transição de estado inválida.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Estado atualizado com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao atualizar o estado.');
        }

        // Redireciona para a view da entrega, conforme a URL: /entregas/view?id=45
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Creates a new Entregas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Entregas();

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
     * Updates an existing Entregas model.
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
     * Deletes an existing Entregas model.
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
     * Finds the Entregas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Entregas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Entregas::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
