<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MktFeature */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mkt-feature-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 colxs-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>  
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <?= $form->field($model, 'value')->textInput() ?>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <?= $form->field($model, 'type')->dropDownList(['BOOL' => 'BOOL', 'INTEGER' => 'INTEGER',], ['prompt' => '']) ?>
        </div>

    </div>              

    <div class="hidden">
        <?= $form->field($model, 'product_id')->hiddenInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
