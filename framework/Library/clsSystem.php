<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 14-7-20
 * Time: 下午2:18
 */

class clsSystem {

    private static $sqlArr = array();

    public static function showRunInfo()
    {
        if (ENV_DISPLAY_RUN_INFO && ENV_DEBUG) {
            $fmt = C('run_info_fmt');
            $cost = microtime(1) - $_SERVER['REQUEST_TIME_FLOAT'];
            $cost = round($cost * 1000, 3);
            $mem = memory_get_peak_usage();
            $mem = round($mem /(1024*1024), 3);
            $queries = \mdlBase::db()->getQueries();
            $string = str_replace(array('{%queries%}', '{%time%}', '{%mem%}'), array($queries, $cost, $mem), $fmt);
            $output = sprintf(C('run_info_html'), $string);
            echo $output;
        }

    }

    public static function logSql($sql)
    {
        self::$sqlArr[] = $sql;
        __d($sql ,false);
    }

    public static function getSqls()
    {
        return self::$sqlArr;
    }

    public static function writeLog() {

        // todo
    }
} 