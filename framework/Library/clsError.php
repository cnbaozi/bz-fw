<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 14-7-20
 * Time: 下午2:20
 */

class clsError {
    public static function report($msg, $display = false, $die = false) {
        $errStr = "Error: {$msg}";
        __d($errStr, $display && ENV_DEBUG, $die);
    }

    // todo
    public static function E404($die = true) {
        $msg = '404: ' . $_SERVER['REQUEST_URI'];
        __d($msg ,false);
        if ($die) {
            exit;
        }
    }
} 