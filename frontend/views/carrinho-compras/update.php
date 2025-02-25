<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CarrinhoCompras $model */

$this->title = 'Update Carrinho Compras: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carrinho Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carrinho-compras-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
