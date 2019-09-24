<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/9/6
	 * Time: 下午2:54
	 * ----------------------------------------
	 *
	 */
	include __DIR__.'/base.php';
	try {
		$xs = new XS($config);
		$docs = $xs->search->setQuery('hightman')->setLimit(5)->search();
		foreach ($docs as $doc) {
			echo $doc->rank().". ".$doc->subject." [".$doc->percent()."%]\n";
			echo $doc->message."\n";
		}
	} catch (XSException $e) {
		echo $e;               // 直接输出异常描述
		if (defined('DEBUG'))  // 如果是 DEBUG 模式，则输出堆栈情况
		{
			echo "\n".$e->getTraceAsString()."\n";
		}
	}