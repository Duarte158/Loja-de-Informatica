<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var \common\models\Carrinhocompras $model */
/** @var \common\models\Linhacarrinho $linha */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carrinho Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="content-wrapper">

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">


                    <div class="invoice p-3 mb-3">

                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> AdminLTE, Inc.
                                    <small class="float-right">Date: 2/10/2014</small>
                                </h4>
                            </div>

                        </div>

                        <div class="col-sm-4 invoice-col">
                            <address>
                                <strong><?= Html::encode($model->user->profile->nome) ?></strong><br>
                                <?= Html::encode($model->user->profile->morada) ?><br>
                                <?= Html::encode($model->user->profile->cidade) ?>, <?= Html::encode($model->user->profile->codPostal) ?><br>
                                <?= Html::encode($model->user->profile->contacto) ?><br>
                                Email: <?= Html::encode($model->user->email) ?>
                            </address>
                        </div>


                        <div class="col-sm-4 invoice-col">
                            <b>Compra: <?= Html::encode($model->id) ?></b><br>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>Product</th>
                                    <th>Serial #</th>
                                    <th>Description</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($linhasCarrinho as $linhaCarrinho): ?>
                                    <tr>
                                        <td><?= Html::encode($linhaCarrinho->quantidade) ?></td>
                                        <td><?= Html::encode($linhaCarrinho->artigo->nome) ?></td>
                                        <td><?= Html::encode($linhaCarrinho->artigo->referencia) ?></td>
                                        <td><?= Html::encode(number_format($linhaCarrinho->artigo->precoUni, 2)) ?>€</td>
                                        <td><?= Html::encode(number_format($linhaCarrinho->valorTotal, 2)) ?>€</td>
                                    </tr>
                                <?php endforeach;?>


                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-6">

                        </div>

                        <div class="col-6">

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Produtos:</th>
                                        <td><?= Html::encode(number_format($model->valorTotal, 2)) ?>€</td>
                                    </tr>
                                    <tr>
                                        <th>Iva (23%)</th>
                                        <td><?= Html::encode(number_format($model->valorIva, 2)) ?>€</td>
                                    </tr>




                                    <tr>
                                        <th>Total:</th>
                                        <td><?= Html::encode(number_format($model->valorTotal, 2)) ?>€</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
        </div>
</div>
</section>

</div>