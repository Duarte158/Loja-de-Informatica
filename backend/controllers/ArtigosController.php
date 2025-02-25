<?php

namespace backend\controllers;

use backend\models\Product;
use common\models\Artigos;
use backend\controllers\ArtigoSeach;
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
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        // Permite o acesso apenas para admin e funcionário
                        [
                            'allow' => true,
                            'roles' => ['admin', 'funcionario'],
                        ],
                        // Negação geral para os demais (incluindo clientes e usuários não autenticados)
                        [
                            'allow' => false,
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => \yii\filters\VerbFilter::className(),
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
        $searchModel = new ArtigoSeach();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
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


                $ivaPercentage = $model->iva->percentagem;
                $model->precoFinal = round($model->precoUni * (1 + $ivaPercentage / 100), 2);


                $imagem = UploadedFile::getInstance($model, 'imagem');
                if ($imagem) {
                    $imagePath = \Yii::getAlias('C:/wamp64/www/Loja-de-Informatica/frontend/web/imagens/materiais/') . $imagem->name;
                    $imagem->saveAs($imagePath);
                    $model->imagem = $imagem->name;
                }


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
