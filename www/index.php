<?php

// demo 入口文件
$configFile = '../config.php';
if (file_exists($configFile)) {
    require $configFile;
}

$startFile = (defined('SYS_ROOT') ? SYS_ROOT : '..') . '/framework/start.php';

if (file_exists($startFile)) {
    require $startFile;
} else {
    echo 'start.php Not Found!';
}
