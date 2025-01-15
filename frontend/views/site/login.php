<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="text-center text-lg-start">
    <style>
        .rounded-t-5 {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        @media (min-width: 992px) {
            .rounded-tr-lg-0 {
                border-top-right-radius: 0;
            }

            .rounded-bl-lg-5 {
                border-bottom-left-radius: 0.5rem;
            }
        }
    </style>
    <div class="card mb-3">
        <div class="row g-0 d-flex align-items-center">
            <div class="col-lg-4 d-none d-lg-flex">
                <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" alt="Trendy Pants and Shoes"
                     class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
            </div>
            <div class="col-lg-8">
                <div class="card-body py-5 px-md-5">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <!-- Username input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <?= $form->field($model, 'username', [
                            'options' => ['tag' => false],
                            'template' => '{input}{label}{error}',
                            'labelOptions' => ['class' => 'form-label'],
                        ])->textInput([
                            'class' => 'form-control',
                            'autofocus' => true,
                        ]) ?>
                    </div>

                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <?= $form->field($model, 'password', [
                            'options' => ['tag' => false],
                            'template' => '{input}{label}{error}',
                            'labelOptions' => ['class' => 'form-label'],
                        ])->passwordInput([
                            'class' => 'form-control',
                        ]) ?>
                    </div>

                    <!-- 2 column grid layout for inline styling -->
                    <div class="row mb-4">
                        <div class="col d-flex justify-content-center">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <?= $form->field($model, 'rememberMe', [
                                    'options' => ['class' => 'form-check'],
                                    'template' => '{input}{label}{error}',
                                    'labelOptions' => ['class' => 'form-check-label'],
                                ])->checkbox([
                                    'class' => 'form-check-input',
                                    'value' => 1,
                                ], false) ?>
                            </div>
                        </div>

                        <div class="col">
                            <!-- Simple link -->
                            <a href="<?= Yii::$app->urlManager->createUrl(['/site/signup']) ?>" class="text-body">Sign Up</a>
                        </div>


                    </div>

                    <!-- Submit button -->
                    <?= Html::submitButton('Sign in', [
                        'class' => 'btn btn-primary btn-block mb-4',
                        'name' => 'login-button',
                    ]) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
