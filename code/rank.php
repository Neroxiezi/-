<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/17
 * Time: 16:16
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

$strKey = 'Test_bihu_score';

// 存储数据
$redis->zAdd($strKey, '50', json_encode(['name' => 'Tom']));
$redis->zAdd($strKey, '70', json_encode(['name' => 'John']));
$redis->zAdd($strKey, '90', json_encode(['name' => 'Jerry']));
$redis->zAdd($strKey, '30', json_encode(['name' => 'Job']));
$redis->zAdd($strKey, '100', json_encode(['name' => 'LiMing']));

$dataOne = $redis->zRevRange($strKey, 0, -1, true);
echo "----{$strKey}由大到小的排序 ---- <br/><br>";
print_r($dataOne);

$dataTwo = $redis->zRange($strKey, 0, -1, true);
echo "<br><br> --- {$strKey}由小到大的排序 ---- <br><br>";
print_r($dataTwo);