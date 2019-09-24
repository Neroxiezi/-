<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/9/6
	 * Time: 下午3:02
	 * ----------------------------------------
	 *
	 */

	include __DIR__.'/base.php';

	try {
		$xs = new XS($config);
		$data = array(
			'id' => 234, // 此字段为主键，必须指定
			'name' => '测试文档的标题',
			'sort' => 1,
			'add_time' => time(),
		);
		$doc = new XSDocument;
		$doc->setFields($data);
		$index = $xs->index;
		var_dump($index);
		$index->add($doc);
	} catch (XSException $e) {
		echo $e;               // 直接输出异常描述
		if (defined('DEBUG'))  // 如果是 DEBUG 模式，则输出堆栈情况
		{
			echo "\n".$e->getTraceAsString()."\n";
		}
	}