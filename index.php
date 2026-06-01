<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("log_errors", 1);

// change the following paths if necessary
define('YII_ENABLE_ERROR_HANDLER', true);
define('YII_ENABLE_EXCEPTION_HANDLER', true);
define('YII_DEBUG', true);
define('YII_TRACE_LEVEL', 3);

//localhost
$yii=dirname(__FILE__).'/framework/yii.php';
//qbix domna
//$yii=dirname(__FILE__).'/../yii18/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// Check if files exist
if (!file_exists($yii)) {
    die("Yii framework file not found at: " . $yii);
}
if (!file_exists($config)) {
    die("Config file not found at: " . $config);
}

// remove the following lines when in production mode
#defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
#defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
