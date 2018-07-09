<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MktPaymentPlan */

?>
<div class="mkt-payment-plan-view">
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'create_time',
            'update_time',
            'discount_percentage',
            'isactive',
            'season',
        ],
    ]) ?>

</div>
