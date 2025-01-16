<?php
namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\helpers\Json;
use yii\web\User;


class ArtigosController extends ActiveController
{
    public $user=null;
    public $modelClass = 'common\models\Artigos';




    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }



    public function actionGetdescricoes()
    {
        $model = new $this->modelClass;
        $recs = $model::find()->select(['descricao'])->all();
        return $recs;
    }

    public function actionGetprecoporreferencia($referencia)
    {
        $model = new $this->modelClass;
        $recs = $model::find()->select(['preco'])->where(['referencia' => $referencia])->all(); //array
        return $recs;
    }

    public function actionDeleteartigo($id)
    {


        $model = new $this->modelClass;
        $recs = $model::deleteAll(['id' => $id]);
        if ($recs !=null)
            return ['success' => true, 'message' => $recs. ' artigo(s) eliminado(s)'];
        else
            return ['success' => false, 'message' => 'id: '.$recs. ' não existe'];
    }

    public function actionPutartigo($id)
    {
        $rawBody = Yii::$app->request->getRawBody();
        $decodedBody = Json::decode($rawBody);

        $artigo = $this->modelClass::findOne(['id' => $id]);

        if ($artigo) {
            $artigo->load($decodedBody, '');

            if ($artigo->save()) {
                return ['success' => true, 'message' => 'Artigo atualizado com sucesso.', 'artigo' => $artigo];
            } else {
                return ['success' => false, 'message' => 'Erro ao salvar o artigo', 'errors' => $artigo->errors];
            }
        } else {
            throw new \yii\web\NotFoundHttpException("O id não existe");
        }
    }

    public function actionPostartigo()
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

}