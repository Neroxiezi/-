<?php
$points = [
    ["x" => 1, "y" => 2],
    ["x" => 2, "y" => 1]
];

list(list("x" => $x1, "y" => $y1), list("x" => $x2, "y" => $y2)) = $points;

$points = [
    "first" => [1, 2],
    "second" => [2, 1]
];

list("first"=>list($x1, $y1), "second"=> list($x2, $y2)) = $points;

foreach ($points as list("x" => $x, "y" => $y)) {
    echo "Point at ($x, $y)", PHP_EOL;
}