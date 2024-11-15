<?php

namespace frontend\controllers;

use backend\models\Linhacarrinho;
use common\models\CarrinhoCompras;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarrinhoComprasController implements the CRUD actions for CarrinhoCompras model.
 */
class CarrinhoComprasController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all CarrinhoCompras models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!\Yii::$app->user->isGuest) {
            $carrinho = CarrinhoCompras::find()
                ->where([
                    'user_id' => \Yii::$app->user->id,
                    'estado' => 'ativo'
                ])
                ->orderBy(['data' => SORT_DESC]) //
                ->one();

            if ($carrinho !== null) {
                // Encontrar todas as linhas de carrinho associadas a esse carrinho
                $linhasCarrinho = \common\models\LinhaCarrinho::find()
                    ->where(['carrinho_id' => $carrinho->id])
                    ->all();

                return $this->render('index', [
                    'linhasCarrinho' => $linhasCarrinho,
                    'model' => $carrinho,
                ]);
            } else {

                return $this->render('pagina-sem-carrinho');
            }
        } else {
            // O usuário não está logado, redirecione para a página de login ou mostre uma mensagem de erro
            return $this->redirect(['site/login']);
        }
    }




    public function actionAtualizarQuantidade()
    {
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $itemId = $request->post('itemId');
            $newQuantity = $request->post('newQuantity');

            // Verifica se o item existe e pertence ao carrinho do usuário
            $item = \common\models\Linhacarrinho::findOne($itemId);
            if ($item && $newQuantity > 0) {
                $item->quantidade = $newQuantity;
                $item->valorTotal = $item->valor * $newQuantity;

                if ($item->save()) {
                    // Atualiza o carrinho com o novo total
                    $carrinho = Carrinhocompras::findOne(['user_id' => \Yii::$app->user->id, 'estado' => 'ativo']);
                    if ($carrinho) {
                        $carrinho->valorIva = $carrinho->getTotalIva();
                        $carrinho->valorTotal = $carrinho->getTotalValue();
                        $carrinho->save();

                        \Yii::$app->session->setFlash('success', 'Quantidade atualizada com sucesso.');
                    }
                } else {
                    \Yii::$app->session->setFlash('error', 'Erro ao salvar a nova quantidade.');
                }
            } else {
                \Yii::$app->session->setFlash('error', 'Item não encontrado ou quantidade inválida.');
            }
        }

        return $this->redirect(['carrinho-compras/index']); // Redireciona de volta ao carrinho
    }

    public function actionRemover()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $id = $request->post('id'); // ID do artigo que desejamos remover

            if (!Yii::$app->user->isGuest) {
                // Obter o carrinho ativo do usuário
                $carrinho = Carrinhocompras::find()
                    ->where([
                        'user_id' => Yii::$app->user->id,
                        'estado' => 'ativo'
                    ])
                    ->andWhere(['not', ['estado' => 'finalizado']])
                    ->one();

                if ($carrinho == null) {
                    Yii::$app->session->setFlash('error', 'Carrinho não encontrado.');
                    return $this->redirect(['artigo/index']);
                }

                // Encontrar a linha do carrinho correspondente ao item
                $linhaCarrinho = \common\models\Linhacarrinho::find()
                    ->where([
                        'carrinho_id' => $carrinho->id,
                        'artigo_id' => $id
                    ])
                    ->one();

                if ($linhaCarrinho) {
                    // Remover a linha do carrinho (item do carrinho)
                    if ($linhaCarrinho->delete()) {
                        $carrinho->valorIva = $carrinho->getTotalIva();
                        $carrinho->valorTotal = $carrinho->getTotalValue();
                        $carrinho->save();

                        Yii::$app->session->setFlash('success', 'Artigo removido do carrinho com sucesso.');
                    } else {
                        Yii::$app->session->setFlash('error', 'Erro ao remover o artigo do carrinho.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Artigo não encontrado no carrinho.');
                }

                return $this->redirect(['carrinho-compras/index']);
            } else {
                return $this->redirect(['site/login']);
            }
        }
    }



    /**
     * Displays a single CarrinhoCompras model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CarrinhoCompras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CarrinhoCompras();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CarrinhoCompras model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CarrinhoCompras model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CarrinhoCompras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CarrinhoCompras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CarrinhoCompras::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
