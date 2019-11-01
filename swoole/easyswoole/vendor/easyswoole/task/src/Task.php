<?php


namespace EasySwoole\Task;


use EasySwoole\Component\Process\AbstractProcess;
use EasySwoole\Component\Process\Socket\UnixProcessConfig;
use Swoole\Atomic\Long;
use Swoole\Server;
use Swoole\Table;

class Task
{
    private $taskIdAtomic;
    private $table;
    private $config;
    private $attachServer = false;

    const ERROR_PROCESS_BUSY = -1;
    const ERROR_PACKAGE_ERROR = -2;
    const ERROR_TASK_ERROR = -3;

    function __construct(Config $config)
    {
        $this->taskIdAtomic = new Long(0);
        $this->table = new Table(512);
        $this->table->column('running',Table::TYPE_INT,4);
        $this->table->column('success',Table::TYPE_INT,4);
        $this->table->column('fail',Table::TYPE_INT,4);
        $this->table->column('pid',Table::TYPE_INT,4);
        $this->table->column('workerId',Table::TYPE_INT,4);
        $this->table->column('workerIndex',Table::TYPE_INT,4);
        $this->table->create();
        $this->config = $config;
    }

    public function attachToServer(Server $server)
    {
        $list = $this->__initProcess();
        /** @var AbstractProcess $item */
        foreach ($list as $item){
            $server->addProcess($item->getProcess());
        }
        $this->attachServer = true;
    }

    public function __initProcess():array
    {
        $ret = [];
        for($i = 0;$i < $this->config->getWorkerNum();$i++){
            $config = new UnixProcessConfig();
            $config->setProcessName($this->config->getServerName().".TaskWorker");
            $config->setSocketFile($this->idToUnixName($i));
            $config->setArg([
                'workerIndex'=>$i,
                'infoTable'=>$this->table,
                'taskIdAtomic'=>$this->taskIdAtomic,
                'taskConfig'=>$this->config
            ]);
            $ret[$i] = new Worker($config);
        }
        return  $ret;
    }

    public function async($task,callable $finishCallback = null,$taskWorkerId = null)
    {
        if($taskWorkerId === null){
            $id = $this->findOutFreeId();
        }else{
            $id = $taskWorkerId;
        }
        if($id !== null){
            if($task instanceof \Closure){
                try{
                    $task = new SuperClosure($task);
                }catch (\Throwable $throwable){
                    return false;
                }
            }
            if($finishCallback instanceof \Closure){
                try{
                    $finishCallback = new SuperClosure($finishCallback);
                }catch (\Throwable $throwable){
                    return false;
                }
            }
            $package = new Package();
            $package->setType($package::ASYNC);
            $package->setTask($task);
            $package->setOnFinish($finishCallback);
            $package->setExpire(round(microtime(true) + $this->config->getTimeout(),4));
            return $this->sendAndRecv($package,$id);
        }else{
            return false;
        }
    }

    public function sync($task,$timeout = 3.0,$taskWorkerId = null)
    {
        if($taskWorkerId === null){
            $id = $this->findOutFreeId();
        }else{
            $id = $taskWorkerId;
        }
        if($id !== null){
            if($task instanceof \Closure){
                try{
                    $task = new SuperClosure($task);
                }catch (\Throwable $throwable){
                    return false;
                }
            }
            $package = new Package();
            $package->setType($package::SYNC);
            $package->setTask($task);
            $package->setExpire(round(microtime(true) + $timeout,4));
            return $this->sendAndRecv($package,$id,$timeout);
        }else{
            return false;
        }
    }

    function status():array
    {
        $ret = [];
        foreach ($this->table as $key => $value){
            $ret[$key] = $value;
        }
        return $ret;
    }

    /*
     * 找出空闲的进程编号,目前用随机
     */
    private function findOutFreeId():?int
    {
        /*
         * 如果该实例是跟随server的，直接调用table来获取信息做最优分配进程
         */
        mt_srand();
        if($this->attachServer){
            $info = $this->status();
            if(!empty($info)){
                array_multisort(array_column($info,'running'),SORT_ASC,$info);
                return $info[0]['workerIndex'];
            }
        }
        return rand(0,$this->config->getWorkerNum() - 1);
    }

    private function idToUnixName(int $id):string
    {
        return $this->config->getTempDir()."/TaskWorker.".md5($this->config->getServerName())."{$id}.sock";
    }

    private function sendAndRecv(Package $package,int $id,float $timeout = null)
    {
        if($timeout === null){
            $timeout = $this->config->getTimeout();
        }
        $client = new UnixClient($this->idToUnixName($id));
        $client->send(Protocol::pack(serialize($package)));
        $ret = $client->recv($timeout);
        if (!empty($ret)) {
            return unserialize(Protocol::unpack($ret));
        }else{
            return null;
        }
    }
}