<?php
//场景：依赖注入, 依赖外观类去调用第三方类的方法，缺点是多次调用会重复占用内存，可配合享元模式实现依赖注入。
header("Content-type: text/html; charset=utf-8");
require_once './vendor/autoload.php';

/**
 * 动物接口
 */
interface AnimalInterFace
{
    public function Produce(); //生产方法
}

/**
 * 创建 - 鸡模型
 */
class ChiCken implements AnimalInterface
{
    public function Produce()
    {
        echo '这是一只鸡<br>';
    }
}

/**
 * 创建 - 猪模型
 */
class Pig implements AnimalInterFace
{
    public function Produce()
    {
        echo '这是一只猪<br>';
    }
}

/**
 * 外观类
 */
class AnimalMaker
{
    private $_chicken;
    private $_pig;
    public function __construct()
    {
        $this->_chicken = new ChiCken();
        $this->_pig = new Pig();
    }

    /**
     * 生产鸡
     */
    public function produceChicken()
    {
        $this->_chicken->Produce();
    }

    /**
     * 生产猪
     */
    public function producePig()
    {
        $this->_pig->Produce();
    }
}

// 初始化外观类
$animalMaker = new AnimalMaker();
// 生产猪
$animalMaker->producePig();
//生产鸡
$animalMaker->produceChicken();