<?php
header("Content-type: text/html; charset=utf-8");
require_once './vendor/autoload.php';

/**
 * 接口  数据库
 */
interface DataBase
{
    public function Connect(); //链接数据库

    public function Select();  // 查询操作
}

/**
 * 实现两种数据库操作类
 */
class Mysql implements DataBase
{
    public function Connect()
    {
        echo '链接mysql<br>';
    }

    public function Select()
    {
        echo '查询Mysql <br/>';
    }
}

class Oracle implements DataBase
{
    public function Connect()
    {
        echo '链接Oracle <br/>';
    }

    public function Select()
    {
        echo '查询Oracle <br/>';
    }
}

/**
 * 实现适配器  使用组件切换的模式  达到适配效果
 */
class Adapter implements DataBase
{
    private $Database;  //数据库操作的实例  也就是组件操作的实例

    public function __construct($DataBase)
    {
        $this->Database = $DataBase;
    }

    // 根据适配器调用对应的方法
    public function Connect()
    {
        $this->Database->Connect();
    }

    public function Select()
    {
        $this->Database->Select();
    }
}

# 实例化适配器，并传入Mysql组件
$obj = new Adapter(new Mysql());
$obj->Connect();
$obj->Select();

# 实例化适配器，并传入Oracle组件
$obj = new Adapter(new Oracle());
$obj->Connect();
$obj->Select();

