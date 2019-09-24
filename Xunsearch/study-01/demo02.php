<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/9/6
	 * Time: 下午3:28
	 * ----------------------------------------
	 *
	 */

	include __DIR__.'/base.php';

	try {
		$xs = new XS($config);
		$result = $xs->search->search('项目');
		var_dump($result);
	} catch (XSException $e) {
		echo $e;               // 直接输出异常描述
		if (defined('DEBUG'))  // 如果是 DEBUG 模式，则输出堆栈情况
		{
			echo "\n".$e->getTraceAsString()."\n";
		}
	}