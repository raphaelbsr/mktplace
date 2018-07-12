<?php

use raphaelbsr\mktplace\models\MktFeature;
use raphaelbsr\mktplace\models\MktPlanHasFeature;
use raphaelbsr\mktplace\models\MktProduct;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $product MktProduct */
?>

<h3><?= $product->name ?></h3>

<?php $form = ActiveForm::begin(['action' => ['/mktplace/mktstore/product/payment-plans']]) ?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
        <?php
        $colums = [];
        $colums[] = [
            'label' => 'Features/Plans',
            'value' => 'name',
        ];
        foreach ($product->mktPlans as $plan) {
            //$inputRadio = $form->field($model, 'payment_plan_id')->radio(['label' => null,'value' => $plan->id]);
            $inputRadio = '<input type="radio" id="mktcontract-payment_plan_id" name="MktContract[plan_id]" value="' . $plan->id . '"';
            $colums[] = [
                'label' => $plan->name,
                'format' => 'raw',
                'footer' => $inputRadio,
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
    <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
        <div class="hidden"><?= $form->field($model, 'product_id')->hiddenInput() ?></div>
        <?= Html::submitButton('Next', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end() ?>