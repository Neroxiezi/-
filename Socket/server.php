<?php

class WS
{
    public $master;
    public $socket = [];
    public $handshake = false;

    public function __construct($address, $port)
    {
        //建立一个socket 套接字
        $this->master = socket_create(AF_INET,SOCK_STREAM, SOL_TCP) or die('大哥不行啊');
        socket_set_option($this->master,SOL_SOCKET, SO_REUSEADDR, 1) or die('大哥这个很蛋疼');
    }
}

new WS('127.0.0.1',2000);