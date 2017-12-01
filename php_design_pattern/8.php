<?php
header("Content-type: text/html; charset=utf-8");
require_once './vendor/autoload.php';

//角色状态存储
class RoleStateMemento
{
    public $Life_Value;

    public function __construct($Life)
    {
        $this->Life_Value = $Life;
    }
}

/**
 * 角色编辑器
 */
class GameRole
{
    public $LifeValue;

    /**
     * 构造方法 初始化状态
     */
    function __construct()
    {
        $this->LifeValue = 100;
    }

    public function Save()
    {
        return (new RoleStateMemento($this->LifeValue));
    }

    public function Recovery($_memento)
    {
        $this->LifeValue = $_memento->Life_Value;
    }

    public function Display(){
        $this->LifeValue -= 10; // 每次被攻击减少10点生命值
    }

    public function Dump()
    {
        echo '当然角色状态:<br/>';
        if ($this->LifeValue <= 0) {
            echo '你已经挂了!<br>';
        } else {
            echo "生命值:{$this->LifeValue}<br>";
        }
    }
}

class RoleStateManger
{
    public $Memento;
}

$Role = new GameRole();
$RoleMan = new RoleStateManger();
$RoleMan->Memento = $Role->Save();
$num = 1; // 记录回合数
for ($i=0; $i<10; $i++){
    echo "-------------第{$num}回合------------<br/>";
    $Role->Display();
    $Role->Dump();
    $num++;

    # 在第5个回合的时候老妈杀来了，你经常会在战斗中存档一次，防止老妈拉电闸
    if($num == 6){
        $RoleMan2 = new RoleStateManger();
        $RoleMan2->Memento = $Role->Save();
    }
}
# 恢复存档：地狱模式打不过，还好他妈存档了！
$Role->Recovery($RoleMan->Memento);
$Role->Dump();
# 咦，好像之前被老妈拉电闸有存档，恢复看下！
$Role->Recovery($RoleMan2->Memento);
$Role->Dump();

