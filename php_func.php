<?php
/**
 *  PHP常用函数收集
 */


// 生成随机字符串

function rand_str($len =10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = substr(str_shuffle($characters),0,$len);
    return $str;
}
/*echo rand_str(4);*/
//获取当前页面的url
function curPageURL() {
    $pageURL = 'http';
    if (!empty($_SERVER['HTTPS'])) {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
/*
echo curPageURL();*/

//获取用户的真实IP
function getIp() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else
        if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else
            if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
                $ip = getenv("REMOTE_ADDR");
            else
                if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
                    $ip = $_SERVER['REMOTE_ADDR'];
                else
                    $ip = "unknown";
    return ($ip);
}

//echo getIp();

// 防止sql注入
function injCheck($sql_str) {
    $check = preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/', $sql_str);
    if ($check) {
        echo '非法字符！！';
        exit;
    } else {
        return $sql_str;
    }
}