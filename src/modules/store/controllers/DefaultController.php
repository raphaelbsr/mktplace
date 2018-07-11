<?php

namespace raphaelbsr\mktplace\modules\store\controllers;

use raphaelbsr\mktplace\modules\store\models\MktProductSearch;
use yii\web\Controller;

/**
 * Description of DefaultController
 *
 * @author rapha
 */
class DefaultController extends Controller {

    public function actionIndex() {
        $searchModel = new MktProductSearch();
        $dataProviver = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProviver, 'searchModel' => $searchModel]);
    }

}
