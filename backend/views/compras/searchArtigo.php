<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Buscar Fornecedores';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Fornecedores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Fornecedores</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Lista de Fornecedores -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Artigos disponíveis</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($artigos as $artigo): ?>
                                    <tr>
                                        <td><?= Html::encode($artigo->Id) ?></td>
                                        <td><?= Html::encode($artigo->nome) ?></td>
                                        <td>
                                            <?= Html::a('Selecionar', ['compras/select', 'id' => $model->id, 'fornecedor_id' => $artigo->Id], ['class' => 'btn btn-success']) ?>
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
    </section>
</div>
