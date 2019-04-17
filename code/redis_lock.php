<?php

/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/16
 * Time: 16:18
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
class Redis_lock
{
    public static function getRedis()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', '6379');
        $redis->auth('pfinal');

        return $redis;
    }

    public static function lock($key, $expire = 60)
    {
        if (!$key) {
            return false;
        }
        $redis = self::getRedis();
        do {
            if ($acquired = ($redis->setnx("Lock:{$key}", time()))) {
                $redis->expire($key, $expire);
                break;
            }
            usleep($expire);
        } while (true);

        return true;
    }

    // 释放锁
    public static function release($key)
    {
        if (!$key) {
            return false;
        }
        $redis = self::getRedis();
        $redis->del("Lock:{$key}");
        $redis->close();
    }
}

$redis = Redis_lock::getRedis();
Redis_lock::lock('lock');
$re = $redis->get('Sentiger');
$re--;
$redis->set('Sentiger', $re);
Redis_lock::release('lock');