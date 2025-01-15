<?php
namespace backend\modules\api\components;
use common\models\User;
use Yii;
use yii\filters\auth\AuthMethod;
use yii\helpers\Json;
use yii\web\UnauthorizedHttpException;

class CustomAuth extends AuthMethod
{
    public function authenticate($user, $request, $response)
    {
        $username = $request->getHeaders()->get('username');
        $password = $request->getHeaders()->get('password');

        if ($username === null || $password === null) {
            return null; // Credenciais ausentes, não autenticar
        }

        // Verificar credenciais usando o modelo User
        $identity = User::findByUsername($username);

        if ($identity === null || !$identity->validatePassword($password)) {
            throw new UnauthorizedHttpException('Falha na autenticação');
        }
        else {
            Yii::$app->user->login($identity);
        }
        return $identity;
    }
}