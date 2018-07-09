<?php

namespace raphaelbsr\mktplace\controllers;

/**
 * Description of MktDefaultController
 *
 * @author rapha
 */
class MktDefaultController extends \yii\web\Controller{
    
    public function actionIndex(){
        return $this->actionIndex('index');
    }
    
}
