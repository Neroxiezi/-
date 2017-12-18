<?php

namespace tool;

class Tool{

    /**
     * 接受表单数据
     * @access public
     * @param string $name 表单name
     * @return string
     */
    public function input($name){
        return htmlspecialchars(trim($_REQUEST[$name]), ENT_COMPAT,'ISO-8859-1');
    }

    /**
     * 通过curl获取图片保存到服务器
     * @access public
     * @param string $url 目标url
     * @param string $upload_dir 图片保存地址
     * @param string $filename 图片名称
     * @param int $timeout 超时时间
     * @return string
     */
    public function saveImgCurl($url,$upload_dir,$filename,$timeout=''){
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $img=curl_exec($ch);
        curl_close($ch);

        $fp2=@fopen($upload_dir.'/'.$filename,'a');
        fwrite($fp2,$img);
        fclose($fp2);
        unset($img,$url);

        return $filename;
    }

    /**
     * 图片上传处理
     * @access public
     * @param string $name 图片名表单的name值
     * @param string $upload_dir 图片名存放的地址
     * @param string $fname 图片名
     * @return string
     */
    public function uploadImage($name, $upload_dir, $fname=''){
        $img = $_FILES[$name]['name'];

        if($img!=""){
            $img_temp = $_FILES[$name]['tmp_name'];
            $temp_arrays = explode(".", $img);
            $img_type = $temp_arrays[sizeof($temp_arrays)-1];
            $img_type = strtolower($img_type);
            if($img_type=="jpg" || $img_type=="jpeg" || $img_type=="gif" || $img_type=="png"){
                if($fname==''){
                    $upfile_path = date('Ymdhis').mt_rand(10000,99999).".".$img_type;
                } else {
                    $upfile_path = $fname;
                }
                if(file_exists($upload_dir)==false){
                    mkdir($upload_dir, 0777);
                }

                move_uploaded_file($img_temp, $upload_dir.$upfile_path);

                //生成缩略图
                //createThumbnail($upload_dir,$upfile_path);

            } else {
                senderror("图片格式不正确。");
            }
        }

        return $upfile_path;
    }

    /**
     * 生成缩略图
     * @param string $path 目标路径
     * @param string $filename 图片名
     * @return void
     */
    public function createThumbnail($path,$filename){
        $thumbnail_path1="images_183";
        $thumbnail_path=array($thumbnail_path1);

        list($src_w,$src_h,$imagetype)=getimagesize($path."/".$filename);
        $mime=image_type_to_mime_type($imagetype);

        $createfun=str_replace("/","createfrom",$mime);
        $outfun=str_replace("/",null,$mime);

        $src_image=$createfun($path."/".$filename);

        $dst_183_image=imagecreatetruecolor(183,140);

        imagecopyresampled($dst_183_image, $src_image, 0, 0, 0, 0,183, 140, $src_w, $src_h);

        for($i=0;$i<1;$i++){
            if(!file_exists($path.'/'.$thumbnail_path[$i])){
                mkdir($path.'/'.$thumbnail_path[$i],0777);
            }
        }

        $outfun($dst_183_image,$path.'/'.$thumbnail_path1.'/'.$filename);

        imagedestroy($src_image);
        imagedestroy($dst_183_image);
    }

    /**
     * 生成唯一标识
     * @return string
     */
    public function uniqeId(){
        return md5(uniqid(rand(), TRUE));
    }

    /**
     * 获取当前请求的时间
     * @access public
     * @param bool $float 是否使用浮点类型
     * @return integer|float
     */
    public function time($float = false){
        return $float ? $_SERVER['REQUEST_TIME_FLOAT'] : $_SERVER['REQUEST_TIME'];
    }

    /**
     * 运行js代码
     * @param  string $code js代码
     * @return string
     */
    public static function js($code) {
        $js = '';
        $js .= '<script type="text/javascript">';
        $js .= $code;
        $js .= '</script>';

        echo $js;
    }

    /**
     * 错误提示
     * @param  string $str 提示内容
     * @return void
     */
    public static function sendError($str) {
        echo("<script>window.alert('发生错误：$str');window.history.back();</script>");
        exit();
    }

    /**
     * JS链接跳转
     * @param  string $url 目标url
     * @param  string $msg 跳转提示
     * @return void
     */
    public static function goUrl($url, $msg = '') {
        if($msg!=''){
            echo("<script>window.alert('$msg');window.top.location.replace('$url');</script>");
        } else {
            echo("<script>window.top.location.replace('$url');</script>");
        }

        exit();
    }

    /**
     * 301重定向
     * @param  string $url 重定向的目标url
     * @return void
     */
    public static function http301($url) {
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: '.$url);
        exit;
    }


    /**
     * 截取两字符中间的字符串
     * @param  string $arr 原字符
     * @param  string $startStr 起始字符
     * @param  string $endStr 结束字符
     * @return string
     */
    public static function subStr($str,$startStr,$endStr) {
        $startPos = strpos($str,$startStr)+strlen($startStr);
        $endPos = strpos($str,$endStr);
        $mediumStr = $endPos - $startPos;
        $result = substr($str,$startPos,$mediumStr);

        return $result;
    }

    /**
     * 查看内容
     * @param  string $arr 需要查看的数组
     * @return void
     */
    public static function show($arr) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }

    /**
     * CURL传输
     * @param  string $url 需要传输的url字符
     * @return boolean
     */
    public static function httpsRequest($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }


    /**
     * 带参数分页
     * @param  string $p 目标页码
     * @return string
     */
    public static function pageUrl($p){
        //获取当前完整URL
        $now_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        //将当前url分割为数组
        $url_arr = parse_url($now_url);
        //将url中的参数分割为数组
        parse_str($url_arr['query'],$url_parameter);

        //修改页码
        $url_parameter['p'] = $p;

        //拼合修改后的url
        $url = $url_arr['scheme'].'://'.$url_arr['host'].$url_arr['path'].'?'.http_build_query($url_parameter);

        return $url;
    }

    /**
     * 防止sql注入
     * @param  string $str 需要检测的字符
     * @return boolean
     */
    public static function injectCheck($str) {
        return preg_match('/select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/i', $str);
    }

    /**
     * 生成MyISAM全文搜索字符
     * @param  string $str 需要生成的字符
     * @return array
     */
    public static function ftSplit($str){
        $chars = array();

        preg_match_all("/[a-zA-Z&]+/", $str, $out, PREG_SET_ORDER);
        foreach ($out as &$v) {
            $chars[] = $v[0];
        }

        preg_match_all("/[0-9]+/", $str, $out, PREG_SET_ORDER);
        foreach ($out as &$v) {
            $chars[] = $v[0];
        }

        preg_match_all("/[\x{4e00}-\x{9fa5}]/u", $str, $out, PREG_SET_ORDER);
        foreach ($out as &$v) {
            $chars[] = $v[0];
        }

        $chars = array_unique($chars);

        return $chars;
    }

    /**
     * 检测是否使用手机访问
     * @access public
     * @return bool
     */
    public function isMobile(){
        if (isset($_SERVER['HTTP_VIA']) && stristr($_SERVER['HTTP_VIA'], "wap")) {
            return true;
        } elseif (isset($_SERVER['HTTP_ACCEPT']) && strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML")) {
            return true;
        } elseif (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])) {
            return true;
        } elseif (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断是否为手机设备
     * @return boolean
     */
    public static function is_Mobile(){
        $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
        $mobile_browser = '0';
        if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
            $mobile_browser++;
        if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
            $mobile_browser++;
        if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
            $mobile_browser++;
        if(isset($_SERVER['HTTP_PROFILE']))
            $mobile_browser++;
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda','xda-'
        );
        if(in_array($mobile_ua, $mobile_agents))
            $mobile_browser++;
        if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
            $mobile_browser++;
        // Pre-final check to reset everything if the user is on Windows
        if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
            $mobile_browser=0;
        // But WP7 is also Windows, with a slightly different characteristic
        if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
            $mobile_browser++;
        if($mobile_browser>0)
            return true;
        else
            return false;
    }



}
