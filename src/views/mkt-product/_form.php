<?php

use raphaelbsr\mktplace\models\MktPaymentGroup;
use raphaelbsr\mktplace\models\MktProduct;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model MktProduct */
/* @var $form ActiveForm */
?>

<div class="mkt-product-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <div class="row">

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?php
            $paymentGroups = MktPaymentGroup::find()->where(['isactive' => true])->orderBy('name')->all();
            ?>
            <?= $form->field($model, 'payment_group_id')->dropDownList(\yii\helpers\ArrayHelper::map($paymentGroups, 'id', 'name')) ?>
        </div>                

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 padding-row">
            <?= $form->field($model, 'isactive')->checkbox() ?>
        </div>                

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS

\$('form#{$model->formName()}').on('beforeSubmit', function(e) 
{   
   var \$form = $(this);
    $.post(
        \$form.attr("action"),
        \$form.serialize()
    ).done(function(data) {
        console.log(JSON.stringify(data));
        if(data.status){
            \$("#modalDialog").modal('hide');    
        }
        showMessage(data);
        \$.pjax.reload({container:'#pjaxContainer'});
    }).fail(function(data) {                              
            console.log("server error "+ JSON.stringify(data));
        });
    return false;
});
        
JS;

$this->registerJs($script);
