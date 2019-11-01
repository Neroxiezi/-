<?php 
 /** 
   *   |++++++++++++++++++++|   
   */    
  
echo '<pre>';
$obj = new SplDoublyLinkedList();
$obj -> push(1);//把新的节点添加到链表的顶部top
$obj -> push(2);
$obj -> push(3);
$obj -> unshift(10);
print_r($obj);
$obj ->rewind();//rewind操作用于把节点指针指向Bottom所在节点
$obj -> prev();
echo 'next node :'.$obj->current().PHP_EOL;
$obj -> next();
$obj -> next();//为什么没有值
echo 'next node :'.$obj->current().PHP_EOL;

// $obj -> next();//为什么没有值### 问题描述

