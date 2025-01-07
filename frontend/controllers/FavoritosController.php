<?php

namespace frontend\controllers;

use frontend\models\Favorito;
use common\widgets\Alert;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;



class FavoritosController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'], // Aceita apenas POST para delete
                ],
            ],
        ];
    }
    /*   public function actionAdd($id)
       {
           $userId = Yii::$app->user->id;
           $wishlist = new Wishlist();
           $wishlist->user_id = $userId;
           $wishlist->product_id = $id;

           if ($wishlist->save()) {
               Yii::$app->session->setFlash('success', 'Artigo adicionado à wishlist com sucesso!');
           } else {
               Yii::$app->session->setFlash('error', 'Ocorreu um erro ao adicionar o artigo à wishlist.');
           }

           return $this->redirect(['artigo/index']); // Redireciona para a página inicial ou qualquer outra
       }*/

    public function actionAdd()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            $userId = Yii::$app->user->id;

            $wishlistItem = Favorito::findOne(['artigo_id' => $id, 'user_id' => $userId]);
            if (!$wishlistItem) {
                $wishlistItem = new Favorito();
                $wishlistItem->artigo_id = $id;
                $wishlistItem->user_id = $userId;

                if ($wishlistItem->save()) {
                    Yii::$app->session->setFlash('success', 'Artigo adicionado à Lista de Favoritos!');
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao adicionar o artigo à Lista de Favoritos.');
                }
            } else {
                Yii::$app->session->setFlash('info', 'Este artigo já está na Lista de Favoritos.');
            }

            return $this->redirect(['site/index', 'id' => $id]);
        }
    }


    public function actionIndex()
    {
        $userId = Yii::$app->user->id;
        $wishlists = Favorito::find()->where(['user_id' => $userId])->all();

        return $this->render('index', [
            'wishlists' => $wishlists,
        ]);
    }

    public function actionDelete($id)
    {
        $wishlistItem = Favorito::findOne($id);
        if ($wishlistItem && $wishlistItem->user_id == Yii::$app->user->id) {
            $wishlistItem->delete();
            Yii::$app->session->setFlash('success', 'Artigo removido dos Favoritos com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Não foi possível remover o artigo dos Favoritos.');
        }
        return $this->redirect(['favoritos/index']);
    }
}