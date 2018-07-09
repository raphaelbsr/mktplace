<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use raphaelbsr\frontend\assets\FrontendAsset;

FrontendAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\MktPaymentGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'New Payment Groups';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
Modal::begin([
    'header' => '<h4>Payment Group</h4>',
    'id' => 'modalDialog',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>


<div class="mkt-payment-group-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('New Payment Group', ['create'], ['class' => 'btn btn-success', 'id' => 'addButton']) ?>
    </p>
    <?php Pjax::begin(['id' => 'pjaxContainer', 'enablePushState' => false]); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'attribute' => 'isactive',
                'value' => function($model) {
                    return $model->isactive ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
                },
                'headerOptions' => ['style' => 'width:100px'],
                'contentOptions' => ['class' => 'text-center'],
                'filter' => Html::activeDropDownList($searchModel, 'isactive', ['1' => 'ACTIVE', 0 => 'INACTIVE'],['class' => 'form-control', 'prompt' => 'ALL'])
            ],
            [
                'class' => 'raphaelbsr\gii\ActionColumn',
                'template' => '{update}',
                'headerOptions' => ['style' => 'width:100px'],
                'contentOptions' => ['class' => 'text-center'],
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?></div>

<?php
$script = <<< JS

    \$('#addButton').click(function () {        
        \$("#modalDialog").modal('show')
                .find('#modalContent')
                .empty()
                .load(\$(this).attr('href'));
        return false;
    });
        
   \$('#pjaxContainer').on("click", ".updateButton", function () {        
        \$("#modalDialog").modal('show')
                .find('#modalContent')
                .empty()
                .load(\$(this).attr('href'));
        return false;
    });
        
    \$('#pjaxContainer').on("click", ".viewButton", function () {        
        \$("#modalDialog").modal('show')
                .find('#modalContent')
                .empty()
                .load(\$(this).attr('href'));
        return false;
    });
        
JS;

$this->registerJs($script);
