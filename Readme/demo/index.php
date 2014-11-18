<?php
/**
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-9-20
 * Time: 下午8:07
 * To change this template use File | Settings | File Templates.
 */

// demo 入口文件
$configFile = '../config.php';

$startFile = '../framework/start.php';

if (file_exists($startFile)) {
    require $startFile;
} else {
    echo 'start.php Not Found!';
}