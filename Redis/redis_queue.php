<?php
/**
 * Created by PhpStorm.
 * User: 运营部
 * Date: 2018/12/17
 * Time: 12:38
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


$strQueueName  = 'Test_bihu_queue';

//进队列
$redis->rpush($strQueueName, json_encode(['uid' => 1,'name' => 'Job']));
$redis->rpush($strQueueName, json_encode(['uid' => 2,'name' => 'Tom']));
$redis->rpush($strQueueName, json_encode(['uid' => 3,'name' => 'John']));

echo '<pre>';

echo "---- 进队列成功 ---- <br /><br />";
//查看队列
$strCount = $redis->lrange($strQueueName, 0, -1);
echo "当前队列数据为： <br />";
print_r($strCount);

//出队列
$redis->lpop($strQueueName);
echo "<br /><br /> ---- 出队列成功 ---- <br /><br />";

//查看队列
$strCount = $redis->lrange($strQueueName, 0, -1);
echo "当前队列数据为： <br />";
print_r($strCount);