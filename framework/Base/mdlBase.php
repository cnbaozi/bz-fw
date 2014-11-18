<?php
/**
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-7-15
 * Time: 下午11:17
 * To change this template use File | Settings | File Templates.
 */

class mdlBase {

    private static $_instance = array();

    public static function instance()
    {
        static $modules = array();
        $class = get_called_class();
        if(!isset($modules[$class]) || !($modules[$class] instanceof $class)){
            $modules[$class] = new $class();
        }
        return $modules[$class];
    }

    public static function db()
    {
        $block = 'db';
        if(!isset(self::$_instance[$block]) || !(self::$_instance[$block] instanceof clsMedoo)){
            $dbInfo = C($block);
            $db = new clsMedoo($dbInfo);
            self::$_instance[$block] = $db;
        }
        return self::$_instance[$block];
    }

}