<?php

/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/7/10
 * Time: 15:57
 *
 *
 *                      _ooOoo_
 *                     o8888888o
 *                     88" . "88
 *                     (| ^_^ |)
 *                     O\  =  /O
 *                  ____/`---'\____
 *                .'  \\|     |//  `.
 *               /  \\|||  :  |||//  \
 *              /  _||||| -:- |||||-  \
 *              |   | \\\  -  /// |   |
 *              | \_|  ''\---/''  |   |
 *              \  .-\__  `-`  ___/-. /
 *            ___`. .'  /--.--\  `. . ___
 *          ."" '<  `.___\_<|>_/___.'  >'"".
 *        | | :  `- \`.;`\ _ /`;.`/ - ` : | |
 *        \  \ `-.   \_ __\ /__ _/   .-` /  /
 *  ========`-.____`-.___\_____/___.-`____.-'========
 *                       `=---='
 *  ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
 *           佛祖保佑       永无BUG     永不修改
 *
 */
class RpcClient
{
    protected $client = null;
    protected $url_info = [];   // 远程调用 URL 组成部分

    public function __construct($url)
    {
        // 解析 URL
        $this->url_info = parse_url($url);
    }

    public function __call($name, $arguments)
    {
        // 创建一个客户端
        $this->client = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$this->client) {
            exit('socket_create() 失败');
        }
        socket_connect($this->client, $this->url_info['host'], $this->url_info['port']);
        // 传递调用的类名
        $class = basename($this->url_info['path']);
        // 传递调用的参数
        $args = '';
        if (isset($arguments[0])) {
            $args = json_encode($arguments[0]);
        }
        // 向服务端发送我们自定义的协议数据
        $proto = "Rpc-Class: {$class};".PHP_EOL
            ."Rpc-Method: {$name};".PHP_EOL
            ."Rpc-Params: {$args};".PHP_EOL;
        socket_write($this->client, $proto);
        // 读取服务端传来的数据
        $buf = socket_read($this->client, 8024);
        socket_close($this->client);

        return $buf;
    }
}

$rpcClient = new RpcClient('http://127.0.0.1:8080/news');
echo $rpcClient->display(['title' => 'txl']);
echo $rpcClient->display(['title' => 'hello world']);
$rpcClient1 = new RpcClient('http://127.0.0.1:8080/article');
echo $rpcClient1->display();