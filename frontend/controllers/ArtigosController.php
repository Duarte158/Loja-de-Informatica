<?php

namespace frontend\controllers;

use backend\models\Product;
use common\models\Artigos;
use common\models\Carrinhocompras;
use common\models\Categoria;
use common\models\LinhaCarrinho;
use Yii;

class ArtigosController extends \yii\web\Controller
{

    public function actionArtigos($id)
    {
        $categoria = Categoria::findOne($id);
        $artigos = Artigos::find()->where(['categoria_id' => $id])->all();

        return $this->render('artigos', [
            'categoria' => $categoria,
            'artigos' => $artigos,
        ]);
    }

    public function actionAdicionarCarrinho()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post('id');
            $quantidade = (int)$request->post('quantidade');
            Yii::info("ID recebido: $id, Quantidade recebida: $quantidade"); // Adiciona log para depuração

            if ($quantidade <= 0) {
                Yii::$app->session->setFlash('error', 'Quantidade inválida.');
                return $this->redirect(['artigo/index']);
            }

            $artigo = Artigos::findOne($id);
            if ($artigo === null) {
                Yii::$app->session->setFlash('error', 'Artigo não encontrado.');
                return $this->redirect(['artigo/index']);
            }

            if (!Yii::$app->user->isGuest) {
                $carrinho = Carrinhocompras::find()
                    ->where(['user_id' => Yii::$app->user->id, 'estado' => 'ativo'])
                    ->andWhere(['not', ['estado' => 'finalizado']])
                    ->one();

                if ($carrinho === null) {
                    $carrinho = new Carrinhocompras();
                    $carrinho->user_id = Yii::$app->user->id;
                    $carrinho->data = date('Y-m-d-H-i-s');
                    $carrinho->estado = 'ativo';
                    $carrinho->save();
                }

                $linhaCarrinho = LinhaCarrinho::find()
                    ->where(['carrinho_id' => $carrinho->id, 'artigo_id' => $artigo->Id])
                    ->one();

                if ($linhaCarrinho) {
                    $linhaCarrinho->quantidade += $quantidade;
                    $linhaCarrinho->valorTotal = round($linhaCarrinho->valor * $linhaCarrinho->quantidade, 2);
                } else {
                    $linhaCarrinho = new LinhaCarrinho();
                    $linhaCarrinho->carrinho_id = $carrinho->id;
                    $linhaCarrinho->artigo_id = $artigo->Id;
                    $linhaCarrinho->quantidade = $quantidade;
                    $linhaCarrinho->valor = round($artigo->precoFinal * $quantidade, 2);
                }

                if ($linhaCarrinho->save()) {
                    $carrinho->valorIva = $carrinho->getTotalIva();
                    $carrinho->valorTotal = $carrinho->getTotalValue();
                    $carrinho->save();

                    Yii::$app->session->setFlash('success', 'Artigo adicionado ao carrinho com sucesso.');
                    return $this->redirect(['carrinho-compras/index']);
                } else {
                    Yii::error('Erro ao salvar linha do carrinho: ' . json_encode($linhaCarrinho->errors));
                    Yii::$app->session->setFlash('error', 'Erro ao adicionar artigo ao carrinho.');
                    return $this->redirect(['site/index']);
                }
            } else {
                return $this->redirect(['site/login']);
            }
        }
    }


}
