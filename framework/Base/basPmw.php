<?php
/**
 * Created by JetBrains PhpStorm.
 * User: B.S
 * Date: 14-9-24
 * Time: 下午8:54
 * To change this template use File | Settings | File Templates.
 */

class BasPmw extends mdlBase
{

    public static function getTable($suffix)
    {
        return TABLE_PREFIX.$suffix;
    }

    /**
     * 导航
     * @param bool $all
     * @return array
     */
    public static function getNav($all = false)
    {
        $cond = $all ? array() : array('checkinfo'=>'true');
        $cond['ORDER'] = array('orderid ASC');
        $_datas = mdlBase::db()->select(self::getTable('nav'),'*',$cond);
        if (empty($_datas)) {
            return array();
        }
        $datas = array();
        foreach ($_datas as $data) {
            if ($data['parentid']==0) {
                $datas[$data['id']] = $data;
            } elseif(isset($datas[$data['parentid']]) && $datas[$data['parentid']]['id'] = $data['id']) {
                $datas[$data['parentid']]['children'][$data['id']] = $data;
            }
        }
        return $datas;
    }

    /**
     * 根据父类取新闻列表
     * @param $pid
     * @param int $page
     * @param int $limit
     * @param string $flag
     * @return mixed
     */
    public static function fetchNewsListByPid($pid, $limit = 5, $page = 1, $flag = '')
    {
        $cond = array(
            'AND'=>array(
                'parentid'=>$pid,
                'checkinfo'=>'true'
            ),
            'LIMIT' => array($limit*($page-1), $limit),
            'ORDER' => array('orderid DESC', 'posttime DESC')
        );
        if (!empty($flag)) {
            $cond['LIKE'] = array('flag'=>$flag);
        }
        empty($field) && $field = array('id', 'classid', 'parentid', 'title', 'flag', 'author', 'hits', 'posttime');
        $datas = mdlBase::db()->select(self::getTable('infolist'),$field, $cond);
        return $datas;
    }

    /**
     * 取数量
     * @param $pid
     */
    public static function countNewsByPid($pid)
    {
        $cond = array(
            'AND'=>array(
                'parentid'=>$pid,
                'checkinfo'=>'true'
            )
        );
        $datas = mdlBase::db()->count(self::getTable('infolist'), $cond);
        return $datas;
    }

    /**
     * 根据分类取新闻列表
     * @param $cid
     * @param int $limit
     * @param int $page
     * @param string $flag
     * @param array $field
     * @return mixed
     */
    public static function fetchNewsListByCid($cid, $limit = 5, $page = 1, $flag = '', $field = array())
    {
        $cond = array(
            'AND'=>array(
                'classid'=>$cid,
                'checkinfo'=>'true'
            ),
            'LIMIT' => array($limit*($page-1), $limit),
            'ORDER' => array('orderid DESC', 'posttime DESC')
        );
        if (!empty($flag)) {
            $cond['LIKE'] = array('flag'=>$flag);
        }
        empty($field) && $field = array('id', 'classid', 'parentid', 'title', 'flag', 'author', 'hits', 'posttime');
        $datas = mdlBase::db()->select(self::getTable('infolist'),$field, $cond);
        return $datas;
    }

    /**
     * 取数量
     * @param $cid
     */
    public static function countNewsByCid($cid)
    {
        $cond = array(
            'AND'=>array(
                'classid'=>$cid,
                'checkinfo'=>'true'
            )
        );
        $datas = mdlBase::db()->count(self::getTable('infolist'), $cond);
        return $datas;
    }


    /**
     * @param $flag
     * @param int $limit
     * @param int $page
     * @param array $field
     * @return mixed
     */
    public static function fetchListByFlag($flag, $limit = 5, $page = 1, $field = array())
    {
        empty ($field) && $field = array('id', 'classid', 'parentid', 'title', 'flag', 'author', 'hits', 'posttime');
        $cond = array(
            'checkinfo'=>'true',
            'LIKE' => array('flag'=>$flag),
            'LIMIT' => array($limit*($page-1), $limit),
            'ORDER' => array('orderid DESC', 'posttime DESC')
        );
        $datas = mdlBase::db()->select(self::getTable('infolist'),'*', $cond);
        if ($datas && $limit==1) {
            $datas = $datas[0];
        }
        return $datas;
    }

    /**
     * 碎片数据
     * @param $title
     * @return mixed
     */
    public static function getFragment($title)
    {
        $cond = array(
            'title'=>$title
        );
        $datas = mdlBase::db()->get(self::getTable('fragment'), '*', $cond);
        return $datas;
    }

    public static function getPostInfo($id)
    {
        $cond = array(
            'id'=>intval($id)
        );
        $data = mdlBase::db()->get(self::getTable('infolist'),'*', $cond);
        return $data;
    }

    public static function getClassInfo($id, $field = '*')
    {
        $cond = array(
            'id'=>intval($id)
        );
        $data = mdlBase::db()->get(self::getTable('infoclass'),$field, $cond);
        return $data;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getClassName($id)
    {
        $data = self::getClassInfo($id, 'classname');
        return $data;
    }

    public static function getMultiClassName($ids)
    {
        $cond = array(
            'id'=> $ids
        );
        $_datas = mdlBase::db()->select(self::getTable('infoclass'),array('id', 'classname'), $cond);
        if (empty($_datas)) {
            return array();
        }
        $datas = array();
        foreach ($_datas as $data) {
            $datas[$data['id']] = $data['classname'];
        }
        return $datas;
    }



    /**
     * 页面信息
     * @param $name
     * @param string $field
     * @return mixed
     */
    public static function getPage($name, $field = '*')
    {
        $cond = array(
            'page_name'=>$name,
        );
        $data = mdlBase::db()->get(self::getTable('page'),$field, $cond);
        return $data;
    }

    /**
     * 页面列表
     * @param string $cate
     * @param string $field
     * @return mixed
     */
    public static function getPageList($cate = '', $field = '*')
    {
        $cond = array('ORDER' => array('orderid ASC'));
        $cate && $cond['category'] = $cate;

        $data = mdlBase::db()->select(self::getTable('page'),$field, $cond);
        return $data;
    }

    public static function fillClassName(&$newsList)
    {
        if (empty($newsList)) {
            return false;
        }
        $cids = array();
        foreach ($newsList as $news) {
            isset($news['classid']) && $cids[] = $news['classid'];
        }
        $classNames = self::getMultiClassName($cids);
        foreach ($newsList as &$news) {
            $news['classname'] = $classNames[$news['classid']];
        }
    }

    public static function cutTitle(&$newsList, $length = 60)
    {
        $_length = $length - 3;
        foreach ($newsList as &$news) {
            if (mb_strlen($news['title'], SYS_CHARSET) > $_length) {
                $news['title'] = mb_substr($news['title'], 0, $_length, SYS_CHARSET) . '...';
            }
        }
    }

    public static function getMemuList($pid, $limit = 6, $page = 1)
    {
        $cond = array(
            'parentid'=> $pid,
            'LIMIT' => array($limit*($page-1), $limit),
            'ORDER'=>array('orderid ASC')
        );
        $data = mdlBase::db()->select(self::getTable('diymenu'),'*', $cond);
        return $data;
    }

    public static function getLinks()
    {
        $cond = array(
            'checkinfo'=> 'true',
            'ORDER'=>array('id ASC')
        );
        $ret = mdlBase::db()->select(self::getTable('weblink'),'*', $cond);
        $datas = array();
        foreach ($ret as $link) {
            $datas[$link['classid']][] = $link;
        }
        return $datas;
    }


}