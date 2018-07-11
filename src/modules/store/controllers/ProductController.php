<?php

namespace raphaelbsr\mktplace\modules\store\controllers;

use raphaelbsr\mktplace\models\MktProduct;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Description of ProductController
 *
 * @author rapha
 */
class ProductController extends Controller{
    
    public function actionIndex(){
        
    }
    
    public function actionDetails($id){
        
        if($product = MktProduct::findOne($id)){
            
            $dataProvider = new ActiveDataProvider(['query' => $product->getMktFeatures()]);            
            return $this->render('details',[
                'product' => $product,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            throw new NotFoundHttpException();
        }
        
    }
    
}
