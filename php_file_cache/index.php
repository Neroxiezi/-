<?php

if (is_file('a.cache.php') && filemtime('a.cache.php') > (time() - 5)) {
    var_dump(filemtime('a.cache.php'));
    include 'a.cache.php';
    echo 'is cache...';
} else {
    ob_start();
    include 'a.php';
    $content = ob_get_clean();
    echo $content;
    file_put_contents('a.cache.php', $content);
}

