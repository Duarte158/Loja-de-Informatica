<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var backend\models\Compras $model */
/** @var backend\models\Linhafaturafornecedor[] $linhasFatura */
/** @var yii\widgets\ActiveForm $form */
/** @var array $fornecedores */
/** @var array $artigos */


?>

<div class="fatura-fornecedor-create">


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fornecedores_id')->dropDownList($fornecedores, ['prompt' => 'Selecione o Fornecedor']) ?>

    <div class="linhas-fatura">
        <?php foreach ($linhasFatura as $index => $linha): ?>
            <div class="linha-fatura">
                <?= $form->field($linha, "[{$index}]artigo_id")->dropDownList($artigos, ['prompt' => 'Selecione o Produto']) ?>
                <?= $form->field($linha, "[{$index}]quantidade")->input('number', ['min' => 1]) ?>
                <?= $form->field($linha, "[{$index}]valor")->input('number', ['step' => '0.01']) ?>
                <div class="subtotal">Subtotal: €<?= $linha->quantidade * $linha->valor ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
