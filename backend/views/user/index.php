<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var backend\models\UserSearch $searchModel */
/** @var array $roles */
/** @var string|null $selectedRole */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .filter-dropdown {
        display: inline-block;
        vertical-align: top;
        margin: 0;
        padding: 5px;
        position: absolute;
        left: 0;
        top: 0;
    }
    .filter-dropdown select {
        width: auto;
        font-size: 14px;
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ccc;
        background-color: #fff;
    }
</style>
<div class="user-index">

    <div class="row">
        <div class="col-md-8">
            <p>
                <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-md-4">
            <div class="filter-dropdown">
                <?= Html::beginForm(['index'], 'get') ?>
                <?= Html::dropDownList(
                    'role',
                    $selectedRole,
                    $roles,
                    [
                        'class' => 'form-control',
                        'prompt' => 'Filter by Role',
                        'onchange' => 'this.form.submit()'
                    ]
                ) ?>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
</div>