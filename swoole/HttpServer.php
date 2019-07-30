<?php
    /**
     * User: pfinal
     * Date: 2019/7/30
     * Time: 上午11:02
     * ----------------------------------------
     */

    $http = new swoole_http_server("127.0.0.1", 9501);
    $http->on(
        "start",
        function ($server) {
            echo "Swoole http server is started at http://127.0.0.1:9501\n";
        }
    );

    // 监听请求对象
    $http->on(
        "request",
        function ($request, $response) {
            # var_dump($request);
            // 推送到websocket服务起上
            $post = $request->post;
            var_dump($post);
            //$response->header("Content-Type", "text/plain");
            //$response->end("Hello World\n");

        }
    );

    $http->start();