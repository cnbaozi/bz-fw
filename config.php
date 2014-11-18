<?php
/**
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-7-15
 * Time: 下午11:00
 * To change this template use File | Settings | File Templates.
 */
define('SYS_ROOT', dirname(__FILE__));
define('ENV_MODE', 'DEBUG'); // DEBUG/PRO
define('ENV_DEBUG', ENV_MODE == 'DEBUG');
define('ENV_ERROR_REPORTING', E_ALL);
define('ENV_DISPLAY_ERROR', true);
define('ENV_DISPLAY_RUN_INFO', true);
define('ENV_DISPLAY_T', true);
define('ENV_D_LOG_PATH', SYS_ROOT . '/log/d.log'); // 调试日志
define('ENV_RUN_LOG_PATH', SYS_ROOT . '/log/run.log'); // 运行日志
define('ENV_WRITE_D_LOG', true); // Debug开关
define('ENV_WRITE_LOG', true); // 日志开关
define('ENV_LOG_SQL', true); // 记录sql日志
define('ENV_PAGE_CACHE', false);
define('TABLE_PREFIX', 'sh_');
define('SITE_HOME', 'http://sh.local.com');



global $_CONFIG;
$_CONFIG = array(
    'apps' => array('Sh'), // 首字母必须大写
    'db' => array(
        'database_type'=>'mysql',
        'server'=>'127.0.0.1',
        'username'=>'root',
        'password'=>'',
        'database_name'=>'test',
    ), // 参照medoo
    'run_info_fmt' => '{%time%} ms, {%queries%} queries, {%mem%}MB',
    'run_info_html' => '<span id="run_info" style="top: 0;right:0;position: absolute;background-color: #555;color: #fff;padding: 5px 12px;">%s</span>',
    'router' => array(
        '^\/([a-zA-z]+)$' => '/page-index/name-$1', //  /about,/contacts
        '^\/post-(\d+)$' => '/post-detail/id-$1',   //  /post-1
        '^\/list-(\d+)$' => '/post-list/type-$1',   //  /list-1
        '^\/list-(\d+)-(\d+)$' => '/post-list/type-$1-page-$2', // /list-1-2
    )
);



