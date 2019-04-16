<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/15
 * Time: 16:11
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

/**
 *  1. 负载均衡算法有哪些?
 *  轮询法: 将请求按顺序轮流地分配到后端服务器上,它均衡地对待后端的每一台服务器,而不关系服务器实际的连接数和当前的系统负载.
 *  随机法: 通过系统的随机算法,根据后端服务器的列表大小值来随机选取其中的一台服务器进行访问。
 *  源地址哈希法: 根据获取客户端的IP地址, 通过哈希函数计算得到一个数值, 用该数值对服务器列表的大小进行取模运算,得到的结果便是客服端要访问服务器的序号。采用源地址哈希算法进行负载均衡，同一IP地址的客户端
 *  当后端服务器列表不变时，它每次都会映射到同一台后端服务器进行访问。
 *  加权轮询法: 不同的后端服务器可能机器的配置和当前系统的负载并不相同, 因此他们的抗压能力也不相同。给配置高，负载低的机器配置更高的权重 让其处理更多的请求;而配置低,负载高的基础,给其分配较低的权重
 *  降低其系统负载,加权轮询能很好地处理这一问题, 并将请求顺序且按照权重分配到后端
 *  加权随机法: 与加权轮询法一样,加权随机法也跟据后端机器的配置, 系统的负载分配不同的权重。 不同的是,它是按照权重随机请求后端服务器,而非顺序。
 *  最小连接数法: 由于后端服务器的配置不尽相同,对于请求的处理有快有慢, 最小连接数法根据后端服务器当前的连接情况, 动态地选取其中当前积压连接数最少的一台服务器来处理当前的请求, 尽可能地提高后端服务的利用效率, 将负责合理地分流到每一台服务器.
 *
 *  2. 如何使用PHP实现加权轮询
 *  实现思路:
 *  通过传入不同的用户id 然后给他们分配不同的主机。
 *  首先, 需要一个接受用户id的数组
 *  其次, 需要一个存主机的数组,这些主机有不同的权重,这里的权重可以这么考虑下:
 *   假设有abc三台主机, 权重分别为 3,1,1 那么a的占比为 0.6 b和c的占比各为0.2
 *   直接遍历主机的数组, 假如用户来了100个人, 到a的时候,a的占比事0.6 就从用户数组那里随机取60个人分给a;轮到b时候,b的占比事0.2 就从用户数组里随机取20人; 同理, c20人 这样就完成了100个请求的转发。
 *  可是真实场景不是固定一批用户,而是持续不断的用户请求,由于转发非常快,当来的新用户非常少时, 每次从用户队列中取完, 转发后立马去用户队列中取, 很有可能每次只取2条, 造成请求全部给了a,b和c一直没有的情况。
 *  这时候可以考虑按照不同策略从用户队列中取数据。假设以前5ms就处理完一次转发,则现在定义两种策略. 如果用户队列中有100个用户时,就取出来,按着主机占比进行转发,如果用户队列中不足100人,但是当前时间和上一次取值时间相差10ms,
 *  就取出来进行转发,这样就可以积累5ms,而这5ms里队列中又会多一些用户请求,这样就不会把所有请求都分给一台机器了。
 */
class WRR
{
    // 每次取100人
    const num = 100;
    // 上次取值时间, 秒级时间戳
    public $last_time;
    // 权重 machine=>weight
    public $machines = [
        'a' => 3,
        'b' => 1,
        'c' => 1,
    ];
    // 占比
    public $proportion = [];
    // 用户队列
    public static $user_ids = [];

    public function __construct()
    {
        // 各机器的占比
        $total = 0;
        foreach ($this->machines as $machine => $weight) {
            $total += $weight;
        }
        $this->proportion['a'] = $this->machines['a'] / $total;
        $this->proportion['b'] = $this->machines['b'] / $total;
        $this->proportion['c'] = $this->machines['c'] / $total;
    }

    public function getUsers()
    {
        $cnt = count(self::$user_ids);
        $a_num = 0;
        $b_num = 0;
        $c_num = 0;
        if ($cnt >= self::num) {
            $a_num = round(self::num * $this->proportion['a']);
            $b_num = round(self::num * $this->proportion['b']);
            $c_num = $cnt - $a_num - $b_num;
        } else { // 队列不足100人
            $last_time = $this->last_time; // 上次访问时间
            while (true) {
                $current_time = $this->getMillisecond();
                if (($current_time - $last_time) >= 10) { // 当前时间和上一次取值时间超过10ms
                    $a_num = round($cnt * $this->proportion['a']);
                    $b_num = round($cnt * $this->proportion['b']);
                    $c_num = $cnt - $a_num - $b_num;
                    $this->last_time = self::getMillisecond();   // 更新访问时间
                    break;
                }
            }
        }
        $a = array_splice(self::$user_ids, 0, $a_num);
        $b = array_splice(self::$user_ids, 0, $b_num);
        $c = array_splice(self::$user_ids, 0, $c_num);

        return array(
            'a' => $a,
            'b' => $b,
            'c' => $c,
        );
    }

    // 获取毫秒级时间戳
    public function getMillisecond()
    {
        list($t1, $t2) = explode(" ", microtime());

        return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }
}

$wrr = new WRR();
echo '<pre>';
for ($i = 0; $i < 3; $i++) {
    $random = rand(10, 120);
    $user_ids = range(1, $random);
    WRR::$user_ids = $user_ids;
    $users = $wrr->getUsers();
    var_dump($users);
}