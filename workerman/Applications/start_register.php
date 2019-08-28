<?php
    /**
     * Created By ${ROJECT_NAME}.
     * User: pfinal
     * Date: 2019/8/28
     * Time: 上午11:22
     * ----------------------------------------
     *
     */

    use GatewayWorker\Register;

    require_once __DIR__.'/../vendor/autoload.php';
    $register = new  Register('text://0.0.0.0:1236');
    // 如果不是在根目录启动，则运行runAll方法
    if(!defined('GLOBAL_START'))
    {
        \Workerman\Worker::runAll();
    }