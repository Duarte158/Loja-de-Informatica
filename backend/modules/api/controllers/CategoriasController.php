<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

class CategoriasController extends ActiveController
{

    // Usa o modelo dos Artigos que esta no common
    public $modelClass = 'common\models\Categoria';

}