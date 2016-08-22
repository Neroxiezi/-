<?php
    
    /*
    
        curl  解释：
            
                curl是利用URL语法在命令行方式下工作的开源文件传输工具

                php模拟post请求接口
    */
    /**
        模拟post进行url请求

        @param  string  $urldecode(str)

        @param  string  $param
    
    
    */
    function request_post($url='',$param='')
    {
        if(empty($url) || empty($param))
        {
            return false;
        }
        
        $postUrl = $url;
        $curlPost = $param;

        //初始化curl
        $ch = curl_init();
        
        //抓取指定的网页
        curl_setopt($ch,CURLOPT_URL,$postUrl);
        //设置header
        curl_setopt($ch,CURLOPT_HEADER,0);
        //要求结果为字符串 输出到屏幕上
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //post提交方式
        curl_setopt($ch,CURLOPT_POST,1);

         curl_setopt($ch,CURLOPT_POSTFIELDS,$curlPost);

        $data = curl_exec($ch);
        
        return $data;
    
    
    }


   
 //  $res=request_post('http://localhost/public_function/curl_index.php','a=add');
    
 //   var_dump($res);



     /**
        模拟GET进行url请求

        @param  string  $url

        @param  string  $param
    
    
    */

    function requ_get($url='')
    {
        $getUrl = $url;

        //初始化curl
        $ch = curl_init();
        //抓取指定的网页
        curl_setopt($ch,CURLOPT_URL,$getUrl);
        //设置header
        curl_setopt($ch,CURLOPT_HEADER,0);
        //结果为字符串  直接输出在电脑屏幕上
        //CURLOPT_RETURNTRANSFER
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $data = curl_exec($ch);
        return $data;    
    }

     
   $res=requ_get('http://localhost/public_function/curl_index.php?a=add');
    
    var_dump($res);

    
?>
