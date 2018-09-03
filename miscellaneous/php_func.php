<?php
/**
 *  PHP常用函数收集
 */


// 生成随机字符串

function rand_str($len = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = substr(str_shuffle($characters), 0, $len);
    return $str;
}

/*echo rand_str(4);*/
//获取当前页面的url
function curPageURL()
{
    $pageURL = 'http';
    if (!empty($_SERVER['HTTPS'])) {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

/*
echo curPageURL();*/

//获取用户的真实IP
function getIp()
{
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
function injCheck($sql_str)
{
    $check = preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/', $sql_str);
    if ($check) {
        echo '非法字符！！';
        exit;
    } else {
        return $sql_str;
    }
}

//简单bese64 加密算法
function encode($string = '', $skey = 'cxphp')
{
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value) {
        $key < $strCount && $strArr[$key] .= $value;
    }
    return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), implode('', $strArr));
}

function decode($string = '', $skey = 'cxphp')
{
    $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value) {
        $key <= $strCount && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    }

    return base64_decode(join('', $strArr));
}

class mycrypt
{

    public $pubkey;
    public $privkey;

    function __construct()
    {
        $this->pubkey = file_get_contents('./public.key');
        $this->privkey = file_get_contents('./private.key');
    }

    public function encrypt($data)
    {
        if (openssl_public_encrypt($data, $encrypted, $this->pubkey))
            $data = base64_encode($encrypted);
        else
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');

        return $data;
    }

    public function decrypt($data)
    {
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->privkey))
            $data = $decrypted;
        else
            $data = '';
        return $data;
    }
}


//加密函数
function passport_encrypt($txt, $key)
{
    $encrypt_key = md5(rand(0, 32000));
    $ctr = 0;
    $tmp = '';
    for ($i = 0; $i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $encrypt_key[$ctr] . ($txt[$i] ^ $encrypt_key[$ctr++]);
    }
    //var_dump(passport_key($tmp, $key));exit;
    return base64_encode(passport_key($tmp, $key));
}

//解密函数
function passport_decrypt($txt, $key)
{
    $txt = passport_key(base64_decode($txt), $key);

    $tmp = '';
    for ($i = 0; $i < strlen($txt); $i++) {
        $md5 = $txt[$i];
        $tmp .= $txt[++$i] ^ $md5;
    }
    return $tmp;
}

function passport_key($txt, $encrypt_key)
{
    $encrypt_key = md5($encrypt_key);
    $ctr = 0;
    $tmp = '';
    for ($i = 0; $i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
    }
    return $tmp;
}

//获取用户端URL
function current_url()
{
    $url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $validURL = str_replace("&", "&", $url);
    return $validURL;
}


// 搜索 和高亮 字符串中的关键字
function highlighter_text($text, $words)
{
    $split_words = explode(" ", $words);
    foreach ($split_words as $word) {
        $color = "#4285F4";
        $text = preg_replace("|($word)|Ui",
            "<span style=\"color:" . $color . ";\"><b>$1</b></span>", $text);
    }
    return $text;
}


//检测URL 是否正确
function isvalidURL($url)
{
    $check = 0;
    if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
        $check = 1;
    }
    return $check;
}


// 计算两个坐标之间的距离
function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2)
{
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    $feet = $miles * 5280;
    $yards = $feet / 3;
    $kilometers = $miles * 1.609344;
    $meters = $kilometers * 1000;
    return compact('miles', 'feet', 'yards', 'kilometers', 'meters');
}

/**
 * 检测用户位置
 * @param $ip
 * @return string
 */
function detect_city($ip)
{

    $default = 'UNKNOWN';
    $curlopt_useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)';

    $url = 'http://ipinfodb.com/ip_locator.php?ip=' . urlencode($ip);
    $ch = curl_init();

    $curl_opt = array(
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_USERAGENT => $curlopt_useragent,
        CURLOPT_URL => $url,
        CURLOPT_TIMEOUT => 1,
        CURLOPT_REFERER => 'http://' . $_SERVER['HTTP_HOST'],
    );

    curl_setopt_array($ch, $curl_opt);

    $content = curl_exec($ch);
    if (!is_null($content)) {
        $curl_info = curl_getinfo($ch);
    }

    curl_close($ch);
    $city = '';
    if (preg_match('{<li>City : ([^<]*)</li>}i', $content, $regs)) {
        $city = $regs[1];
    }
    if (preg_match('{<li>State/Province : ([^<]*)</li>}i', $content, $regs)) {
        $state = $regs[1];
    }

    if ($city != '' && $state != '') {
        $location = $city . ', ' . $state;
        return $location;
    } else {
        return $default;
    }
}







