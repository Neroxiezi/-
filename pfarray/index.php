<?php
require './vendor/autoload.php';
use pf\arr\PFarr;

$arr = [1,54,'a',45,12,'c',1,1,12,[1,1,'a',['a','b','a']]];
$arr = PFarr::pf_encode($arr);
echo '<pre>';
print_r($arr);