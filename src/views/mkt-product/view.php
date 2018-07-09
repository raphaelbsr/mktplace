<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MktProduct */

?>
<div class="mkt-product-view">
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'create_time',
            'update_time',
            'name',
            'payment_group_id',
            'isactive',
        ],
    ]) ?>

</div>
