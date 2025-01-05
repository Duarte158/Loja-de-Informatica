<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $roles */ // Passar a lista de roles do controlador
/** @var string|null $selectedRole */ // Role atualmente selecionada

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .filter-dropdown {
        display: inline-block;
        vertical-align: top;
        margin: 0;
        padding: 5px;
        position: absolute; /* Posiciona de forma absoluta em relação ao seu elemento pai */
        left: 0; /* Alinha à borda esquerda */
        top: 0; /* Alinha ao topo, você pode ajustar a posição conforme necessário */
    }
    .filter-dropdown select {
        width: auto; /* Faz o dropdown ajustar ao tamanho do conteúdo */
        font-size: 14px; /* Ajuste o tamanho da fonte, se necessário */
        padding: 5px; /* Ajuste o espaçamento interno do dropdown */
        border-radius: 4px; /* Suaviza as bordas */
        border: 1px solid #ccc; /* Define a borda */
        background-color: #fff; /* Cor de fundo */
    }
</style>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-8">
            <p>
                <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-md-4">
            <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['index']]); ?>
            <div class="filter-dropdown">
                <?= Html::dropDownList(
                    'role',
                    $selectedRole,
                    $roles,
                    [
                        'class' => 'form-control', // Ou use 'form-control-sm' para um tamanho menor
                        'prompt' => 'Filtrar por Role',
                        'onchange' => 'this.form.submit()' // Envia o formulário ao alterar a seleção
                    ]
                ) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            //'verification_token',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
</div>
