<?php
/**
 * 导出csv文件
 * @param mixed $data 二维数组
 * @param string $title 标题字段 eg: 姓名,性别,年龄
 * @param string $filename 文件名 eg: xxx.csv
 */
function ExToCsv($data,$title,$filename){
	$mess = '';
	$mess .= $title;
	foreach ($data as $v) {
		$mess .= "\r";
		foreach ($v as $vv) {
			$mess .= $vv.",";
		}
	}
	header("Content-type: application/octet-stream");
	header("Accept-Ranges:bytes");
	$encoded_filename = urlencode($filename);
	$encoded_filename = str_replace("+", "%20", $encoded_filename);

	$ua = $_SERVER["HTTP_USER_AGENT"];
	if (preg_match("/MSIE/", $ua)) {
		header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
	} else if (preg_match("/Firefox/", $ua)) {
		header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
	} else {
		header('Content-Disposition: attachment; filename="' . $filename . '"');
	}
	echo mb_convert_encoding($mess, "GBK", "UTF-8");
}
