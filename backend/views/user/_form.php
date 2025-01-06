<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $roles */ // Receber a lista de roles do controlador

// Relacione os dados do Profile ao carregar o formulário
$profile = $model->profile ?? new \common\models\Profile();
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Campos do User -->
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <!-- Campos do Profile -->
    <?= $form->field($profile, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($profile, 'morada')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile, 'nif')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile, 'contacto')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile, 'cidade')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile, 'codPostal')->textInput(['maxlength' => true]) ?>

    <!-- Dropdown para selecionar a Role -->
    <?= $form->field($model, 'role')->dropDownList(
        ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'), // Usa a descrição para exibir
        ['prompt' => 'Selecione uma Role']
    ) ?>

    <!-- Campos ocultos ou desativados -->
    <?= $form->field($model, 'password_hash')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
