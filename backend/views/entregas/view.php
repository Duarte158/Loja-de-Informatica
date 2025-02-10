<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Entregas $model */
/** @var array $linhasCarrinho */

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
                                    <i class="fas fa-file-invoice"></i> Entrega Nº: <?= Html::encode($model->id) ?>
                                    <small class="float-right">Data: <?= Html::encode(Yii::$app->formatter->asDate($model->data)) ?></small>
                                </h4>
                            </div>
                        </div>

                        <!-- Informações do Cliente e da Entrega -->
                        <div class="row invoice-info mt-4">
                            <div class="col-sm-4 invoice-col">
                                <strong>Dados de Entrega do Cliente</strong>
                                <address>
                                    <strong>Nome:</strong> <?= Html::encode($model->nome) ?><br>
                                    <strong>Morada:</strong> <?= Html::encode($model->morada) ?><br>
                                    <strong>Cidade:</strong> <?= Html::encode($model->cidade) ?>,
                                    <strong>Cod Postal:</strong> <?= Html::encode($model->codPostal) ?><br>
                                    <strong>Contacto:</strong> <?= Html::encode($model->user->profile->contacto) ?><br>
                                    <strong>Email:</strong> <?= Html::encode($model->user->email) ?>
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <strong>Informações de Entrega</strong>
                                <b>Entrega Nº:</b> <?= Html::encode($model->id) ?><br>
                                <strong>Estado da entrega:</strong> <?= Html::encode($model->estado) ?><br>
                            </div>
                        </div>

                        <div class="btn-group" role="group" aria-label="Alteração de estado">
                            <?php if ($model->estado === 'Por entregar'): ?>
                                <!-- Se estiver por entregar: permite mudar para "em preparação" e desativa o botão de "entregue" -->
                                <?= Html::a('Marcar como em preparação', ['entregas/alterar-estado', 'id' => $model->id, 'estado' => 'em preparação'], [
                                    'class' => 'btn btn-primary',
                                    'data-method' => 'post'
                                ]) ?>
                                <?= Html::a('Marcar como entregue', '#', [
                                    'class' => 'btn btn-success disabled',
                                    'disabled' => true,
                                ]) ?>
                            <?php elseif ($model->estado === 'em preparação'): ?>
                                <!-- Se estiver em preparação: desativa o botão de "em preparação" e permite mudar para "entregue" -->
                                <?= Html::a('Marcar como em preparação', '#', [
                                    'class' => 'btn btn-primary disabled',
                                    'disabled' => true,
                                ]) ?>
                                <?= Html::a('Marcar como entregue', ['entregas/alterar-estado', 'id' => $model->id, 'estado' => 'entregue'], [
                                    'class' => 'btn btn-success',
                                    'data-method' => 'post'
                                ]) ?>
                            <?php else: ?>
                                <!-- Se já estiver entregue, ambos os botões ficam desativados -->
                                <?= Html::a('Marcar como em preparação', '#', [
                                    'class' => 'btn btn-primary disabled',
                                    'disabled' => true,
                                ]) ?>
                                <?= Html::a('Marcar como entregue', '#', [
                                    'class' => 'btn btn-success disabled',
                                    'disabled' => true,
                                ]) ?>
                            <?php endif; ?>
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

                        <!-- Botões de Ação Gerais -->
                        <div class="row no-print mt-4">
                            <div class="col-12">
                                <?= Html::a('<i class="fas fa-arrow-left"></i> Voltar', ['fatura/index'], ['class' => 'btn btn-secondary']) ?>
                                <?= Html::a('<i class="fas fa-print"></i> Imprimir', '#', [
                                    'class' => 'btn btn-primary float-right',
                                    'onclick' => 'window.print(); return false;'
                                ]) ?>
                            </div>
                        </div>

                    </div>
                    <!-- /.invoice -->

                </div>
            </div>
        </div>
    </section>
</div>
