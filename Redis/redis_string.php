<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/9/2
	 * Time: 上午11:06
	 * ----------------------------------------
	 *
	 */

	require_once __DIR__.'/redis_link.php';

	// 存储user 表  批量存储
//	$res = $redis->mset(['user:1:name' => 'pfinal', 'user:1:balance' => 18888]);
//	var_dump($res);

	// 批量获取
//	$result = $redis->mget(['user:1:name', 'user:1:balance']);
//	var_dump($result);

// Redis hash 设置购物车


