<?php
    /**
     * Created By ${pROJECT_NAME}.
     * User: pfinal
     * Date: 2019/7/31
     * Time: 下午2:16
     * ----------------------------------------
     *
     */
    if (!defined('SERVER_PATH')) exit("No Access");
    class OnMessage
    {
        public static function run($serv, $frame)
        {
            try {
                echo output("onMessage: FD={$frame->fd} Msg={$frame->data}");
                $param = [
                    'type'   => 'speak',
                    'msg'    => $frame->data,
                    'server' => 'ws'
                ];
                $serv->task(json_encode($param));
            } catch(Exception $e) {
            }
        }
    }
