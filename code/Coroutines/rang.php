<?php
//
//function rang($start, $end, $step = 1)
//{
//    $ret = [];
//    for ($i = $start; $i <= $end; $i += $step) {
//        $ret[] = $i;
//    }
//    return $ret;
//}
class Xrange implements Iterator
{
    protected $start;
    protected $limit;
    protected $step;
    protected $current;

    public function __construct($start, $limit, $step = 1)
    {
        $this->start = $start;
        $this->limit = $limit;
        $this->step = $step;
    }

    // 重置标量
    public function rewind()
    {
        $this->current = $this->start;
    }

    // 下一个标量
    public function next()
    {
        $this->current += $this->step;
    }

    // 获取当前内部标量指向的元素的数据
    public function current()
    {
        return $this->current;
    }

    // 获取当前标量
    public function key()
    {
        return $this->current;
    }

    // 检查当前标量是否有效
    public function valid()
    {
        return $this->current <= $this->limit;
    }
}

$startMemory = memory_get_usage();
$arr = range(0, 500000);
echo 'range(): ', memory_get_usage() - $startMemory, " bytes\n";
unset($arr);
// xrange
echo '<hr>';
$startMemory = memory_get_usage();
$arr = new Xrange(0, 500000);
echo 'xrange(): ', memory_get_usage() - $startMemory, " bytes\n";