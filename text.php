<?php

$domains = [
    'dev.project.com',
    'dev.oa.com',
    'localhost'
];

$domain = array_rand($domains);
header('Location:http://'.$domains[$domain]);
