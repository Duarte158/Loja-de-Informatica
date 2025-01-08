<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

$this->title = 'View';
$this->params['breadcrumbs'][] = $this->title;
/** @var backend\models\Product $model */



?>

<section class="py-5">
    <div class="container">
        <div class="row gx-5">
            <aside class="col-lg-6">
                <div class="border rounded-4 mb-3 d-flex justify-content-center">
                    <?php
                    $imagemSrc = Yii::getAlias('@web') . '/imagens/materiais/' . $model->imagem;
                    ?>
                    <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image" href="<?= $imagemSrc ?>">
                        <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="<?= $imagemSrc ?>" />
                    </a>
                </div>
                <!--    <div class="d-flex justify-content-center mb-3">
                        <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank" data-type="image" href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big1.webp" class="item-thumb">
                            <img width="60" height="60" class="rounded-2" src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big1.webp" />
                        </a>
                        <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank" data-type="image" href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big2.webp" class="item-thumb">
                            <img width="60" height="60" class="rounded-2" src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big2.webp" />
                        </a>
                        <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank" data-type="image" href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big3.webp" class="item-thumb">
                            <img width="60" height="60" class="rounded-2" src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big3.webp" />
                        </a>
                        <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank" data-type="image" href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big4.webp" class="item-thumb">
                            <img width="60" height="60" class="rounded-2" src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big4.webp" />
                        </a>
                        <a data-fslightbox="mygalley" class="border mx-1 rounded-2" target="_blank" data-type="image" href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big.webp" class="item-thumb">
                            <img width="60" height="60" class="rounded-2" src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big.webp" />
                        </a>
                    </div> -->
                <!-- thumbs-wrap.// -->
                <!-- gallery-wrap .end// -->
            </aside>
            <main class="col-lg-6">
                <div class="ps-lg-3">
                    <h4 class="title text-dark">
                        <?= $model->nome ?> <br />

                    </h4>.
                    <!--
                    <div class="d-flex flex-row my-3">
                        <div class="text-warning mb-1 me-2">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ms-1">
                4.5
              </span>
                        </div>
                        <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>154 orders</span>
                        <span class="text-success ms-2">In stock</span>
                    </div>
-->
                    <div class="mb-3">
                        <span class="h5"><?= $model->precoFinal?> €</span>
                        <span class="text-muted">/uni</span>
                    </div>

                    <p>
                        <?= $model->descricao ?>
                    </p>
                    <p>
                       Stock:  <?= $model->stock ?>
                    </p>

                    <hr />


                    <!-- Formulário para adicionar ao carrinho -->
                    <!-- Formulário para adicionar ao carrinho -->
                    <?= Html::beginForm(['artigos/adicionar-carrinho'], 'post') ?>
                    <?= Html::hiddenInput('id', $model->Id) ?>
                    <?= Html::input('number', 'quantidade', 1, [
                        'min' => 1,
                        'class' => 'form-control',
                        'style' => 'width: 80px; display: inline-block; margin-right: 10px;',
                    ]) ?>

                    <?= Html::submitButton('Adicionar ao Carrinho', [
                        'class' => 'btn btn-primary',
                        'style' => 'margin-top: 10px;',
                    ]) ?>
                    <?= Html::endForm() ?>

                    <?= Html::beginForm(['favoritos/add'], 'post', ['class' => 'form-add-to-wishlist']) ?>
                    <?= Html::hiddenInput('id', $model->Id) ?>
                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                    <?= Html::submitButton(
                        '<i class="fas fa-heart fa-lg px-1 text-secondary"></i>',
                        [
                            'class' => 'btn btn-light border px-2 pt-2 float-end icon-hover',
                            'style' => 'background: none; border: none; padding: 0; margin: 0;',
                        ]
                    ) ?>
                    <?= Html::endForm() ?>
                </div>
            </main>
        </div>
    </div>
</section>



