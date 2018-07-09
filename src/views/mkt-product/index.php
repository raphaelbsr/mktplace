<?php

use raphaelbsr\frontend\assets\FrontendAsset;
use raphaelbsr\mktplace\models\MktProduct;
use raphaelbsr\mktplace\models\MktProductSearch;
use yii\bootstrap\Modal;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

FrontendAsset::register($this);

/* @var $this View */
/* @var $searchModel MktProductSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
Modal::begin([
    'header' => '<h4>Product</h4>',
    'id' => 'modalDialog',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4>Features</h4>',
    'id' => 'modalDialogFeature',
    'size' => 'modal-lg',
]);
echo "<div id='modalContentFeature'></div>";
Modal::end();
?>


<div class="mkt-product-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('app', 'New Product'), ['create'], ['class' => 'btn btn-success', 'id' => 'addButton']) ?>
    </p>
    <?php Pjax::begin(['id' => 'pjaxContainer', 'enablePushState' => false]); ?>    
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'attribute' => 'payment_group_id',
                'value' => function(MktProduct $model) {
                    return $model->paymentGroup->name;
                },
                'headerOptions' => ['style' => 'width:300px'],
            ],
            [
                'attribute' => 'isactive',
                'value' => function($model) {
                    return $model->isactive ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
                },
                'headerOptions' => ['style' => 'width:100px'],
                'contentOptions' => ['class' => 'text-center'],
                'filter' => Html::activeDropDownList($searchModel, 'isactive', ['1' => 'ACTIVE', 0 => 'INACTIVE'], ['class' => 'form-control', 'prompt' => 'ALL'])
            ],
            [
                'class' => 'raphaelbsr\gii\ActionColumn',
                'template' => '{update} {features} {plans}',
                'headerOptions' => ['style' => 'width:100px'],
                'contentOptions' => ['class' => 'text-center'],
                'buttons' => [
                    'features' => function($url, MktProduct $model) {
                        $url = yii\helpers\Url::to(['/mktplace/mkt-feature', 'id' => $model->id]);
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-wrench"]);
                        return Html::a($icon, $url, ['class' => 'btn-features', 'data-pjax' => 0, 'title' => 'Features']);
                    },
                    'plans' => function($url, MktProduct $model) {
                        $url = yii\helpers\Url::to(['/mktplace/mkt-plan', 'id' => $model->id]);
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-th-list"]);
                        return Html::a($icon, $url, ['class' => 'btn-features', 'data-pjax' => 0, 'title' => 'Plans']);
                    }
                ]
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
   
//   \$('#pjaxContainer').on("click", ".btn-features", function () {
//        \$("#modalDialogFeature")
//                .find('#modalContentFeature')
//                .empty()
//                .load(\$(this).attr('href'),
//                    function(){
//                        \$("#modalDialogFeature").modal('show')
//                    }
//        );
//        return false;
//    });
        
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
