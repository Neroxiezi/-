<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/8/29
	 * Time: 下午4:15
	 * ----------------------------------------
	 *
	 */

	require_once __DIR__.'/RedisQueue.php';
	// queue config
	$queueName = 'pf_test';
	$redisConfig = [
		'host' => '127.0.0.1',
		'port' => '6379',
		'index' => '0',
	];

	echo "Queue name: ".$queueName."\n";
	try {
		// create queue
		$redisQueue = new RedisQueue($queueName, $redisConfig);

		// fetch from queue
		$data = $redisQueue->get();
		var_dump($data);
		echo "Fetched data:\n";
		echo "Current Index:";
		$currentIndex = $redisQueue->getCurrentIndex($data);
		var_dump($currentIndex);

		$success = true;

		if ($success) {  // success
			$ret = $redisQueue->remove($data);
			if (!empty($ret)) {
				echo "\nData removed !";
			}
			$ret = $redisQueue->status();
		} else { // failed
			echo "\nRollback current data";
			$redisQueue->rollback($data);  // if retry times up to max, the index will be transfer to blocked list
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}