<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/1/15
 * Time: 10:20
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

class Jwt
{
    private $alg = 'sha256';
    private $secret = "123456";

    /**
     * alt 属性标识前面算法 typ属性表示这个令牌
     * @return string
     */
    public function getHeader()
    {
        $header = [
            'alg' => $this->alg,
            'typ' => 'JWT'
        ];

        return $this->base64urlEncode(json_encode($header, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 生成token 假设现在只需要uid
     * @param $uid
     * @return string
     */
    public function getToken($uid)
    {
        $header = $this->getHeader();
        $payload = $this->getPayload($uid);
        $raw = $header . '.' . $payload;
        $token = $raw . '.' . hash_hmac($this->alg, $raw, $this->secret);
        return $token;
    }

    /**
     * 解密校验token,成功的话返回uid
     * @param $token
     * @return bool
     */
    public function verifyToken($token)
    {
        if (!$token) return false;
        $tokenArr = explode('.', $token);
        if (count($tokenArr) != 3) return false;
        $header = $tokenArr[0];
        $payload = $tokenArr[1];
        $signature = $tokenArr[2];
        $payloadArr = json_decode($this->base64urlDncode($payload), true);
        if (!$payloadArr) return false;

        if (isset($payloadArr['exp']) && $payloadArr['exp'] < time()) return false;

        $expected = hash_hmac($this->alg, $header . '.' . $payload, $this->secret);

        if ($expected !== $signature) return false;
        return $payloadArr['uid'];
    }

    /**
     * 存放实际需要传递的数据
     * @param $uid
     * @return string
     */
    private function getPayload($uid)
    {
        $payload = [
            'iss' => 'admin', //签发人
            'exp' => time() + 600, //过期时间
            'sub' => 'test', //主题
            'aud' => 'every',//受众
            'nbf' => time(), //生效时间
            'iat' => time(), //签发时间
            'jti' => 10001, //编号
            'uid' => $uid,  //私有信息
        ];

        return $this->base64urlEncode(json_encode($payload, JSON_UNESCAPED_UNICODE));
    }

    /**
     * base64 url编码
     * @param $data
     * @return string
     */
    private function base64urlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /***
     * base64 url解码
     * @param $data
     * @return bool|string
     */
    private function base64urlDncode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

}

$jwt = new Jwt();

$token = $jwt->getToken(1);
$uid = $jwt->verifyToken($token);
//var_dump($token);
var_dump($uid);


