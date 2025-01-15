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
}