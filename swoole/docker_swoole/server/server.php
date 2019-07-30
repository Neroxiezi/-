<?php
    /**
     * Created By ${pROJECT_NAME}.
     * User: pfinal
     * Date: 2019/7/30
     * Time: 下午5:59
     * ----------------------------------------
     *
     */
    $http = new swoole_http_server('0.0.0.0', 9503);
    $http->on(
        "start",
        function ($server) {
            echo "Swoole http server is started at http://127.0.0.1:9503\n";
        }
    );

    // 监听请求对象
    $http->on(
        "request",
        function ($request, $response) {
            var_dump($request);
            $response->header("Content-Type", "text/plain");
            $response->end("Hello World\n");
        }
    );
    $http->start();