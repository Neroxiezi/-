<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/18
 * Time: 10:47
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

// 实现使用curl模拟百度蜘蛛进行采集

class Curlcontent
{
    protected $ch;

    protected function _GetContent($url)
    {
        $this->ch = curl_init();
        $this->ip = '220.181.108.'.rand(1, 255);  // 百度蜘蛛
        $this->timeout = 15;
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 0);
        // 伪造百度蜘蛛IP
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, ['X-FORWARDED-FOR:'.$this->ip.'', 'CLIENT-IP:'.$this->ip.'']);
        // 伪造百度蜘蛛头部
        curl_setopt(
            $this->ch,
            CURLOPT_USERAGENT,
            "Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)"
        );
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
        $content = curl_exec($this->ch);
        if ($content === false) {
            // 输出错误信息
            $no = curl_errno($this->ch);
            switch (trim($no)) {
                case 28:
                    $this->error = "访问目标地址超时";
                    break;
                default:
                    $this->error = curl_error($this->ch);
                    break;
            }
            echo $this->error;
        } else {
            $this->succ = true;

            return $content;
        }
    }

    public function getCurl($url)
    {
        return $this->_GetContent($url);
    }
}

$api = "http://www.pfinal.club/";
$CurlContent = new Curlcontent();
$data = $CurlContent->getCurl($api);
var_dump($data);