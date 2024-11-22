<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Funcionario $model */

$this->title = 'Create Funcionario';
$this->params['breadcrumbs'][] = ['label' => 'Funcionarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funcionario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
