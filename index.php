<?php
defined('NCUFRESH2013') or define('NCUFRESH2013',true);

defined('YII_DEBUG') or define('YII_DEBUG',false);
ini_set("display_errors", "Off");
date_default_timezone_set("Asia/Taipei");

defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once(require_once('ncufresh13.php'));

Yii::createWebApplication('config.php')->run();
