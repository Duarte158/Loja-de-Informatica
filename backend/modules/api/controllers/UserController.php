<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Profile;
use common\models\User;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\Application;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{
    public $user=null;
    public $modelClass = 'common\models\User';
    /**
     * Renders the index view for the module
     * @return array|array[]|string
     */





    public function actionLogin()
    {
        // Obtém os dados do corpo da requisição (POST)
        $params = Yii::$app->request->post();
        $username = $params['username'] ?? null;
        $password = $params['password'] ?? null;

        // Verifica se o nome de usuário e a senha foram fornecidos
        if ($username === null || $password === null) {
            throw new BadRequestHttpException('Parâmetros ausentes');
        }

        // Encontra o usuário pelo nome de usuário
        $user = User::findByUsername($username);

        // Verifica se o usuário existe e a senha está correta
        if ($user === null || !$user->validatePassword($password)) {
            throw new UnauthorizedHttpException('Credenciais inválidas');
        }

        // Gere um token de autenticação (exemplo: auth_key)
        $user->generateAuthKey(); // Supondo que você tenha esse método no seu modelo User
        $user->save();

        // Retorna os dados do usuário e o token
        return [
            'success' => true,
            'token' => $user->auth_key,
            'email' => $user->email,
            'message' => 'Login bem-sucedido',
        ];
    }

}