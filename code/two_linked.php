<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/15
 * Time: 11:14
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

// 节点类
class Node
{
    public $data;
    public $previous = null;
    public $next = null;

    public function __construct($data)
    {
        $this->data = $data;
        $this->previous = null;
        $this->next = null;
    }
}

class DoubleLinkedList
{
    private $header;

    public function __construct($data)
    {
        $this->header = new Node($data);
    }

    // 查找节点
    public function find($item)
    {
        $current = $this->header;
        while ($current->data != $item) {
            $current = $current->next;
        }

        return $current;
    }

    // 查找链表最后一个节点
    public function findLast()
    {
        $current = $this->header;
        while ($current->next != null) {
            $current = $current->next;
        }

        return $current;
    }

    // 在节点后 插入新节点
    public function insert($item, $new)
    {
        $newNode = new Node($new);
        $current = $this->find($item);
        $newNode->next = $current->next;
        $newNode->previous = $current;
        $current->next = $newNode;

        return true;
    }

    // 从链表中删除一个节点
    public function delete($item)
    {
        $current = $this->find($item);
        if ($current->next != null) {
            $current->previous->next = $current->next;
            $current->next->previous = $current->previous;
            $current->next = null;
            $current->previous = null;

            return true;
        }
    }

    // 显示链表中的元素
    public function display()
    {
        $current = $this->header;
        if ($current->next == null) {
            echo "链表为空!";

            return;
        }
        while ($current->next != null) {
            echo $current->next->data."&nbsp;&nbsp;&nbsp";
            $current = $current->next;
        }
    }

    // 反序显示双向链表中的元素
    public function dispReverse()
    {
        $current = $this->findLast();
        while ($current->previous != null) {
            echo $current->data."&nbsp;&nbsp;&nbsp;";
            $current = $current->previous;
        }
    }
}

$linkedList = new DoubleLinkedList('header');
$linkedList->insert('header', 'China');
$linkedList->display();
$linkedList->insert('China', 'USA');
echo '<br>';
$linkedList->display();
$linkedList->insert('USA', 'England');
echo '<br>';
$linkedList->display();