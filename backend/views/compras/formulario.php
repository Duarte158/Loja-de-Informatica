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

                                    <!-- Exibindo a lista de fornecedores -->

                                        </div>
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
                                        <th>Quantidade</th>
                                        <th>Produto</th>
                                        <th>Preço</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Aqui você pode listar as linhas já associadas à compra -->
                                    </tbody>
                                </table>
                                <button class="btn btn-success" onclick="addLinha()">Adicionar Linha</button>
                            </div>
                        </div>

                        <!-- Final Actions -->
                        <div class="row no-print">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-save"></i> Finalizar Compra
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
