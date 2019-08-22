<?php
    /**
     * Created By ${ROJECT_NAME}.
     * User: pfinal
     * Date: 2019/8/22
     * Time: 上午11:08
     * ----------------------------------------
     *
     */
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    var_dump($redis->set('count',0),$redis->get('count'));