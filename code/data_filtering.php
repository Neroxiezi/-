<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/18
 * Time: 11:15
 *
 *
 *                      _ooOoo_
 *                     o8888888o
 *                     88" . "88
 *                     (| ^_^ |)
 *                     O\  =  /O
 *                  ____/`---'\____
 *                .'  \\|     |//  `.
 *               /  \\|||  :  |||//  \
 *              /  _||||| -:- |||||-  \
 *              |   | \\\  -  /// |   |
 *              | \_|  ''\---/''  |   |
 *              \  .-\__  `-`  ___/-. /
 *            ___`. .'  /--.--\  `. . ___
 *          ."" '<  `.___\_<|>_/___.'  >'"".
 *        | | :  `- \`.;`\ _ /`;.`/ - ` : | |
 *        \  \ `-.   \_ __\ /__ _/   .-` /  /
 *  ========`-.____`-.___\_____/___.-`____.-'========
 *                       `=---='
 *  ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
 *           佛祖保佑       永无BUG     永不修改
 *
 */

// 数据过滤的方法
/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string
 * @return array|string
 */
function new_addslashes($string)
{
    if (!is_array($string)) {
        return addslashes($string);
    }
    if (count($string) > 0) {
        foreach ($string as $key => $val) {
            $string[$key] = new_addslashes($val);
        }

        return $string;
    }
}

print_r(new_addslashes("see:'Hello 树先生!' me:'嗯'"));
echo '<br>';
/**
 * 返回经过 stripslashes处理过的字符串或数组
 * @param $string
 * @return array|string
 */
function new_stripslashes($string)
{
    if (!is_array($string)) {
        return stripslashes($string);
    }
    if (count($string) > 0) {
        foreach ($string as $key => $value) {
            $string[$key] = new_stripslashes($value);
        }

        return $string;
    }
}

print_r(new_stripslashes("see:'Hello 树先生!' me:'嗯'"));
echo '<br>';
print_r(new_stripslashes("see:\'Hello 树先生!\' me:\'嗯\'"));

/**
 *  返回经 htmlspecialchars 处理过的字符串或数组
 * @param $string
 * @return array|string
 */
function new_html_special_chars($string)
{
    $encoding = "utf-8";
    if (strtolower(CHARSET) == 'gbk') {
        $encoding = 'ISO-8859-15';
    }
    if (!is_array($string)) {
        return htmlspecialchars($string, ENT_QUOTES, $encoding);
    }
    foreach ($string as $key => $val) {
        $string[$key] = new_html_special_chars($val);
    }

    return $string;
}

/**
 * @param $string
 * @return string
 */
function new_html_entity_decode($string)
{
    $encoding = 'utf-8';
    if (strtolower(CHARSET) == 'gbk') {
        $encoding = 'ISO-8859-15';
    }

    return html_entity_decode($string, ENT_QUOTES, $encoding);
}

function new_htmlentities($string)
{
    $encoding = 'utf-8';
    if (strtolower(CHARSET) == 'gbk') {
        $encoding = 'ISO-8859-15';
    }

    return htmlentities($string, ENT_QUOTES, $encoding);
}

function safe_replace($string)
{
    $string = str_replace('%20', '', $string);
    $string = str_replace('%27', '', $string);
    $string = str_replace('%2527', '', $string);
    $string = str_replace('*', '', $string);
    $string = str_replace('"', '&quot;', $string);
    $string = str_replace("'", '', $string);
    $string = str_replace('"', '', $string);
    $string = str_replace(';', '', $string);
    $string = str_replace('<', '&lt;', $string);
    $string = str_replace('>', '&gt;', $string);
    $string = str_replace("{", '', $string);
    $string = str_replace('}', '', $string);
    $string = str_replace('\\', '', $string);

    return $string;

}