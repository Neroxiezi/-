<?php

// PHP 加密算法

/*+++++++++++++++++++++++++++++++ 不可逆算法 +++++++++++++++++++++++++++++++++*/
//md5() 简单加密

$str = '123456';
echo md5($str);
echo '<hr>';

//md5 盐加密
$str1 = '123456';
$salt = 'salt'; // 这是密码盐
echo md5(md5($str1).$salt);
echo '<hr>';

//crypt() 加密
$str2 = '123456';
$salt2 = 'salt'; // 这是密码盐
echo crypt($str2,$salt2);


/*+++++++++++++++++++++++++++++ 可逆算法 +++++++++++++++++++++++++++++++++++++*/

/**
 *  对称算法
 */

// 1. 简单的对称加密算法
function encode($string = '', $skey = 'cxphp') {
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value){
        $key < $strCount && $strArr[$key].=$value;
    }
    return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), implode('', $strArr));
}

function decode($string = '', $skey = 'cxphp') {
    $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value){
        $key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    }

    return base64_decode(join('', $strArr));
}

// 2.利用 位运算的对称加密算法

//加密函数
function passport_encrypt($txt, $key) {
    $encrypt_key = md5(rand(0, 32000));
    $ctr = 0;
    $tmp = '';
    for($i = 0;$i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
    }
    //var_dump(passport_key($tmp, $key));exit;
    return base64_encode(passport_key($tmp, $key));
}
//解密函数
function passport_decrypt($txt, $key) {
    $txt = passport_key(base64_decode($txt), $key);

    $tmp = '';
    for($i = 0;$i < strlen($txt); $i++) {
        $md5 = $txt[$i];
        $tmp .= $txt[++$i] ^ $md5;
    }
    return $tmp;
}

function passport_key($txt, $encrypt_key) {
    $encrypt_key = md5($encrypt_key);
    $ctr = 0;
    $tmp = '';
    for($i = 0; $i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
    }
    return $tmp;
}

/**
 *  非对称加密
 */

class Rsa {
    private static $PRIVATE_KEY = '-----BEGIN RSA PRIVATE KEY-----MIICXgIBAAKBgQCoZZ8iUBprOIc0kGckr5ax6/Fd9IKKMc/XHayKEAvqpS0oz0b1ojEkpkdZBk0OWNhp73YNV+YLKBwwxOwb3u3hl8nBLoG/RilEbBMdCf55cUzNsfn/XF5CiLr/aci/OHuTe6ULvXs280T5M+nUh3iKdiT6z9XrFbH69C+xFoNInwIDAQABAoGAe+ape7msdo+VC5vkCB4ZprePVC3/jmawIfr3ZG4CFpeJ7qjz8O9xcSHXBS2ZrKC6Otex6Idv/213sHpzrt4L7+rSrgMOauWNjSVjr4T4Z168uvsnNocn+3GWfzbBPQj3PhjE64R/MkWDvuq2UK945WYtqFaC6LT1mJAXhjxqpiECQQDYGWYbCsUgQS0LnDzReyotkb9Eyr5UGlI8Nzn3PvwwkIS3N3yUsm2t3UokOw02DlhkC4f1aT097fM1w0FruSNNAkEAx31taitIGwgJg+yPmvwTs8AENm0wxi/V6loEXPBPxX2R4NjSG+ExYzA7/daDq//McKsX0EcYcsFN0E3HwSANmwJBAJUXGOHpUU1Kiihrd25TWissVdjBRATEUB4pP/2738QlwNqjFnmEjLUaak+KyjeUOBl19ywymkUCyPw7pQQMLDUCQQC84DKSDPyuK0PnFjk5QmXdEHZsmaFOY8gjpKrw286La8KMonz8TJCYGvkR8uKkHQMRwcxANLAfJopoKNxyK8j1AkEAwcY3EHeKe4i3FhCjGSqAGAzFFBS1jzTNZxw/cxMMCbfxFH4WvhowqoC1iAKDyZ7HF7V+RcxcfuhoBJi/3+ImEg==-----END RSA PRIVATE KEY-----';
    private static $PUBLIC_KEY = '-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCoZZ8iUBprOIc0kGckr5ax6/Fd9IKKMc/XHayKEAvqpS0oz0b1ojEkpkdZBk0OWNhp73YNV+YLKBwwxOwb3u3hl8nBLoG/RilEbBMdCf55cUzNsfn/XF5CiLr/aci/OHuTe6ULvXs280T5M+nUh3iKdiT6z9XrFbH69C+xFoNInwIDAQAB-----END PUBLIC KEY-----';

    /**
     * 获取私钥
     * @return bool|resource
     */
    private static function getPrivateKey()
    {
        $privKey = self::$PRIVATE_KEY;
        return openssl_pkey_get_private($privKey);
    }

    /**
     * 获取公钥
     * @return bool|resource
     */
    private static function getPublicKey()
    {
        $publicKey = self::$PUBLIC_KEY;
        return openssl_pkey_get_public($publicKey);
    }

    /**
     * 私钥加密
     * @param string $data
     * @return null|string
     */
    public static function privEncrypt($data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_private_encrypt($data,$encrypted,self::getPrivateKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 公钥加密
     * @param string $data
     * @return null|string
     */
    public static function publicEncrypt($data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_public_encrypt($data,$encrypted,self::getPublicKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 私钥解密
     * @param string $encrypted
     * @return null
     */
    public static function privDecrypt($encrypted = '')
    {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey())) ? $decrypted : null;
    }

    /**
     * 公钥解密
     * @param string $encrypted
     * @return null
     */
    public static function publicDecrypt($encrypted = '')
    {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_public_decrypt(base64_decode($encrypted), $decrypted, self::getPublicKey())) ? $decrypted : null;
    }
}

//使用 非对称加密
$rsa = new Rsa();
$data['name'] = 'Tom';
$data['age']  = '20';
$privEncrypt = $rsa->privEncrypt(json_encode($data));
echo '私钥加密后:'.$privEncrypt.'<br>';

$publicDecrypt = $rsa->publicDecrypt($privEncrypt);
echo '公钥解密后:'.$publicDecrypt.'<br>';

$publicEncrypt = $rsa->publicEncrypt(json_encode($data));
echo '公钥加密后:'.$publicEncrypt.'<br>';

$privDecrypt = $rsa->privDecrypt($publicEncrypt);
echo '私钥解密后:'.$privDecrypt.'<br>';