<?php
/**
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-7-15
 * Time: 下午11:07
 * To change this template use File | Settings | File Templates.
 */

!isset($_SERVER['REQUEST_TIME_FLOAT']) && $_SERVER['REQUEST_TIME_FLOAT'] = microtime(1);

//强制不缓存
header("Cache-Control: no-cache, private, max-age=0");
header("Expires: Thu, 02 Apr 2009 00:00:00 GMT");

require SYS_ROOT . '/framework/common.php';

// check config
if (count(C('apps')) == 0) {
    clsError::report('config - apps');
}

error_reporting(ENV_ERROR_REPORTING);
ini_set('display_errors', ENV_MODE != 'PRO' && ENV_DISPLAY_ERROR);

$router = new clsRouter();
$router->go();
ENV_DISPLAY_RUN_INFO && clsSystem::showRunInfo();
// todo ENV_WRITE_LOG &&
