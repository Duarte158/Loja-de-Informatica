<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Compras $model */
/** @var backend\models\Linhafaturafornecedor[] $linhasFatura */

$this->title = 'Criar Fatura de Fornecedor';
$this->params['breadcrumbs'][] = ['label' => 'Faturas de Fornecedor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-fornecedor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'linhasFatura' => $linhasFatura,
    ]) ?>

</div>
