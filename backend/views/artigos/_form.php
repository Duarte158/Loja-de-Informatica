<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Artigos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="artigos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precoUni')->textInput() ?>

    <?= $form->field($model, 'stock')->textInput() ?>

    <?= $form->field($model, 'categoria_id')->textInput() ?>

    <?= $form->field($model, 'iva_id')->textInput() ?>

    <?= $form->field($model, 'destaque')->textInput() ?>

    <?= $form->field($model, 'referencia')->textInput() ?>


    <?= $form->field($model, 'precoFinal')->textInput() ?>

    <?= $form->field($model, 'marca_id')->textInput() ?>

    <?= $form->field($model, 'imagem')->fileInput() ?> <!-- Campo de upload de imagem -->


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
