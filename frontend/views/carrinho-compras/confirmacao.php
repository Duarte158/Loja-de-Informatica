<?php
use yii\helpers\Html;

$this->title = 'Compra Finalizada';
?>
<div class="alert alert-success">
    <h4>Obrigado pela sua compra!</h4>
    <p>Sua encomenda foi criada com sucesso e está sendo processada.</p>

<?php  if (Yii::$app->session->hasFlash('endereço')) {
    echo '<div class="alert alert-info">' . Yii::$app->session->getFlash('info') . '</div>';
}
?>


</div>
