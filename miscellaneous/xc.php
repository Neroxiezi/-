<?php
function runThread()
{
    $fp = fsockopen('localhost', 80, $errno, $errmsg);

    fputs($fp, "GET /test/CodeSnippet/xc.php?act=b\r\n\r\n");        //这里的第二个参数是HTTP协议中规定的请求头
    //不明白的请看RFC中的定义

    fclose($fp);
}

function a()
{
    $fp = fopen('result_a.log', 'w');
    fputs($fp, 'Set in ' . Date('h:i:s', time()) . (double)microtime() . "\r\n");

    fclose($fp);
}

function b()
{
    $fp = fopen('result_b.log', 'w');
    fputs($fp, 'Set in ' . Date('h:i:s', time()) . (double)microtime() . "\r\n");

    fclose($fp);
}

if (!isset($_GET['act'])) $_GET['act'] = 'a';

if ($_GET['act'] == 'a') {
    runThread();
    a();
} else if ($_GET['act'] == 'b') b();
