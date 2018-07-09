<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MktFeature */

?>
<div class="mkt-feature-view">
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'create_time',
            'update_time',
            'name',
            'value',
            'type',
            'product_id',
        ],
    ]) ?>

</div>
