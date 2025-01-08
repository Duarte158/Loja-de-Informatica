<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('@web/css/wishlist.css');

?>


<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Loja</title>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<div class="cart-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-wishlist">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <thead>
                        <tr>
                            <th width="45%">Product Name</th>
                            <th width="15%">Unit Price</th>
                            <th width="15%">Stock Status</th>
                            <th width="15%"></th>
                            <th width="10%"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($wishlists as $wishlist): ?>
                            <?php
                            $imagemSrc = 'http://localhost/Loja-de-Informatica/frontend/web/imagens/materiais/' . $wishlist->artigo->imagem;
                            ?>
                            <tr>
                                <td width="20%">
                                    <div class="display-flex align-center">
                                        <div class="img-product">
                                            <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">

                                                <img src="<?= $imagemSrc ?>" class="card-img-top" alt="<?= $wishlist->artigo->nome ?>" />
                                            </div>
                                        </div>
                                        <div class="name-product">
                                            <?= Html::encode($wishlist->artigo->nome) ?>
                                        </div>
                                    </div>
                                </td>
                                <td width="15%" class="price"><?= Html::encode(number_format($wishlist->artigo->precoFinal, 2)) ?>€</td>
                                <td width="15%">
                                    <?php $form = ActiveForm::begin([
                                        'action' => ['artigos/adicionar-carrinho'],
                                        'method' => 'post',
                                    ]); ?>
                                    <div class="input-group">
                                        <?= Html::hiddenInput('id', $wishlist->artigo->Id) ?>
                                        <input type="number" class="form-control" id="quantidade" name="quantidade" value="1" min="1">
                                    </div>
                                </td>
                                <td width="15%">
                                    <?= Html::submitButton('Add Carrinho', ['class' => 'btn btn small-btn']) ?>
                                    <?php ActiveForm::end(); ?>
                                </td>
                                <td width="10%" class="text-center">
                                    <?= Html::a('<i class="far fa-trash-alt"></i>', ['favoritos/delete', 'id' => $wishlist->id], [
                                        'class' => 'trash-icon',
                                        'data' => [
                                            'confirm' => 'Tem certeza de que deseja remover este item dos Favoritos?',
                                            'method' => 'post', // Garante que será enviado como POST
                                        ],
                                    ]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>





