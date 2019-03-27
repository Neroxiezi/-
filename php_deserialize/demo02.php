<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/3/27
 * Time: 11:40
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

class  A
{
    public $target = 'test';

    public function __wakeup()
    {
        $this->target = "wakeup!";
    }

    public function __destruct()
    {
        $f = fopen(__DIR__."./hello.php", "w");
        fputs($f, $this->target);
        fclose($f);
    }
}

$a = $_GET['test'];
$a_user = unserialize($a);
echo "hello.php<br/>";
include __DIR__.'/hello.php';