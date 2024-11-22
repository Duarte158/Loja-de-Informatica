<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Artigos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'referencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precoUni')->textInput() ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'categoria_id')->dropDownList(
        ArrayHelper::map(\common\models\Categoria::find()->all(), 'id', 'descricao'),
        ['prompt' => 'Selecione a categoria']
    ) ?>

    <?= $form->field($model, 'iva_id')->dropDownList(
        ArrayHelper::map(\common\models\Iva::find()->all(), 'id', 'descricao'),
        ['prompt' => 'Selecione o Iva']
    ) ?>


    <?= $form->field($model, 'marca_id')->dropDownList(
        ArrayHelper::map(\common\models\Marca::find()->all(), 'id', 'nome'),
        ['prompt' => 'Selecione a marca']
    ) ?>

    <?= $form->field($model, 'destaque')->checkbox() ?>


    <?= $form->field($model, 'imagem')->fileInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

