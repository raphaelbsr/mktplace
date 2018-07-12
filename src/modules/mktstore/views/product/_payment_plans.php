<?php
/* @var $this \yii\web\View */
/* @var $model raphaelbsr\mktplace\models\MktPaymentPlan */
/* @var $contract raphaelbsr\mktplace\models\MktContract */

$price = $model->calcPrice($contract->plan->price);
$inputRadio = '<input type="radio" id="mktcontract-payment_plan_id" name="MktContract[payment_plan_id]" value="' . $model->id . '"/>';
?>

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    <div class="text-center">
        <?= $model->name ?>
        <hr/>
        <h3><?= Yii::$app->formatter->asCurrency($price)?>/<small>month</small></h3>
        <span><small>Total amount <?= Yii::$app->formatter->asCurrency($price * $model->season) ?> in <?= $model->season?>x</small></span>
        <br/>
        <span class="text-success" <?= $model->discount_percentage == 0 ? "style='display:none'" : ""?>> <?= $model->discount_percentage?>% off</span>            
        <br/>
        <?= $inputRadio ?>
    </div>
</div>