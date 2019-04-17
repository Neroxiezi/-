<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/17
 * Time: 14:06
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

header('content-type:text/html;charset=utf-8');

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->auth('pfinal');

// 监视 count 值
$redis->watch('count');
// 开启事务
$redis->multi();
// 操作count
$time = time();
$redis->set('count', $time);

/**
 *  模拟并发下其他进程进行 set count 操作
 */

$res = $redis->exec();
if ($res) {
    // 成功
    echo 'success'.$time;

    return;
}
// 失败
echo 'fail'.$time;