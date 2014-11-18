<?php
/**
 * Created by PhpStorm.
 * User: B.S
 * Date: 2014/10/28
 * Time: 20:41
 */

class clsTools {

    public static function page($cur, $total, $linkPrefix, $param, $config = array())
    {
        if ($cur>$total) {
            return '';
        }
        $_config = array(
            'num' => 5,
            'text_first' => '<<首页',
            'text_prev' => '<上页',
            'text_next' => '下页>',
            'text_end' => '末页>>',
        );
        $config = array_merge($_config, $config);
        $num = $config['num'];
        $output = '';
        $radius = floor($num / 2);
        $min = max(1, $cur - $radius);
        $max = min($total, $cur + $radius);
        $min>1 && $output .= '<span class="list_page_frt"><a href="'.$linkPrefix.'">'.$config['first'].'</a></span>';
        $cur>1 && $output .= '<span class="list_page_frt"><a href="'.$linkPrefix.$param.($cur-1).'">'.$config['text_prev'].'</a></span>';
        for ($i = $min; $i<=$max; $i++) {
            $output .= ('<span class="list_page_num'. ($i==$cur ? ' list_page_cur': '').'">
                <a href="'.$linkPrefix.$param.$i.'">' . $i . '</a></span>');
        }
        $cur<$max && $output .= '<span class="list_page_next"><a href="'.$linkPrefix.$param.($cur+1).'">'.$config['text_next'].'</a></span>';
        $max<$total && $output .= '<span class="list_page_next"><a href="'.$linkPrefix.$param.$total.'">'.$config['text_end'].'</a></span>';

        return $output;
    }
} 