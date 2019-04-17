<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/17
 * Time: 11:07
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

class Ranks
{
    const PREFIX = 'rank:';
    protected $redis = null;

    public function __construct()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->auth('pfinal');
        $this->redis = $redis;
    }

    public function addScores($memeber, $scores)
    {
        $key = self::PREFIX.date('Ymd');

        return $this->redis->zIncrBy($key, $scores, $memeber);
    }

    protected function getOneDayRankings($date, $start, $stop)
    {
        $key = self::PREFIX.$date;

        return $this->redis->zRevRange($key, $start, $stop, true);
    }

    protected function getMultiDaysRankings($dates, $outKey, $start, $stop)
    {
        $keys = array_map(
            function ($date) {
                return self::PREFIX.$date;
            },
            $dates
        );
        $weights = array_fill(0, count($keys), 1);
        $this->redis->zUnion($outKey, $keys, $weights);

        return $this->redis->zRevRange($outKey, $start, $stop, true);
    }

    public function getYesterdayTop10()
    {
        $date = date('Ymd', time() - 3600 * 24);

        return $this->getOneDayRankings($date, 0, 9);
    }

    public static function getCurrentMonthDates()
    {
        $dt = time();
        $days = self::getDaysByMonth($dt);
        $dates = [];
        for ($day = 1; $day <= $days; $day++) {
            $dates[] = date('Ym').$day;
        }

        return $dates;
    }

    public static function getDaysByMonth($unix)
    {
        $month = date('m', $unix);
        $year = date('Y', $unix);
        $nextMonth = (($month + 1) > 12) ? 1 : ($month + 1);
        $year = ($nextMonth > 12) ? ($year + 1) : $year;
        $days = date('d', mktime(0, 0, 0, $nextMonth, 0, $year));

        return $days;
    }

    public function getCurrentMonthTop10()
    {
        $dates = self::getCurrentMonthDates();

        return $this->getMultiDaysRankings($dates, 'rank:current_month', 0, 9);
    }
}

var_dump(Ranks::getCurrentMonthDates());