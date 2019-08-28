<?php

    use GatewayWorker\Gateway;

    /**
     * Created By ${ROJECT_NAME}.
     * User: pfinal
     * Date: 2019/8/28
     * Time: 上午11:19
     * ----------------------------------------
     *
     */
    class Events
    {
        public static function onMessage($client_id, $message)
        {
            echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:".json_encode(
                    $_SESSION
                )." onMessage:".$message."\n";
// 客户端传递的是json数据
            $message_data = json_decode($message, true);
            if (!$message_data) {
                return;
            }
            // 根据类型执行不同的业务
            switch ($message_data['type']) {
                // 客户端回应服务端的心跳
                case 'pong':
                    return;
                case 'login':
                    // 判断是否有房间号
                    if (!isset($message_data['room_id'])) {
                        throw new \Exception(
                            "\$message_data['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message"
                        );
                    }
                    $room_id = $message_data['room_id'];
                    $client_name = htmlspecialchars($message_data['client_name']);
                    $_SESSION['room_id'] = $room_id;
                    $_SESSION['client_name'] = $client_name;

                    // 获取房间内所有用户列表
                    $clients_list = \GatewayWorker\Lib\Gateway::getClientSessionsByGroup($room_id);
                    foreach ($clients_list as $tmp_client_id => $item) {
                        $clients_list[$tmp_client_id] = $item['client_name'];
                    }
                    $clients_list[$client_id] = $client_name;
                    $new_message = array(
                        'type' => $message_data['type'],
                        'client_id' => $client_id,
                        'client_name' => htmlspecialchars($client_name),
                        'time' => date('Y-m-d H:i:s'),
                    );
                    \GatewayWorker\Lib\Gateway::sendToGroup($room_id, json_encode($new_message));
                    \GatewayWorker\Lib\Gateway::joinGroup($client_id, $room_id);
                    // 给当前用户发送用户列表
                    $new_message['client_list'] = $clients_list;
                    \GatewayWorker\Lib\Gateway::sendToCurrentClient(json_encode($new_message));
                    break;
                case 'say':
                    if (!isset($_SESSION['room_id'])) {
                        throw new \Exception("\$_SESSION['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']}");
                    }
                    $room_id = $_SESSION['room_id'];
                    $client_name = $_SESSION['client_name'];
                    // 私聊
                    if ($message_data['to_client_id'] != 'all') {
                        $new_message = [
                            'type' => 'say',
                            'from_client_id' => $client_id,
                            'from_client_name' => $client_name,
                            'to_client_id' => $message_data['to_client_id'],
                            'content' => "<b>对你说: </b>".nl2br(htmlspecialchars($message_data['content'])),
                            'time' => date('Y-m-d H:i:s'),
                        ];
                        \GatewayWorker\Lib\Gateway::sendToClient(
                            $message_data['to_client_id'],
                            json_encode($new_message)
                        );
                        $new_message['content'] = "<b>你对".htmlspecialchars(
                                $message_data['to_client_name']
                            )."说: </b>".nl2br(htmlspecialchars($message_data['content']));

                        return \GatewayWorker\Lib\Gateway::sendToCurrentClient(json_encode($new_message));
                    }
                    $new_message = array(
                        'type' => 'say',
                        'from_client_id' => $client_id,
                        'from_client_name' => $client_name,
                        'to_client_id' => 'all',
                        'content' => nl2br(htmlspecialchars($message_data['content'])),
                        'time' => date('Y-m-d H:i:s'),
                    );

                    return \GatewayWorker\Lib\Gateway::sendToGroup($room_id, json_encode($new_message));
                    break;
            }
        }

        public static function onClose($client_id)
        {
            // debug
            echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id onClose:''\n";

            // 从房间的客户端列表中删除
            if (isset($_SESSION['room_id'])) {
                $room_id = $_SESSION['room_id'];
                $new_message = array(
                    'type' => 'logout',
                    'from_client_id' => $client_id,
                    'from_client_name' => $_SESSION['client_name'],
                    'time' => date('Y-m-d H:i:s'),
                );
                \GatewayWorker\Lib\Gateway::sendToGroup($room_id, json_encode($new_message));
            }
        }


    }