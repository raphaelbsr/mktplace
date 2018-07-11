<?php

namespace raphaelbsr\mktplace\modules\store;

/**
 * Description of Module
 *
 * @author rapha
 */
class Module extends \yii\base\Module{
            
    public $controllerNamespace = 'raphaelbsr\mktplace\modules\store\controllers';
    
    public function init() {
        //die('INIT MODULE');
        parent::init();                
        
    }
    
}