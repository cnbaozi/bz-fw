<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 14-7-16
 * Time: 下午7:33
 */

// todo

function C($name, $value = null){
    if ($value === null) {
        return $GLOBALS['_CONFIG'][$name];
    } else {
        $GLOBALS['_CONFIG'][$name] = $value;
    }
}

function __d($var, $display = true,  $isDie = false,$split = "\n")
{
    $type = gettype($var);
    if(in_array($type, array('array'))) {
        $var = var_export($var, 1);
    }
    // write log
    if (ENV_WRITE_D_LOG) {
        $file = ENV_D_LOG_DIR;
        @file_put_contents($file, "******************* ".date('Y-m-d H:i:s')." *******************\n".
            $var . $split . "\n", FILE_APPEND);
    }

    // output
    if (defined('ENV_DEBUG') && ENV_DEBUG && $display) {
        echo "<pre>" . $var . "</pre>";
    }

    if($isDie) {
        die();
    }
}



function __t($name = '', $echo = ENV_DISPLAY_T)
{
    $now = microtime(1);
    if (!isset($GLOBALS['time'])) {
        // first
        $GLOBALS['time']['log']['request_start'] = $_SERVER['REQUEST_TIME_FLOAT'];
    }

    $name == '' && $name = count($GLOBALS['time']['log']);
    $current = $now - $GLOBALS['time']['log']['request_start'];
    $current = round($current * 1000, 5);
    $output = "{$name}: {$current}ms";
    __d($output, $echo);

    $GLOBALS['time']['log'][$name] = $now;
}