<?php

use backend\models\LinhaFaturaFornecedor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Linha Fatura Fornecedors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-fatura-fornecedor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Linha Fatura Fornecedor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'quantidade',
            'valor',
            'referencia',
            'faturafornecedor_id',
            //'artigo_id',
            //'total',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, LinhaFaturaFornecedor $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
