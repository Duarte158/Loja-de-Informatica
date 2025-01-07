<?php
use yii\helpers\Html;

$this->title = 'Checkout';
$this->params['breadcrumbs'][] = $this->title;

$carrinhoItens = $linhasCarrinho;
?>

<div class="container">
    <div class="row">
        <!-- Formulário que abrange a página toda -->
        <form class="needs-validation" method="POST" action="finalizar" novalidate style="width: 100%;">
            <!-- CSRF Token do Yii (Necessário para segurança) -->

            <!-- Coluna da esquerda (formulário de checkout) -->
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Endereço de cobrança</h4>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="primeiroNome">Nome</label>
                        <input type="text" class="form-control" id="primeiroNome" name="primeiroNome" value="<?= $user->profile->nome ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sobrenome">Contacto</label>
                        <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?= $user->profile->contacto ?>" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $user->email ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?= $user->profile->morada ?>" readonly>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cep">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" value="<?= $user->profile->codPostal ?>" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="nif">Nif</label>
                        <input type="text" class="form-control" id="nif" name="nif" value="<?= $user->profile->nif ?>" readonly>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- Checkbox para usar o mesmo endereço para envio -->
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="mesmo-endereco" name="mesmoEndereco" value="1" checked>
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
                        <?php $imagemSrc = 'http://localhost/Loja-de-Informatica/frontend/web/imagens/materiais/' . $item->artigo->imagem; ?>

                        <?php
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

                <!-- Seleção de método de pagamento -->
                <div class="mt-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Método de Pagamento</span>
                    </h4>

                    <div class="mb-3">
                        <label for="metodoPagamento">Selecione o Método de Pagamento</label>
                        <select class="form-control" id="metodoPagamento_id" name="metodoPagamento_id" required>
                            <option value="" disabled selected>Selecione o Método de Pagamento</option>
                            <?php foreach ($metodos as $metodo): ?>
                                <option value="<?= $metodo->id ?>"><?= Html::encode($metodo->nome) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Campos de pagamento específicos -->
                    <div id="cartaoPagamento" class="mb-3">
                        <label for="numeroCartao">Número do Cartão</label>
                        <input type="text" class="form-control" id="numeroCartao" name="numeroCartao" placeholder="Número do Cartão">
                        <small class="text-muted">Ex.: 1234 5678 9012 3456</small>
                    </div>

                    <div id="dataValidade" class="row">
                        <div class="col-md-6 mb-3">
                            <label for="mesValidade">Mês de Validade</label>
                            <input type="text" class="form-control" id="mesValidade" name="mesValidade" placeholder="MM">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="anoValidade">Ano de Validade</label>
                            <input type="text" class="form-control" id="anoValidade" name="anoValidade" placeholder="AA">
                        </div>
                    </div>

                    <div id="codigoSeguranca" class="mb-3">
                        <label for="cvv">Código de Segurança (CVV)</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV">
                        <small class="text-muted">3 dígitos atrás do cartão</small>
                    </div>

                    <!-- Botão para continuar -->
                    <button type="submit" class="btn btn-warning small-btn">Finalizar carrinho</button>
                </div>
            </div>

        </form>
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
