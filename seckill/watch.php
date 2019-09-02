<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/8/22
	 * Time: 上午10:29
	 * ----------------------------------------
	 *
	 */

	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	//var_dump($redis->set('name', 'pfinal'), $redis->get('name'));
	// 制定监视的key
	$redis->watch('count'); // 为这个key设置版本标识
	$count = $redis->get('count');
	$total = 10; // 总库存
	// 乐观锁处理
	if ($count >= $total) {
		exit('活动结束');
	}

	// 引入redis 事物
	$redis->multi();
	// 业务逻辑
	$redis->incr('count'); // 库存加1
	sleep(1);
	// 记录抢购成功id
	// 默认的redis事物,不会取管命令到底是成功还是失败
	$res = $redis->exec();

	if ($res) {
		include 'db.php';
		$sql = 'update products set store=store-1 where id=1';
		if ($mod->exec($sql)) {
			echo '更新库存成功';
		} else {
			echo '更新失败';
		}
	}



