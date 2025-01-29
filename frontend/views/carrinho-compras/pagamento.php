<?php

use yii\bootstrap5\Nav;

$currentStep = 'Pagamento';

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