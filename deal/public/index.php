<?php

ini_set('display_errors',1);
date_default_timezone_set('Asia/Shanghai');
error_reporting(E_ALL);

define('APPLICATION_PATH', dirname(__DIR__));

$application = new Yaf\Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
