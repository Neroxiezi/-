<?php
/**
 * Created by PhpStorm.
 * User: 运营部
 * Date: 2018/12/17
 * Time: 11:44
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
$link = $redis->connect('192.168.99.100',6379);
//var_dump($link); // 返回bool值 true

echo '<pre>';

$ret = $redis->hSet('user', 'name', '大爷');
var_dump($redis->hGet('user','name'));
var_dump($redis->hExists('user','age'));
$redis->hDel('user', 'name');

//同时设置某个hash表的多个字段值。成功返回true。
$ret = $redis->hMset('user', ['name' => 'jet', 'age' => 18]);
//同时获取某个hash表的多个字段值。其中不存在的字段值为false。
var_dump($redis->hMget('user', ['name', 'age']));
var_dump($redis->hGetAll('user'));

//获取某个hash表所有字段名。hash表不存在时返回空数组，key不为hash表时返回false。
var_dump($redis->hKeys('user'));
//获取某个hash表所有字段值。
var_dump($redis->hVals('user'));