<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

/** @var yii\web\View $this */
/** @var \common\models\Carrinhocompras $model */
/** @var \common\models\LinhaCarrinho $linha */

/** @var yii\widgets\ActiveForm $form */

$this->registerCssFile('@web/css/carrinhoIndex.css', ['depends' => []]);


?>
<header>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</header>

<section class="h-100 gradient-custom">
    <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Cart - 2 items</h5>
                    </div>
                    <div class="card-body">
                        <!-- Single item -->


                        <!-- foreach START -->
                      //  <?php foreach ($linhasCarrinho as $linhaCarrinho): ?>
                            <div class="row">
                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                    <!-- Image -->
                                    <?php
                                    $imagemSrc = 'http://localhost/jcfTaicar/frontend/web/images/materiais/' . $linhaCarrinho->artigo->image;
                                    ?>
                                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                        <img src="<?= $imagemSrc ?>"
                                             class="w-100" alt="Blue Jeans Jacket" />
                                        <a href="#!">
                                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                        </a>
                                    </div>
                                    <!-- Image -->
                                </div>

                                <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                    <!-- Data -->
                                    <p><strong><?= $linhaCarrinho->artigo->name ?></strong></p>
                                    <p><?= $linhaCarrinho->artigo->priceUni ?>€</p>

                                    <br>
                                    <br>

                                    <?= Html::a('Eliminar Artigo', ['carrinho-compras/remover', 'id' => $linhaCarrinho->id], [
                                        'class' => 'remove-item',
                                        'data' => [

                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                    <!-- Data -->
                                </div>

                                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                    <!-- Quantity -->
                                    <div class="d-flex mb-4" style="max-width: 300px">


                                        <div class="form-outline">
                                            <input
                                                    id="quantityInput<?= $linhaCarrinho->id ?>"
                                                    min="0"
                                                    name="quantity"
                                                    value="<?= $linhaCarrinho->quantidade ?>"
                                                    type="number"
                                                    class="form-control quantity-input"
                                                    data-item-id="<?= $linhaCarrinho->id ?>"
                                                    onchange="updateCartQuantity(this)"  <!-- Chama a função ao mudar valor -->
                                            />
                                            <label class="form-label" for="quantityInput<?= $linhaCarrinho->id ?>">Quantidade</label>
                                            <p class="feedback" id="feedback-<?= $linhaCarrinho->id ?>"></p> <!-- Para exibir feedback do usuário -->
                                        </div>
                                    </div>
                                    <!-- Quantity -->

                                    <!-- Price -->
                                    <p class="text-start text-md-center">

                                        <strong class="valorTotalUnit">Preço Total: <?= $linhaCarrinho->valorTotal ?>€</strong>
                                    </p>
                                    <!-- Price -->
                                </div>
                            </div>
                            <!-- Single item -->

                            <hr class="my-4" />

                        <?php endforeach; ?>
                        <!-- foreach end -->


                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <p><strong>Expected shipping delivery</strong></p>
                        <p class="mb-0">12.10.2020 - 14.10.2020</p>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                    <div class="card-body">
                        <p><strong>We accept</strong></p>
                        <img class="me-2" width="45px"
                             src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
                             alt="Visa" />
                        <img class="me-2" width="45px"
                             src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg"
                             alt="American Express" />
                        <img class="me-2" width="45px"
                             src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
                             alt="Mastercard" />
                        <img class="me-2" width="45px"
                             src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce/includes/gateways/paypal/assets/images/paypal.webp"
                             alt="PayPal acceptance mark" />
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Summary</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Products
                                <span class="valor"><?php echo $model->valor?>€</span>
                            </li>
                            <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Products
                                <span class="valorIva"><?php echo $model->valorIva?>€</span>

                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                Shipping
                                <span>Gratis</span>
                            </li>
                            <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong>Total amount</strong>
                                    <strong>
                                        <p class="mb-0">(including VAT)</p>
                                    </strong>
                                </div>
                                <span class="valorTotal"><?php echo $model->valorTotal?>€</span>
                            </li>
                        </ul>

                        <?= Html::a('Pagamento', ['carrinho-compras/pagamento'],  ['class' => 'btn btn-warning small-btn']) ?>



                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

