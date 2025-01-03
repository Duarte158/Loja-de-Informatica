<?php

use yii\helpers\Html;

?>


<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Yii::$app->urlManager->createUrl(['/site/index']) ?>" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Loja De Informática</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div style="font-size: 30px; color: #6c757d;"> <!-- Ajuste o tamanho e cor -->
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="info">
                <a href="<?= \yii\helpers\Url::to(['user/view', 'id' => Yii::$app->user->getId()]) ?>">
                    <?= Html::encode(\Yii::$app->user->identity->username) ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Yii2 PROVIDED', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],

                    ['label' => 'Zona Cliente', 'header' => true],
                    ['label' => 'Users','icon' => 'user', 'url' => (['user/index'])],

                    ['label' => 'Zona Funcionário', 'header' => true],
                    ['label' => 'Funcionários','icon' => 'user', 'url' => ['funcionario/index']],

                    ['label' => 'Zona Artigos', 'header' => true],
                    ['label' => 'Artigos','icon' => 'fas fa-boxes', 'url' => ['artigos/index']],
                    ['label' => 'Categorias','icon' => 'fas fa-plus', 'url' => ['categoria/index']],
                    ['label' => 'Iva','icon' => 'fas fa-plus', 'url' => ['iva/index']],

                    ['label' => 'Zona Fornecedor', 'header' => true],
                    ['label' => 'Fornecedores','icon' => 'user', 'url' => ['fornecedor/index']],

                    // Botão de logout
                    ['label' => 'Logout', 'url' => ['site/logout'], 'icon' => 'sign-out-alt', 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>'],
                ],
            ]);
            ?>
        </nav>


        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>