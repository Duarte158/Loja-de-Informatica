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

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }


 /*   public function actionLogin()
    {
        // Captura os dados do corpo da requisição (nome de usuário e senha)
        $params = Yii::$app->getRequest()->getBodyParams();
        $username = $params['username'] ?? null;
        $password = $params['password'] ?? null;

        if ($username === null || $password === null) {
            return [
                'success' => false,
                'message' => 'Credenciais ausentes.',
            ];
        }

        // Verifica se as credenciais estão corretas
        $user = User::findByUsername($username);
        if ($user === null || !$user->validatePassword($password)) {
            return [
                'success' => false,
                'message' => 'Falha na autenticação',
            ];
        }

        // Gera um token para o usuário (auth_key ou JWT)
        Yii::$app->user->login($user);

        return [
            'success' => true,
            'token' => $user->auth_key, // Ou o JWT gerado
            'email' => $user->email,
            'role' => Yii::$app->authManager->getRolesByUser($user->id), // Role do usuário
            'message' => 'Login bem-sucedido',
        ];
    }*/


     public function actionLogin()
     {
         $user = Yii::$app->user->identity;
         $role = Yii::$app->authManager->getRole($user);
         if ($role == null){
             $role = "cliente";
         }
         else{
             $role = $role->name;
         }
         if ($user!=null) {
             return [
                 'success' => true,
                 'token' => $user->auth_key,
                 'email' => $user->email,
                 'role' => $role,
                 'message' => 'Login bem-sucedido',

             ];
         } else {
             return [
                 'success' => false,
                 'message' => 'Falha na autenticação',
             ];
         }
     }



  /*  public function actionLogin()
    {
        // Obtém os dados do corpo da requisição (POST)
        $params = Yii::$app->request->post();
        $username = $params['username'] ?? null;
        $password = $params['password'] ?? null;

        // Verifica se o nome de usuário e a senha foram fornecidos
        if ($username === null || $password === null) {
            throw new BadRequestHttpException('Parâmetros ausentes');
        }

        $user = User::findByUsername($username);

        // Verifica se o usuário existe e a senha está correta
        if ($user === null || !$user->validatePassword($password)) {
            throw new UnauthorizedHttpException('Credenciais inválidas');
        }

        // Gera o auth key
        $user->generateAuthKey();
        $user->save();

        // Obtém as roles associadas ao usuário
        $authManager = Yii::$app->authManager;
        $roles = $authManager->getRolesByUser($user->id);

        // Você pode extrair as roles e armazená-las em um array simples (se necessário)
        $roleNames = [];
        foreach ($roles as $role) {
            $roleNames[] = $role->name;
        }

        // Retorna os dados do usuário, o token e a(s) role(s)
        return [
            'success' => true,
            'token' => $user->auth_key,
            'email' => $user->email,
            'roles' => $roleNames,  // Adiciona a(s) role(s) associada(s)
            'message' => 'Login bem-sucedido',
        ];
    }*/


}