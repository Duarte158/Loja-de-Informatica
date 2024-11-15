<?php

namespace backend\modules\api\controllers;



use yii\rest\ActiveController;

class ArtigosController extends ActiveController
{

    // Usa o modelo dos Artigos que esta no common
    public $modelClass = 'common\models\Artigos';

}