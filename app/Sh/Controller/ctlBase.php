<?php
/**
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-9-20
 * Time: 下午7:49
 * To change this template use File | Settings | File Templates.
 */

namespace Sh;


class ctlBase extends \ctlBase
{
    public function __construct()
    {
        $this->_nav();
    }


    protected function _nav()
    {
        $nav = mdlPmw::getNav();
        $this->_setCurrent();
        $this->assign('navArr', $nav);
    }

    public function _setCurrent()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, 'list-')!==false) {
            $uri = preg_replace('/(^\/list-\d+)(-\d)+/', "$1", $uri);
        }
        $this->assign('cur', $uri);
    }

}