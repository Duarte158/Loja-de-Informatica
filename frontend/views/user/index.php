<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile">



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <?php
                echo \yii\bootstrap5\Nav::widget([
                    'options' => ['class' => 'nav nav-tabs nav-justified mb-3'],
                    'items' => [
                        ['label' => 'Profile', 'url' => ['user/index', 'id' => $model->id], 'linkOptions' => ['class' => 'nav-link active']],
                        ['label' => 'Compras', 'url' => ['user/compras', 'id' => $model->id], 'linkOptions' => ['class' => 'nav-link']],
                    ],
                ]);
                ?>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="profile">
                        <div class="card mt-3">
                            <div class="card-header card-background text-white">
                                <h4 class="card-title mb-0">Perfil</h4>
                                <h4 class="card-title mb-0">Dados de Faturação</h4>
                            </div>

                            <div class="card-body">

                                <p>
                                    <?= Html::a('Atualizar Dados', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

                                </p>

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
                                <div class="row">
                                    <div class="col-sm-4">
                                        <strong>Password</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= Html::a('Mudar Password', ['site/request-password-reset'], ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>




                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="invoices">
                        <div class="card mt-3">
                            <div class="card-header bg-secondary text-white">
                                <h4 class="card-title mb-0">Invoices</h4>
                            </div>
                            <div class="card-body">
                                <!-- Content for Invoices will be loaded here -->
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
                                <!-- Content for Change Password will be loaded here -->
                                <p class="text-center">Change password form will be here.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>