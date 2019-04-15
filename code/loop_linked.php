<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/15
 * Time: 15:17
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
// 循环链表
// 循环链表和单向链表相似，节点类型都是一样的。唯一的区别是，在创建循环链表时，让其头节点的 next 属性指向它本身，即:head.next = head，这种行为会传导至链表中的每个节点，使得每个节点的 next 属性都指向链表的头节点。换句话说，链表的尾节点指向头节点，形成了一个循环链表。

class Node
{
    public $data;
    public $previous;
    public $next;

    public function __construct($data)
    {
        $this->data = $data;
        $this->next = null;
    }
}

// 循环链表类
class CircularLinkedList
{
    private $header;

    public function __construct($data)
    {
        $this->header = new Node($data);
        $this->header->next = $this->header;
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

    // 插入新节点
    public function insert($item, $new)
    {
        $newNode = new Node($new);
        $current = $this->find($item);
        if ($current->next != $this->header) {
            $current->next = $newNode;
            $newNode->next = $current->next;
        } else {
            $current->next = $newNode;
            $newNode->next = $this->header;
        }

        return true;
    }

    // 删除节点
    public function delete($item)
    {
        $current = $this->header;
        while ($current->next != null && $current->next->data != $item) {
            $current = $current->next;
        }
        if ($current->next != $this->header) {
            $current->next = $current->next->next;
        } else {
            $current->next = $this->header;
        }
    }

    // 显示链表中的元素
    public function display()
    {
        $current = $this->header;
        while ($current->next != $this->header) {
            echo $current->next->data."&nbsp;&nbsp;&nbsp;";
            $current = $current->next;
        }
    }
}

$linkedList = new CircularLinkedList('header');
$linkedList->insert('header', 'China');
$linkedList->insert('China', 'USA');
$linkedList->insert('USA', 'England');
$linkedList->insert('England', 'Australia');
echo '链表为：';
$linkedList->display();
echo "</br>";
echo '-----删除节点USA-----';
echo "</br>";
$linkedList->delete('USA');
echo '链表为：';
$linkedList->display();
