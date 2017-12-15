<?php
//类常量属性设定

class Token {
    // 常量默认为 public
    const PUBLIC_CONST = 0;

    // 可以自定义常量的可见范围
    private const PRIVATE_CONST = 0;
    protected const PROTECTED_CONST = 0;
    public const PUBLIC_CONST_TWO = 0;

    // 多个常量同时声明只能有一个属性
    private const FOO = 1, BAR = 2;
}
//接口（interface）中的常量只能是 public 属性：
interface ICache {
    public const PUBLIC = 0;
    const IMPLICIT_PUBLIC = 1;
}

//为了应对变化，反射类的实现也相应的丰富了一下，增加了 getReflectionConstant 和getReflectionConstants 两个方法用于获取常量的额外属性：

class testClass  {
    const TEST_CONST = 'test';
}

$obj = new ReflectionClass( "testClass" );
$const = $obj->getReflectionConstant( "TEST_CONST" );
$consts = $obj->getReflectionConstants();