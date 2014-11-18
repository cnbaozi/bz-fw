<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 14-7-22
 * Time: 下午8:32
 */

/**
 * deal input class
 * Class clsInput
 */
class clsInput {

    /**
     * get
     * @param null $key
     * @param string $type
     * @param bool $noDefault
     * @param null $extra
     * @return bool|int|mixed|null|string
     */
    public static function get($key = null, $type = TYPE_INT, $noDefault = false, $extra = null)
    {
        $data = $_GET;
        return self::_deal($data, $key, $type, $noDefault, $extra);
    }

    public static function post($key = null, $type = TYPE_INT, $noDefault = false, $extra = null)
    {
        $data = $_POST;
        return self::_deal($data, $key, $type, $noDefault, $extra);
    }

    public static function cookie($key = null, $type = TYPE_INT, $noDefault = false, $extra = null)
    {
        $data = $_COOKIE;
        return self::_deal($data, $key, $type, $noDefault, $extra);
    }

    public static function request($key = null, $type = TYPE_INT, $noDefault = false, $extra = null)
    {
        $data = $_REQUEST;
        return self::_deal($data, $key, $type, $noDefault, $extra);
    }


    /**
     * deal method
     * @param $data
     * @param null $key
     * @param string $type
     * @param bool $noDefault
     * @param null $extra
     * @return bool|int|mixed|null|string
     */
    private static function _deal($data, $key = null, $type = TYPE_INT, $noDefault = false, $extra = null)
    {
        if ($key === null) {
            return $data;
        }

        if (!isset($data[$key])) {
            if ($noDefault) {
                $value = null;
            } else {
                $value = self::_getDefault($type);
            }
        } else {
            $c = get_called_class();
            $value = $data[$key];
            $value = call_user_func_array(array($c, '_filter' . $type), array($value, $extra));
        }
        return $value;
    }

    /**
     * get default
     * @param $type
     * @return bool|int|string
     */
    protected static function _getDefault($type)
    {
        switch ($type) {
            case TYPE_INT :
                $value = 0;
                break;
            case TYPE_STRING :
                $value = '';
                break;
            case TYPE_ENUM :
                $value = false;
                break;
            default:
                $value = 0;
        }
        return $value;
    }

    /**
     * int filter
     * @param $value
     * @return int
     */
    protected static function _filterInt($value)
    {
        return intval($value);
    }

    protected static function _filterString($value) {
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        $value = trim($value);
        return $value;
    }

    protected static function _filterEnum($value, $extra)
    {
        if (!in_array($value, $extra)) {
            $value = false;
        }
        return $value;
    }

    public static function getPara()
    {
        return clsRouter::$getPara;
    }

} 