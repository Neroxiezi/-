<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/17
 * Time: 13:50
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

$timeout = 5000;
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->auth('pfinal');
do {
    $microtime = microtime(true) * 1000;
    $microtime_time = date('Y-m-d H:i:s', $microtime);
    echo "执行microtime:{$microtime}";
    echo "执行microtime_time:{$microtime_time}";
    echo '<pre>';
    $microtimeout = $microtime + $timeout + 1;
    $microtimeout_time = date('Y-m-d H:i:s', $microtimeout);
    echo "执行microtimeout_time:{$microtimeout_time}";
    echo '<pre>';
    // 上锁
    $isLock = $redis->setnx('lock.count', $microtimeout);
    if (!$isLock) {
        $getTime = $redis->get('lock.count');
        if ($getTime > $microtime) {
            // 睡眠 降低抢锁频率 缓解 redis压力
            usleep(5000);
            // 未超时继续等待
            continue;
        }
        // 超时 抢锁 可能有几毫秒级时间差可忽略
        $previousTime = $redis->getSet('lock,count', $microtimeout);
        if ((int)$previousTime < $microtime) {
            break;
        }
    }
} while (!$isLock);

$count = $redis->get('count') ?: 0;
//业务逻辑
echo '执行count加1操作~';
echo '<pre>';
$redis->set('count', $count + 1);
// 删除锁
$redis->del('lock.count');
// 打印count值
$count = $redis->get('count');
echo "count值为:$count";
echo '<pre>';