<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/8/29
	 * Time: 下午4:00
	 * ----------------------------------------
	 *
	 */

	require_once __DIR__.'/RedisQueue.php';

	$queueName = 'pf_test';
	$redisConfig = [
		'host' => '127.0.0.1',
		'port' => '6379',
		'index' => '0',
	];
	$data = [
		'sendMessage' => ['user1' => ['all']],
	];

	echo "Queue name: ".$queueName."\n";
	try {
		// create queue
		$redisQueue = new RedisQueue($queueName, $redisConfig);
		$index = $redisQueue->add($data);
		echo "Data index: ".$index."\n";  // index of added data
		sleep(1);
	} catch (Exception $e) {
		echo $e->getMessage();
	}