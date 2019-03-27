<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
</head>
<body bgcolor="#000">
<div style=" margin-top:70px;color:#FFF; font-size:23px; text-align:center">Welcome&nbsp;&nbsp;&nbsp;<font
            color="#FF0000">csrf</font>
    <br>
    <?php
    /**
     * Created by PhpStorm.
     * User: 南丞
     * Date: 2019/3/27
     * Time: 10:07
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
    // 模拟请求数据库
    $data = json_decode(file_get_contents('data.json'), true);
    //做登录验证
    if ($_POST['name'] != $data['username']) {
        exit('用户名错误');
    }
    if ($_POST['password'] != $data['password']) {
        exit('密码错误');
    }

    //验证活了以后存储登录状态
    setcookie('uid', $data['id'], 0);
    ?>
    <font color="#FF0000"><?php echo $data['username'] ?> 登录成功 </font>
    <a href="./set_username.php">更新用户名</a>
</body>
</html>
