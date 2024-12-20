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

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>


<br>
<br>


<!-- intro -->
<section class="pt-3">
    <div class="container-fluid">
        <div class="row gx-3">
            <main class="col-lg-9">
                <div class="card-banner p-5 bg-primary rounded-5" style="height: 350px;">
                    <div style="max-width: 500px;">
                        <h2 class="text-white">
                            Great products with <br />
                            best deals
                        </h2>
                        <p class="text-white">No matter how far along you are in your sophistication as an amateur astronomer, there is always one.</p>
                        <a href="#" class="btn btn-light shadow-0 text-primary"> View more </a>
                    </div>
                </div>
            </main>
            <aside class="col-lg-3">
                <div class="card-banner h-100 rounded-5" style="background-color: #f87217;">
                    <div class="card-body text-center pb-5">
                        <h5 class="pt-5 text-white">Amazing Gifts</h5>
                        <p class="text-white">No matter how far along you are in your sophistication</p>
                        <a href="#" class="btn btn-outline-light"> View more </a>
                    </div>
                </div>
            </aside>
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
                $imagemSrc = 'http://localhost/LojaDeInformatica/frontend/web/imagens/materiais/' . $destaque->imagem;
                ?>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card my-2 shadow-0">
                        <a href="<?= \yii\helpers\Url::to(['artigos/artigos-view', 'Id' => $destaque->Id]) ?>" class="">
                            <img src="<?= $imagemSrc ?>" class="card-img-top rounded-2" style="aspect-ratio: 1 / 1"/>
                        </a>
                        <div class="card-body p-0 pt-3">
                            <a href="#!" class="btn btn-light border px-2 pt-2 float-end icon-hover">
                                <i class="fas fa-heart fa-lg px-1 text-secondary"></i>
                            </a>
                            <h5 class="card-title">$<?= number_format($destaque->precoFinal, 2) ?></h5>
                            <p class="card-text mb-0"><?= htmlspecialchars($destaque->nome) ?></p>
                            <p class="text-muted">

                            </p>
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

