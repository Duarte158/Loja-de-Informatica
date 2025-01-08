<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Fatura $model */

$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="content">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- Invoice Design -->
                    <div class="invoice p-3 mb-3">

                        <!-- Header -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-file-invoice"></i> Fatura Nº:      <?= Html::encode($model->id) ?>

                                    <small class="float-right">Data: <?= Html::encode(Yii::$app->formatter->asDate($model->data)) ?></small>
                                </h4>
                            </div>
                        </div>

                        <!-- Informações do Cliente -->
                        <div class="row invoice-info mt-4">
                            <div class="col-sm-4 invoice-col">
                                <strong>Informações do Cliente</strong>
                                <address>
                                    <strong><?= Html::encode($model->user->profile->nome) ?></strong><br>
                                    <?= Html::encode($model->user->profile->morada) ?><br>
                                    <?= Html::encode($model->user->profile->cidade) ?>, <?= Html::encode($model->user->profile->codPostal) ?><br>
                                    <?= Html::encode($model->user->profile->contacto) ?><br>
                                    Email: <?= Html::encode($model->user->email) ?>
                                </address>
                            </div>

                            <!-- Informações da Compra -->
                            <div class="col-sm-4 invoice-col">
                                <strong>Informações da Compra</strong>
                                <b>Fatura Nº:</b> <?= Html::encode($model->id) ?><br>
                                <b>Método de Pagamento:</b> <?= Html::encode($model->metodoPagamento->nome) ?><br>
                            </div>
                        </div>

                        <!-- Produtos Adquiridos -->
                        <div class="row mt-4">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Quantidade</th>
                                        <th>Produto</th>
                                        <th>Referência</th>
                                        <th>Preço Unitário</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($linhasCarrinho as $linhaCarrinho): ?>
                                        <tr>
                                            <td><?= Html::encode($linhaCarrinho->quantidade) ?></td>
                                            <td><?= Html::encode($linhaCarrinho->artigo->nome) ?></td>
                                            <td><?= Html::encode($linhaCarrinho->artigo->referencia) ?></td>
                                            <td><?= Html::encode(Yii::$app->formatter->asCurrency($linhaCarrinho->artigo->precoUni)) ?></td>
                                            <td><?= Html::encode(Yii::$app->formatter->asCurrency($linhaCarrinho->valorTotal)) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Totais -->
                        <div class="row mt-4">
                            <div class="col-6"></div> <!-- Espaço vazio na esquerda -->

                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td><?= Html::encode(Yii::$app->formatter->asCurrency($model->carrinho->valorTotal)) ?></td>
                                        </tr>
                                        <tr>
                                            <th>IVA (23%):</th>
                                            <td><?= Html::encode(Yii::$app->formatter->asCurrency($model->carrinho->valorIva)) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td><?= Html::encode(Yii::$app->formatter->asCurrency($model->carrinho->valorTotal)) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="row no-print mt-4">
                            <div class="col-12">
                                <?= Html::a('<i class="fas fa-arrow-left"></i> Voltar', ['fatura/index'], ['class' => 'btn btn-secondary']) ?>
                                <?= Html::a('<i class="fas fa-print"></i> Imprimir', '#', ['class' => 'btn btn-primary float-right', 'onclick' => 'window.print(); return false;']) ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->

                </div>
            </div>
        </div>
    </section>
</div>
