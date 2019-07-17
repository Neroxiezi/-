<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/7/17
 * Time: 13:36
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
function xrange($start, $limit, $step = 1)
{
    for ($i = 0; $i < $limit; $i += $step) {
        yield $i + 1;
    }
}

//foreach (xrange(0, 9) as $k => $v) {
//    printf("%d--%d <br>", $k, $v);
//}

function printer()
{
    $i = 0;
    while (true) {
        # printf("receive: %s\n", yield);
        printer("receive: %s\n", (yield ++$i));
    }
}

//$printer = printer();
//printf("%d\n", $printer->current());
//$printer->send('hello');
//printf("%d\n", $printer->current());
//$printer->send('world');
//printf("%d\n", $printer->current());


function gen()
{
    $ret = (yield 'yield1');
    var_dump($ret);
    $ret = (yield 'yield2');
    var_dump($ret);
}
$gen = gen();
var_dump($gen->current());
$gen->send('ret1');
var_dump($gen->current());
$gen->send('ret2');
var_dump($gen->current());
