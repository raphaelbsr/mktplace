<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use raphaelbsr\frontend\assets\FrontendAsset;

FrontendAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\MktPlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', $product->name . ' Plans');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
Modal::begin([
    'header' => '<h4>Plan</h4>',
    'id' => 'modalDialog',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>


<div class="mkt-plan-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('app', 'New ' . $product->name . ' Plan'), ['create', 'id' => $product->id], ['class' => 'btn btn-success', 'id' => 'addButton']) ?>
    </p>
    <?php Pjax::begin(['id' => 'pjaxContainer', 'enablePushState' => false]); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'attribute' => 'price',
                'format' => 'currency',
                'contentOptions' => ['class' => 'text-right','style' => 'width:120px'],
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
