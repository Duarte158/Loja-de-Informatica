<?php
use yii\helpers\Url;
use common\models\Artigos;

$totalArtigos = Artigos::find()->count(); // Conta o total de artigos
?>

<div class="col-md-4 col-sm-6"> <!-- Controle o tamanho aqui -->
    <div class="small-box bg-info">
        <div class="inner">
            <h3><?= $totalArtigos ?></h3>
            <p>Total de Artigos</p>
        </div>
        <div class="icon">
            <i class="fas fa-boxes"></i>
        </div>
        <a href="<?= Url::to(['artigos/index']) ?>" class="small-box-footer">
            Mais informações <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>