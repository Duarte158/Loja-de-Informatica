<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\controllers\FornecedorSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fornecedor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'designacaoSocial') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'nif') ?>

    <?= $form->field($model, 'morada') ?>

    <?php // echo $form->field($model, 'capitalSocial') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
