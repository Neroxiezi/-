<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/7/8
 * Time: 11:26
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

namespace Api;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;

# use Lcobucci\JWT\Signer\Hmac\Sha256;

class Api
{
    public function index()
    {
        $builder = new Builder();
        # $signer = new Sha256();
        # var_dump($signer);
        // 设置发行人$builder->setIssuer('http://example.com');
        // 设置接收人$builder->setAudience('http://example.org');
        // 设置id$builder->setId('4f1g23a12aa', true);
        // 设置生成token的时间$builder->setIssuedAt(time());
        // 设置在60秒内该token无法使用$builder->setNotBefore(time() + 60);
        // 设置过期时间$builder->setExpiration(time() + 3600);
        // 给token设置一个id$builder->set('uid', 1);
        // 对上面的信息使用sha256算法签名$builder->sign($signer, '签名key');
        // 获取生成的token$token = $builder->getToken();

    }

    /**
     * 使用RSA和ECDSA签名
     */
    public function _get_token()
    {
        $signer = new Sha256();
        $keychain = new Keychain();
        $builder = new Builder();
        $builder->setIssuer('http://example.com');
        $builder->setAudience('http://example.org');
        $builder->setId('4f1g23a12aa', true);
        $builder->setIssuedAt(time());
        $builder->setNotBefore(time() + 60);
        $builder->setExpiration(time() + 3600);
        $builder->set('uid', 1);// 与上面不同的是这里使用的是你的私钥，并提供私钥的地址$builder->sign($signer, $keychain->getPrivateKey('file://{私钥地址}'));
        $token = $builder->getToken();
        echo '<pre>';
        var_dump($token);
    }
}