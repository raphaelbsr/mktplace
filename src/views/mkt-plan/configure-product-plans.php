<?php

use raphaelbsr\frontend\assets\FrontendAsset;
use raphaelbsr\mktplace\models\MktFeature;
use raphaelbsr\mktplace\models\MktPlanHasFeature;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
FrontendAsset::register($this);
?>

<?php $form = ActiveForm::begin(['id' => 'configure-plan-form']) ?>
<?php
$colums = [];
$colums[] = [
    'label' => 'Feats/Plans',
    'value' => 'name',
];
foreach ($plans as $plan) {
    $colums[] = [
        'label' => $plan->name,
        'format' => 'raw',
        'value' => function(MktFeature $model) use ($plan, $form) {

            $planHasFeature = MktPlanHasFeature::find()->where(['plan_id' => $plan->id, 'feature_id' => $model->id])->one();

            if (!$planHasFeature) {
                $planHasFeature = new MktPlanHasFeature();
                $planHasFeature->plan_id = $plan->id;
                $planHasFeature->feature_id = $model->id;
            }

            $id = $model->id . '-' . $plan->id;
            $name = $id;

            $hiddenPlanIdInput = Html::activeHiddenInput($planHasFeature, '[' . $name . ']plan_id');
            $hiddenFeatureInput = Html::activeHiddenInput($planHasFeature, '[' . $name . ']feature_id');
            $hiddenIdInput = Html::activeHiddenInput($planHasFeature, '[' . $name . ']id');

            switch ($model->type) {
                case MktFeature::INTEGER:
                    return $form->field($planHasFeature, '[' . $name . ']value')->textInput(['class' => 'text-center form-control'])->label(false) . $hiddenFeatureInput . $hiddenIdInput . $hiddenPlanIdInput;
                case MktFeature::BOOL:
                    return $form->field($planHasFeature, '[' . $name . ']value')->checkbox(['label' => null])->label(false) . $hiddenFeatureInput . $hiddenIdInput . $hiddenPlanIdInput;
            }
        },
        'contentOptions' => ['class' => 'text-center']
    ];
}
?>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $colums,
]);
?>

<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
<?php $form = ActiveForm::end() ?>

<?php

$script = <<< JS

\$('form#configure-plan-form').on('beforeSubmit', function(e) 
{   
   var \$form = $(this);
    $.post(
        \$form.attr("action"),
        \$form.serialize()
    ).done(function(data) {
        console.log(JSON.stringify(data));        
        showMessage(data);
    }).fail(function(data) {                              
            console.log("server error "+ JSON.stringify(data));
        });
    return false;
});
        
JS;

$this->registerJs($script);