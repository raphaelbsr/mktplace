<?php

use raphaelbsr\mktplace\Mktplace;
use raphaelbsr\mktplace\modules\store\models\MktProductSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel MktProductSearch */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'name',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{details}',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'width:120px'],
                    'buttons' => [
                        'details' => function($url, MktProductSearch $model) {
                            $moduleId = Mktplace::$moduleId;
                            $url = Url::to(["/$moduleId/store/product/details", 'id' => $model->id]);
                            $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]);
                            return Html::a($icon, $url, ['class' => 'btn-features', 'data-pjax' => 0, 'title' => 'Details']);
                        }
                    ]
                ]
            ]
        ])
        ?>
    </div>
</div>