<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/12
 * Time: 上午10:05
 */

//create function with an exception
function checkNum($number)
{
    if ($number > 1) {
        throw new Exception("Value must be 1 or below");
    }
    return true;
}

//trigger exception
//checkNum(2);

try
{
    checkNum(2);
    //If the exception is thrown, this text will not be shown
    echo 'If you see this, the number is 1 or below';
}

//捕获异常
catch(Exception $e)
{
    echo "信息错误了\n";
}