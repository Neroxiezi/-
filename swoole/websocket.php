<?php
    /**
     * Created By ${pROJECT_NAME}.
     * User: pfinal
     * Date: 2019/7/30
     * Time: 上午11:29
     * ----------------------------------------
     *
     */
    // 专门负责 消息服务的
    $server = new swoole_websocket_server("0.0.0.0", 9502);


    $server->on(
        'request',
        function ($request, $response) use ($server) {
            foreach ($server->connection_list() as $fd) {
                if ($server->isEstablished($fd)) {
                    $server->push($fd, $request->post['content']);
                }
            }
            $response->header('Access-Control-Origin', '*');
            $response->end("消息内容");
        }
    );
    $server->on(
        'message',
        function ($server, $frame) {

        }
    );

    $server->on(
        'close',
        function ($server, $fd) {
            echo "connection close: {$fd}\n";
        }
    );

    $server->start();