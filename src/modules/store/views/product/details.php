<?php

use raphaelbsr\mktplace\models\MktFeature;
use raphaelbsr\mktplace\models\MktPlanHasFeature;
use yii\grid\GridView;
use yii\web\View;

/* @var $this View */
/* @var $product \raphaelbsr\mktplace\models\MktProduct */
?>

<h3><?= $product->name ?></h3>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">

        <?php
        $colums = [];
        $colums[] = [
            'label' => 'Features/Plans',
            'value' => 'name',
        ];
        foreach ($product->mktPlans as $plan) {
            $colums[] = [
                'label' => $plan->name,
                'format' => 'raw',
                'footer' => '<input type="radio" name="selected-plan" />',
                'footerOptions' => ['class' => 'text-center'],
                'value' => function(MktFeature $model) use ($plan) {
                    $planHasFeature = MktPlanHasFeature::find()->where(['plan_id' => $plan->id, 'feature_id' => $model->id])->one();
                    $id = $model->id . '-' . $plan->id;
                    switch ($model->type) {
                        case MktFeature::INTEGER:
                            return $planHasFeature->value;
                        case MktFeature::BOOL:
                            return $planHasFeature->value ? 'Yes' : '--';
                    }
                },
                'contentOptions' => ['class' => 'text-center'],
            ];
        }
        ?>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $colums,
            'layout' => '{items}',
            'showFooter' => true,
        ]);
        ?>

    </div>
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php
            $paymentPlans = $product->paymentGroup->getMktPaymentPlans()->all();
            print_r($paymentPlans);
        ?>
    </div>
    
</div>