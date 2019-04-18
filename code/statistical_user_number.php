<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/18
 * Time: 13:01
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

class OnlineUser
{
    public $prefix_key = "online"; // key 前缀
    public $redis;

    public function __construct()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->auth('pfinal');
        $this->redis = $redis;
    }

    /**
     *  往集合中添加新的在线用户
     * @param $uid
     */
    public function addUser($uid)
    {
        $this->redis->sAdd($this->prefix_key.date('hi'), $uid);
    }

    public function userNum($start_min, $end_min)
    {
        // 第一个参数, 并集的key名称
        $params[] = $this->prefix_key.$start_min.'_'.$end_min;
        // 遍历时间区间所有的分钟, 并放入到参数中
        for ($min = $start_min; $min < $end_min; $min++) {
            $params[] = $this->prefix_key.$min;
        }
        // 求所有分钟的用户的并集并保存, 性能比直接计算返回快很多, 省去了数据传输
        $num = call_user_func_array([$this->redis, 'sUnionStore'], $params);
        // 删除临时并集
        $this->redis->delete($params[0]);

        return $num;
    }


}