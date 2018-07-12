<?php

use app\models\MktContract;
use yii\base\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this View */
/* @var $contract MktContract */
?>

<div>
    <div class="row">    
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Selected Plan - <?= $contract->plan->name ?></h3>
            <hr/>
        </div>
    </div>
    <?php $form = ActiveForm::begin(['action' => ['/mktplace/mktstore/product/payment-information']]) ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?=
            ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'tag' => 'ul',
                    'class' => 'list-group',
                    'id' => 'list-wrapper',
                ],
                'itemOptions' => [
                    'tag' => false,
                ],
                'itemView' => function ($model, $key, $index, $widget) use ($contract, $form) {
                    return $this->render('_payment_plans', ['model' => $model, 'contract' => $contract, 'form' => $form]);
                },
                'layout' => "{items}",
            ]);
            ?>
        </div>
    </div>    

    <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
        <br/>
        <div class="hidden"><?= $form->field($contract, 'product_id')->hiddenInput() ?></div>
        <div class="hidden"><?= $form->field($contract, 'plan_id')->hiddenInput() ?></div>
        <?= Html::submitButton('Next', ['class' => 'btn btn-success']) ?>
    </div>
    <?php $form = ActiveForm::end() ?>
</div>