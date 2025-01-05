<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\Fornecedor[] $fornecedores */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Selecionar Fornecedor';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="fornecedor-select">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="search-form">
        <?php $form = ActiveForm::begin(['action' => Url::to(['fornecedor/select'])]); ?>

        <?= $form->field($searchModel, 'search')->textInput(['placeholder' => 'Pesquise por fornecedor']) ?>

        <div class="form-group">
            <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="fornecedor-list">
        <ul>
            <?php foreach ($fornecedores as $fornecedor): ?>
                <li>
                    <?= Html::a($fornecedor->designacaoSocial, ['compras/create', 'fornecedorId' => $fornecedor->ID], ['class' => 'btn btn-link']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
