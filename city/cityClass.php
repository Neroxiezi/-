<?php

class Character{
    /**
     * @param array $data
     * @param string $targetKey
     * @return array
     */
    public function groupByInitials(array  $data,$targetKey='name'){
        $data = array_map(function($item) use ($targetKey){
           return array_merge($item,[
               'initials'=> $this->getInitials($item[$targetKey]), //拿到城市的首字母 然后放到原来的数组
           ]);
        },$data);
        $data = $this->sortInitials($data);   //排序
        return $data;
    }

    /**
     * 获取首字母
     * @param $str
     * @return null|string
     */
    public function getInitials($str)
    {
        if (empty($str)) {return '';}
        $fchar = ord($str{0});     //把字符转换成ASII码
        if ($fchar >= ord('A') && $fchar <= ord('z')) {
            return strtoupper($str{0});
        }
        $s1  = iconv('UTF-8', 'gb2312', $str);
        $s2  = iconv('gb2312', 'UTF-8', $s1);
        $s   = $s2 == $str ? $s1 : $str;   //转换字符编码
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) {
            return 'A';
        }

        if ($asc >= -20283 && $asc <= -19776) {
            return 'B';
        }

        if ($asc >= -19775 && $asc <= -19219) {
            return 'C';
        }

        if ($asc >= -19218 && $asc <= -18711) {
            return 'D';
        }

        if ($asc >= -18710 && $asc <= -18527) {
            return 'E';
        }

        if ($asc >= -18526 && $asc <= -18240) {
            return 'F';
        }

        if ($asc >= -18239 && $asc <= -17923) {
            return 'G';
        }

        if ($asc >= -17922 && $asc <= -17418) {
            return 'H';
        }

        if ($asc >= -17417 && $asc <= -16475) {
            return 'J';
        }

        if ($asc >= -16474 && $asc <= -16213) {
            return 'K';
        }

        if ($asc >= -16212 && $asc <= -15641) {
            return 'L';
        }

        if ($asc >= -15640 && $asc <= -15166) {
            return 'M';
        }

        if ($asc >= -15165 && $asc <= -14923) {
            return 'N';
        }

        if ($asc >= -14922 && $asc <= -14915) {
            return 'O';
        }

        if ($asc >= -14914 && $asc <= -14631) {
            return 'P';
        }

        if ($asc >= -14630 && $asc <= -14150) {
            return 'Q';
        }

        if ($asc >= -14149 && $asc <= -14091) {
            return 'R';
        }

        if ($asc >= -14090 && $asc <= -13319) {
            return 'S';
        }

        if ($asc >= -13318 && $asc <= -12839) {
            return 'T';
        }

        if ($asc >= -12838 && $asc <= -12557) {
            return 'W';
        }

        if ($asc >= -12556 && $asc <= -11848) {
            return 'X';
        }

        if ($asc >= -11847 && $asc <= -11056) {
            return 'Y';
        }

        if ($asc >= -11055 && $asc <= -10247) {
            return 'Z';
        }

        return null;
    }

    /**
     * 把字符编码相同的放在一起
     * @param array $data
     * @return array
     */
    public function sortInitials(array $data)
    {
        $sortData = [];
        foreach ($data as $key => $value) {
            $sortData[$value['initials']][] = $value;
        }
        ksort($sortData);
        return $sortData;
    }

}

$data = [
    ['id' => 1, 'area_name' => '山东'],
    ['id' => 2, 'area_name' => '江苏'],
    ['id' => 3, 'area_name' => '安徽'],
    ['id' => 4, 'area_name' => '福建'],
    ['id' => 5, 'area_name' => '江西'],
    ['id' => 6, 'area_name' => '广东'],
    ['id' => 7, 'area_name' => '广西'],
    ['id' => 8, 'area_name' => '海南'],
    ['id' => 9, 'area_name' => '河南'],
    ['id' => 10, 'area_name' => '湖南'],
    ['id' => 11, 'area_name' => '湖北'],
];
// 初始化，然后调用分组方法
$data = (new Character)->groupByInitials($data, 'area_name');
echo '<pre>';
    print_r($data);
echo '</pre>';