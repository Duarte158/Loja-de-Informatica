<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Página Inicial';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Loja</title>


</head>
<style>
    .card-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;  /* A imagem vai cobrir toda a div sem distorcer */
    }
</style>

<body>


<br>
<br>


<!-- intro -->
<section class="pt-3">
    <div class="container-fluid">
        <div class="row gx-3">
            <main class="col-lg-9">
                <div class="card-banner p-5 rounded-5"
                     style="
                        height: 350px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        background: none; /* Remove fundo */
                     ">
                    <div style="max-width: 500px; text-align: center;">
                        <?php
                        $imagemSrc = 'http://localhost/Loja-de-Informatica/frontend/web/imagens/materiais/banner.jpeg';
                        ?>
                        <img src="<?= $imagemSrc ?>" alt="Banner" style="max-width: 100%; height: auto; width: 800px; border-radius: 8px;" />
                    </div>
                </div>
            </main>

        </div>
        <!-- row //end -->
    </div>
    <!-- container end.// -->
</section>


<!-- intro -->

<!-- category -->

<!-- category -->

<!-- Products -->

<!-- Features -->

<!-- Recommended -->
<section>
    <div class="container my-5">
        <header class="mb-4">
            <h3>Destaques</h3>
        </header>

        <div class="row">
            <?php foreach ($destaques as $destaque): ?>
                <?php
                $imagemSrc = Yii::getAlias('@web') . '/imagens/materiais/' . $destaque->imagem;
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 d-flex flex-column justify-content-between shadow-sm border" style="border-radius: 8px; overflow: hidden;">
                        <a href="<?= Yii::$app->urlManager->createUrl(['artigos/artigos-view', 'Id' => $destaque->Id]) ?>" style="text-decoration: none; color: inherit;">
                            <!-- Imagem do produto -->
                            <img src="<?= $imagemSrc ?>" class="card-img-top" alt="<?= $destaque->nome ?>" style="height: 200px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <!-- Botão para adicionar aos favoritos -->
                            <?= Html::beginForm(['favoritos/add'], 'post') ?>
                            <?= Html::hiddenInput('id', $destaque->Id) ?>
                            <?= Html::submitButton('<i class="fas fa-heart fa-lg px-1 text-secondary"></i>', [
                                'class' => 'btn btn-light border px-2 pt-2 float-end icon-hover'
                            ]) ?>
                            <?= Html::endForm() ?>

                            <p class="card-text text-center">
                                <?= Html::encode($destaque->nome) ?>
                            </p>

                            <!-- Informações do produto -->
                            <h5 class="preco-bold text-center">
                                <?= Html::encode(number_format($destaque->precoFinal, 2)) ?> € / <?= Html::encode($destaque->unidade->descricao) ?>
                            </h5>

                            <!-- Botão "Adicionar ao Carrinho" -->
                            <?= Html::beginForm(['artigos/adicionar-carrinho'], 'post') ?>
                            <?= Html::hiddenInput('id', $destaque->Id) ?>
                            <?= Html::hiddenInput('quantidade', 1) ?>

                            <?= Html::submitButton('ADICIONAR', [
                                'class' => 'btn btn-primary btn-block mt-2',
                                'style' => 'text-transform: uppercase; font-weight: bold; padding: 10px; width: 100%;'
                            ]) ?>
                            <?= Html::endForm() ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


    </div>
</section>
<!-- Recommended -->

<!-- Footer -->

<!-- Footer -->

