<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\LinhaFaturaFornecedor $model */

$this->title = 'Create Linha Fatura Fornecedor';
$this->params['breadcrumbs'][] = ['label' => 'Linha Fatura Fornecedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-fatura-fornecedor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
