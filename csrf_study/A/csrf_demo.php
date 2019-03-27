<?php
/**
 * Created by PhpStorm.
 * User: 运营部
 * Date: 2019/3/27
 * Time: 10:26
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
empty($_COOKIE['uid']) || empty($_POST['name']) ? die('非法用户') : '';
$data = json_decode(file_get_contents('data.json'), true);
//更新数据
$data['username'] = $_POST['name'];
$data['money'] -= 500;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
</head>
<body bgcolor="#000">
<div style=" margin-top:70px;color:#FFF; font-size:23px; text-align:center">Welcome&nbsp;&nbsp;&nbsp;<font
            color="#FF0000">修改用户名密码</font>
    <br>
    <font color="#FFF000">
        <?php
        if (file_put_contents('data.json', json_encode($data))) {
            echo '用户名改为'.$data['username'].'<br>花费了'.$data['money'].'元<br>';
        }
        ?>
    </font>
</body>
</html>
