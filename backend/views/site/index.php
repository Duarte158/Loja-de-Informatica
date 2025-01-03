<?php

/** @var yii\web\View $this */

$this->title = 'Loja de Informática';
?>
<div class="site-index">

    <div class="row">
        <!-- Widget de Artigos -->
        <?=
         $this->render('@backend/widgets/smallBoxArtigos'),
         $this->render('@backend/widgets/smallBoxCategorias') ,
         $this->render('@backend/widgets/smallBoxUsers')
        ?>
    </div>

</div>
