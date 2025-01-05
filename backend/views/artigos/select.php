<?php
use yii\helpers\Html;

/** @var common\models\Artigos[] $artigos */
/** @var int $fatura_id */
/** @var int $quantidade */
?>

<h1>Selecionar Artigo</h1>

<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Referência</th>
        <th>Nome</th>
        <th>Preço</th>
        <th>Quantidade</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($artigos as $artigo): ?>
        <tr>
            <td><?= $artigo->Id ?></td>
            <td><?= $artigo->referencia ?></td>
            <td><?= $artigo->nome ?></td>
            <td><?= Yii::$app->formatter->asCurrency($artigo->preco) ?></td>
            <td>
                <form method="post" action="<?= \yii\helpers\Url::to(['fatura/create', 'id' => $fatura_id]) ?>">
                    <?= Html::hiddenInput('_csrf', Yii::$app->request->csrfToken) ?>
                    <?= Html::hiddenInput('referencia', $artigo->referencia) ?>
                    <?= Html::input('number', 'quantidade', $quantidade, ['class' => 'form-control', 'style' => 'width: 100px']) ?>
                    <?= Html::submitButton('Selecionar', ['class' => 'btn btn-primary']) ?>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
