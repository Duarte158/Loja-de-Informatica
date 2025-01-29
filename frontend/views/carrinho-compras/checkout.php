<?php

use yii\bootstrap5\Nav;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Checkout';
$this->params['breadcrumbs'][] = $this->title;

$carrinhoItens = $linhasCarrinho;



$currentStep = 'Checkout';

$steps = [
    'Checkout' => 'carrinho-compras/checkout',
    'Pagamento' => 'carrinho-compras/pagamento',
    'Confirmação' => 'carrinho-compras/confirmacao',
];

$stepItems = [];
$stepReached = true;

foreach ($steps as $label => $url) {
    $isCurrent = $label === $currentStep;

    $stepItems[] = [
        'label' => '<span class="step-number">' . array_search($label, array_keys($steps)) + 1 . '</span> <span class="step-label">' . $label . '</span>',
        'url' => $stepReached ? [$url] : null, // Desativa os links futuros
        'encode' => false,
        'linkOptions' => [
            'class' => 'nav-link' . ($isCurrent ? ' active' : '') . (!$stepReached ? ' disabled' : ''),
        ],
    ];

    if ($isCurrent) {
        $stepReached = false;
    }
}


?>

<div class="container">
    <?php
    echo Nav::widget([
        'options' => ['class' => 'nav step-indicator justify-content-center mb-3'],
        'items' => $stepItems,
    ]);
    ?>
    <br>
    <br>

    <div class="row">
        <div class="col-md-8 order-md-1">
            <form class="needs-validation" method="POST" action="pagamento" novalidate>
                <h4 class="mb-3">Endereço de cobrança</h4>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="primeiroNome">Nome</label>
                        <input type="text" class="form-control" id="primeiroNome" name="primeiroNome"
                               value="<?= Html::encode($user->profile->nome) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sobrenome">Contacto</label>
                        <input type="text" class="form-control" id="sobrenome" name="sobrenome"
                               value="<?= Html::encode($user->profile->contacto) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="<?= Html::encode($user->email) ?>">
                </div>

                <div class="mb-3">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco"
                           value="<?= Html::encode($user->profile->morada) ?>">
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cep">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep"
                               value="<?= Html::encode($user->profile->codPostal) ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="nif">Nif</label>
                        <input type="text" class="form-control" id="nif" name="nif"
                               value="<?= Html::encode($user->profile->nif) ?>">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Continuar para Pagamento</button>
            </form>
        </div>

        <!-- Coluna da direita (detalhes do carrinho) -->
        <div class="col-md-4 order-md-2">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Detalhes do Carrinho</span>
                <span class="badge bg-secondary"><?= count($carrinhoItens) ?></span>
            </h4>
            <ul class="list-group mb-3">
                <?php $total = 0; ?>
                <?php foreach ($carrinhoItens as $item): ?>
                    <?php
                    $imagemSrc = Yii::getAlias('@web') . '/imagens/materiais/' . $item->artigo->imagem;
                    $subtotal = $item->quantidade * $item->valor;
                    $total += $subtotal;
                    ?>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div class="d-flex">
                            <img src="<?= $imagemSrc ?>" alt="<?= Html::encode($item->artigo->nome) ?>" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                            <div>
                                <h6 class="my-0"><?= Html::encode($item->artigo->nome) ?></h6>
                                <small class="text-muted">Qtd: <?= $item->quantidade ?> x <?= Yii::$app->formatter->asCurrency($item->valor) ?></small>
                            </div>
                        </div>
                        <span class="text-muted"><?= Yii::$app->formatter->asCurrency($subtotal) ?></span>
                    </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (EUR)</span>
                    <strong><?= Yii::$app->formatter->asCurrency($total) ?></strong>
                </li>
            </ul>
        </div>
    </div>
</div>
