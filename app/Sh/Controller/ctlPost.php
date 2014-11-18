<?php
/**
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-9-27
 * Time: 上午10:33
 * To change this template use File | Settings | File Templates.
 */

namespace Sh;


class ctlPost extends ctlBase{

    public function opList()
    {
        $cid = \clsInput::get('type');
        $page = \clsInput::get('page');
        $page = max(1, $page);
        $limit = 10;
        $parentIds = array(12);
        if (in_array($cid, $parentIds)) {
            $list = mdlPmw::fetchNewsListByPid($cid, $limit, 1);
            $total = mdlPmw::countNewsByPid($cid);
        } else {
            $list = mdlPmw::fetchNewsListByCid($cid, $limit, 1);
            $total = mdlPmw::countNewsByCid($cid);
        }
        mdlPmw::fillClassName($list);
        $cateName = mdlPmw::getClassName($cid);
        $this->assign('cateName', $cateName);
        $this->assign('list', $list);
        $pageLink = SITE_HOME . '/list-'.$cid;
        $pageHtml = \clsTools::page($page, ceil($total/$limit), $pageLink, '-');
        $this->assign('page', $pageHtml);
        $this->assign('fastLink', mdlPmw::getMemuList(1, 6));
        $hotNews = mdlPmw::fetchListByFlag('c',5);
        mdlPmw::cutTitle($hotNews, 17);
        $this->assign('hotNews', $hotNews);
        $this->display('list');
    }

    public function opDetail()
    {
        //echo 'detail';
        $id = \clsInput::get('id');
        $info = mdlPmw::getPostInfo($id);
        $info['cateName'] = mdlPmw::getClassName($info['classid']);
        $this->assign('post', $info);
        $this->assign('fastLink', mdlPmw::getMemuList(1, 6));
        $hotNews = mdlPmw::fetchListByFlag('c',5);
        mdlPmw::cutTitle($hotNews, 17);
        $this->assign('hotNews', $hotNews);
        $this->display('post');
    }
}