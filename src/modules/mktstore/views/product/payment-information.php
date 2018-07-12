<?php

use raphaelbsr\mktplace\models\MktContract;
use raphaelbsr\mktplace\models\MktCreditCard;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $contract MktContract */
/* @var $creditCard MktCreditCard */
?>

<?php $form = ActiveForm::begin(['action' => ['/mktplace/mktstore/product/billing']]) ?>
<div class="row">

    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
        <h3>Purchase Summary</h3>
        <hr/>

        <div class="row">
            <div class="col-lg-2"><b>Product:</b></div>
            <div class="col-lg-10"><?= $contract->product->name ?></div>
        </div>

        <div class="row">
            <div class="col-lg-2"><b>Plan:</b></div>
            <div class="col-lg-10"><?= $contract->plan->name ?></div>
        </div>

        <div class="row">
            <div class="col-lg-2"><b>Total:</b></div>
            <div class="col-lg-10"><?= Yii::$app->formatter->asCurrency($contract->plan->price * $contract->paymentPlan->season) ?> in <?= $contract->paymentPlan->season ?>x</div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <h3>Billing</h3>
        <hr/>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= $form->field($creditCard, 'number')->textInput(['maxlength' => 16]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= $form->field($creditCard, 'name')->textInput() ?>
            </div>        
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <?= $form->field($creditCard, 'month')->dropDownList(MktCreditCard::MONTH) ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <?= $form->field($creditCard, 'year')->dropDownList(MktCreditCard::$YEAR) ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <?= $form->field($creditCard, 'security_code')->textInput(['maxlength' => 3]) ?>
            </div>
        </div>    
        <div class="row">            
            <div class="col-lg-12">
                <div class="hidden"><?= $form->field($contract, 'product_id')->hiddenInput() ?></div>
                <div class="hidden"><?= $form->field($contract, 'plan_id')->hiddenInput() ?></div>
                <div class="hidden"><?= $form->field($contract, 'payment_plan_id')->hiddenInput() ?></div>
                <?= \yii\helpers\Html::submitButton('Confirm', ['class' => 'btn btn-success form-control']) ?>
            </div>
        </div>

    </div>

</div>
<?php ActiveForm::end() ?>