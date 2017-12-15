<?php

//可空类型主要用于参数类型声明很函数返回值声明。

function  answer() : ?int {
    return null;
}
function answer1(): ?int  {
    return 42; // ok
}

function say(?string $msg) {
    if ($msg) {
        return  $msg;
    }
}
var_dump(answer());
var_dump(answer1());
var_dump(say(123));

/**
 * 从例子很容易理解，所指的就是通过 ? 的形式表明函数参数或者返回值的类型要么为指定类型，要么为 null。
 */