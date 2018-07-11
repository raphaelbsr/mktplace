<?php

namespace raphaelbsr\mktplace;

use Exception;
use raphaelbsr\mktplace\interfaces\ConsumerInterface;
use raphaelbsr\mktplace\models\MktConsumer;
use raphaelbsr\mktplace\Module;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Module as Module2;

/**
 * Description of Mktplace
 *
 * @author rapha
 */
class Mktplace extends Component {

    public static $moduleId;
    public $_module;    
    
    public function init() {
        $this->initModule();
        parent::init();
    }

    private function initModule() {
        if (!isset(self::$moduleId)) {
            $this->_module = Module::getInstance();
            if (isset($this->_module)) {
                self::$moduleId = $this->_module->id;
                return;
            }
            self::$moduleId = Module::MODULE;
        }
        $this->_module = self::getModule(self::$moduleId, Module::className());
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
     * @return Module2
     */
    private static function getModule($m, $class = '') {
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

    public function registerConsumer(ConsumerInterface $consumer) {

        if ($consumer->getMktToken() === "" || $consumer->getMktToken() === null) {
            throw new Exception("You must return a valid token on getMktToken method");
        }

        if ($mktConsumer = MktConsumer::find()->where(['token' => $consumer->getMktToken()])->one()) {
            throw new Exception("Consumer already exists for the token " . $consumer->getMktToken());
        }

        try {
            $mktConsumer = new MktConsumer();
            $mktConsumer->token = $consumer->getMktToken();
            if ($mktConsumer->save()) {
                return true;
            } else {
                throw new Exception(print_r($mktConsumer->errors));
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function addCreditCard(ConsumerInterface $consumer) {

        if ($consumer->getMktToken() === "" || $consumer->getMktToken() === null) {
            throw new Exception("You must return a valid token on getMktToken method");
        }

        if (!$mktConsumer = MktConsumer::find()->where(['token' => $consumer->getMktToken()])->one()) {
            throw new Exception("Consumer doesn´t exist for the token " . $consumer->getMktToken());
        }

        return print_r($consumer->getCreditCard());
    }

    public function getConsumer(ConsumerInterface $consumer) {

        if ($consumer->getMktToken() === "" || $consumer->getMktToken() === null) {
            throw new Exception("You must return a valid token on getMktToken method");
        }

        if (!$mktConsumer = MktConsumer::find()->where(['token' => $consumer->getMktToken()])->one()) {
            throw new Exception("Consumer doesn´t exist for the token " . $consumer->getMktToken());
        }

        return $mktConsumer;
    }

    public function loadStoreModule() {        
        $action = "/".self::$moduleId."/store";
        return Yii::$app->controller->run($action);
    }

}
