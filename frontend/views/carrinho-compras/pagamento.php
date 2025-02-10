<?php

use yii\bootstrap5\Nav;
use yii\helpers\Html;

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

    <h2>Pagamento</h2>

    <p><strong>Nome:</strong> <?= Html::encode($dadosEntrega['primeiroNome']) ?></p>
    <p><strong>Endereço:</strong> <?= Html::encode($dadosEntrega['endereco']) ?></p>
    <p><strong>Contacto:</strong> <?= Html::encode($dadosEntrega['cidade']) ?></p>
    <p><strong>Código Postal:</strong> <?= Html::encode($dadosEntrega['cep']) ?></p>

    <!-- Formulário para confirmar o pagamento -->
<?= Html::beginForm(['carrinho-compras/finalizar'], 'post', ['id' => 'payment-form']) ?>




    <label for="metodoPagamento_id">Selecione o Método de Pagamento:</label>
    <select name="metodoPagamento_id" id="metodoPagamento_id" class="form-control" required>
        <option value="">Escolha um método</option>
        <?php foreach($metodos as $metodo): ?>
            <!-- Supondo que o atributo 'nome' armazena 'paypal', 'multibanco' ou 'mbway' -->
            <option value="<?= $metodo->id ?>" data-type="<?= strtolower($metodo->nome) ?>">
                <?= Html::encode($metodo->nome) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Campos extras para PayPal -->
    <div id="paypal-fields" style="display: none; margin-top: 15px;">
        <label for="paypal-email">Email do PayPal:</label>
        <input type="email" name="paypal_email" id="paypal-email" class="form-control" placeholder="Digite seu email do PayPal">
    </div>

    <!-- Campos extras para Cartão/Multibanco -->
    <div id="cartao-fields" style="display: none; margin-top: 15px;">
        <div class="form-group">
            <label for="card-number">Número do Cartão:</label>
            <input type="text" name="card_number" id="card-number" class="form-control" placeholder="Digite o número do cartão">
        </div>
        <div class="form-group">
            <label for="card-holder">Nome do Titular:</label>
            <input type="text" name="card_holder" id="card-holder" class="form-control" placeholder="Digite o nome do titular">
        </div>
        <div class="form-group">
            <label for="card-expiry">Data de Expiração:</label>
            <input type="text" name="card_expiry" id="card-expiry" class="form-control" placeholder="MM/AA">
        </div>
        <div class="form-group">
            <label for="card-ccv">CCV:</label>
            <input type="text" name="card_ccv" id="card-ccv" class="form-control" placeholder="Digite o CCV">
        </div>
    </div>


    <!-- Campos extras para Mbway -->
    <div id="mbway-fields" style="display: none; margin-top: 15px;">
        <label for="mbway-phone">Número de Telemóvel para Mbway:</label>
        <input type="text" name="mbway_phone" id="mbway-phone" class="form-control" placeholder="Digite seu número de telemóvel">
    </div>

    <br>
<?= Html::submitButton('Finalizar Compra', ['class' => 'btn btn-success']) ?>

<?= Html::endForm() ?>

<?php
// JavaScript para exibir/esconder os campos extras conforme o método de pagamento escolhido
$this->registerJs("
    $('#metodoPagamento_id').on('change', function(){
         var selectedType = $('#metodoPagamento_id option:selected').data('type');
         // Esconde todos os campos extras
         $('#paypal-fields, #cartao-fields, #mbway-fields').hide();
         // Mostra o bloco correspondente ao tipo selecionado
         if(selectedType == 'paypal'){
              $('#paypal-fields').show();
         } else if(selectedType == 'cartão'){
              $('#cartao-fields').show();
         } else if(selectedType == 'mbway'){
              $('#mbway-fields').show();
         }
    });
");
?>