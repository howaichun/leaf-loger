<?php

require '../../vendor/autoload.php';

$logDriver = \Leaf\Loger\Example\LogDriver::getInstance();
$logDriver->setLogFile('./log.log');

$logDriver->info('test');