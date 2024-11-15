<?php

namespace backend\modules\api\controllers;

use yii;
use yii\web\Controller;
use common\models\User;

class LoginController extends Controller
{

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');

        $user = User::findOne(['username' => $username, 'password' => $password]);

        if ($user) {
            return ['message' => 'Login bem-sucedido!', 'user' => $user];
        } else {
            Yii::$app->response->statusCode = 401;
            return ['message' => 'Credenciais incorretas'];

        }
    }
}