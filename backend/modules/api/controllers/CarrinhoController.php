<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Carrinhocompras;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class CarrinhoController extends ActiveController
{

    public $modelClass = 'common\models\Carrinhocompras';



    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }


    /**
     * Obtém o carrinho ativo do usuário logado.
     *
     * @return array
     * @throws UnauthorizedHttpException
     */





    public function actionGetCarrinhoAtivo()
    {
        // Obtém o usuário logado
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Usuário não está logado.');
        }

        // Procura o carrinho ativo associado ao usuário
        $carrinho = Carrinhocompras::find()
            ->where(['user_id' => $user->id, 'estado' => "ativo"])
            ->one();

        if (!$carrinho) {
            return [
                'success' => false,
                'message' => 'Nenhum carrinho ativo encontrado.',
            ];
        }

        // Retorna os dados do carrinho ativo
        return [
            'success' => true,
            'carrinho' => $carrinho,
        ];
    }

    }