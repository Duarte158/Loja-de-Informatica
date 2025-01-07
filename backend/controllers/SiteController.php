<?php

namespace backend\controllers;

use common\models\LoginForm;
use frontend\models\SignupForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'], // Define as ações a restringir
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Apenas utilizadores autenticados
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin', 'funcionario'], // Apenas admin e funcionário
                    ],
                    [
                        'allow' => false,
                        'roles' => ['cliente'], // Bloqueia clientes
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            // Se o usuário já está logado, redirecione para a página inicial
            return $this->redirect(['site/index']);
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Após login bem-sucedido, redirecione para a página inicial
            return $this->redirect(['site/index']);
        }

        $model->password = ''; // Limpa a senha no formulário por segurança

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $model = new \backend\models\SignUpForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }



    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['site/login']); // Use um array para indicar a rota
    }
}
