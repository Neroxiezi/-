<?php

/**
 * php 消息队列
 */

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
for ($i = 0; $i < 50; $i++) {
    try {
        $redis->LPUSH('click', rand(1000, 5000));
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}