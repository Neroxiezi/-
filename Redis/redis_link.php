<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/9/2
	 * Time: 上午11:06
	 * ----------------------------------------
	 *
	 */

	$redis = new Redis();
	$link = $redis->connect('127.0.0.1', 6379);