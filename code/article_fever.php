<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/16
 * Time: 13:20
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

class Good
{
    public $redis = null;

    //60*60*24/20=4320,每个点赞得到的分数，反之即之。
    public $score = 4320;

    //点赞增加数，或者点hate增加数
    public $num = 1;

    //init redis
    public $redis_host = "127.0.0.1";
    public $redis_port = "6379";
    public $redis_pass = "pfinal";

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect($this->redis_host, $this->redis_port);
        $this->redis->auth($this->redis_pass);
    }

    public function click($user_id, $type, $comment_id)
    {
        //判断redis是否已经缓存了该文章数据
        //使用：分隔符对redis管理是友好的
        //这里使用redis zset-> zscore()方法
        if ($this->redis->zscore("comment:like", $comment_id)) {
            //已经存在
            //判断点的是什么
            if ($type == 1) {
                //判断以前是否点过，点的是什么？
                //redis hash-> hget()
                $rel = $this->redis->hget("comment:record", $user_id.":".$comment_id);
                if (!$rel) {
                    //什么都没点过
                    //点赞加1
                    $this->redis->zincrby("comment:like", $this->num, $comment_id);
                    //增加分数
                    $this->redis->zincrby("comment:score", $this->score, $comment_id);
                    //记录上次操作
                    $this->redis->hset("comment:record", $user_id.":".$comment_id, $type);

                    $data = array(
                        "state" => 1,
                        "status" => 200,
                        "msg" => "like+1",
                    );
                } else {
                    if ($rel == $type) {
                        //点过赞了
                        //点赞减1
                        $this->redis->zincrby("comment:like", -($this->num), $comment_id);
                        //增加分数
                        $this->redis->zincrby("comment:score", -($this->score), $comment_id);
                        $data = array(
                            "state" => 2,
                            "status" => 200,
                            "msg" => "like-1",
                        );
                    } else {
                        if ($rel == 2) {
                            //点过hate
                            //hate减1
                            $this->redis->zincrby("comment:hate", -($this->num), $comment_id);
                            //增加分数
                            $this->redis->zincrby("comment:score", $this->score + $this->score, $comment_id);
                            //点赞加1
                            $this->redis->zincrby("comment:like", $this->num, $comment_id);
                            //记录上次操作
                            $this->redis->hset("comment:record", $user_id.":".$comment_id, $type);

                            $data = array(
                                "state" => 3,
                                "status" => 200,
                                "msg" => "like+1",
                            );
                        }
                    }
                }
            } else {
                if ($type == 2) {
                    //点hate和点赞的逻辑是一样的。参看上面的点赞
                    $rel = $this->redis->hget("comment:record", $user_id.":".$comment_id);
                    if (!$rel) {
                        //什么都没点过
                        //点hate加1
                        $this->redis->zincrby("comment:hate", $this->num, $comment_id);
                        //减分数
                        $this->redis->zincrby("comment:score", -($this->score), $comment_id);
                        //记录上次操作
                        $this->redis->hset("comment:record", $user_id.":".$comment_id, $type);

                        $data = array(
                            "state" => 4,
                            "status" => 200,
                            "msg" => "hate+1",
                        );
                    } else {
                        if ($rel == $type) {
                            //点过hate了
                            //点hate减1
                            $this->redis->zincrby("comment:hate", -($this->num), $comment_id);
                            //增加分数
                            $this->redis->zincrby("comment:score", $this->score, $comment_id);

                            $data = array(
                                "state" => 5,
                                "status" => 200,
                                "msg" => "hate-1",
                            );

                            return $data;
                        } else {
                            if ($rel == 2) {
                                //点过like
                                //like减1
                                $this->redis->zincrby("comment:like", -($this->num), $comment_id);
                                //增加分数
                                $this->redis->zincrby("comment:score", -($this->score + $this->score), $comment_id);
                                //点hate加1
                                $this->redis->zincrby("comment:hate", $this->num, $comment_id);

                                $data = array(
                                    "state" => 6,
                                    "status" => 200,
                                    "msg" => "hate+1",
                                );

                                return $data;
                            }
                        }
                    }
                }
            }
        } else {
            //未存在
            if ($type == 1) {
                //点赞加一
                $this->redis->zincrby("comment:like", $this->num, $comment_id);
                //分数增加
                $this->redis->zincrby("comment:score", $this->score, $comment_id);
                $data = array(
                    "state" => 7,
                    "status" => 200,
                    "msg" => "like+1",
                );
            } else {
                if ($type == 2) {
                    //点hate加一
                    $this->redis->zincrby("comment:hate", $this->num, $comment_id);
                    //分数减少
                    $this->redis->zincrby("comment:score", -($this->score), $comment_id);

                    $data = array(
                        "state" => 8,
                        "status" => 200,
                        "msg" => "hate+1",
                    );
                }
            }
            //记录
            $this->redis->hset("comment:record", $user_id.":".$comment_id, $type);
        }

        //判断是否需要更新数据
        $this->ifUploadList($comment_id);

        return $data;
    }

    public function ifUploadList($comment_id)
    {
        date_default_timezone_set("Asia/Shanghai");
        $time = strtotime(date('Y-m-d H:i:s'));

        if (!$this->redis->sismember("comment:uploadset", $comment_id)) {
            //文章不存在集合里，需要更新
            $this->redis->sadd("comment:uploadset", $comment_id);
            //更新到队列
            $data = array(
                "id" => $comment_id,
                "time" => $time,
            );
            $json = json_encode($data);
            $this->redis->lpush("comment:uploadlist", $json);
        }
    }
}

$user_id = 100;
$type = 1;
$comment_id = 99;
$good = new Good();
$rel = $good->click($user_id, $type, $comment_id);
var_dump($rel);