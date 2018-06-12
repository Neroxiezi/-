<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/12
 * Time: 上午10:23
 */
register_shutdown_function('zyfshutdownfunc');
function zyfshutdownfunc()
{
    if ($error = error_get_last()) {
        var_dump('<b>register_shutdown_function: Type:' . $error['type'] . ' Msg: ' . $error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line'] . '</b>');
    }
}
