<?php
/**
 * PHP密码强度检测
 */
$score = 0;
$str = '1';            //密码
if (preg_match("/[0-9]+/", $str)) {
    $score++;
}
if (preg_match("/[0-9]{3,}/", $str)) {
    $score++;
}
if (preg_match("/[a-z]+/", $str)) {
    $score++;
}
if (preg_match("/[a-z]{3,}/", $str)) {
    $score++;
}
if (preg_match("/[A-Z]+/", $str)) {
    $score++;
}
if (preg_match("/[A-Z]{3,}/", $str)) {
    $score++;
}
if (preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/", $str)) {
    $score += 2;
}
if (preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/", $str)) {
    $score++;
}
if (strlen($str) >= 10) {
    $score++;
}
echo $score;