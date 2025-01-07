<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

// Adicionar um filtro na view
?>

<div class="entregas-index">

    <!-- Filtro para os estados -->
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['entregas/index'],
        'options' => ['class' => 'form-inline mb-3'],
    ]); ?>

    <?= $form->field($searchModel, 'estado')->dropDownList(
        ArrayHelper::map(\backend\models\Entregas::find()->select(['estado'])->distinct()->all(), 'estado', 'estado'),
        ['prompt' => 'Selecione o estado', 'class' => 'form-control']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Filtrar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <h1>Entregas</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nome',
            'estado',
            'data',  // Data da entrega
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

</div>
