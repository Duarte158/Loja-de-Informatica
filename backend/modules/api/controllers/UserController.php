<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use common\models\User;

/**
 * UserController para o módulo API
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    /**
     * Definição de comportamentos (ex.: CORS e formato de resposta).
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Formato JSON por padrão
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        return $behaviors;
    }

    /**
     * Ação de login.
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;
        $data = $request->post(); // Captura os dados enviados via POST.

        // Validação dos dados enviados.
        if (empty($data['username']) || empty($data['password'])) {
            return [
                'success' => false,
                'message' => 'Por favor, preencha username e password.'
            ];
        }

        $username = $data['username'];
        $password = $data['password'];

        // Procurar o usuário pelo username.
        $user = User::find()->where(['username' => $username])->one();

        if (!$user || !Yii::$app->security->validatePassword($password, $user->password_hash)) {
            return [
                'success' => false,
                'message' => 'Username ou senha inválidos.'
            ];
        }

        // Gerar um token simples (opcional: substitua por JWT para maior segurança).
        $token = Yii::$app->security->generateRandomString();

        // Salvar o token no banco (se necessário).
        $user->auth_key = $token;
        $user->save();

        return [
            'success' => true,
            'message' => 'Login bem-sucedido.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ]
        ];
    }
}