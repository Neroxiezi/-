<?php
	/**
	 * ----------------------------------------
	 * | Created By rabbitmq                 |
	 * | User: pfinal <lampxiezi@163.com>     |
	 * | Date: 2019/11/18                      |
	 * | Time: 上午11:12                        |
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
	$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection('localhost', 5672, 'pfinal', 'pfinal');
// 创建channel，多个channel可以共用连接
	$channel = $connection->channel();

// 创建交换机以及队列（如果已经存在，不需要重新再次创建并且绑定）

// 创建直连的交换机
	$channel->exchange_declare('direct_logs', 'direct', false, true, false);#第四个参数true 持久化
// 创建队列
	$channel->queue_declare('hello', false, true, false, false);#第三个参数true 持久化
// 交换机跟队列的绑定，
	$channel->queue_bind('hello', 'direct_logs', 'routigKey');
	
	$data = ['name' => 'pfinal社区'];

// 设置消息bady传送字符串logs(消息只能为字符串，建议消息均json格式)
	$msg = new AMQPMessage(
		json_encode($data, true), array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
	);#第二参数 持久化
// 发送数据到对应的交换机direct_logs并设置对应的routigKey
	$channel->basic_publish($msg, 'direct_logs', 'routigKey');