<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

$this->title = 'Artigo';
$this->params['breadcrumbs'][] = $this->title;
/* @var $categoria \common\models\Categoria */

use yii\widgets\LinkPager;

//$this->registerJsFile('@web/js/live-search.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->title = $categoria->descricao;

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
                    <div class="card">
                        <div class="card-header">
                            <h5>Filtrar por Marca</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($marcas as $marca): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="<?= Yii::$app->urlManager->createUrl(['artigos/artigos', 'id' => $categoria->id, 'marca' => $marca->id]) ?>">
                                        <?= Html::encode($marca->nome) ?>
                                    </a>
                                    <span class="badge badge-primary badge-pill">
                <?= $marca->artigos_count ?>
            </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Listagem de artigos -->
                <div class="col-lg-8 col-xl5 col-sm-4"> <!-- Ajustei os tamanhos das colunas -->
                    <div class="filter-container p-0 row">
                        <?php if (!empty($artigos)): ?>
                            <?php foreach ($artigos as $artigo): ?>
                                <?php
                                $imagemSrc = Yii::getAlias('@web') . '/imagens/materiais/' . $artigo->imagem;
                                ?>
                                <div class="col-md-4 mb-4 filtr-item" data-categoria_id="<?= $artigo->categoria_id ?>">
                                    <a href="<?= Yii::$app->urlManager->createUrl(['artigos/artigos-view', 'Id' => $artigo->Id]) ?>" style="text-decoration: none; color: inherit;">
                                        <div class="card h-100 d-flex flex-column justify-content-between">
                                            <img src="<?= $imagemSrc ?>" class="card-img-top" alt="<?= Html::encode($artigo->nome) ?>" style="height: 200px; object-fit: cover;">
                                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                <h5 class="card-title text-center"><?= Html::encode($artigo->nome) ?></h5>
                                                <span class="card-text text-center">Preço: <?= Html::encode(number_format($artigo->precoFinal, 2)) ?> €</span>
                                                <a href="<?= Yii::$app->urlManager->createUrl(['artigos/artigos-view', 'Id' => $artigo->Id]) ?>" class="btn btn-primary mt-2">Ver Detalhes</a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Não foram encontrados artigos para os filtros selecionados.</p>
                        <?php endif; ?>
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
