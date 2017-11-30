<?php

use pf\arr\PFarr;

header("Content-type: text/html; charset=utf-8");
require_once './vendor/autoload.php';

interface IState
{
    function WriteCode($work);
}

class AState implements IState
{
    public function WriteCode($work)
    {
        if ($work->hour == '春') {
            echo '春季，要下雨啦！<br/>';
        } else {
            # 调用回调方法，去访问夏季方法
            $work->SetState(new BState());
            $work->WriteCode();
        }
    }
}


class BState implements IState
{
    public function WriteCode($work)
    {
        if ($work->hour == '夏') {
            PFarr::dd('夏季好热');
        } else {
            $work->SetState(new CState());
            $work->WriteCode();
        }
    }
}

class CState implements IState
{
    public function WriteCode($work)
    {
        if ($work->hour == '秋') {
            PFarr::dd('秋季，恋爱的季节！<br/>');
        } else {
            $work->SetState(new DState());
            $work->WriteCode();
        }
    }
}

class DState implements IState
{
    public function WriteCode($work)
    {
        if ($work->hour == '冬') {
            PFarr::dd('冬季，浪漫的季节！<br/>');
        } else {
            PFarr::dd('你不是地球人');
        }
    }
}

class Work
{
    public $hour;  //季节成员
    private $current;
    public $isDone;

    public function __construct()
    {
        $this->current = new AState();
    }

    public function SetState($S)
    {
        $this->current = $S;
    }

    public function WriteCode()
    {
        $this->current->WriteCode($this);
    }
}

# 实例DEMO
$obj = new Work();
/*$obj->hour = '春';
$obj->WriteCode();*/
$obj->hour = '这个';
$obj->WriteCode();