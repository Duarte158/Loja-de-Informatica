<?php

namespace backend\controllers;

use backend\controllers\SiteController;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends SiteController
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
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
     * Displays a single User model.
     * @param int $id
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $userModel = new User(); // Modelo para a tabela `user`
        $profileModel = new Profile(); // Modelo para a tabela `profile`

        if ($this->request->isPost) {
            $postData = $this->request->post();

            // Carregar os dados enviados no formulário para os modelos
            if ($userModel->load($postData) && $profileModel->load($postData)) {
                // Configurar senha e outros atributos automáticos
                $userModel->setPassword($userModel->password); // Gera o hash da senha
                $userModel->generateAuthKey(); // Gera a chave de autenticação

                // Iniciar transação para garantir consistência entre as tabelas
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // Salvar o usuário
                    if ($userModel->save()) {
                        // Associar o ID do usuário ao perfil
                        $profileModel->user_id = $userModel->id;

                        // Salvar o perfil
                        if ($profileModel->save()) {
                            $transaction->commit(); // Confirma a transação
                            return $this->redirect(['view', 'id' => $userModel->id]);
                        }
                    }

                    // Se algo der errado, reverte a transação
                    $transaction->rollBack();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }

        // Exibir o formulário para criação do usuário e perfil
        return $this->render('create', [
            'userModel' => $userModel,
            'profileModel' => $profileModel,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
