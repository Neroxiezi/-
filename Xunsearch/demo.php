<?php

	require_once __DIR__.'/vendor/autoload.php';

	#define('XS_APP_ROOT', __DIR__.'/conf/');

	$xs = new XS('demo');
	$docs = $xs->search->search('测试');
	print_r($docs);