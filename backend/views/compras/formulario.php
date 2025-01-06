<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Compras $model */
?>
<div class="content">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Configurar Compra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Configurar Compra</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info"></i> Nota:</h5>
                        Configure os detalhes desta compra, incluindo o fornecedor e as linhas de compra.
                    </div>

                    <!-- Main Content -->
                    <div class="invoice p-3 mb-3">
                        <!-- Info Row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                Compra
                                <address>
                                    <strong>ID da Compra:</strong> <?= $model->id ?><br>
                                    <strong>Data:</strong> <?= $model->data ?><br>
                                    <strong>Valor Total:</strong> <?= $model->valorTotal ?><br>
                                    <strong>Estado:</strong> <?= $model->estado ?>
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                Fornecedor
                                <address>
                                    <strong>
                                        <?= $model->fornecedores_id ? '' . $model->fornecedores->designacaoSocial : 'Nenhum fornecedor associado' ?>
                                    </strong><br>

                                    <!-- Formulário de pesquisa de fornecedor -->
                                    <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['compras/formulario', 'id' => $model->id]]); ?>
                                    <div class="form-group">
                                        <?= Html::a('Pesquisar Fornecedores', ['compras/search', 'id' => $model->id]);
                                        ?>
                                    </div>
                                    <?php ActiveForm::end(); ?>

                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <b>Número:</b> <?= $model->numero ?><br>
                                <b>Estado:</b> <?= $model->estado ?><br>
                            </div>
                        </div>

                        <!-- Table Row for Adding Lines -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <h4>Linhas de Compra</h4>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Referência</th>
                                        <th>Nome</th>
                                        <th>Quantidade</th>
                                        <th>Valor Uni</th>
                                        <th>Total</th>

                                        <th>Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Linha de Input para Adicionar Artigo -->
                                    <tr>
                                        <?php $form = ActiveForm::begin([
                                            'action' => ['compras/validar-artigo', 'id' => $model->id], // Controller e Action
                                            'method' => 'post',
                                        ]); ?>

                                        <div class="form-group">
                                            <?= Html::textInput('referencia', '', ['class' => 'form-control', 'placeholder' => 'Digite a Referência do Artigo']) ?>
                                        </div>

                                        <div class="form-group">
                                            <?= Html::input('number', 'quantidade', '', ['class' => 'form-control', 'min' => 1, 'placeholder' => 'Quantidade']) ?>
                                        </div>

                                        <div class="form-group">
                                            <?= Html::submitButton('Selecionar', ['class' => 'btn btn-primary']) ?>
                                        </div>

                                        <?php ActiveForm::end(); ?>
                                    </tr>

                                    <!-- Aqui você vai listar as linhas de compra associadas -->
                                    <?php foreach ($linhas as $linha): ?>
                                        <tr>
                                            <td><?= Html::encode($linha->artigo->referencia) ?></td> <!-- Exibe a referência do artigo -->
                                            <td><?= Html::encode($linha->artigo->nome) ?></td> <!-- Exibe a referência do artigo -->

                                            <td><?= Html::encode($linha->quantidade) ?></td> <!-- Exibe a quantidade -->
                                            <td><?= Html::encode($linha->artigo->precoUni) ?>€</td> <!-- Exibe a referência do artigo -->
                                            <td><?= Html::encode($linha->total) ?>€</td> <!-- Exibe a referência do artigo -->


                                            <td>
                                                <?= Html::a('Editar', ['compras/editar-linha', 'id' => $linha->id], ['class' => 'btn btn-warning']) ?>
                                                <?= Html::a('Excluir', ['compras/excluir-linha', 'id' => $linha->id], [
                                                    'class' => 'btn btn-danger',
                                                    'data-method' => 'post',
                                                    'data-confirm' => 'Tem certeza de que deseja excluir esta linha?'
                                                ]) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Final Actions -->
                        <div class="row no-print">
                            <div class="col-12">
                                <?= Html::a('Finalizar Compra', ['compras/finalizar-compra', 'id' => $model->id], [
                                    'class' => 'btn btn-success float-right',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Tem certeza de que deseja finalizar esta compra? O estado será alterado para "Finalizado" e o stock será atualizado.',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
