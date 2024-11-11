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
                >
                </div>
                <div class="col-md-9">
                    <!-- Lista de artigos -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3>Categoria: <?= Html::encode($this->title) ?></h3>
                        </div>





                        <div class="card-body">
                            <div class="filter-container p-0 row">
                                <?php foreach ($artigos as $artigo): ?>

                                    <?php
                                    $imagemSrc = 'http://localhost/frontend-loja/frontend/web/imagens/materiais/' . $artigo->imagem;
                                    ?>

                                    <div class="col-md-4 mb-4 filtr-item" data-categoria_id="<?= $artigo->categoria_id ?>">
                                        <a href="<?= Yii::$app->urlManager->createUrl(['artigos/artigoView', 'id' => $artigo->Id]) ?>" style="text-decoration: none; color: inherit;">
                                            <div class="card h-100 d-flex flex-column justify-content-between">
                                                <img src="<?= $imagemSrc ?>" class="card-img-top" alt="<?= $artigo->nome ?>" />
                                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                    <h5 class="card-title text-center"><?= $artigo->nome ?></h5>
                                                    <span class="card-text text-center">Preço: <?= Html::encode(number_format($artigo->precoFinal, 2)) ?> €</span>
                                                    <div class="mt-3">
                                                        <?php $form = ActiveForm::begin([
                                                            'action' => ['artigos/adicionar-carrinho'], // Ação no controller CarrinhoController
                                                            'method' => 'post',
                                                        ]); ?>

                                                        <?= Html::hiddenInput('id', $artigo->Id); ?> <!-- ID do artigo -->
                                                        <?= Html::input('number', 'quantidade', 1, ['min' => 1, 'class' => 'form-control', 'style' => 'width:80px;', 'placeholder' => 'Qtd']); ?> <!-- Quantidade -->

                                                        <?= Html::submitButton('Adicionar ao Carrinho', ['class' => 'btn btn-success']); ?>

                                                        <?php ActiveForm::end(); ?>
                                                    </div>
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
