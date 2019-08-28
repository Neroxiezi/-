<?php
    /**
     * Created By pfinal.
     * User: pfinal
     * Date: 2019/8/28
     * Time: 上午10:12
     * ----------------------------------------
     *
     */

    ini_set('display_errors', 'on');
    if (!extension_loaded('pcntl')) {
        exit("没有安装pcntl扩展");
    }

    if (!extension_loaded('posix')) {
        exit("请安装posix扩展\n");
    }

    // 标记是全局启动
    define('GLOBAL_START', 1);
    require_once __DIR__.'/vendor/autoload.php';

    // 加载所有的 Applications 以便于启动所有的服务
    foreach (glob(__DIR__.'/Applications/start*.php') as $start_file) {
        require_once $start_file;
    }

    \Workerman\Worker::runAll();