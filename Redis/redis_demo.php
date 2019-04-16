<?php
echo '<meta charset="utf-8">';
/**
 * Created by PhpStorm.
 * User: 运营部
 * Date: 2018/12/17
 * Time: 11:20
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
$link = $redis->connect('127.0.0.1',6379);
$redis->auth('pfinal');
var_dump($link); // 返回bool值 true

/**
 * set()
 */
$result = $redis->set('test','111111111');
var_dump($result);
/**
 * get()
 */
var_dump($redis->get('test'));
/**
 * delete();
 */
$redis->delete('test');
var_dump($redis->get('test'));
/**
 * setnx()
 */
$redis->set('test',"1111111111111");
$redis->setnx('test',"22222222");
echo '<hr>';
echo $redis->get('test').'<br>';  //结果：1111111111111
$redis->delete('test');
$redis->setnx('test',"22222222");
echo $redis->get('test');  //结果：22222222

/**
 * exists();
 */

$redis->set('test2','aaaaaaa');
var_dump($redis->exists('test2'));

/**
 * decr()
 */

$redis->set('test3',"123");
var_dump($redis->decr("test3"));
var_dump($redis->decr("test3"));

/**
 * getMultiple()
 */
echo '<pre>';
$result = $redis->getMultiple(array('test1','test2','test3'));
var_dump($result);

/**
 * lpush()
 */
$redis->delete('test4');
var_dump($redis->lpush("test4","111"));   //结果：int(1)
var_dump($redis->lpush("test4","222"));   //结果：int(2)
//var_dump($result->get('test4'));

/**
 * rpush()
 */

var_dump($redis->lpush("test5","111"));   //结果：int(1)
var_dump($redis->lpush("test5","222"));   //结果：int(2)
var_dump($redis->rpush("test5","333"));   //结果：int(3)
var_dump($redis->rpush("test5","444"));   //结果：int(4)

/**
 * lpop()
 */
$redis->delete('test6');
$redis->lpush("test6","111");
$redis->lpush("test6","222");
$redis->rpush("test6","333");
$redis->rpush("test6","444");
var_dump($redis->lpop("test6"));  //结果：string(3) "222"
var_dump($redis->rpop("test6"));  //结果：string(3) "222"


/**
 * lsize,llen
 */

var_dump($redis->lSize('test6'));

/**
 * lget()
 */

$redis->delete('test');
$redis->lpush("test","111");
$redis->lpush("test","222");
$redis->rpush("test","333");
$redis->rpush("test","444");
var_dump($redis->lget("test",3));  //结果：string(3) "444"


/**
 * lset()
 */

$redis->lpush("test","111");
$redis->lpush("test","222");
var_dump($redis->lget("test",1));  //结果：string(3) "111"
var_dump($redis->lset("test",1,"333"));  //结果：bool(true)
var_dump($redis->lget("test",1));  //结果：string(3) "333"