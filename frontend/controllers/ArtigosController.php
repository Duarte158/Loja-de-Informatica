<?php

namespace frontend\controllers;

use backend\models\Product;
use common\models\Artigos;
use common\models\Carrinhocompras;
use common\models\Categoria;
use common\models\LinhaCarrinho;
use common\models\Marca;
use Yii;
use yii\web\NotFoundHttpException;

class ArtigosController extends \yii\web\Controller
{

    public function actionArtigos($id)
    {
        // Obtém a categoria selecionada
        $categoria = Categoria::findOne($id);

        // Verifica se a categoria existe
        if (!$categoria) {
            throw new \yii\web\NotFoundHttpException("Categoria não encontrada.");
        }

        // Obtém o ID da marca selecionada para filtrar (se houver)
        $marcaId = Yii::$app->request->get('marca');

        // Consulta de artigos: Filtra por categoria e, se aplicável, por marca
        $query = Artigos::find()->where(['categoria_id' => $id]);

        if ($marcaId) {
            $query->andWhere(['marca_id' => $marcaId]);
        }

        $artigos = $query->all();

        // Consulta para obter as marcas na categoria e contar seus artigos
        $marcas = Marca::find()
            ->select(['marca.*', 'COUNT(artigos.Id) AS artigos_count'])
            ->joinWith('artigos') // Certifique-se de que a relação `artigos` está definida no modelo Marca
            ->where(['artigos.categoria_id' => $id])
            ->groupBy('marca.Id')
            ->all();

        return $this->render('artigos', [
            'categoria' => $categoria,
            'artigos' => $artigos,
            'marcas' => $marcas,
            'marcaSelecionada' => $marcaId, // Passa a marca selecionada para o view (opcional)
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
                    $carrinho->save();
                }

                // Verifica se o produto já está no carrinho
                $linhaCarrinho = Linhacarrinho::find()
                    ->where([
                        'carrinho_id' => $carrinho->id,
                        'artigo_id' => $produto->Id
                    ])
                    ->one();

                if ($linhaCarrinho) {
                    // Se o produto já existe no carrinho, incrementa a quantidade e atualiza o valor total
                    $linhaCarrinho->quantidade += $quantidade;
                    $linhaCarrinho->valorTotal = round($linhaCarrinho->valor * $linhaCarrinho->quantidade, 2);
                } else {
                    // Caso contrário, cria uma nova linha no carrinho para o produto
                    $linhaCarrinho = new Linhacarrinho();
                    $linhaCarrinho->carrinho_id = $carrinho->id;
                    $linhaCarrinho->artigo_id = $produto->Id;
                    $linhaCarrinho->quantidade = $quantidade;
                    $linhaCarrinho->valor = round($produto->precoFinal, 2);
                    $linhaCarrinho->valorTotal = round($produto->precoFinal * $quantidade, 2);
                }

                // Salva a linha do carrinho e atualiza os valores totais do carrinho
                if ($linhaCarrinho->save()) {
                    $carrinho->valorIva = $carrinho->getTotalIva();
                    $carrinho->valorTotal = $carrinho->getTotalValue();
                    $carrinho->save();

                    Yii::$app->session->setFlash('success', 'Produto adicionado ao carrinho com sucesso.');
                    return $this->redirect(['carrinho-compras/index']);  // Altere o redirecionamento para onde desejar
                } else {
                    Yii::error('Erro ao salvar linha do carrinho: ' . json_encode($linhaCarrinho->errors));
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
