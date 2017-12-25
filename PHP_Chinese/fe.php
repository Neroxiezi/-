<?php
header("Content-Type:text/html; charset=utf-8");

$str = '真怕有一天我们再次成为交叉线，我想那时就再也不可能回归了，快乐永远是拿痛苦做代价，你现在多幸福，多快乐，你以后就会越伤心越难过，不想发生!';
//$str = iconv('GB2312','UTF-8',$str);
$result = spStr($str);
print_r($result);

/**
 * UTF-8版 中文二元分词
 */
function spStr($str)
{
    $cstr = array();

    $search = array(",", "/", "\\", ".", ";", ":", "\"", "!", "~", "`", "^", "(", ")", "?", "-", "\t", "\n", "'", "<", ">", "\r", "\r\n", "{1}quot;", "&", "%", "#", "@", "+", "=", "{", "}", "[", "]", "：", "）", "（", "．", "。", "，", "！", "；", "“", "”", "‘", "’", "［", "］", "、", "—", "　", "《", "》", "－", "…", "【", "】",);

    $str = str_replace($search, " ", $str);
    preg_match_all("/[a-zA-Z]+/", $str, $estr);
    preg_match_all("/[0-9]+/", $str, $nstr);

    $str = preg_replace("/[0-9a-zA-Z]+/", " ", $str);
    $str = preg_replace("/\s{2,}/", " ", $str);

    $str = explode(" ", trim($str));

    foreach ($str as $s) {
        $l = strlen($s);

        $bf = null;
        for ($i= 0; $i< $l; $i=$i+3) {
            $ns1 = $s{$i}.$s{$i+1}.$s{$i+2};
            if (isset($s{$i+3})) {
                $ns2 = $s{$i+3}.$s{$i+4}.$s{$i+5};
                if (preg_match("/[\x80-\xff]{3}/",$ns2)) $cstr[] = $ns1.$ns2;
            } else if ($i == 0) {
                $cstr[] = $ns1;
            }
        }
    }

    $estr = isset($estr[0])?$estr[0]:array();
    $nstr = isset($nstr[0])?$nstr[0]:array();

    return array_merge($nstr,$estr,$cstr);
}