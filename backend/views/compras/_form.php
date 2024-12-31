<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/** @var yii\web\View $this */
/** @var backend\models\Compras $model */
/** @var backend\models\Linhafaturafornecedor[] $linhasFatura */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fatura-fornecedor-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'fornecedores_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\backend\models\Fornecedor::find()->all(), 'id', 'designacaoSocial'),
        ['prompt' => 'Selecione o Fornecedor']
    ) ?>

    <?= $form->field($model, 'data')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'valorTotal')->textInput(['readonly' => true]) ?>

    <h4>Linhas da Fatura</h4>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.item',
        'min' => 1,
        'insertButton' => '.add-item',
        'deleteButton' => '.remove-item',
        'model' => $linhasFatura[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'artigo_id',
            'quantidade',
        ],
    ]); ?>

    <div class="container-items">
        <?php foreach ($linhasFatura as $i => $linha): ?>
            <div class="item panel panel-default">
                <div class="panel-heading">
                    <div class="pull-right">
                        <button type="button" class="add-item btn btn-success btn-xs"><i class="fa fa-plus"></i></button>
                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <?= $form->field($linha, "[{$i}]artigo_id")->dropDownList(
                        \yii\helpers\ArrayHelper::map(\common\models\Artigos::find()->all(), 'id', 'nome'),
                        ['prompt' => 'Selecione um Artigo']
                    ) ?>

                    <?= $form->field($linha, "[{$i}]quantidade")->textInput(['type' => 'number', 'min' => 1]) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php DynamicFormWidget::end(); ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
