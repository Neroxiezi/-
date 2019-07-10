<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/7/10
 * Time: 14:15
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

class RpcServer
{
    protected $server = null;

    public function __construct($host, $port, $path)
    {
        // 创建一个 Socket 服务
        if (($this->server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
            exit("socket_create() 失败的原因是:".socket_strerror($this->server)."\n");
        }
        if (($ret = socket_bind($this->server, $host, $port)) < 0) {
            exit("socket_bind() 失败的原因是:".socket_strerror($ret)."\n");
        }
        if (($ret = socket_listen($this->server, 3)) < 0) {
            exit("socket_listen() 失败的原因是:".socket_strerror($ret)."\n");
        }

        // 判断RPC 服务目录是否存在
        $realPath = realpath(__DIR__.$path);
        if ($realPath === false || !file_exists($realPath)) {
            exit("{$path} error \n");
        }

        do {
            $client = socket_accept($this->server);
            if ($client) {
                //一次性读取
                $buf = socket_read($client, 8024);
                echo $buf;
                //解析客户端发送过来的协议
                $classRet = preg_match('/Rpc-Class:\s(.*);\r\n/i', $buf, $class);
                $methodRet = preg_match('/Rpc-Method:\s(.*);\r\n/i', $buf, $method);
                $paramsRet = preg_match('/Rpc-Params:\s(.*);\r\n/i', $buf, $params);
                if ($classRet && $methodRet) {
                    $class = ucfirst($class[1]);
                    $method = $method[1];
                    $params = json_decode($params[1], true);
                    $file = $realPath.'/'.$class.'.php';  // 类文件需要和类名一致
                    $data = ''; // 执行结果
                    //判断类文件是否存在
                    if (file_exists($file)) {
                        // 引入类文件
                        require_once $file;
                        //实例化类,
                        $rfc_obj = new ReflectionClass($class);
                        // 判断该类指定方法是否存在
                        if ($rfc_obj->hasMethod($method)) {
                            // 执行类方法
                            $rfc_method = $rfc_obj->getMethod($method);
                            $data = $rfc_method->invokeArgs($rfc_obj->newInstance(), [$params]);
                        } else {
                            socket_write($client, 'method error');
                        }
                        //把运行后的结果返回给客户端
                        socket_write($client, $data);
                    }
                } else {
                    socket_write($client, 'class or method error');
                }
                // 关闭客户端
                socket_close($client);
            }
        } while (true);
    }

    public function __destruct()
    {
        socket_close($this->server);
    }
}
new RpcServer('127.0.0.1',8080,'./service');