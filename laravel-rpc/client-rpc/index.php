<?php
error_reporting(0);
require './vendor/autoload.php';
try{
    $client = new \Hprose\Socket\Client('tcp://127.0.0.1:1314', false);
    $res = $client->comment_content();
}catch(\Exception $e) {
    $res = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id="comment"><?php echo $res?></div>
</body>
</html>