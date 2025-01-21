<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Carrinhocompras;
use common\models\Fatura;
use common\models\Linhacarrinho;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class FaturaController extends ActiveController
{



    public $userModelClass = 'common\models\User';

    public $modelClass = 'common\models\Fatura';




    public function actionView($id)
    {
        $fatura = Fatura::findOne($id);

        if ($fatura === null) {
            throw new NotFoundHttpException("Fatura não encontrada.");
        }

        $carrinho = Carrinhocompras::findOne($fatura->carrinho_id);

        if ($carrinho === null) {
            throw new NotFoundHttpException("Carrinho associado não encontrado.");
        }

        $linhasCarrinho = Linhacarrinho::find()->where(['carrinho_id' => $carrinho->id])->all();

        return [
            'fatura_id' => $fatura->id,
            'carrinho_id' => $carrinho->id,
            'linhas_carrinho' => $linhasCarrinho,
        ];
    }


    public function actionFaturasUsuario($user_id)
    {
        // Encontrar todas as faturas do usuário
        $faturas = Fatura::find()->where(['user_id' => $user_id])->all();

        $resultado = [];
        foreach ($faturas as $fatura) {
            // Buscar o carrinho associado à fatura
            $carrinho = Carrinhocompras::findOne($fatura->carrinho_id);
            $linhasCarrinho = Linhacarrinho::find()->where(['carrinho_id' => $carrinho->id])->all();

            // Formatar as linhas de carrinho
            $linhasCarrinhoArray = [];
            foreach ($linhasCarrinho as $linha) {
                $linhasCarrinhoArray[] = [
                    'id' => $linha->id,
                    'quantidade' => $linha->quantidade,
                    'valor' => $linha->valor,
                    'artigo_id' => $linha->artigo_id,
                    'nome_artigo' => $linha->artigo ? $linha->artigo->nome : 'Desconhecido',
                ];
            }

            // Adicionar fatura e informações do carrinho ao resultado
            $resultado[] = [
                'fatura_id' => $fatura->id,
                'data' => $fatura->data,
                'metodopagamento_id' => $fatura->metodoPagamento_id,
                'valor_total' => $carrinho->valorTotal,
                'valor_iva' => $carrinho->valorIva,
                'user_id' => $fatura->user_id,
                'carrinho_id' => $fatura->carrinho_id,
                'carrinho' => $carrinho ? [
                    'id' => $carrinho->id,
                    'data' => $carrinho->data,
                    'valor_iva' => $carrinho->valorIva,
                    'user_id' => $carrinho->user_id,
                    'valor_total' => $carrinho->valorTotal,
                    'estado' => $carrinho->estado,
                ] : null,
                'linhas_carrinho' => $linhasCarrinhoArray, // Incluir as linhas de carrinho
            ];
        }

        return $resultado;
    }



}