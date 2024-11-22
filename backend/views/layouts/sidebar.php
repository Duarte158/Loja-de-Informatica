<?php

use yii\helpers\Html;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/AdminLTELogo.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <div class="info">
                    <a <?= Html::a(\Yii::$app->user->identity->username, ['profile/view', 'id_user' => Yii::$app->user->getId()]) ?>
                </div>
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
                    ['label' => 'Users', 'url' => (['user/index'])],

                    ['label' => 'Zona Funcionário', 'header' => true],
                    ['label' => 'Funcionários', 'url' => ['funcionario/index']],

                    ['label' => 'Zona Artigos', 'header' => true],
                    ['label' => 'Artigos', 'url' => ['artigos/index']],
                    ['label' => 'Categorias', 'url' => ['categoria/index']],
                    ['label' => 'Iva', 'url' => ['iva/index']],

                    ['label' => 'Zona Fornecedor', 'header' => true],
                    ['label' => 'Fornecedores', 'url' => ['fornecedor/index']],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>