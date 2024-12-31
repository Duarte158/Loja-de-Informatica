<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\LinhaFaturaFornecedor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="linha-fatura-fornecedor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'quantidade')->textInput() ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <?= $form->field($model, 'referencia')->textInput() ?>

    <?= $form->field($model, 'faturafornecedor_id')->textInput() ?>

    <?= $form->field($model, 'artigo_id')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
