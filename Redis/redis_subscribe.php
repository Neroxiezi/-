<?php
/**
 * Created by PhpStorm.
 * User: 运营部
 * Date: 2018/12/17
 * Time: 17:06
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

ini_set('default_socket_timeout', -1);
$redis = new Redis();
$link = $redis->connect('192.168.99.100', 6379);


$strChannel = 'Test_bihu_channel';

echo "---- 订阅{$strChannel}这个频道，等待消息推送...----  <br/><br/>";

$redis->subscribe([$strChannel], 'callBackFun');

function callBackFun($redis,$channel, $msg )
{
    print_r([
        'redis'   => $redis,
        'channel' => $channel,
        'msg'     => $msg
    ]);
}

/***
 * Redis 发布订阅
 * Redis 客户端可以订阅任意数量的频道。
 *  SUBSCRIBE redisChat    创建了订阅频道名为 redisChat
 *  PUBLISH redisChat "Redis is a great caching technique"
 *
 */