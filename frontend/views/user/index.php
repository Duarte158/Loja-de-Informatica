<?php

use yii\bootstrap5\Html;

?>
<br>
<div class="user-profile">
    <div class="container">
        <div class="row">
            <!-- Coluna para o menu de navegação no lado esquerdo -->
            <div class="col-md-3">
                <div class="card" style="width: 100%;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item <?= Yii::$app->controller->action->id === 'index' ? 'active' : '' ?>" style="cursor: pointer;">
                            <?= Html::a('Perfil', ['user/index', 'id' => $model->id], ['class' => 'text-decoration-none d-block']) ?>
                        </li>
                        <li class="list-group-item <?= Yii::$app->controller->action->id === 'compras' ? 'active' : '' ?>" style="cursor: pointer;">
                            <?= Html::a('Compras', ['user/compras', 'id' => $model->id], ['class' => 'text-decoration-none d-block ']) ?>
                        </li>
                    </ul>
                </div>
            </div>


            <!-- Coluna para o conteúdo principal -->
            <div class="col-md-9">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="profile">
                                <div class="card mt-3">

                                    <div class="card-body">


                                        <div class="row">
                                            <div class="col-sm-4">
                                                <strong>Nome:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= $model->profile !== null ? Html::encode($model->profile->name) : 'N/A' ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <strong>Email:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= Html::encode($model->email) ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <strong>Morada:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= $model->profile !== null ? Html::encode($model->profile->address) : 'N/A' ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <strong>Cidade:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= $model->profile !== null ? Html::encode($model->profile->cidade) : 'N/A' ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <strong>Codigo Postal:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= $model->profile !== null ? Html::encode($model->profile->codpostal) : 'N/A' ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <strong>Contacto:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= $model->profile !== null ? Html::encode($model->profile->contact) : 'N/A' ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <strong>NIF:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= $model->profile !== null ? Html::encode($model->profile->nif) : 'N/A' ?>
                                            </div>
                                        </div>

                                        <hr>
                                        <p>
                                            <?= Html::a('Atualizar Dados', ['update', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="invoices">
                                <div class="card mt-3">
                                    <div class="card-header bg-secondary text-white">
                                        <h4 class="card-title mb-0">Invoices</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-center">No invoices available.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="change-password">
                                <div class="card mt-3">
                                    <div class="card-header bg-warning text-white">
                                        <h4 class="card-title mb-0">Change Password</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-center">Change password form will be here.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Fim da coluna de conteúdo principal -->
        </div>
    </div>
</div>

<style>
    .list-group-item {
        cursor: pointer;
        transition: background-color 0.3s ease;
    }



    .list-group-item.active {
        background-color: #f44336 !important; /* Cor de fundo vermelha para o item ativo */
        color: white; /* Cor do texto branca para o item ativo */
    }

    .list-group-item a {
        display: block; /* Faz o link ocupar toda a área do item */
        color: inherit; /* Herda a cor do item */
        text-decoration: none; /* Remove o sublinhado do link */
    }

    .list-group-item.active a {
        color: white; /* Cor do texto branco no item ativo */
    }
</style>


