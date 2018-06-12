<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/12
 * Time: 上午10:34
 */

function checkNum($num)
{
    if ($num > 1) {
        # 新建异常信息
        throw new Exception("Value must be 1 or below");
    }
    return true;
}

try {
    checkNum(3); // 触发异常
    echo "如果你看到这条信息，证明num小于或等于1";
} catch (Exception $e) { // 捕获异常
    echo "Message:" . $e->getMessage(); // 显示异常信息
} finally { // 触发异常与否,都会执行
    echo "<br>finally...";
}