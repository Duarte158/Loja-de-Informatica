<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */
/** @var common\models\Artigos[] $artigos */
/** @var backend\models\Compras $model */

$this->title = 'Selecionar Artigo';
?>

<div class="table-responsive">
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['compras/adicionar-varios-artigos', 'id' => $model->id]),
        'method' => 'post',
    ]); ?>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Selecionar</th>
            <th>Referência</th>
            <th>Nome</th>
            <th>Preço Unitário</th>
            <th>Quantidade</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($artigos as $artigo): ?>
            <tr>
                <td>
                    <!-- Checkbox para selecionar o artigo -->
                    <?= Html::checkbox("artigos[{$artigo->Id}][selecionado]", false, [
                        'class' => 'form-check-input',
                    ]) ?>
                </td>
                <td><?= Html::encode($artigo->referencia) ?></td>
                <td><?= Html::encode($artigo->nome) ?></td>
                <td><?= Html::encode($artigo->precoUni) ?></td>
                <td>
                    <!-- Input para definir a quantidade do artigo -->
                    <?= Html::input('number', "artigos[{$artigo->Id}][quantidade]", 1, [
                        'class' => 'form-control',
                        'min' => 1,
                        'style' => 'width: 100px;',
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="form-group">
        <!-- Botão para adicionar os artigos selecionados -->
        <?= Html::submitButton('Adicionar Artigos Selecionados', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>