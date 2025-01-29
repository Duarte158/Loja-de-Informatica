<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

/** @var yii\web\View $this */
/** @var \common\models\Carrinhocompras $model */
/** @var \common\models\Linhacarrinho $linha */

/** @var yii\widgets\ActiveForm $form */
$csrfParam = Yii::$app->request->csrfParam;

$csrfToken = Yii::$app->request->csrfToken;
$this->registerJsFile('@web/js/calcularDistancia.js');

?>
<header>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</header>

<section class="h-100 gradient-custom">
    <div class="container">
        <div class="row d-flex justify-content-center my-4">
            <!-- Coluna esquerda - Carrinho de itens -->
            <div class="col-md-8"> <!-- Altere o tamanho da coluna aqui, se necessário -->
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Cart - 2 items</h5>
                    </div>
                    <div class="card-body">
                        <!-- Loop para cada item no carrinho -->
                        <?php foreach ($linhasCarrinho as $linhaCarrinho): ?>
                            <div class="row mb-4">
                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                    <?php                         $imagemSrc = Yii::getAlias('@web') . '/imagens/materiais/' . $linhaCarrinho->artigo->imagem;

                                    ?>
                                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                        <img src="<?= $imagemSrc ?>" class="w-100" alt="<?= $linhaCarrinho->artigo->nome ?>"/>
                                        <a href="<?= Yii::$app->urlManager->createUrl(['artigos/artigos-view', 'Id' => $linhaCarrinho->artigo->Id]) ?>">
                                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                    <p><strong><?= $linhaCarrinho->artigo->nome ?></strong></p>
                                    <p><?= number_format($linhaCarrinho->artigo->precoFinal, 2) ?>€</p>
                                    <?= Html::a('Remover do Carrinho', Url::to(['carrinho-compras/remover']), [
                                        'data' => [
                                            'method' => 'post',
                                            'params' => [
                                                'id' => $linhaCarrinho->artigo_id,
                                                $csrfParam => $csrfToken,
                                            ],
                                            'confirm' => 'Tem certeza de que deseja remover este item do carrinho?',
                                        ],
                                        'class' => 'btn btn-danger',
                                    ]) ?>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                    <div class="d-flex mb-4" style="max-width: 300px">
                                        <?= Html::beginForm(['carrinho-compras/atualizar-quantidade'], 'post') ?>
                                        <?= Html::hiddenInput('itemId', $linhaCarrinho->id) ?>
                                        <div class="form-outline">
                                            <?= Html::label('Quantidade', 'quantidade', ['class' => 'form-label']) ?>
                                            <?= Html::input('number', 'newQuantity', $linhaCarrinho->quantidade, [
                                                'class' => 'form-control',
                                                'style' => 'width: 100px;',
                                                'min' => 1,
                                                'onchange' => 'this.form.submit()',
                                            ]) ?>
                                        </div>
                                        <?= Html::endForm() ?>
                                    </div>
                                    <p class="text-start text-md-center">
                                        <strong class="valorTotalUnit">Preço Total: <span id="total-<?= $linhaCarrinho->id ?>"><?= number_format($linhaCarrinho->valorTotal, 2) ?></span>€</strong>
                                    </p>
                                </div>
                            </div>
                            <hr class="my-4"/>
                        <?php endforeach; ?>
                        <div class="row">
                            <div class="col">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna direita - Resumo -->
            <div class="col-md-4"> <!-- Aqui define-se o tamanho da coluna para a área de resumo -->
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Resumo</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Produtos <span class="valor"><?= number_format($model->valorTotal, 2) ?>€</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                IVA <span class="valorIva"><?= number_format($model->valorIva, 2) ?>€</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong>Total</strong>
                                    <strong><p class="mb-0">(incluindo IVA)</p></strong>
                                </div>
                                <span class="valorTotal"><?= number_format($model->valorTotal, 2) ?>€</span>
                            </li>

                            <!-- Campo de entrada para a morada -->

                        </ul>
                        <?= Html::a('Checkout', ['carrinho-compras/checkout'], ['class' => 'btn btn-warning small-btn']) ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


