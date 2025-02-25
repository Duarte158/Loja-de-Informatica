<?php
namespace backend\modules\api\components;
use common\models\User;
use Yii;
use yii\filters\auth\AuthMethod;
use yii\helpers\Json;
use yii\web\UnauthorizedHttpException;

class CustomAuth extends AuthMethod{



    public function authenticate($user, $request, $response)
    {
        // Obtém os dados de 'username' e 'password' do corpo da requisição POST
        $params = $request->getBodyParams();  // Acessa os parâmetros do corpo da requisição

        $username = $params['username'] ?? null;  // Pega o 'username' do corpo, ou null se não existir
        $password = $params['password'] ?? null;  // Pega a 'password' do corpo, ou null se não existir

        if ($username === null || $password === null) {
            return null; // Credenciais ausentes, não autenticar
        }

        // Verificar credenciais usando o modelo User
        $identity = User::findByUsername($username);

        if ($identity === null || !$identity->validatePassword($password)) {
            throw new UnauthorizedHttpException('Falha na autenticação');
        } else {
            Yii::$app->user->login($identity);  // Realiza o login do usuário
        }

        return $identity; // Não retorna nada conforme solicitado
    }

}