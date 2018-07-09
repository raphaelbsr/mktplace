<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MktPaymentGroup */

?>
<div class="mkt-payment-group-view">
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'create_time',
            'update_time',
            'name',
            'isactive',
        ],
    ]) ?>

</div>
