<?php
/**
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-7-15
 * Time: 下午11:22
 * To change this template use File | Settings | File Templates.
 */

class clsRouter {

    public $app = '';

    public $module = '';

    public $method = '';

    public static $getPara = array();

    public function __construct()
    {
        $this->parse();
    }

    public function rewrite($uri)
    {
        $reg = C('router');
        foreach ($reg as $old => $new) {
            $uri = preg_replace("/$old/", $new, $uri, 1, $count);
            if ($count) {
                break;
            }
        }
        return $uri;
    }

    /**
     * /news/1
     * /news/id-1-page-1
     * /news-list/page-1
     * /home/news/1
     */
    public function parse()
    {
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $uri = $uri['path'];
        $uri = $this->rewrite($uri); // rewrite
        $section = explode('/', $uri);
        $section = array_values(array_filter($section));
        $apps = C('apps');
        $sectionLen = count($section);
        if ($sectionLen == 0) {
            // default, like /
        } elseif ($sectionLen == 1){
            if (in_array(ucfirst($section[0]), $apps)) {
                // like /Home
                $this->app = $section[0];
            } else {
                $this->_dealModuleAndMethod($section[0]);
            }
        } elseif($sectionLen == 2) {
            if (in_array(ucfirst($section[0]), $apps)) {
                // like /Home/news-detail
                $this->app = $section[0];
                $this->_dealModuleAndMethod($section[1]);
            } else {
                // like /news-detail/get...
                $this->_dealModuleAndMethod($section[0]);
                $this->_dealGetPara($section[1]);
            }
        } elseif ($sectionLen == 3) {
            if (!in_array(ucfirst($section[0]), $apps)) {
                // like /Home/news-detail/id-1-page-2
                clsError::E404();
            } else {
                $this->app = $section[0];
                $this->_dealModuleAndMethod($section[1]);
                $this->_dealModuleAndMethod($section[2]);
            }
        }
    }

    private function _dealModuleAndMethod($section) {
        $newSection = explode('-', $section);
        if (count($newSection) == 1) {
            // like /news
            $this->module = $newSection[0];
        } elseif(count($newSection) == 2) {
            // like /news-detail
            $this->module = $newSection[0];
            $this->method = $newSection[1];
        } else {
            clsError::E404();
        }
    }

    private function _dealGetPara($section) {
        if (empty($section)) {
            return ;
        }
        $section = explode('-', $section);
        self::$getPara = $section;

        $sectionLen = count($section);
        $i = 1;
        $data = array();
        while ($i<$sectionLen) {
            $data[$section[$i-1]] = $section[$i];
            $i += 2;
        }

        if ($sectionLen % 2 == 1) {
            $data['_last'] = $section[$i-1];
        }

        $_GET = array_merge($data, $_GET);
    }

    public function go()
    {
        $app = empty($this->app) ? SYS_DEFAULT_APP : $this->app;
        $module = empty($this->module) ? SYS_DEFAULT_MODULE : $this->module;
        $method = empty($this->method) ? SYS_DEFAULT_METHOD : $this->method;


        $app = ucfirst($app);
        $module = ucfirst($module);
        $method = ucfirst($method);

        $path = SYS_APP_DIR . "/{$app}/Controller/ctl{$module}.php";

        if(!in_array($app, C('apps')) || !file_exists($path)) {
            clsError::E404();
        }

        $class = "\\{$app}\\ctl{$module}";

        $realMethod = 'op' . $method;
        $ctl = new $class();
        $ctl->initController($app, $module, $realMethod);

        if (method_exists($ctl, $realMethod)) {
            $ctl->$realMethod();
        } else {
            clsError::E404();
        }

    }

}