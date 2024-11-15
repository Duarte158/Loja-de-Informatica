<?php

use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Compras';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-profile">



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <?php
                echo Nav::widget([
                    'options' => ['class' => 'nav nav-tabs nav-justified mb-3'],
                    'items' => [
                        ['label' => 'Profile', 'url' => ['user/index', 'id' => $model->id], 'linkOptions' => ['class' => 'nav-link']],
                        ['label' => 'Compras', 'url' => ['user/compras'], 'linkOptions' => ['class' => 'nav-link active']],
                    ],
                ]);
                ?>

                <div class="tab-content">


                    <div class="tab-pane fade show active" id="invoices">
                        <div class="card mt-3">

                            <div class="card-header card-background text-black">
                                <h4 class="card-title mb-0">Compras Finalizadas</h4>
                            </div>
                            <div class="card-body">
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        'valorTotal',
                                        'data',
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{view}',
                                            'buttons' => [
                                                'view' => function ($url, $model) {
                                                    return Html::a('Ver', ['user/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                                                },
                                            ],
                                        ],
                                    ],
                                    'tableOptions' => ['class' => 'table table-bordered table-striped table-hover'],
                                ]); ?>
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
