<?php
include './PFArrFormat.php';
class Base {
    use pf\arr\build\PFArrFormat;
}

$base = new Base();

var_dump($base->pf_encode([1,2,3]));

