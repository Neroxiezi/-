<?php
//void 返回类型
/**
 * PHP7.0 添加了指定函数返回类型的特性，但是返回类型却不能指定为 void，7.1 的这个特性算是一个补充：
 * 定义返回类型为 void 的函数不能有返回值，即使返回 null 也不行：
 */
function should_return_nothing(): void {
    //return 1; // Fatal error: A void function must not return a value
}
//类函数中对于返回类型的声明也不能被子类覆盖，否则会触发错误：
class Foo
{
    public function bar(): void {
    }
}

class Foobar extends Foo
{
    public function bar(): array { // Fatal error: Declaration of Foobar::bar() must be compatible with Foo::bar(): void
    }
}