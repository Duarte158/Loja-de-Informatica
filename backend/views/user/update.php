<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\Profile $profile */

$this->title = 'Atualizar Usuário: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <!-- Formulário para User -->
            <?= $form->field($user, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($user, 'email') ?>

            <!-- Campos para senha -->
            <?= $form->field($user, 'new_password')->passwordInput() ?>
            <?= $form->field($user, 'confirm_password')->passwordInput() ?>
        </div>

        <div class="col-md-6">
            <!-- Formulário para Profile -->
            <?= $form->field($profile, 'nome') ?>
            <?= $form->field($profile, 'nif') ?>
            <?= $form->field($profile, 'morada') ?>
            <?= $form->field($profile, 'contacto') ?>
            <?= $form->field($profile, 'cidade') ?>
            <?= $form->field($profile, 'codPostal') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
