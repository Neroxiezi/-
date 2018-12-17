<?php
/**
 * Created by PhpStorm.
 * User: 运营部
 * Date: 2018/12/17
 * Time: 17:35
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
 *   悲观锁(Pessimistic Lock), 顾名思义，就是很悲观。
 *   每次去拿数据的时候都认为别人会修改，所以每次在拿数据的时候都会上锁。
 *   场景：如果项目中使用了缓存且对缓存设置了超时时间。当并发量比较大的时候，如果没有锁机制，那么缓存过期的瞬间， 大量并发请求会穿透缓存直接查询数据库，造成雪崩效应。
 *
 */
declare(strict_types=1);
function lock(string $key = '', int $expire = 5): bool
{
    $redis = new Redis();
    $redis->connect('192.168.99.100', 6379);
    $is_lock = $redis->setnx($key, time() + $expire);
    if (!$is_lock) {
        //判断锁是否过期
        $lock_time = $redis->get($key);
        //锁已过期, 删除锁，重新获取
        if (time() > $lock_time) {
            unlock($key);
            $is_lock = $redis->setnx($key, time() + $expire);
        }
    }

    return $is_lock ? true : false;
}

function unlock(string $key): int
{
    $redis = new Redis();
    $redis->connect('192.168.99.100', 6379);
    return $redis->del($key);
}


$key = 'Test_bihu_lock';

// 获取锁
$is_lock = lock($key, 10);

//var_dump($is_lock);
if ($is_lock) {
    echo '获取锁成功<br>';
    echo '------------写功能代码------------<br>';
    sleep(5);
    echo '操作成功<br>';
    unlock($key);  // 删除锁
} else {
    echo '操作失败';
}