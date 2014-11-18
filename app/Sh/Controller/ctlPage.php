<?php
/**
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-9-24
 * Time: 下午11:28
 * To change this template use File | Settings | File Templates.
 */

namespace Sh;


class ctlPage extends ctlBase{

    public function OpIndex()
    {
        $name = \clsInput::get('name', TYPE_STRING);
        $data = mdlPmw::getPage($name);
        if (empty($data)) {
            \clsError::E404();
        }
        $pageList = mdlPmw::getPageList($data['category'], array('page_name', 'title'));
        $this->assign('pageList', $pageList);
        $this->assign('page', $data);
        $this->assign(array(
            'pageList' => $pageList,
            'page' => $data,
            'fastLink' => mdlPmw::getMemuList(1, 6)
        ));
        $this->display('page');
    }

    public function OpTest()
    {
        var_dump(mdlPmw::getPage('ab1out'));
        $this->display('page');
    }

}