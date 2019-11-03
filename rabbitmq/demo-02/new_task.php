<?php
    $exchangeName = 'pfinal_demo';
    $queueName = 'task_queue';
    $routeKey = 'task_queue';
    $message = 'PFinal社区';
    $conf = [
        'host' => '172.17.0.1',
        'port' => '5672',
        'login' => 'admin',
        'password' => 'admin',
        'vhost' => '/',
    ];

    $connection = new AMQPConnection($conf);
    $connection->connect() or die("Cannot connect to the broker!\n");

    $channel = new AMQPChannel($connection);
    $exchange = new AMQPExchange($channel);

    $exchange->setName($exchangeName);
    $queue = new AMQPQueue($channel);

    $queue->setName($queueName);
    $queue->setFlags(AMQP_DURABLE);
    $queue->declare();

    $exchange->publish($message, $routeKey);
    var_dump("[x] Sent $message");
    $connection->disconnect();