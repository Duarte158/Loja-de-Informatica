<?php
use yii\bootstrap5\Nav;
use yii\helpers\Html;
use yii\helpers\Url;

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
        'label' => '<span class="step-number">' . (array_search($label, array_keys($steps)) + 1) . '</span> <span class="step-label">' . $label . '</span>',
        'url' => $stepReached ? [$url] : null,
        'encode' => false,
        'linkOptions' => [
            'class' => 'nav-link' . ($isCurrent ? ' active' : '') . (!$stepReached ? ' disabled' : ''),
        ],
    ];
    if ($isCurrent) {
        $stepReached = false;
    }
}

// Valor base: soma dos itens do carrinho (sem envio)
$totalCarrinho = 0;
foreach ($carrinhoItens as $item) {
    $totalCarrinho += $item->quantidade * $item->valor;
}

// Se o carrinho já tiver um envio selecionado, recalcule o total com base no valor do envio
if ($carrinho->envio_id) {
    $envioEscolhido = \common\models\MetodoEnvio::findOne($carrinho->envio_id);
    $displayTotal = $totalCarrinho + ($envioEscolhido ? $envioEscolhido->valor : 0);
} else {
    $displayTotal = $totalCarrinho;
}
?>

<div class="container">
    <?= Nav::widget([
        'options' => ['class' => 'nav step-indicator justify-content-center mb-3'],
        'items' => $stepItems,
    ]) ?>

    <br><br>

    <div class="row">
        <div class="col-md-8 order-md-1">
            <?= Html::beginForm(['carrinho-compras/pagamento'], 'post', ['class' => 'needs-validation', 'novalidate' => true]) ?>

            <h4 class="mb-3">Dados de Envio</h4>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="primeiroNome">Nome</label>
                    <input type="text" class="form-control" id="primeiroNome" name="primeiroNome"
                           value="<?= Html::encode($user->profile->nome) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade"
                       value="<?= Html::encode($user->profile->cidade) ?>">
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
            </div>

            <h4 class="mb-3">Método de Envio</h4>
            <?php foreach ($metodosEnvio as $envio): ?>
                <div class="form-check">
                    <input class="form-check-input metodo-envio" type="radio" name="envio_id"
                           id="envio-<?= $envio->id ?>" value="<?= $envio->id ?>"
                           data-valor="<?= $envio->valor ?>"
                        <?= ($carrinho->envio_id == $envio->id) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="envio-<?= $envio->id ?>">
                        <?= Html::encode($envio->nome) ?> (<?= Yii::$app->formatter->asCurrency($envio->valor) ?>)
                    </label>
                </div>
            <?php endforeach; ?>

            <!-- Campo oculto que guarda o total (que será atualizado via JS) -->
            <input type="hidden" name="valorTotal" id="valorTotal" value="<?= $displayTotal ?>">

            <button type="submit" class="btn btn-primary mt-3">Continuar para Pagamento</button>
            <?= Html::endForm() ?>
        </div>

        <div class="col-md-4 order-md-2">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Detalhes do Carrinho</span>
                <span class="badge bg-secondary"><?= count($carrinhoItens) ?></span>
            </h4>
            <ul class="list-group mb-3">
                <?php foreach ($carrinhoItens as $item): ?>
                    <?php
                    $imagemSrc = Yii::getAlias('@web') . '/imagens/materiais/' . $item->artigo->imagem;
                    $subtotal = $item->quantidade * $item->valor;
                    ?>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div class="d-flex">
                            <img src="<?= $imagemSrc ?>" alt="<?= Html::encode($item->artigo->nome) ?>"
                                 style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
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
                    <!-- Use um campo oculto para armazenar o total base (soma dos itens) que não muda -->
                    <input type="hidden" id="base-total" value="<?= (float)$totalCarrinho ?>">
                    <strong id="total-carrinho" data-base="<?= (float)$totalCarrinho ?>" data-valor="<?= (float)$displayTotal ?>">
                        <?= Yii::$app->formatter->asCurrency($displayTotal) ?>
                    </strong>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    // Sempre utilize o valor do campo oculto "base-total" como base para o cálculo
    const baseTotal = parseFloat(document.getElementById('base-total').value);
    console.log('baseTotal:', baseTotal);

    document.querySelectorAll('.metodo-envio').forEach(input => {
        input.addEventListener('change', function() {
            const envioId = this.value;
            const envioValor = parseFloat(this.dataset.valor);
            // Novo total sempre é o valor base + custo do envio atual
            const novoTotal = baseTotal + envioValor;

            // Atualiza a exibição
            document.getElementById('total-carrinho').innerText =
                new Intl.NumberFormat('pt-PT', { style: 'currency', currency: 'EUR' }).format(novoTotal);
            // Atualiza o campo hidden
            document.getElementById('valorTotal').value = novoTotal;

            // Atualiza o banco de dados via AJAX
            fetch('<?= Url::to(['carrinho-compras/atualizar-total']) ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': '<?= Yii::$app->request->getCsrfToken() ?>'
                },
                body: JSON.stringify({ envio_id: envioId, novo_total: novoTotal })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Opcional: atualize o atributo data-valor se necessário
                        document.getElementById('total-carrinho').dataset.valor = novoTotal;
                    }
                });
        });
    });

    function validateForm() {
        const selectedEnvio = document.querySelector('input[name="envio_id"]:checked');
        if (!selectedEnvio) {
            alert('Por favor, selecione um método de envio antes de continuar.');
            return false;
        }
        return true;
    }
</script>
