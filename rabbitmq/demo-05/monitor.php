<?php
	
	
	require_once __DIR__.'/../vendor/autoload.php';
	$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
// 创建channel，多个channel可以共用连接
	$channel = $connection->channel();
	$channel->exchange_declare('amq.fanout', 'fanout', false, true, false);#第四个参数true 持久化
	// 创建队列
	$channel->queue_declare('goods_cancel', false, true, false, true);#第三个参数true 持久化
// 交换机跟队列的绑定，
	$channel->queue_bind('goods_cancel', 'amq.fanout', 'rabbitmq_routingkey');
	$callback = function ($msg) {
		echo $msg->body."\n";
		$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
	};

// 启动队列消费者
	$channel->basic_consume('goods_cancel', '', false, false, false, false, $callback);
// 判断是否存在回调函数
	while (count($channel->callbacks)) {
		// 此处为执行回调函数
		$channel->wait();
	}


	
	