<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MktPlan */

?>
<div class="mkt-plan-view">
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'create_time',
            'update_time',
            'name',
            'description:ntext',
            'price',
            'product_id',
        ],
    ]) ?>

</div>
