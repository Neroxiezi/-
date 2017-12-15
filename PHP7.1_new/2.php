<?php
interface Fooable {
    function foo(?Fooable $f);
}

function foo_nullable(?Bar $bar) {}

class Bar{}
foo_nullable(new Bar); // 可行
foo_nullable(null); // 可行
foo_nullable(); // 不可行