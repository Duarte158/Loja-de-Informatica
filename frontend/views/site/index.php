<!DOCTYPE html>
<html lang="en">

<body>




<?php

use yii\helpers\Html;
$imagemSrc = Yii::getAlias('@web') . '/imagens/logos/banner.jpeg' ;
?>
<section style="background-image: url('<?php echo "http://frontend-loja/imagens/materiais/banner.webp"; ?>'); background-repeat: no-repeat; block-size: 825px ;width: auto ; background-size: cover;">
    <div class="container-lg">
        <div class="row">
            <div class="col-lg-6 pt-5 mt-5">
                <div class="d-flex gap-3">

                </div>
                <div class="row my-5">


                </div>
            </div>
        </div>



    </div>
</section>



<section class="pb-5">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between my-4">
                    <h2 class="section-title">Artigos em Destaque</h2>
                    <div class="d-flex align-items-center">
                        <a href="#" class="btn btn-primary rounded-1">View All</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                    <?php foreach ($destaques as $destaque): ?>
                        <?php
                        $imagemSrc = Yii::getAlias('@web') . '/imagens/materiais/' . $destaque->imagem;
                        ?>
                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['artigos/artigos-view', 'Id' => $destaque->Id]) ?>" title="<?= Html::encode($destaque->nome) ?>">
                                        <!-- Imagem com o estilo aplicado -->
                                        <img src="<?= $imagemSrc ?>" alt="<?= Html::encode($destaque->nome) ?>" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal"><?= Html::encode($destaque->nome) ?></h3>
                                    <div>
                                    <span class="rating">
                                        <svg width="18" height="18" class="text-warning"><use xlink:href="#star-full"></use></svg>
                                        <svg width="18" height="18" class="text-warning"><use xlink:href="#star-full"></use></svg>
                                        <svg width="18" height="18" class="text-warning"><use xlink:href="#star-full"></use></svg>
                                        <svg width="18" height="18" class="text-warning"><use xlink:href="#star-full"></use></svg>
                                        <svg width="18" height="18" class="text-warning"><use xlink:href="#star-half"></use></svg>
                                    </span>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <del><?= Html::encode(number_format($destaque->precoUni, 2)) ?> €</del>
                                        <span class="text-dark fw-semibold"><?= Html::encode(number_format($destaque->precoFinal, 2)) ?> €</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2">
                                            <div class="col-3">
                                                <input type="number" name="quantity" class="form-control border-dark-subtle input-number quantity" value="1" min="1">
                                            </div>
                                            <div class="col-7">
                                                <?= Html::beginForm(['artigos/adicionar-carrinho'], 'post') ?>
                                                <?= Html::hiddenInput('id', $destaque->Id) ?>
                                                <?= Html::hiddenInput('quantidade', 1) ?>
                                                <button class="btn btn-primary rounded-1 p-2 fs-7 btn-cart">
                                                    <svg width="18" height="18"><use xlink:href="#cart"></use></svg> Add to Cart
                                                </button>
                                                <?= Html::endForm() ?>
                                            </div>
                                            <div class="col-2">
                                                <?= Html::beginForm(['favoritos/add'], 'post') ?>
                                                <?= Html::hiddenInput('id', $destaque->Id) ?>
                                                <button class="btn btn-outline-dark rounded-1 p-2 fs-6">
                                                    <svg width="18" height="18"><use xlink:href="#heart"></use></svg>
                                                </button>
                                                <?= Html::endForm() ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="py-3">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">

                <div class="banner-blocks">

                    <div class="banner-ad d-flex align-items-center large bg-info block-1" style="background: url('images/banner-ad-1.jpg') no-repeat; background-size: cover;">
                        <div class="banner-content p-5">
                            <div class="content-wrapper text-light">
                                <h3 class="banner-title text-light">Items on SALE</h3>
                                <p>Discounts up to 30%</p>
                                <a href="#" class="btn-link text-white">Shop Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="banner-ad bg-success-subtle block-2" style="background:url('images/banner-ad-2.jpg') no-repeat;background-size: cover">
                        <div class="banner-content align-items-center p-5">
                            <div class="content-wrapper text-light">
                                <h3 class="banner-title text-light">Combo offers</h3>
                                <p>Discounts up to 50%</p>
                                <a href="#" class="btn-link text-white">Shop Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="banner-ad bg-danger block-3" style="background:url('images/banner-ad-3.jpg') no-repeat;background-size: cover">
                        <div class="banner-content align-items-center p-5">
                            <div class="content-wrapper text-light">
                                <h3 class="banner-title text-light">Discount Coupons</h3>
                                <p>Discounts up to 40%</p>
                                <a href="#" class="btn-link text-white">Shop Now</a>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- / Banner Blocks -->

            </div>
        </div>
    </div>
</section>


<section>
    <div class="container-lg">

        <div class="bg-secondary text-light py-5 my-5" style="background: url('images/banner-newsletter.jpg') no-repeat; background-size: cover;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5 p-3">
                        <div class="section-header">
                            <h2 class="section-title display-5 text-light">Get 25% Discount on your first purchase</h2>
                        </div>
                        <p>Just Sign Up & Register it now to become member.</p>
                    </div>
                    <div class="col-md-5 p-3">
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label d-none">Name</label>
                                <input type="text"
                                       class="form-control form-control-md rounded-0" name="name" id="name" placeholder="Name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label d-none">Email</label>
                                <input type="email" class="form-control form-control-md rounded-0" name="email" id="email" placeholder="Email Address">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-dark btn-md rounded-0">Submit</button>
                            </div>
                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>
</section>





<section id="latest-blog" class="pb-4">
    <div class="container-lg">
        <div class="row">
            <div class="section-header d-flex align-items-center justify-content-between my-4">
                <h2 class="section-title">Our Recent Blog</h2>
                <a href="#" class="btn btn-primary">View All</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <article class="post-item card border-0 shadow-sm p-3">
                    <div class="image-holder zoom-effect">
                        <a href="#">
                            <img src="images/post-thumbnail-1.jpg" alt="post" class="card-img-top">
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                            <div class="meta-date"><svg width="16" height="16"><use xlink:href="#calendar"></use></svg>22 Aug 2021</div>
                            <div class="meta-categories"><svg width="16" height="16"><use xlink:href="#category"></use></svg>tips & tricks</div>
                        </div>
                        <div class="post-header">
                            <h3 class="post-title">
                                <a href="#" class="text-decoration-none">Top 10 casual look ideas to dress up your kids</a>
                            </h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-md-4">
                <article class="post-item card border-0 shadow-sm p-3">
                    <div class="image-holder zoom-effect">
                        <a href="#">
                            <img src="images/post-thumbnail-2.jpg" alt="post" class="card-img-top">
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                            <div class="meta-date"><svg width="16" height="16"><use xlink:href="#calendar"></use></svg>25 Aug 2021</div>
                            <div class="meta-categories"><svg width="16" height="16"><use xlink:href="#category"></use></svg>trending</div>
                        </div>
                        <div class="post-header">
                            <h3 class="post-title">
                                <a href="#" class="text-decoration-none">Latest trends of wearing street wears supremely</a>
                            </h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-md-4">
                <article class="post-item card border-0 shadow-sm p-3">
                    <div class="image-holder zoom-effect">
                        <a href="#">
                            <img src="images/post-thumbnail-3.jpg" alt="post" class="card-img-top">
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                            <div class="meta-date"><svg width="16" height="16"><use xlink:href="#calendar"></use></svg>28 Aug 2021</div>
                            <div class="meta-categories"><svg width="16" height="16"><use xlink:href="#category"></use></svg>inspiration</div>
                        </div>
                        <div class="post-header">
                            <h3 class="post-title">
                                <a href="#" class="text-decoration-none">10 Different Types of comfortable clothes ideas for women</a>
                            </h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="pb-4 my-4">
    <div class="container-lg">

        <div class="bg-warning pt-5 rounded-5">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-4">
                        <h2 class="mt-5">Download Organic App</h2>
                        <p>Online Orders made easy, fast and reliable</p>
                        <div class="d-flex gap-2 flex-wrap mb-5">
                            <a href="#" title="App store"><img src="images/img-app-store.png" alt="app-store"></a>
                            <a href="#" title="Google Play"><img src="images/img-google-play.png" alt="google-play"></a>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <img src="images/banner-onlineapp.png" alt="phone" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="py-4">
    <div class="container-lg">
        <h2 class="my-4">People are also looking for</h2>
        <a href="#" class="btn btn-warning me-2 mb-2">Blue diamon almonds</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Angie’s Boomchickapop Corn</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Salty kettle Corn</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Chobani Greek Yogurt</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Sweet Vanilla Yogurt</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Foster Farms Takeout Crispy wings</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Warrior Blend Organic</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Chao Cheese Creamy</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Chicken meatballs</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Blue diamon almonds</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Angie’s Boomchickapop Corn</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Salty kettle Corn</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Chobani Greek Yogurt</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Sweet Vanilla Yogurt</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Foster Farms Takeout Crispy wings</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Warrior Blend Organic</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Chao Cheese Creamy</a>
        <a href="#" class="btn btn-warning me-2 mb-2">Chicken meatballs</a>
    </div>
</section>

<section class="py-5">
    <div class="container-lg">
        <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-5">
            <div class="col">
                <div class="card mb-3 border border-dark-subtle p-3">
                    <div class="text-dark mb-3">
                        <svg width="32" height="32"><use xlink:href="#package"></use></svg>
                    </div>
                    <div class="card-body p-0">
                        <h5>Free delivery</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-3 border border-dark-subtle p-3">
                    <div class="text-dark mb-3">
                        <svg width="32" height="32"><use xlink:href="#secure"></use></svg>
                    </div>
                    <div class="card-body p-0">
                        <h5>100% secure payment</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-3 border border-dark-subtle p-3">
                    <div class="text-dark mb-3">
                        <svg width="32" height="32"><use xlink:href="#quality"></use></svg>
                    </div>
                    <div class="card-body p-0">
                        <h5>Quality guarantee</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-3 border border-dark-subtle p-3">
                    <div class="text-dark mb-3">
                        <svg width="32" height="32"><use xlink:href="#savings"></use></svg>
                    </div>
                    <div class="card-body p-0">
                        <h5>guaranteed savings</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-3 border border-dark-subtle p-3">
                    <div class="text-dark mb-3">
                        <svg width="32" height="32"><use xlink:href="#offers"></use></svg>
                    </div>
                    <div class="card-body p-0">
                        <h5>Daily offers</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="py-5">
    <div class="container-lg">
        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer-menu">
                    <img src="images/logo.svg" width="240" height="70" alt="logo">
                    <div class="social-links mt-3">
                        <ul class="d-flex list-unstyled gap-2">
                            <li>
                                <a href="#" class="btn btn-outline-light">
                                    <svg width="16" height="16"><use xlink:href="#facebook"></use></svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-outline-light">
                                    <svg width="16" height="16"><use xlink:href="#twitter"></use></svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-outline-light">
                                    <svg width="16" height="16"><use xlink:href="#youtube"></use></svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-outline-light">
                                    <svg width="16" height="16"><use xlink:href="#instagram"></use></svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-outline-light">
                                    <svg width="16" height="16"><use xlink:href="#amazon"></use></svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">Organic</h5>
                    <ul class="menu-list list-unstyled">
                        <li class="menu-item">
                            <a href="#" class="nav-link">About us</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Conditions </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Our Journals</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Careers</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Affiliate Programme</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Ultras Press</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">Quick Links</h5>
                    <ul class="menu-list list-unstyled">
                        <li class="menu-item">
                            <a href="#" class="nav-link">Offers</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Discount Coupons</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Stores</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Track Order</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Shop</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Info</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">Customer Service</h5>
                    <ul class="menu-list list-unstyled">
                        <li class="menu-item">
                            <a href="#" class="nav-link">FAQ</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Contact</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Privacy Policy</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Returns & Refunds</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Cookie Guidelines</a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="nav-link">Delivery Information</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">Subscribe Us</h5>
                    <p>Subscribe to our newsletter to get updates about our grand offers.</p>
                    <form class="d-flex mt-3 gap-0" action="index.html">
                        <input class="form-control rounded-start rounded-0 bg-light" type="email" placeholder="Email Address" aria-label="Email Address">
                        <button class="btn btn-dark rounded-end rounded-0" type="submit">Subscribe</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</footer>
<div id="footer-bottom">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-6 copyright">
                <p>© 2024 Organic. All rights reserved.</p>
            </div>
            <div class="col-md-6 credit-link text-start text-md-end">
                <p>HTML Template by <a href="https://templatesjungle.com/">TemplatesJungle</a> Distributed By <a href="https://themewagon.com">ThemeWagon</a> </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>