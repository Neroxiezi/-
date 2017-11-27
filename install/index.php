<?php
//检测锁文件 如果没有锁文件 则跳转到 安装页面
$file_lock = __DIR__.'/install.lock';
if (!file_exists($file_lock)) {
    header("location:./install.php");
}
echo 'You are already install';
exit;

