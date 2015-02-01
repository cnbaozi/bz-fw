<?php
/**
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-7-15
 * Time: 下午11:17
 * To change this template use File | Settings | File Templates.
 */

class ctlBase {

    public $app;
    public $module;
    public $method;
    private $tplVars = array();

    public function __construct()
    {

    }

    public function initController($app, $module, $method)
    {
        $this->app = $app;
        $this->module = $module;
        $this->method = $method;
    }

    public function assign($name, $value = null)
    {
        if (is_array($name) && !empty($name)) {
            // 多个同时赋值
            foreach($name as $key => $value) {
                $this->tplVars[$key] = $value;
            }
        } else {
            $this->tplVars[$name] = $value;
        }
    }

    // by templates file
    public function display($tplFile = '', $values = null, $return = false)
    {
        is_array($values) && $this->assign($values);
        empty($tplFile) && $tplFile = strtolower($this->module) . '_' . strtolower(substr($this->method, 2));

        $tplPath = SYS_APP_DIR . '/' . $this->app . '/Templates';
        $loader = new \Twig_Loader_Filesystem($tplPath);

        $config = array();
        ENV_PAGE_CACHE && $config['cache'] = SYS_CACHE_TPL_DIR;
        $twig = new \Twig_Environment($loader, $config);

        $tplFile = $tplFile . '.html';
        $output = $twig->render($tplFile, $this->tplVars);

        if ($return) {
            return $output;
        } else {
            echo $output;
        }
    }

    // by string
    public function render($format, $values = null, $return = false)
    {
        is_array($values) && $this->assign($values);

        $loader = new \Twig_Loader_String();
        $twig = new \Twig_Environment($loader);
        $output = $twig->render($format, $this->tplVars);

        if ($return) {
            return $output;
        } else {
            echo $output;
        }
    }

    public function opPage404()
    {
        echo '404';
    }

    protected function response($code = 100, $result = null, $msg = '')
    {
        $o = new \stdClass();
        $o->code = $code;
        $o->result = $result;
        $o->msg = $msg;
        $output = json_encode($o);
        echo $output;
        
    }
    
}