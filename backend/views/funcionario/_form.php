<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Funcionario $model */
/** @var common\models\Profile $profile */

/** @var yii\widgets\ActiveForm $form */
?>

<div class="funcionario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <!-- Campos do Profile -->
    <?= $form->field($profile, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($profile, 'morada')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile, 'nif')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile, 'contacto')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile, 'cidade')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile, 'codPostal')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>