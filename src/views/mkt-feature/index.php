<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use raphaelbsr\frontend\assets\FrontendAsset;

FrontendAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel \raphaelbsr\mktplace\models\MktFeatureSearch */
/* @var $product \raphaelbsr\mktplace\models\MktProduct */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $product->name . ' Features';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
Modal::begin([
    'header' => '<h4>Feature</h4>',
    'id' => 'modalDialog',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>


<div class="mkt-feature-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('New ' . $product->name . ' Feature', ['create', 'id' => $product->id], ['class' => 'btn btn-success', 'id' => 'addButton']) ?>
    </p>
    <?php Pjax::begin(['id' => 'pjaxContainer', 'enablePushState' => false]); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
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
