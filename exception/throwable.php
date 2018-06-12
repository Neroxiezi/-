<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/12
 * Time: 上午10:30
 */

function test($num = 0)
{
    echo 1 / $num;
}

try {
    test();
} catch (Throwable $e) {
    echo $e->getMessage();
}