<?php
	/**
	 * ----------------------------------------
	 * | Created By taobao_tools                 |
	 * | User: pfinal <lampxiezi@163.com>     |
	 * | Date: 2019/10/9                      |
	 * | Time: 下午12:45                        |
	 * ----------------------------------------
	 * |    _____  ______ _             _     |
	 * |   |  __ \|  ____(_)           | |    |
	 * |   | |__) | |__   _ _ __   __ _| |    |
	 * |   |  ___/|  __| | | '_ \ / _` | |    |
	 * |   | |    | |    | | | | | (_| | |    |
	 * |   |_|    |_|    |_|_| |_|\__,_|_|    |
	 * ----------------------------------------
	 */
	require_once  __DIR__.'/vendor/autoload.php';
	switch ($_POST['step']) {
		case 'upload_csv':
			$response = init_data($_FILES);
			
			return $response;
			break;
	}
	
	return $response;
	
	
	function init_data($file)
	{
		if (!file_exists(__DIR__.'/tmp')) {
			mkdir(__DIR__.'/tmp', 0777, true);
		}
		move_uploaded_file($file["file"]["tmp_name"], __DIR__."/tmp/".$file["file"]["name"]);
		if (file_exists(__DIR__.'/tmp/'.$file["file"]["name"])) {
			$data = read_csv(__DIR__.'/tmp/'.$file["file"]["name"]);
			processing_data($data);
			
		}
	}
	
	function read_csv($file)
	{
		$handle = fopen_utf8($file);
		$i = 0;//记录cvs的行
		while (($file_data = fgetcsv($handle)) !== false) {
			$i++;
			if($i==1 || $i==2  || $i==3) {
				continue;
			}
			// 下面这行代码可以解决中文字符乱码问题
			$res = array();
			if ($file_data[1] != '') {
				foreach ($file_data as $val) {
					$res[] = $val;
				}
				$data[$i] = $res;
			}
		}
		
		return $data;
	}
	
	function fopen_utf8($filename)
	{
		$encoding = '';
		$handle = fopen($filename, 'r');
		$bom = fread($handle, 2);
		rewind($handle);
		if ($bom === chr(0xff).chr(0xfe) || $bom === chr(0xfe).chr(0xff)) {
			$encoding = 'UTF-16';
		} else {
			$file_sample = fread($handle, 1000) + 'e';
			rewind($handle);
			$encoding = mb_detect_encoding(
				$file_sample,
				'UTF-8, UTF-7, ASCII, EUC-JP,SJIS, eucJP-win, SJIS-win, JIS, ISO-2022-JP'
			);
		}
		if ($encoding) {
			stream_filter_append($handle, 'convert.iconv.'.$encoding.'/UTF-8');
		}
		
		return ($handle);
	}
	
	function processing_data($data)
	{
		var_dump($data);
	}