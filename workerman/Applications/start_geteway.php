<?php
    /**
     * Created By ${ROJECT_NAME}.
     * User: pfinal
     * Date: 2019/8/28
     * Time: 上午10:44
     * ----------------------------------------
     *
     */

    use GatewayWorker\Gateway;

    require_once __DIR__.'/../vendor/autoload.php';
    $gateway = new Gateway("Websocket://0.0.0.0:7272");
    // 设置名称，方便status时查看
    $gateway->name = 'ChatGateway';
    // 设置进程数，gateway进程数建议与cpu核数相同
    $gateway->count = 4;
    // 分布式部署时请设置成内网ip（非127.0.0.1）
    $gateway->lanIp = '127.0.0.1';
    // 内部通讯起始端口。假如$gateway->count=4，起始端口为2300
    // 则一般会使用2300 2301 2302 2303 4个端口作为内部通讯端口
    $gateway->startPort = 2300;
    // 心跳间隔
    $gateway->pingInterval = 10;
    // 心跳数据
    $gateway->pingData = '{"type":"ping"}';
    // 服务注册地址
    $gateway->registerAddress = '127.0.0.1:1236';
    // 如果不是在根目录启动，则运行runAll方法
    if (!defined('GLOBAL_START')) {
        \Workerman\Worker::runAll();
    }

