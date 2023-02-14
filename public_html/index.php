<?php

ini_set('error_repoting',E_ALL);        //on
ini_set('error_reporting',~E_ALL);      //off
ini_set('display_errors','on');


// change the following paths if necessary
#$yii=dirname(__FILE__).'/../yii_framework/yii.php';
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',true);
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

function EA($obj){
	echo '<pre>';
	print_r($obj);
	echo '</pre>';
}

require_once($yii);
Yii::createWebApplication($config)->run();

