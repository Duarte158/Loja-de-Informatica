<?php

namespace frontend\controllers;

use backend\models\Product;
use common\models\Artigos;
use common\models\Carrinhocompras;
use common\models\Categoria;
use common\models\LinhaCarrinho;
use Yii;
use yii\web\NotFoundHttpException;

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

    public function actionPesquisar()
    {
        $query = Yii::$app->request->get('query');


        $artigos = Artigos::find()
            ->where(['like', 'nome', $query])
            ->all();

        // Renderiza a view de resultados, passando os artigos encontrados
        return $this->render('search', [
            'artigos' => $artigos,
            'query' => $query,


        ]);

    }


    public function actionAdicionarCarrinho()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post('id');
            $quantidade = $request->post('quantidade');

            $produto = Artigos::findOne($id);

            if (!$produto) {
                Yii::$app->session->setFlash('error', 'Produto não encontrado.');
                return $this->redirect(['site/index']);
            }

            // Verifica se o usuário está logado
            if (!Yii::$app->user->isGuest) {
                $carrinho = Carrinhocompras::find()
                    ->where([
                        'user_id' => Yii::$app->user->id,
                        'estado' => 'ativo'
                    ])
                    ->andWhere(['not', ['estado' => 'finalizado']])
                    ->one();

                // Cria o carrinho caso não exista
                if ($carrinho == null) {
                    $carrinho = new Carrinhocompras();
                    $carrinho->user_id = Yii::$app->user->id;
                    $carrinho->data = date('Y-m-d H:i:s');
                    $carrinho->estado = 'ativo';
                    if (!$carrinho->save()) {
                        Yii::error('Erro ao salvar o carrinho: ' . json_encode($carrinho->errors));
                        Yii::$app->session->setFlash('error', 'Erro ao criar o carrinho.');
                        return $this->redirect(['site/index']);
                    }
                }

                if (!$carrinho->id) {
                    Yii::error('O ID do carrinho está nulo após a criação.');
                    Yii::$app->session->setFlash('error', 'Erro ao obter o ID do carrinho.');
                    return $this->redirect(['site/index']);
                }

                // Verifica se o produto já está no carrinho
                $linhaCarrinho = LinhaCarrinho::find()
                    ->where([
                        'carrinho_id' => $carrinho->id,
                        'artigo_id' => $produto->Id
                    ])
                    ->one();

                if ($linhaCarrinho) {
                    $linhaCarrinho->quantidade += $quantidade;
                    $linhaCarrinho->valorTotal = round($linhaCarrinho->valor * $linhaCarrinho->quantidade, 2);
                } else {
                    $linhaCarrinho = new Linhacarrinho();
                    $linhaCarrinho->carrinho_id = $carrinho->id;
                    $linhaCarrinho->artigo_id = $produto->Id;
                    $linhaCarrinho->quantidade = $quantidade;
                    $linhaCarrinho->valor = round($produto->precoFinal, 2);
                    $linhaCarrinho->valorTotal = round($produto->precoFinal * $quantidade, 2);
                }

                if ($linhaCarrinho->save()) {
                    $carrinho->valorIva = $carrinho->getTotalIva();
                    $carrinho->valorTotal = $carrinho->getTotalValue();
                    $carrinho->save();

                    Yii::$app->session->setFlash('success', 'Produto adicionado ao carrinho com sucesso.');
                    return $this->redirect(['carrinho-compras/index']);
                } else {
                    Yii::error('Erro ao salvar linha do carrinho: ' . json_encode($linhaCarrinho->errors));
                    Yii::$app->session->setFlash('error', 'Erro ao adicionar produto ao carrinho.');
                    return $this->redirect(['site/index']);
                }
            } else {
                return $this->redirect(['site/login']);
            }
        }
    }


    public function actionArtigosView($Id)
    {
        return $this->render('artigoView', ['model' => $this->findModel($Id),]);
    }

    protected function findModel($Id)
    {
        if (($model = Artigos::findOne($Id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
