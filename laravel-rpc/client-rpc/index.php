<?php
require './vendor/autoload.php';

$client = new \Hprose\Socket\Client('tcp://127.0.0.1:1314', false);
echo '<pre>';
//var_dump($client);
$res = $client->comment_content();
var_dump($res);
?>