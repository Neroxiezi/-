<?php
// 5.4 之前
//$array = array(1, 2, 3);
//$array = array("a" => 1, "b" => 2, "c" => 3);

// 5.4 及之后
$array = [1, 2, 3];
//$array = ["a" => 1, "b" => 2, "c" => 3];

list($a, $b, $c) = $array;

[$a1, $b1, $c1] = $array;

foreach ($array as ["x" => $x, "y" => $y]) {
    var_dump($x, $y);
}