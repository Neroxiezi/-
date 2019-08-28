<?php
    /**
     * Created By ${ROJECT_NAME}.
     * User: pfinal
     * Date: 2019/8/28
     * Time: 上午10:52
     * ----------------------------------------
     *
     */

    use GatewayWorker\BusinessWorker;

    require_once __DIR__.'/../vendor/autoload.php';
    // bussinessWorker 进程
    $worker = new BusinessWorker();
    $worker->count = 4;
    $worker->registerAddress = '127.0.0.1:1236';
    // 如果不是在根目录启动，则运行runAll方法
    if (!defined('GLOBAL_START')) {
        Worker::runAll();
    }
