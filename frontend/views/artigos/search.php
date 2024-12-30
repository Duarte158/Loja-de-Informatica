<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $artigos \common\models\Artigos[] */
/* @var $query string */

$this->title = 'Resultados da Pesquisa: ' . Html::encode($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
<div class="content-wrapper">

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                </div>
                <div class="col-md-9">
                    <!-- Lista de artigos -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5><?= Html::encode($this->title) ?></h5>
                        </div>





                        <div class="col-lg-8 col-xl5 col-sm-4"> <!-- Ajustei os tamanhos das colunas -->                            <div class="filter-container p-0 row">
                                <?php foreach ($artigos as $artigo): ?>
                                    <?php
                                    $imagemSrc = Yii::getAlias('@web') . '/imagens/materiais/' . $artigo->imagem;
                                    ?>
                                    <div class="col-md-4 mb-4 filtr-item" data-categoria_id="<?= $artigo->categoria_id ?>">
                                        <a href="<?= Yii::$app->urlManager->createUrl(['artigos/artigos-view', 'Id' => $artigo->Id]) ?>" style="text-decoration: none; color: inherit;">
                                            <div class="card h-100 d-flex flex-column justify-content-between">
                                                <img src="<?= $imagemSrc ?>" class="card-img-top" alt="<?= $artigo->nome ?>" />
                                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                    <h5 class="card-title text-center"><?= $artigo->nome ?></h5>
                                                    <span class="card-text text-center">Preço: <?= Html::encode(number_format($artigo->precoFinal, 2)) ?> €</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- Adicione a paginação aqui -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script src="../plugins/jquery/jquery.min.js"></script>

<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

<script src="../dist/js/adminlte.min.js?v=3.2.0"></script>

<script src="../plugins/filterizr/jquery.filterizr.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




</body>
</html>
