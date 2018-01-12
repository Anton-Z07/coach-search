<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../../framework/yiic.php';
$config=dirname(__FILE__).'/config/console.php';
mb_internal_encoding("UTF-8");
ini_set('date.timezone', 'Europe/Moscow');

require_once($yiic);
Yii::createConsoleApplication($config)->run();