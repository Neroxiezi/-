<?php
    /**
     * Created By ${ROJECT_NAME}.
     * User: pfinal
     * Date: 2019/8/28
     * Time: 上午10:39
     * ----------------------------------------
     *
     */

    use Workerman\WebServer;

    require_once __DIR__.'/../vendor/autoload.php';
    // WebServer
    $web = new WebServer("http://0.0.0.0:55151");
    $web->count = 2;
    $web->addRoot('www.php_im.com', __DIR__.'/Web');
    // 如果不是在根目录启动，则运行runAll方法
    if (!defined('GLOBAL_START')) {
        \Workerman\Worker::runAll();
    }