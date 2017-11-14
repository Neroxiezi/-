<?php
namespace Test;
use PHPUnit\Framework\TestCase;

class StackTest extends TestCase
{
    public function testEmpty() {
        $stack = [];
        $this->assertEmpty($stack);
        return $stack;
    }

    public function testPush($stack) {
    array_push($stack,'foo');
    $this->assertEquals("foo",$stack[count($stack)-1]);
    $this->assertNotEmpty($stack);
    return $stack;
}
}