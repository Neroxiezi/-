<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: 运营部
 * Date: 2018/11/29
 * Time: 15:07
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
/**
 * function main()
 * {
 * // 前置操作，例如对身份的验证之类
 * echo 'this is before middleware';
 *
 * // 业务逻辑操作
 * // ....
 * echo 'this body of application';
 *
 * // 后置操作，发射响应包之类
 * echo 'this is back middleware';
 * }
 *
 * // 执行
 * main();
 */
/**
 * $before_middleware = function () {
 * echo 'this is before middleware';
 * };
 * $back_middleware = function () {
 * echo 'this is back middleware';
 * };
 *
 * $body = function () {
 * echo 'this body of application';
 * };
 *
 * function main($fmw, $body, $bmw)
 * {
 * $fmw();
 * $body();
 * $bmw();
 * }
 *
 * main($before_middleware, $back_middleware,$body);
 */

/**
 * $before_middleware = function ($body) {
 * return function () use ($body) {
 * echo 'this is before middleware' . "\n";
 * return $body();
 * };
 * };
 * $back_middleware = function ($body) {
 * return function () use ($body) {
 * $bd = $body();
 * echo 'this is back middleware' . "\n";
 * return $bd;
 * };
 * };
 *
 *
 * $body = function () {
 * echo 'this body of application' . "\n";
 * };
 *
 * $body = $before_middleware($body);
 * $body = $back_middleware($body);
 *
 * $body();
 */
/**
 * $before_middleware = function ($body) {
 * return function () use ($body) {
 * echo 'this is before middleware' . "\n";
 * return $body();
 * };
 * };
 *
 * $back_middleware = function ($body) {
 * return function () use ($body) {
 * $bd = $body();
 * echo 'this is back middleware' . "\n";
 * return $bd;
 * };
 * };
 *
 * $body = function () {
 * echo 'this body of application' . "\n";
 * };
 * // 准备
 * $conf = array(
 * $before_middleware,
 * $back_middleware,
 * );
 *
 * function ready($body, $conf)
 * {
 * foreach ($conf as $midd) {
 * $body = $midd($body);
 * }
 * return $body;
 * }
 *
 * $res = ready($body, $conf);
 * $res();
 */

/**
 function middleware(array $handlers, array $arguments = [])  {
    //函数栈
    $stack = [];
    $result = null;
    if (count($handlers) > 0) {
        foreach ($handlers as $handler) {
            // 每次循环之前重置，只能保存最后一个处理程序的返回值
            $result = null;
            $generator = call_user_func_array($handler, $arguments);
            //var_dump($generator);
            if ($generator instanceof Generator) {
                //将协程函数入栈,为重入做准备
                $stack[] = $generator;
                //获取协程返回参数
                $yieldValue = $generator->current();
                //检查是否重入函数栈
                if ($yieldValue === false) {
                    break;
                }
            }elseif ($generator !== null) {
                $result = $generator;
            }
        }
        $return = ($result !== null);
        //将协程函数出栈
        while ($generator = array_pop($stack)) {
            if ($return) {
                $generator->send($result);
            } else {
                $generator->next();
            }
        }
    }
}

$abc = function () {
    echo "this is abc start <br/>";
    yield;
    echo "this is abc end <br/>";
};

$qwe = function () {
    echo "this is qwe start <br/>";
    $a = yield;
    echo $a . "<br/>";
    echo "this is qwe end <br/>";
};
$one = function () {
    return 1;
};

middleware([$abc, $qwe, $one]);
 */

$link = mysqli_connect('127.0.0.1', 'root', 'root', 'scrapy_ip', 3306);
echo '<pre>';
var_dump($link);
var_dump($link->thread_id);
$sql= "select * from  `proxy_ip`";
$link->query($sql, MYSQLI_ASYNC);
var_dump($link->reap_async_query());
