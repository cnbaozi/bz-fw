<?php
/**
 * basic init
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-7-15
 * Time: 下午11:00
 * To change this template use File | Settings | File Templates.
 */


// !!! DO NOT CHANGE follow, please change them in config.php

// default $_CONFIG
if (!isset($_CONFIG)) {
    global $_CONFIG;
    $_CONFIG = array(
        'apps' => array('Home') // 首字母必须大写
    );
}

defined('SYS_ROOT') || define('SYS_ROOT', dirname(dirname(__FILE__)));

// system constants
define('SYS_FRAMEWORK', SYS_ROOT . '/framework');
define('SYS_LIB_DIR', SYS_FRAMEWORK . '/Library');
define('SYS_TOOLS_DIR', SYS_FRAMEWORK . '/Tools');
define('SYS_BaseLib_DIR', SYS_FRAMEWORK . '/Base');
define('SYS_APP_DIR', SYS_ROOT . '/app');
define('SYS_CACHE_TPL_DIR', SYS_ROOT . '/cache/tpl');
define('SYS_CHARSET', 'UTF-8');

// default environment, config.php is priority
defined('ENV_MODE') || define('ENV_MODE', 'PRO'); // DEBUG/PRO
defined('ENV_DEBUG') || define('ENV_DEBUG', false);
defined('ENV_ERROR_REPORTING') || define('ENV_ERROR_REPORTING', 0);
defined('ENV_DISPLAY_ERROR') || define('ENV_DISPLAY_ERROR', 0);
defined('ENV_DISPLAY_RUN_INFO') || define('ENV_DISPLAY_RUN_INFO', false);
defined('ENV_DISPLAY_T') || define('ENV_DISPLAY_T', false);
defined('ENV_WRITE_D_LOG') || define('ENV_WRITE_D_LOG', false);
defined('ENV_D_LOG_DIR') || define('ENV_D_LOG_DIR', SYS_ROOT . '/log/d.log');

// default system constants
defined('SYS_DEFAULT_APP') || define('SYS_DEFAULT_APP', $GLOBALS['_CONFIG']['apps'][0]);
defined('SYS_DEFAULT_MODULE') || define('SYS_DEFAULT_MODULE', 'Index');
defined('SYS_DEFAULT_METHOD') || define('SYS_DEFAULT_METHOD', 'Index');

define('TYPE_STRING', 'String');
define('TYPE_INT', 'Int');
define('TYPE_TYPE_ENUM', 'Enum');

defined('TABLE_PREFIX') || define('TABLE_PREFIX', '');

require SYS_FRAMEWORK . '/functions.php';


spl_autoload_register(function ($clsName){
    $clsName = trim($clsName, "\\");
    if (strpos($clsName, 'cls') === 0) {
        // system lib
        $file = SYS_LIB_DIR . "/{$clsName}.php";
    } elseif (strpos($clsName, 'tls') === 0) {
        // tools lib
        $file = SYS_TOOLS_DIR . "/{$clsName}.php";
    } elseif (strpos($clsName, 'Base') === 3 || strpos($clsName, 'bas') === 0) {
        // Base lib like '\ctlBase'  '\mdlBase'
        $file = SYS_BaseLib_DIR . "/{$clsName}.php";
    } elseif(strpos($clsName, 'Twig') === 0){
        $path = str_replace('_', '/', $clsName);
        $file = SYS_LIB_DIR . '/' . $path .'.php';

    } else {
        // app
        $clsInfo = explode("\\", $clsName);
        $clsInfo = array_filter($clsInfo);
        if (count($clsInfo) == 1 ) {
            // like \Route, not recommended
            $file = SYS_LIB_DIR . "/{$clsName}.php";
        }elseif(count($clsInfo) == 2) {
            // like \Home\ctlBase
            if (strpos($clsInfo[1], 'mdl') !== 0 && strpos($clsInfo[1], 'ctl') !== 0) {
                $file ='';
            } else {
                $classType = strpos($clsInfo[1], 'mdl') === 0 ? 'Model' : 'Controller';
                $file = SYS_APP_DIR . "/{$clsInfo[0]}/{$classType}/{$clsInfo[1]}.php";
            }
        } elseif(count($clsInfo) == 3) {
            // like \Home\user\ctlBase
            if (strpos($clsInfo[2], 'mdl') !== 0 && strpos($clsInfo[2], 'mdl') !== 0) {
                $file ='';
            } else {
                $classType = strpos($clsInfo[1], 'mdl') === 0 ? 'Model' : 'Controller';
                $file = SYS_APP_DIR . "/{$clsInfo[0]}/{$classType}/{$clsInfo[1]}/{$clsInfo[2]}.php";
            }
        } else {
            $file = '';
        }
    }

    if (empty($file)) {
        __d("load {$clsName} error.", true, true);
    }

    $file = realpath($file);

    if ($file) {
        require_once $file;
    } else {
        __d($clsName . ' not found!', true, true);
    }

});