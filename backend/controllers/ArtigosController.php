<?php

namespace backend\controllers;

use common\models\Artigos;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArtigosController implements the CRUD actions for Artigos model.
 */
class ArtigosController extends Controller
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
     * Lists all Artigos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Artigos::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'Id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Artigos model.
     * @param int $Id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($Id)
    {
        return $this->render('view', [
            'model' => $this->findModel($Id),
        ]);
    }

    /**
     * Creates a new Artigos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Artigos();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {

                // Calcular o precoFinal
                $ivaPercentage = $model->iva->percentagem; // Certifique-se de que o valor do iva_id seja o percentual
                $model->precoFinal = round($model->precoUni * (1 + $ivaPercentage / 100), 2); // Arredondar para 2 casas decimais
                $model->stock = 0;
                // Carregar e salvar a imagem
                $imagem = UploadedFile::getInstance($model, 'imagem');
                if ($imagem) {
                    $imagePath = 'C:\wamp64\www\Loja-de-Informatica-main\frontend\web\imagens\materiais\\' . $imagem->nome;
                    $imagem->saveAs($imagePath);
                    $model->imagem = $imagem->nome;
                }

                // Salvar o modelo com precoFinal e imagem
                if ($model->save(false)) {
                    return $this->redirect(['view', 'Id' => $model->Id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Artigos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $Id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($Id)
    {
        $model = $this->findModel($Id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Id' => $model->Id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Artigos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $Id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($Id)
    {
        $this->findModel($Id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Artigos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $Id ID
     * @return Artigos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Id)
    {
        if (($model = Artigos::findOne(['Id' => $Id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
