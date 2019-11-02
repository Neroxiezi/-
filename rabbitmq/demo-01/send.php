<?php

    $exchangeName = 'pfinal';
    $queueName = 'hello';
    $routeKey = 'hello';
    $message = 'PFinal 社区';
    $conf = [
        'host' => '172.17.0.1',
        'port' => '5672',
        'login' => 'admin',
        'password' => 'admin',
        'vhost' => '/',
    ];
    $connection = new AMQPConnection($conf);
    $connection->connect() or die("Cannot connect to the broker!\n");

    try {
        $channel = new AMQPChannel($connection);
        $exchange = new AMQPExchange($channel);
        $exchange->setName($exchangeName);
        $queue = new AMQPQueue($channel);
        $queue->setName($queueName);
        $exchange->publish($message, $routeKey);
        var_dump("[x] Sent 'Hello World!'");


    } catch (\Exception $e) {
        var_dump($e->getMessage());
        exit();
    }
    $connection->disconnect();