<?php
    $exchangeName = 'logs';
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
    $exchange->setType(AMQP_EX_TYPE_FANOUT);
    $exchange->declare();
    $queue = new AMQPQueue($channel);
    $queue->setFlags(AMQP_EXCLUSIVE);
    $queue->declare();
    $queue->bind($exchangeName, '');
    var_dump('[*] Waiting for messages. To exit press CTRL+C');
    while (true) {
        $queue->consume('callback');
    }
    $connection->disconnect();
    function callback($envelope, $queue)
    {
        $msg = $envelope->getBody();
        var_dump(" [x] Received:".$msg);
        $queue->nack($envelope->getDeliveryTag());
    }