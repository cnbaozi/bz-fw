<?php
/**
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-9-20
 * Time: 下午7:48
 * To change this template use File | Settings | File Templates.
 */

namespace Sh;

class ctlIndex extends ctlBase
{
    public function opIndex()
    {
        $headline = mdlPmw::fetchListByFlag('h', 1);
        if ($headline) {
            $hlLen = 100;
            $headline['content'] = strip_tags($headline['content']);
            if (mb_strlen($headline['content'], SYS_CHARSET)>$hlLen) {
                $headline['content'] = mb_substr($headline['content'], 0 , $hlLen, 'UTF-8').'...';
            }

        }

        $shNews = mdlPmw::fetchNewsListByCid(14, 4);
        $services = mdlPmw::fetchNewsListByPid(12, 6);
        mdlPmw::fillClassName($services);
        $shBulletin = mdlPmw::fetchNewsListByCid(13, 6);
        mdlPmw::cutTitle($shBulletin);
        $members = mdlPmw::fetchNewsListByCid(11, 6);
        mdlPmw::cutTitle($members);
        $memberNews = mdlPmw::fetchNewsListByCid(15, 6);
        mdlPmw::cutTitle($memberNews);
        $this->assign(array(
            'slideArr' => mdlPmw::fetchListByFlag('f', 5),
            'headline' => $headline,
            'shNews' => $shNews,
            'shBulletin' => $shBulletin,
            'services' => $services,
            'members' => $members,
            'memberNews' => $memberNews,
            'indexAbout' => mdlPmw::getFragment('index_about'),
            'indexVideo' => mdlPmw::getFragment('index_video'),
            'fastLink' => mdlPmw::getMemuList(1, 6),
            'shAlbum' => mdlPmw::fetchNewsListByCid(9, 10, 1, '', array('id', 'title', 'picurl')),
            'memberAlbum' => mdlPmw::fetchNewsListByCid(8, 10, 1, '', array('id', 'title', 'picurl'))
        ));
        $this->display('index');
    }

    public function opTest()
    {
        var_dump(mdlPmw::fetchListByFlag('c', 1));
    }

    public function opT()
    {
        $a = mdlPmw::fetchNewsListByCid(9, 10, 1, '', array('title', 'title', 'picurl'));
        var_dump($a);
    }
}