<?php
	/**
	 * ----------------------------------------
	 * | Created By rabbitmq                 |
	 * | User: pfinal <lampxiezi@163.com>     |
	 * | Date: 2019/11/18                      |
	 * | Time: 上午11:19                        |
	 * ----------------------------------------
	 * |    _____  ______ _             _     |
	 * |   |  __ \|  ____(_)           | |    |
	 * |   | |__) | |__   _ _ __   __ _| |    |
	 * |   |  ___/|  __| | | '_ \ / _` | |    |
	 * |   | |    | |    | | | | | (_| | |    |
	 * |   |_|    |_|    |_|_| |_|\__,_|_|    |
	 * ----------------------------------------
	 */
	
	use PhpAmqpLib\Connection\AMQPStreamConnection;
	use PhpAmqpLib\Message\AMQPMessage;
	
	require_once __DIR__.'/../vendor/autoload.php';
	
	# var_dump($connection);
	// 创建连接
	$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
// 创建channel，多个channel可以共用连接
	$channel = $connection->channel();
	// 创建直连的交换机
	$channel->exchange_declare('amq.direct', 'direct', false, true, false);#第四个参数true 持久化
// 创建队列
	$channel->queue_declare('hello', false, true, false, false);#第三个参数true 持久化
// 交换机跟队列的绑定，
	$channel->queue_bind('hello', 'direct_logs', 'routigKey');
	
	$callback = function ($msg) {
		echo $msg->body."\n";
		$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
	};

// 启动队列消费者
	$channel->basic_consume('hello', '', false, false, false, false, $callback);
// 判断是否存在回调函数
	while (count($channel->callbacks)) {
		// 此处为执行回调函数
		$channel->wait();
	}