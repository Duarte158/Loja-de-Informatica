<?php
namespace backend\modules\api\controllers;

use common\models\Artigos; // Certifique-se de que o modelo do artigo está correto
use frontend\models\Favorito;
use Yii;
use yii\helpers\Json;
use yii\rest\ActiveController;

class FavoritosController extends ActiveController
{
    public $modelClass = 'common\models\Favorito';

    /**
     * Retorna os artigos favoritos de um usuário específico.
     * Endpoint: GET /api/favoritos/getfavoritos?user_id=123
     *
     * @param int $user_id
     * @return array
     */
    public function actionGetfavoritos($user_id)
    {
        $favoritos = Favorito::find()
            ->select(['artigo_id'])
            ->where(['user_id' => $user_id])
            ->asArray()
            ->all();

        if (!$favoritos) {
            return [
                'success' => true,
                'message' => 'Nenhum artigo favorito encontrado',
                'data' => []
            ];
        }

        $artigo_ids = array_column($favoritos, 'artigo_id');

        // Buscar os detalhes dos artigos favoritos
        $artigos = Artigos::find()
            ->where(['id' => $artigo_ids])
            ->asArray()
            ->all();

        return [
            'success' => true,
            'data' => $artigos
        ];
    }

    /**
     * Adiciona um artigo aos favoritos de um usuário.
     * Endpoint: POST /api/favoritos/postfavorito
     * Exemplo de JSON enviado:
     * {
     *    "user_id": 123,
     *    "artigo_id": 456
     * }
     *
     * @return array
     */
    public function actionPostfavorito()
    {
        $rawBody = Yii::$app->request->getRawBody();
        $decodedBody = Json::decode($rawBody);

        if (!isset($decodedBody['user_id']) || !isset($decodedBody['artigo_id'])) {
            return [
                'success' => false,
                'message' => 'Parâmetros user_id e artigo_id são obrigatórios'
            ];
        }

        $favorito = new Favorito();
        $favorito->user_id = $decodedBody['user_id'];
        $favorito->artigo_id = $decodedBody['artigo_id'];

        if ($favorito->save()) {
            return [
                'success' => true,
                'message' => 'Artigo adicionado aos favoritos'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Erro ao adicionar favorito',
                'errors' => $favorito->errors
            ];
        }
    }

    /**
     * Remove um artigo dos favoritos de um usuário.
     * Endpoint: DELETE /api/favoritos/deletefavorito?user_id=123&artigo_id=456
     *
     * @param int $user_id
     * @param int $artigo_id
     * @return array
     */
    public function actionDeletefavorito($user_id, $artigo_id)
    {
        $favorito = Favorito::find()
            ->where(['user_id' => $user_id, 'artigo_id' => $artigo_id])
            ->one();

        if ($favorito) {
            $favorito->delete();
            return [
                'success' => true,
                'message' => 'Artigo removido dos favoritos'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Favorito não encontrado'
            ];
            }
       }
}