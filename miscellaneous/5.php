<?php

//请写一段PHP代码，确保多个进程同时写入同一个文件成功（腾讯）
function file_lock($path)
{
    $fp = fopen($path, 'w+');
    if (flock($fp, LOCK_EX)) {
        //获得写锁，写数据
        fwrite($fp, "todo");
        //解除锁定
        flock($fp, LOCK_UN);
    } else {
        return 'file is locking......';
    }
}

//var_dump('核心思路：加锁');

//算两个文件的相对路径
function relative_path($path1, $path2)
{
    $arr1 = explode("/", dirname($path1));
    $arr2 = explode("/", dirname($path2));
    for ($i = 0, $len = count($arr2); $i < $len; $i++) {
        if ($arr1[$i] != $arr2[$i]) {
            break;
        }

        $return_path = [];
        // 不在同一个根目录下
        if ($i == 1) $return_path = array();
        // 在同一个根目录下
        if ($i != 1 && $i < $len) {
            $return_path = array_fill(0, $len - $i, "..");
        }
        // 在同一个目录下
        if ($i == $len) {
            $return_path = array('./');
        }
    }
    $return_path = array_merge($return_path, array_slice($arr1, $i));
    return implode('/', $return_path);
}

$a = '/a/b/c/d/e.php';
$b = '/a/b/12/34/c.php';
$c = '/e/b/c/d/f.php';
$d = '/a/b/c/d/g.php';
//var_dump(relative_path($a, $b));//结果是../../c/d
var_dump(relative_path($a, $c));//结果是a/b/c/d
//var_dump(relative_path($a, $d));//结果是./*/

//php双向列表
class DoubleQueue
{
    private $queue = ["php", "java", "perl"];
    public function init()
    {
        return $this->queue;
    }
    public function addFirst($item)
    {
        return array_unshift($this->queue, $item);
    }
    public function addLast($item)
    {
        return array_push($this->queue, $item);
    }
    public function removeFirst()
    {
        return array_shift($this->queue);
    }
    public function removeLast()
    {
        return array_pop($this->queue);
    }
}
$queue = new DoubleQueue();
$queue->addFirst('js');
$queue->addLast('python');
var_dump($queue->init());
$queue->removeFirst();
$queue->removeLast();
var_dump($queue->init());