<?php
use yii\helpers\Url;
use common\models\User;

$totalUsers = User::find()->count(); // Conta o total de usuários
?>

<div class="col-md-4 col-sm-6">
    <div class="small-box bg-gradient-success">
        <div class="inner">
            <h3><?= $totalUsers ?></h3>
            <p>Total de Utilizadores</p>
        </div>
        <div class="icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <a href="<?= Url::to(['user/index']) ?>" class="small-box-footer">
            Mais informações <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
