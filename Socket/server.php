<?php
class WS
{
    public $master;
    public $sockets = [];
    public $handshake = false;

    public function __construct($address, $port)
    {
        //建立一个socket 套接字
        $this->master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die('大哥不行啊');
        socket_set_option($this->master, SOL_SOCKET, SO_REUSEADDR, 1) or die('大哥这个很蛋疼');
        socket_bind($this->master, $address, $port) or die('这个真的不太好');
        socket_listen($this->master, 2) or die('大爷的故事');
        $this->sockets[] = $this->master;

        // debug
        echo("Master socket  : " . $this->master . "\n");
        while (true) {
            $write = NULL;
            $except = NULL;
            socket_select($this->sockets, $write, $except, NULL);
            foreach ($this->sockets as $socket) {
                //链接注入的client
                if($socket == $this->master) {
                    $client = socket_accept($this->master);
                    if($client < 0 ) {
                        echo 'socket_accept()';
                        continue;
                    } else {
                        array_push($this->sockets,$client);
                        echo '链接客户端';
                    }
                } else {
                    $bytes = @socket_recv($socket,$buffer,2048,0);
                    print_r($bytes);
                    if($bytes == 0) return;
                    if(!$this->handshake) {
                        $this->doHandShake($socket, $buffer);
                        echo 'zd';
                    } else {
                        $buffer = $this->decode($buffer);
                        echo "send\n";
                    }
                }
            }
        }

    }

    public function doHandShake($socket, $req)
    {
        $acceptKey = $this->encry($req);
        $upgrade = "HTTP/1.1 101 Switching Protocols\r\n" ."Upgrade: websocket\r\n" ."Connection: Upgrade\r\n" ."Sec-WebSocket-Accept: " . $acceptKey . "\r\n" ."\r\n";
        echo "afa ".$upgrade.chr(0);
        socket_write($socket,$upgrade.chr(0), strlen($upgrade.chr(0)));
        $this->handshake = true;
    }

    public function encry($req)
    {
        $key = $this->getKey($req);
        $mask = "258EAFA5-E914-47DA-95CA-C5AB0DC85B11";
        return base64_encode(sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
    }

    public function getKey($req)
    {
        $key = null;
        if (preg_match("/Sec-WebSocket-Key: (.*)\r\n/", $req, $match)) {
            $key = $match[1];
        }
        return $key;
    }

    public function decode($buffer)
    {
        $len = $masks = $data = $decoded = null;
        $len = ord($buffer[1]) & 127;
        if ($len === 126)  {
            $masks = substr($buffer, 4, 4);
            $data = substr($buffer, 8);
        } else if($len === 127) {
            $masks = substr($buffer, 10, 4);
            $data = substr($buffer, 14);
        } else {
            $masks = substr($buffer, 2, 4);
            $data = substr($buffer, 6);
        }
        for ($index = 0; $index < strlen($data); $index++) {
            $decoded .= $data[$index] ^ $masks[$index % 4];
        }
        return $decoded;
    }

    public function frame($s)
    {
        $a = str_split($s, 125);
        if (count($a) == 1) {
            return "\x81" . chr(strlen($a[0])) . $a[0];
        }
        $ns = "";
        foreach ($a as $o) {
            $ns .= "\x81" . chr(strlen($o)) . $o;
        }
        return $ns;
    }

    public function send($client, $msg)
    {
        $msg = $this->frame($msg);
        socket_write($client, $msg, strlen($msg));
    }
}

new WS('127.0.0.1', 2000);