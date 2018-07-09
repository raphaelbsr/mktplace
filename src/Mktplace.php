<?php

namespace raphaelbsr\mktplace;

use Codeception\Specify\Config;
use Yii;
use yii\base\Component;
use raphaelbsr\mktplace\Module;

/**
 * Description of Mktplace
 *
 * @author rapha
 */
class Mktplace extends Component {

    public $moduleId;
    public $_module;

    public function init() {
        $this->initModule();
        parent::init();
    }

    public function initModule() {
        if (!isset($this->moduleId)) {
            $this->_module = Module::getInstance();
            if (isset($this->_module)) {
                $this->moduleId = $this->_module->id;
                return;
            }
            $this->moduleId = Module::MODULE;
        }
        $this->_module = self::getModule($this->moduleId, Module::className());
    }

    /**
     * Gets the module instance by validating the module name. The check is first done for a submodule of the same name
     * and then the check is done for the module within the current Yii2 application.
     *
     * @param string $m the module identifier
     * @param string $class the module class name
     *
     * @throws InvalidConfigException
     *
     * @return yii\base\Module
     */
    private static function getModule($m, $class = '')
    {
        $app = Yii::$app;
        $mod = isset($app->controller) && $app->controller->module ? $app->controller->module : null;
        $module = $mod && $mod->getModule($m) ? $mod->getModule($m) : $app->getModule($m);
        if ($module === null) {
            throw new InvalidConfigException("The '{$m}' module MUST be setup in your Yii configuration file.");
        }
        if (!empty($class) && !$module instanceof $class) {
            throw new InvalidConfigException("The '{$m}' module MUST be an instance of '{$class}'.");
        }
        return $module;
    }
    
    public function mktProductCrud() {
        //return Yii::$app->runAction('@vendor/raphaelbsr/yii2-mktplace/mkt-product-controller');
        
//        if (!isset($this->_module->downloadAction)) {
//            $action = ["/{$this->moduleId}/export/download"];
//        } else {
//            $action = (array)$this->_module->downloadAction;
//        }
        $action = "/{$this->moduleId}/default";
        return Yii::$app->controller->run($action);
    }

}