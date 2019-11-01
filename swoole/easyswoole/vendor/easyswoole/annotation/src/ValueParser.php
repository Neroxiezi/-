<?php


namespace EasySwoole\Annotation;


class ValueParser
{
    public static function parser(?string $raw):array
    {
        /*
         * 以逗号为分隔符，分割配置项
         */
        $allParams = [];
        $hasQuotation = false;
        $hasArray = false;
        $temp = '';
        for($i = 0;$i < strlen($raw);$i++){
            if($raw[$i] == ','){
                if($hasQuotation || $hasArray){
                    $temp = $temp.$raw[$i];
                }else{
                    $allParams[] = $temp;
                    $temp = '';
                }
            }else{
                $temp = $temp.$raw[$i];
            }
            if($raw[$i] == "\""){
                if($hasQuotation){
                    $hasQuotation = false;
                }else{
                    $hasQuotation = true;
                }
            }
            if($hasArray){
                if($raw[$i] == '}'){
                    $hasArray = false;
                }
            }else{
                if($raw[$i] == '{'){
                    $hasArray = true;
                }
            }
        }
        /*
         * 追加最后的参数值
         */
        if(!empty($temp)){
            $allParams[] = $temp;
        }
        $final = [];
        foreach ($allParams as $paramRaw){
            $temp = self::parserKeyValue($paramRaw);
            if(is_array($temp)){
                $final = $final + $temp;
            }
        }
        return $final;

    }

    /**
     * 解析一个字符串到key value形式
     * eg:
     *  param=1
     *  param={1,2,3}
     *  param="eval(time() + 2)"
     *  param="{1,2,3}|asd"
     *
     * @param string|null $raw
     * @return array|null
     */
    public static function parserKeyValue(?string $raw):?array
    {
        /*
         * 找出第一个等号
         */
        $pos = strpos($raw,'=');
        if($pos > 0){
            $key = trim(substr($raw,0,$pos));
            $raw = trim(substr($raw,$pos+1)," \t\n\r\0\x0B\"");
            $explodeList = explode("|",$raw);
            if(count($explodeList) > 1){
                $tempList = [];
                foreach ($explodeList as $temp){
                    $tempList[] = self::parserValue($temp);
                }
                return [
                    $key=>$tempList
                ];
            }else{
                return [
                    $key=>self::parserValue($raw)
                ];
            }
        }
        return null;
    }

    public static function parserValue(?string $value)
    {

        if(substr($value,0,1) == '{' && substr($value,-1,1) == '}'){
            /*
             * {} 数组支持
            */
            $list = [];
            $raw = trim($value,"{}");
            $hasQuotation = false;
            $temp = '';
            for($i = 0;$i < strlen($raw);$i++){
                if($raw[$i] == ',' && (!$hasQuotation)){
                    $list[] = $temp;
                    $temp = '';
                }else{
                    $temp = $temp.$raw[$i];
                }
                if($raw[$i] == "'"){
                    if($hasQuotation){
                        $hasQuotation = false;
                    }else{
                        $hasQuotation = true;
                    }
                }
            }
            if(!empty($temp)){
                $list[] = $temp;
            }
            foreach ($list as $index => $item){
                $list[$index] = self::eval(trim($item," \t\n\r\0\x0B\"'"));
            }
            return $list;
        }else{
            return self::eval(trim($value," \t\n\r\0\x0B\"'"));
        }
    }

    public static function eval($value)
    {
        if(substr($value,0,5) == 'eval('  && substr($value,-1,1) == ')'){
            $value =  substr($value,5,strlen($value) - 6);
            return eval("return {$value} ;");
        }if($value == 'true'){
             $value = true;
        }else if($value == 'false'){
            $value = false;
        }else if($value == 'null'){
            $value = null;
        }
        return $value;
    }
}