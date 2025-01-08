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


    <?= $form->field($model, 'categoria_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Categoria::find()->all(), 'id', 'descricao'),
        ['prompt' => 'Selecione a categoria']
    ) ?>
    <?= $form->field($model, 'iva_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Iva::find()->all(), 'id', 'descricao'),
        ['prompt' => 'Selecione o Iva']
    ) ?>
    <?= $form->field($model, 'destaque')->checkbox() ?>

    <?= $form->field($model, 'referencia')->textInput() ?>

    <?= $form->field($model, 'imagem')->fileInput() ?>

    <?= $form->field($model, 'marca_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Marca::find()->all(), 'id', 'nome'),
        ['prompt' => 'Selecione a marca']
    ) ?>
    <?= $form->field($model, 'unidade_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Unidade::find()->all(), 'id', 'descricao'),
        ['prompt' => 'Selecione a unidade']
    ) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
