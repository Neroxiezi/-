<?php

header("Content-type: text/html; charset=utf-8");
require_once './vendor/autoload.php';

abstract class Subject
{
    private $observers = [];

    public function attach($observer)
    {
        array_push($this->observers, $observer);
    }

    public function detach($observer)
    {
        foreach ($this->observers as $k => $v) {
            if ($v == $observer) {
                unset($this->observers[$k]);
            }
        }
    }

    public function Notify()
    {
        foreach ($this->observers as $v) {
            $v->Update();
        }
    }
}

//具体通知者（Boss和Secretary）
class ConcreteSubject extends Subject{
    public $subject_state; // 推送的内容
}

//抽象观察者
abstract class Observer{
    public abstract function Update();
}

//具体观察者
class ConcreteObserver extends Observer{
    private $name;          // 观察者名称
    private $observerState; // 保存通知者推送过来的内容
    public $subject;        // 通知者实例，作用是保证大家都在同一频道内
    # 初始化成员属性
    public function __construct($_sub,$_name){
        $this->subject = $_sub;
        $this->name = $_name;
    }
    # 输出推送的内容
    public function  Update(){
        $this->observerState = $this->subject->subject_state;
        echo "观察者：" .$this->name. "接受到的内容是:" .$this->observerState. "<br/>";
    }
}

# 实例化一个频道
$A = new ConcreteSubject();
# 添加两个观察者 - 并加入同一频道
$zs = new ConcreteObserver($A, '张三');
$ls = new ConcreteObserver($A, '李四');
# 让两个观察者获得接受数据推送的权限
$A->attach($zs);
$A->attach($ls);
# 注入推送内容
$A->subject_state = "I Love You";
# 推送消息
$A->Notify();
