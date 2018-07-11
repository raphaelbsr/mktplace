<?php

namespace raphaelbsr\mktplace;

/**
 * Description of Module
 *
 * @author rapha
 */
class Module extends \yii\base\Module {

    const MODULE = "mktplace";

    public function init() {
        parent::init();

        $this->modules = [
            'store' => [
                'class' => modules\store\Module::className(),
            ],
        ];
    }

}
