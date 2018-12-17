<?php
/**
 * Created by PhpStorm.
 * User: 运营部
 * Date: 2018/12/17
 * Time: 12:30
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
echo '<pre>';
$ret = $redis->lPush('city', 'guangzhou');

//从list尾部插入一个值。
$ret = $redis->rPush('city', 'guangzhou');
//获取列表指定区间中的元素。0表示列表第一个元素，-1表示最后一个元素，-2表示倒数第二个元素。
$ret = $redis->lrange('city', 0, -1);//查看队列所有元素
//将一个插入已存在的列表头部，列表不存在时操作无效。
$ret = $redis->lPushx('city', 'hangzhou');

//将一个或多个值插入已存在的列表尾部，列表不存在时操作无效。
$ret = $redis->rPushx('city', 'hangzhou');

//移除并返回列表的第一个元素，若key不存在或不是列表则返回false。
$ret = $redis->lPop('city');


//移除并返回列表的最后一个元素，若key不存在或不是列表则返回false。
$ret = $redis->rPop('city');


//移除并获取列表的第一个元素。如果列表没有元素则会阻塞列表直到等待超时或发现可弹出元素为止。
//参数：key，超时时间（单位：秒）
//返回值：[0=>key,1=>value]，超时返回[]
$ret = $redis->blPop('city', 10);
//移除列表中最后一个元素，将其插入另一个列表头部，并返回这个元素。若源列表没有元素则返回false。
$ret = $redis->rpoplpush('city', 'city2');


//移除列表中最后一个元素，将其插入另一个列表头部，并返回这个元素。如果列表没有元素则会阻塞列表直到等待超时或发现可弹出元素为止。
//参数：源列表，目标列表，超时时间（单位：秒）
//超时返回false
$ret = $redis->brpoplpush('city', 'city2', 10);
//返回列表长度。
$ret = $redis->lLen('city');


//通过索引获取列表中的元素。若索引超出列表范围则返回false。
$ret = $redis->lindex('city', 0);
var_dump($ret);
//通过索引设置列表中元素的值。若是索引超出范围，或对一个空列表进行lset操作，则返回false。
$ret = $redis->lSet('city', 2, 'changsha');
var_dump($ret);
//在列表中指定元素前或后面插入元素。若指定元素不在列表中，或列表不存在时，不执行任何操作。
//参数：列表key，Redis::AFTER或Redis::BEFORE，基准元素，插入元素
//返回值：插入成功返回插入后列表元素个数，若基准元素不存在返回-1，若key不存在返回0，若key不是列表返回false。
$ret = $redis->lInsert('city', Redis::AFTER, 'changsha', 'nanjing');
var_dump($ret);
//根据第三个参数count的值，移除列表中与参数value相等的元素。
//count > 0 : 从表头开始向表尾搜索，移除与value相等的元素，数量为count。
//count < 0 : 从表尾开始向表头搜索，移除与value相等的元素，数量为count的绝对值。
//count = 0 : 移除表中所有与value相等的值。
//返回实际删除元素个数
$ret = $redis->lrem('city', 'guangzhou', -2);
//对一个列表进行修剪，只保留指定区间的元素，其他元素都删除。成功返回true。
$ret = $redis->ltrim('city', 1, 4);

var_dump($ret);