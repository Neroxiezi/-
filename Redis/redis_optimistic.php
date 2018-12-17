<?php
/**
 * Created by PhpStorm.
 * User: 运营部
 * Date: 2018/12/17
 * Time: 17:55
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
 *
 * 解释：乐观锁(Optimistic Lock), 顾名思义，就是很乐观。

 * 每次去拿数据的时候都认为别人不会修改，所以不会上锁。

 * watch命令会监视给定的key，当exec时候如果监视的key从调用watch后发生过变化，则整个事务会失败。

 * 也可以调用watch多次监视多个key。这样就可以对指定的key加乐观锁了。

 * 注意watch的key是对整个连接有效的，事务也一样。

 * 如果连接断开，监视和事务都会被自动清除。

 * 当然了exec，discard，unwatch命令都会清除连接中的所有监视。
 *
 *
 */
$redis = new Redis();
$redis->connect('192.168.99.100', 6379);

$strKey = 'Test_bihu_age';
$redis->set($strKey,10);
$age = $redis->get($strKey);
echo "---- Current Age:{$age} ---- <br/><br/>";
$redis->watch($strKey);
// 开启事务
$redis->multi();

//在这个时候新开了一个新会话执行
$redis->set($strKey,30);  //新会话

echo "---- Current Age:{$age} ---- <br/><br/>"; //30

$redis->set($strKey,20);

$redis->exec();

$age = $redis->get($strKey);

echo "---- Current Age:{$age} ---- <br/><br/>"; //30
