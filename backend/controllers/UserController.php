<?php

namespace backend\controllers;

use backend\controllers\SiteController;
use backend\models\SignUpForm;
use backend\models\UserSearch;
use common\models\Profile;
use common\models\User;
use Yii;
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
    $searchModel = new UserSearch();
    $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

    // Obter o parâmetro role da requisição
    $role = \Yii::$app->request->get('role');

    if ($role) {
        $auth = \Yii::$app->authManager;
        $userIds = $auth->getUserIdsByRole($role); // Obter IDs dos usuários com a role
        $dataProvider->query->andWhere(['id' => $userIds]);
    }

    // Obter lista de roles
    $auth = \Yii::$app->authManager;
    $roles = \yii\helpers\ArrayHelper::map($auth->getRoles(), 'name', 'description');

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'roles' => $roles,
        'selectedRole' => $role, // Role selecionada
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
        $model = new \backend\models\SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
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
        // Carregar o modelo do usuário
        $user = User::findOne($id);
        // Carregar o perfil associado ao usuário
        $profile = Profile::findOne(['user_id' => $user->id]);

        // Verificar se os modelos existem
        if (!$user || !$profile) {
            throw new NotFoundHttpException("Usuário ou perfil não encontrado.");
        }

        // Se for uma requisição POST
        if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
            // Verificar se a senha foi alterada
            if (!empty($user->new_password)) {
                // Validar que as senhas coincidem
                if ($user->new_password === $user->confirm_password) {
                    // Atualizar a senha
                    $user->setPassword($user->new_password);
                } else {
                    // Adicionar erro se as senhas não coincidirem
                    $user->addError('new_password', 'As senhas não coincidem.');
                    return $this->render('update', [
                        'user' => $user,
                        'profile' => $profile,
                    ]);
                }
            }

            // Tente salvar os dois modelos
            $isUserSaved = $user->save();  // Salvar os dados do usuário
            $isProfileSaved = $profile->save();  // Salvar os dados do perfil

            // Verificar se os dois modelos foram salvos com sucesso
            if ($isUserSaved && $isProfileSaved) {
                Yii::$app->session->setFlash('success', 'Usuário e perfil atualizados com sucesso!');
                return $this->redirect(['view', 'id' => $user->id]);  // Redireciona para a página de visualização do usuário
            }
        }

        // Se a requisição não for POST ou não salvar corretamente, renderize o formulário de update
        return $this->render('update', [
            'user' => $user,
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
