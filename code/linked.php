<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/4/11
 * Time: 14:34
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

/**
单链表从链表的头节点遍历到尾节点很简单，但从后向前遍历就没那么简单了。它的每个数据结点中都有两个指针，分别指向直接后继和直接前驱。
所以，从双向链表中的任意一个结点开始，都可以很方便地访问它的前驱结点和后继结点。

 *
 */
class Node
{
    public $data; // 节点数据
    public $next; // 下一个节点

    public function __construct($data)
    {
        $this->data = $data;
        $this->next = null;
    }
}

//单链表类

class SingleLinkedList
{
    private $header; // 头节点

    function __construct($data)
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

    // 在节点后 插入新的节点
    public function insert($item, $new)
    {
        $newNode = new Node($new);
        $current = $this->find($item);
        $newNode->next = $current->next;
        $current->next = $newNode;

        return true;
    }

}