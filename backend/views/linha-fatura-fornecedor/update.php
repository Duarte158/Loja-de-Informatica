<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\LinhaFaturaFornecedor $model */

$this->title = 'Update Linha Fatura Fornecedor: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linha Fatura Fornecedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="linha-fatura-fornecedor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
