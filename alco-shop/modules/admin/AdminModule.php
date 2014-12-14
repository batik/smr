<?php

namespace app\modules\admin;

use Yii;

class AdminModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();

        /*// set the layout path
    	$this->setLayoutPath('\views\layouts');
    	$this->setViewPath('\views');
    	// set the layout
    	$this->layout = 'main';*/
    }
}
