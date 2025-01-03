<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Compras $model */
/** @var backend\models\Linhafaturafornecedor[] $linhasFatura */
/** @var array $fornecedores */
/** @var array $artigos */

$this->title = 'Criar Fatura de Fornecedor';
$this->params['breadcrumbs'][] = ['label' => 'Faturas de Fornecedor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-fornecedor-create">


    <?= $this->render('_form', [
        'model' => $model,
        'linhasFatura' => $linhasFatura,
        'fornecedores' => $fornecedores, // Passando corretamente o array de fornecedores
        'artigos' => $artigos, // Passando corretamente o array de artigos
    ]) ?>

</div>
