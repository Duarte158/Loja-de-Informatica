<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\helpers\Json;
use yii\rest\ActiveController;

class CategoriasController extends ActiveController
{

    // Usa o modelo dos Artigos que esta no common
    public $modelClass = 'common\models\Categoria';


    public function actionPostcategoria()
    {
        $rawBody = Yii::$app->request->getRawBody();
        $decodedBody = Json::decode($rawBody);
        $model = new $this->modelClass;
        $model->load($decodedBody, '');

        if ($model->save()) {
            return ['success' => true, 'data' => $model];
        } else {
            return ['success' => false, 'data' => $model->errors];
        }
    }



    public function actionPutcategoria($id)
    {
        $rawBody = Yii::$app->request->getRawBody();
        $decodedBody = Json::decode($rawBody);

        $categoria = $this->modelClass::findOne(['id' => $id]);

        if ($categoria) {
            $categoria->load($decodedBody, '');

            if ($categoria->save()) {
                return ['success' => true, 'message' => 'Categoria atualizado com sucesso.', 'categoria' => $categoria];
            } else {
                return ['success' => false, 'message' => 'Erro ao salvar a categoria', 'errors' => $categoria->errors];
            }
        } else {
            throw new \yii\web\NotFoundHttpException("O id não existe");
        }
    }


}