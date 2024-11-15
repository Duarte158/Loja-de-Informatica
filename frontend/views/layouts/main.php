<?php
/** @var \yii\web\View $this */

/** @var string $content */

use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Nav;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Url;

AppAsset::register($this);


if (!Yii::$app->user->isGuest) {
    $carrinho = \common\models\Carrinhocompras::find()
        ->where([
            'user_id' => Yii::$app->user->id,
            'estado' => 'ativo'
        ])
        ->andWhere(['not', ['estado' => 'finalizado']])
        ->one();
    $cartItemCount = $carrinho ? $carrinho->getItemCount() : 0;
} else {
    $cartItemCount = 0;
}

$categorias = Yii::$app->view->params['categorias'] ?? [];

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

    <style>
        .navbar-nav .nav-link {
            padding-right: 1rem;
            padding-left: 1rem;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<!--Main Navigation-->
<header>
    <!-- Jumbotron -->
    <div class="p-3 text-center bg-white border-bottom">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left elements -->
                <div class="col-md-4 d-flex justify-content-center justify-content-md-start mb-3 mb-md-0">
                    <a href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>" class="ms-md-2">
                        <?= Html::img('@web/imagens/materiais/logo.png', ['alt' => Yii::$app->name, 'style' => 'height:100px;']) ?>
                    </a>
                </div>
                <!-- Center elements -->
                <div class="col-md-4 d-flex justify-content-center">
                    <form action="<?= Yii::$app->urlManager->createUrl(['artigos/pesquisar']) ?>" method="get"
                          class="d-flex input-group w-auto my-auto mb-3 mb-md-0">
                        <input autocomplete="off" name="query" value="" type="search" class="form-control rounded"
                               placeholder="Comece já a pesquisa"/>
                        <button type="submit" class="input-group-text border-0 d-none d-lg-flex">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <!-- Right elements -->
                <div class="col-md-4 d-flex justify-content-center justify-content-md-end align-items-center">
                    <div class="d-flex align-items-center">
                        <!-- Cart -->
                        <a class="text-reset me-3"
                           href="<?= Yii::$app->urlManager->createUrl(['carrinho-compras/index']) ?>">
                            <span><i class="fas fa-shopping-cart"></i></span>
                            <span class="badge rounded-pill badge-notification bg-danger"><?= $cartItemCount ?></span>
                        </a>
                        <!-- Profile -->
                        <div class="dropdown">
                            <?php if (Yii::$app->user->isGuest): ?>
                                <a class="text-reset d-flex align-items-center hidden-arrow" href="#"
                                   id="navbarDropdownMenuLink" role="button" onclick="toggleDropdown()">
                                    <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                                </a>
                                <!-- Dropdown for guests -->
                                <ul class="dropdown-menu dropdown-menu-end" id="userDropdown" style="display: none;">
                                    <li><a class="dropdown-item" href="<?= Url::to(['site/login']) ?>">Login</a></li>
                                    <li><a class="dropdown-item" href="<?= Url::to(['site/signup']) ?>">Register</a>
                                    </li>
                                </ul>
                            <?php else: ?>
                                <a class="text-reset d-flex align-items-center hidden-arrow" href="#"
                                   id="navbarDropdownMenuLink" role="button" onclick="toggleDropdown()">
                                    <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                                </a>
                                <!-- Dropdown for logged-in users -->
                                <ul class="dropdown-menu dropdown-menu-end" id="userDropdown" style="display: none;">
                                    <li><a class="dropdown-item" href="<?= Url::to(['user/index']) ?>">Perfil</a></li>
                                    <li><a class="dropdown-item" href="/settings">Configurações</a></li>
                                    <li>
                                        <?= Html::beginForm(['/site/logout'], 'post')
                                        . Html::submitButton(
                                            'Logout (' . Yii::$app->user->identity->username . ')',
                                            ['class' => 'dropdown-item text-decoration-none']
                                        )
                                        . Html::endForm();
                                        ?>
                                    </li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumbotron -->

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary" style="padding: 0px;">
            <!-- Container wrapper -->
            <div class="container">
                <!-- Toggle button -->
                <button data-mdb-button-init class="navbar-toggler px-0" type="button" data-mdb-collapse-init
                        data-mdb-target="#navbarExampleOnHover" aria-controls="navbarExampleOnHover"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarExampleOnHover">
                    <!-- Left links -->
                    <ul class="navbar-nav me-auto ps-lg-0" style="padding-left: 0.15rem">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Regular link</a>
                        </li>
                        <!-- Navbar dropdown -->
                        <li class="nav-item dropdown dropdown-hover position-static">
                            <a data-mdb-dropdown-init class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                               role="button"
                               data-mdb-toggle="dropdown" aria-expanded="false">
                                Mega menu
                            </a>
                            <!-- Dropdown menu -->
                            <div class="dropdown-menu w-100 mt-0" aria-labelledby="navbarDropdown" style="border-top-left-radius: 0;
                            border-top-right-radius: 0;
                          ">

                                <div class="container">
                                    <div class="row my-4">
                                        <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                                            <div class="list-group list-group-flush">
                                                <a href="<?= Url::to(['artigos/artigos', 'id' => 1]) ?>"
                                                   class="list-group-item list-group-item-action">Ratos</a>
                                                <a href="" class="list-group-item list-group-item-action">Dolor sit</a>
                                                <a href="" class="list-group-item list-group-item-action">Amet
                                                    consectetur</a>
                                                <a href="" class="list-group-item list-group-item-action">Cras justo
                                                    odio</a>
                                                <a href="" class="list-group-item list-group-item-action">Adipisicing
                                                    elit</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                                            <div class="list-group list-group-flush">
                                                <a href="" class="list-group-item list-group-item-action">Explicabo
                                                    voluptas</a>
                                                <a href="" class="list-group-item list-group-item-action">Perspiciatis
                                                    quo</a>
                                                <a href="" class="list-group-item list-group-item-action">Cras justo
                                                    odio</a>
                                                <a href="" class="list-group-item list-group-item-action">Laudantium
                                                    maiores</a>
                                                <a href="" class="list-group-item list-group-item-action">Provident
                                                    dolor</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 mb-3 mb-md-0">
                                            <div class="list-group list-group-flush">
                                                <a href="" class="list-group-item list-group-item-action">Iste
                                                    quaerato</a>
                                                <a href="" class="list-group-item list-group-item-action">Cras justo
                                                    odio</a>
                                                <a href="" class="list-group-item list-group-item-action">Est iure</a>
                                                <a href=""
                                                   class="list-group-item list-group-item-action">Praesentium</a>
                                                <a href="" class="list-group-item list-group-item-action">Laboriosam</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="list-group list-group-flush">
                                                <a href="" class="list-group-item list-group-item-action">Cras justo
                                                    odio</a>
                                                <a href="" class="list-group-item list-group-item-action">Saepe</a>
                                                <a href="" class="list-group-item list-group-item-action">Vel alias</a>
                                                <a href="" class="list-group-item list-group-item-action">Sunt
                                                    doloribus</a>
                                                <a href="" class="list-group-item list-group-item-action">Cum
                                                    dolores</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- Left links -->
                </div>
                <!-- Collapsible wrapper -->
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->

        <!--Sidenav -->


        <!-- Background image -->
        <!-- Background image -->
</header>
<!--Main Navigation-->
<main class="flex-shrink-0">
    <div class="container">
        <?= $content ?>
    </div>
</main>
<footer class="text-center text-lg-start bg-light text-muted">
    <!-- Section: Social media -->
    <section class="p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        <div class="container">
            <div class="row d-flex">
                <!-- Left -->
                <div class="col-md-6 col-sm-12 mb-2 mb-md-0 d-flex justify-content-center justify-content-md-start">
                    <div class="">
                        <div class="input-group" style="max-width: 400px;">
                            <input type="email" class="form-control border" placeholder="Email" aria-label="Email"
                                   aria-describedby="button-addon2"/>
                            <button class="btn btn-light border" type="button" id="button-addon2"
                                    data-mdb-ripple-color="dark">
                                Subscribe
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Left -->

                <!-- Right -->
                <div class="col-md-6 col-sm-12 float-center">
                    <div class="float-md-end">
                        <a class="btn btn-icon btn-light text-secondary px-3 border" title="Facebook" target="_blank"
                           href="#"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a class="btn btn-icon btn-light text-secondary px-3 border" title="Instagram" target="_blank"
                           href="#"><i class="fab fa-instagram fa-lg"></i></a>
                        <a class="btn btn-icon btn-light text-secondary px-3 border" title="Youtube" target="_blank"
                           href="#"><i class="fab fa-youtube fa-lg"></i></a>
                        <a class="btn btn-icon btn-light text-secondary px-3 border" title="Twitter" target="_blank"
                           href="#"><i class="fab fa-twitter fa-lg"></i></a>
                    </div>
                </div>
                <!-- Right -->
            </div>
        </div>
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5 mb-4">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-12 col-lg-3 col-sm-12">
                    <!-- Content -->
                    <a href="https://mdbootstrap.com/" target="_blank" class="ms-md-2">
                        <?= Html::img('@web/favicon.ico', ['alt' => Yii::$app->name, 'style' => 'height:80px;']) ?>                    </a>
                    <p class="mt-3">
                        © 2023 Copyright: MDBootstrap.com.
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-6 col-sm-4 col-lg-2">
                    <!-- Links -->
                    <h6 class="text-uppercase text-dark fw-bold mb-2">
                        Store
                    </h6>
                    <ul class="list-unstyled mb-4">
                        <li><a class="text-muted" href="#">About us</a></li>
                        <li><a class="text-muted" href="#">Find store</a></li>
                        <li><a class="text-muted" href="#">Categories</a></li>
                        <li><a class="text-muted" href="#">Blogs</a></li>
                    </ul>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-6 col-sm-4 col-lg-2">
                    <!-- Links -->
                    <h6 class="text-uppercase text-dark fw-bold mb-2">
                        Information
                    </h6>
                    <ul class="list-unstyled mb-4">
                        <li><a class="text-muted" href="#">Help center</a></li>
                        <li><a class="text-muted" href="#">Money refund</a></li>
                        <li><a class="text-muted" href="#">Shipping info</a></li>
                        <li><a class="text-muted" href="#">Refunds</a></li>
                    </ul>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-6 col-sm-4 col-lg-2">
                    <!-- Links -->
                    <h6 class="text-uppercase text-dark fw-bold mb-2">
                        Support
                    </h6>
                    <ul class="list-unstyled mb-4">
                        <li><a class="text-muted" href="#">Help center</a></li>
                        <li><a class="text-muted" href="#">Documents</a></li>
                        <li><a class="text-muted" href="#">Account restore</a></li>
                        <li><a class="text-muted" href="#">My orders</a></li>
                    </ul>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-12 col-sm-12 col-lg-3">
                    <!-- Links -->
                    <h6 class="text-uppercase text-dark fw-bold mb-2">Our apps</h6>
                    <a href="#" class="mb-2 d-inline-block"> <img
                                src="https://mdbootstrap.com/img/bootstrap-ecommerce/misc/btn-appstore.webp"
                                height="38"/></a>
                    <a href="#" class="mb-2 d-inline-block"> <img
                                src="https://mdbootstrap.com/img/bootstrap-ecommerce/misc/btn-market.webp" height="38"/></a>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->
    <div class="container">
        <div class="py-4 border-top">
            <div class="d-flex justify-content-between">
                <!--- payment --->
                <div class="text-dark">
                    <i class="fab fa-lg fa-cc-visa"></i>
                    <i class="fab fa-lg fa-cc-amex"></i>
                    <i class="fab fa-lg fa-cc-mastercard"></i>
                    <i class="fab fa-lg fa-cc-paypal"></i>
                </div>
                <!--- payment --->
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
<script>
    document.getElementById('openSidebar').addEventListener('click', function () {
        document.getElementById('sidenav-1').classList.toggle('active');
    });

    // Clique fora da sidebar para fechar
    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidenav-1');
        if (!sidebar.contains(event.target) && event.target.id !== 'openSidebar') {
            sidebar.classList.remove('active');
        }
    });
</script>
</body>
</html>
<?php $this->endPage() ?>

<script>
    function toggleDropdown() {
        const dropdownMenu = document.getElementById("userDropdown");
        dropdownMenu.style.display = dropdownMenu.style.display === "none" ? "block" : "none";
    }

    // Fecha o dropdown ao clicar fora dele
    document.addEventListener('click', function (event) {
        const dropdownMenu = document.getElementById("userDropdown");
        const avatar = document.getElementById("navbarDropdownMenuLink");

        if (!avatar.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = "none";
        }
    });
</script>
