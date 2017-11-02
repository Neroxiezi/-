<?php
/**

对象工厂
@author flynetcn
 */
class ObjectFactory
{
    private static $objSet = array();

    /**
    清空工厂中的对象
     */
    public function clear()
    {
        self::$objSet = array();
    }
    /**
    在工厂中创建对象并将其返回
    参数格式：$class_name, $class_param1, $class_param2, ...
     */
    public static function create()
    {
        $argc = func_num_args();
        if ($argc <= 0) {
            throw new Exception('params error', 1);
        }
        $args = func_get_args();
        $class_name = array_shift($args);
        $params = $args;
        if (!$params) {
            $class_sign = $class_name;
        } else {
            $param_sign = serialize($params);
            if (strlen($param_sign) > 100) {
                $param_sign = md5($param_sign);
            }
            $class_sign = $class_name.'@'.$param_sign;
        }
        if (isset(self::$objSet[$class_sign])) {
            return self::$objSet[$class_sign];
        }
        $ref = new ReflectionClass($class_name);
        if ($ref->hasMethod('__construct') && !empty($params)) {
            $obj = $ref->newInstanceArgs($params);
        } else {
            $obj = $ref->newInstance();
        }
        self::$objSet[$class_sign] = $obj;
        return $obj;
    }
}