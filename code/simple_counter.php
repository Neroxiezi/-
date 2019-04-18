<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/18
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
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->auth('pfinal');

$strKey = "Test_bibu_comments";
// 设置初始值
$redis->set($strKey, 0);
$redis->incr($strKey);
$redis->incr($strKey);
$redis->incr($strKey);
$redis->incr($strKey);
$strNowCount = $redis->get($strKey);
echo "--- 当前数量为{$strNowCount}。----";
