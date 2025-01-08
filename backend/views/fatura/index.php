<?php

use common\models\Fatura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Faturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Fatura', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'data',
            'user_id',
            [
                'attribute' => 'metodoPagamento.nome',
                'label' => 'Método de Pagamento',
                'value' => function ($model) {
                    return $model->metodoPagamento->nome ?? 'Não definido'; // Mostra "Não definido" se não houver relação
                },
            ],
            [
                'attribute' => 'carrinho.valorTotal',
                'label' => 'Valor Total',
                'value' => function ($model) {
                    return $model->carrinho->valorTotal ?? 'Não definido'; // Mostra "Não definido" se não houver relação
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Fatura $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
