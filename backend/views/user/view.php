<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->username; // Exibe o username como título
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            [
                'label' => 'Morada',
                'value' => $model->profile->morada ?? '(Não definido)', // Campo do Profile
            ],
            [
                'label' => 'NIF',
                'value' => $model->profile->nif ?? '(Não definido)', // Campo do Profile
            ],
            [
                'label' => 'Contacto',
                'value' => $model->profile->contacto ?? '(Não definido)', // Campo do Profile
            ],
            [
                'label' => 'Cidade',
                'value' => $model->profile->cidade ?? '(Não definido)', // Campo do Profile
            ],
            [
                'label' => 'Codigo Postal',
                'value' => $model->profile->codPostal ?? '(Não definido)', // Campo do Profile
            ],
            'status', // Campo do User
        ],
    ]) ?>

</div>
