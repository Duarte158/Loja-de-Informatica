<?php
use yii\helpers\Html;

$this->title = 'Checkout';
$this->params['breadcrumbs'][] = $this->title;

$nome = Html::encode($user->profile->nome);
$contacto = Html::encode($user->profile->contacto);
$codpostal = Html::encode($user->profile->codPostal);
$cidade = Html::encode($user->profile->cidade);
$endereco = Html::encode($user->profile->morada);
$nif = Html::encode($user->profile->nif);
$carrinhoItens = $linhasCarrinho; // Assumindo que $carrinho contém os itens.
?>

<div class="container">
    <div class="row">
        <!-- Coluna da esquerda (formulário de checkout) -->
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Endereço de cobrança</h4>
            <form class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="primeiroNome">Nome</label>
                        <input type="text" class="form-control" id="primeiroNome" value="<?= $nome ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sobrenome">Contacto</label>
                        <input type="text" class="form-control" id="sobrenome" value="<?= $contacto ?>" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" value="<?= $user->email ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" id="endereco" value="<?= $endereco ?>" readonly>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cep">CEP</label>
                        <input type="text" class="form-control" id="cep" value="<?= $codpostal ?>" readonly>
                    </div>
                </div>

                <hr class="mb-4">
                <!-- Checkbox para usar o mesmo endereço para envio -->
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="mesmo-endereco" name="mesmoEndereco" checked>
                    <label class="custom-control-label" for="mesmo-endereco">Endereço de envio é o mesmo que o de cobrança</label>
                </div>

                <!-- Campos de endereço de envio (escondidos por padrão) -->
                <div id="endereco-envio" style="display: none;">
                    <h4 class="mb-3">Endereço de envio</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nomeEnvio">Nome</label>
                            <input type="text" class="form-control" id="nomeEnvio" name="nomeEnvio" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contactoEnvio">Contacto</label>
                            <input type="text" class="form-control" id="contactoEnvio" name="contactoEnvio" value="">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="enderecoEnvio">Endereço</label>
                        <input type="text" class="form-control" id="enderecoEnvio" name="enderecoEnvio" value="">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cidadeEnvio">Cidade</label>
                            <input type="text" class="form-control" id="cidadeEnvio" name="cidadeEnvio" value="">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="codpostalEnvio">CEP</label>
                            <input type="text" class="form-control" id="codpostalEnvio" name="codpostalEnvio" value="">
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <a href="<?= \yii\helpers\Url::to(['carrinho-compras/pagamento']) ?>" class="btn btn-primary btn-lg btn-block">
                    Continue o checkout
                </a>
            </form>
        </div>

        <!-- Coluna da direita (Resumo do carrinho) -->
        <div class="col-md-4 order-md-2">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Seu Carrinho</span>
                <span class="badge badge-secondary badge-pill"><?= count($carrinhoItens) ?></span>
            </h4>
            <ul class="list-group mb-3">
                <?php $total = 0; ?>
                <?php foreach ($carrinhoItens as $item): ?>
                    <?php
                    $subtotal = $item->quantidade * $item->valor;
                    $total += $subtotal;
                    ?>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0"><?= Html::encode($item->artigo->nome) ?></h6>
                            <small class="text-muted">Qtd: <?= $item->quantidade ?> x <?= Yii::$app->formatter->asCurrency($item->valor) ?></small>
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


<script>
    // Função para mostrar/ocultar campos de endereço de envio
    document.getElementById('mesmo-endereco').addEventListener('change', function() {
        var envioDiv = document.getElementById('endereco-envio');
        if (this.checked) {
            envioDiv.style.display = 'none';
        } else {
            envioDiv.style.display = 'block';
        }
    });


</script>
