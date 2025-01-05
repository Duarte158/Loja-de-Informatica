<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\Compras $model */
/** @var yii\widgets\ActiveForm $form */
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
                                Fornecedor
                                <address>
                                    <strong>
                                        <?= $model->fornecedores_id ? 'Fornecedor Atual: ' . $model->fornecedores_id : 'Nenhum fornecedor associado' ?>
                                    </strong><br>

                                    <!-- Formulário de pesquisa de fornecedor -->
                                    <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['compras/configure', 'id' => $model->id]]); ?>
                                    <?= $form->field($model, 'fornecedores_id')->textInput(['placeholder' => 'Digite o ID do fornecedor para buscar'])->label(false) ?>
                                    <div class="form-group">
                                        <?= Html::submitButton('Buscar Fornecedores', ['class' => 'btn btn-primary']) ?>
                                    </div>
                                    <?php ActiveForm::end(); ?>

                                    <!-- Exibindo a lista de fornecedores -->
                                    <?php if (!empty($fornecedores)): ?>
                                        <div class="mt-3">
                                            <h4>Fornecedores encontrados</h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nome</th>
                                                    <th>Ação</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($fornecedores as $fornecedor): ?>
                                                    <tr>
                                                        <td><?= Html::encode($fornecedor['id']) ?></td>
                                                        <td><?= Html::encode($fornecedor['nome']) ?></td>
                                                        <td>
                                                            <!-- Formulário para selecionar o fornecedor -->
                                                            <?php $form = ActiveForm::begin([
                                                                'method' => 'post',
                                                                'action' => ['compras/update-fornecedor', 'id' => $model->id]
                                                            ]); ?>
                                                            <?= Html::hiddenInput('fornecedores_id', $fornecedor['id']) ?>
                                                            <?= Html::submitButton('Selecionar', ['class' => 'btn btn-success']) ?>
                                                            <?php ActiveForm::end(); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </address>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
