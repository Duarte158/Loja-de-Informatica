<?php

namespace backend\controllers;

use backend\controllers\SiteController;
use common\models\Profile;
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
        $model = new User();

        // Obter lista de roles para o dropdown
        $auth = \Yii::$app->authManager;
        $roles = $auth->getRoles();
        $rolesList = \yii\helpers\ArrayHelper::map($roles, 'name', 'name'); // Mapear name => name

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                // Atribuir a role selecionada
                $selectedRole = $this->request->post('User')['role']; // Obter a role do POST
                if ($selectedRole) {
                    $role = $auth->getRole($selectedRole);
                    $auth->assign($role, $model->id); // Atribuir a role ao usuário criado
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => $rolesList, // Passar a lista de roles para a view
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
        $model = $this->findModel($id); // Carrega o modelo User
        $profile = $model->profile ?? new Profile(); // Carrega ou cria o Profile

        if ($model->load(\Yii::$app->request->post()) && $profile->load(\Yii::$app->request->post())) {
            $isValid = $model->validate() && $profile->validate(); // Valida ambos os modelos
            if ($isValid) {
                // Salva o User
                $model->save(false);

                // Relaciona o Profile com o User
                $profile->user_id = $model->id;

                // Atualiza o campo nome no Profile com o username do User
                $profile->nome = $model->username;

                // Salva o Profile
                $profile->save(false);

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'profile' => $profile,
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
        $model = $this->findModel($id);

        // Delete related profiles first
        \common\models\Profile::deleteAll(['user_id' => $model->id]);

        // Now delete the user
        $model->delete();

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
