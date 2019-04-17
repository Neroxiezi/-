<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/17
 * Time: 10:01
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
$mysqli = mysqli_connect('127.0.0.1', 'root', 'root');
mysqli_select_db($mysqli, 'test') or die("不能选择数据库");
if (!$mysqli) {
    die("连接失败");
}
while (true) {
    try {
        $value = $redis->lPop('name');
        if (!$value) {
            echo "等待";
        } else {
            $sql = "insert into test(`name`) values ('".$value."')";
            $result = mysqli_query($mysqli, $sql);
            if ($result && mysqli_affected_rows($mysqli) > 0) {
                echo '插入成功';
            } else {
                echo '插入失败:'.mysqli_error($mysqli);
            }
        }
    } catch (\Exception $exception) {
        echo $exception->getMessage();
    }
    sleep(1);
}