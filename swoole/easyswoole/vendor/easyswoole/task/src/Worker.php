<?php


namespace EasySwoole\Task;


use EasySwoole\Component\Process\Socket\AbstractUnixProcess;
use EasySwoole\Task\AbstractInterface\TaskInterface;
use Swoole\Atomic\Long;
use Swoole\Coroutine\Socket;
use Swoole\Table;

class Worker extends AbstractUnixProcess
{
    protected $workerIndex;
    /**
     * @var Table
     */
    protected $infoTable;
    /** @var Long */
    protected $taskIdAtomic;
    /**
     * @var Config
     */
    protected $taskConfig;

    public function run($arg)
    {
        $this->workerIndex = $arg['workerIndex'];
        $this->infoTable = $arg['infoTable'];
        $this->taskIdAtomic = $arg['taskIdAtomic'];
        $this->taskConfig = $arg['taskConfig'];
        $this->infoTable->set($this->workerIndex,[
            'running'=>0,
            'success'=>0,
            'fail'=>0,
            'pid'=>$this->getProcess()->pid,
            'workerId'=>$this->getProcess()->id,
            'workerIndex'=>$this->workerIndex
        ]);
        parent::run($arg);
    }

    function onAccept(Socket $socket)
    {
        // 收取包头4字节计算包长度 收不到4字节包头丢弃该包
        $header = $socket->recvAll(4, 1);
        if (strlen($header) != 4) {
            $socket->sendAll(Protocol::pack(serialize(Task::ERROR_PACKAGE_ERROR)));
            $socket->close();
            return;
        }

        // 收包头声明的包长度 包长一致进入命令处理流程
        //多处close是为了快速释放连接
        $allLength = Protocol::packDataLength($header);
        $data = $socket->recvAll($allLength, 1);
        if (strlen($data) == $allLength) {
            /** @var Package $package */
            $package = unserialize($data);
            try{
                if($this->infoTable->incr($this->workerIndex,'running',1) < $this->taskConfig->getMaxRunningNum()){
                    /*
                     * 在投递一些非协成任务的时候，例如客户端的等待时间是3s，阻塞任务也刚好是趋于2.99999~
                     * 因此在进程accept该链接并读取完数据后，客户端刚好到达最大等待时间，客户端返回了null，
                     * 因此业务逻辑可能就认定此次投递失败，重新投递，因此进程逻辑也要丢弃该任务。次处逻辑为尽可能避免该种情况发生
                     */
                    if($package->getExpire() - round(microtime(true),4) < 0.001){
                        $socket->sendAll(Protocol::pack(serialize(Task::ERROR_PROCESS_BUSY)));
                        $socket->close();
                        return;
                    }
                    $taskId = $this->taskIdAtomic->add(1);
                    switch ($package->getType()){
                        case $package::ASYNC:{
                            $socket->sendAll(Protocol::pack(serialize($taskId)));
                            $this->runTask($package,$taskId);
                            $socket->close();
                            break;
                        }
                        case $package::SYNC:{
                            $reply = $this->runTask($package,$taskId);
                            $socket->sendAll(Protocol::pack(serialize($reply)));
                            $socket->close();
                            break;
                        }
                    }
                }else{
                    $socket->sendAll(Protocol::pack(serialize(Task::ERROR_PROCESS_BUSY)));
                    $socket->close();
                }
                $this->infoTable->incr($this->workerIndex,'success',1);
            }catch (\Throwable $exception){
                $this->infoTable->incr($this->workerIndex,'fail',1);
                if($package->getType() != $package::ASYNC){
                    /*
                     * 异步的已经立即返回了
                     */
                    $socket->sendAll(Protocol::pack(serialize(Task::ERROR_TASK_ERROR)));
                    $socket->close();
                }
                throw $exception;
            }finally{
                $this->infoTable->decr($this->workerIndex,'running',1);
            }
        }else{
            $socket->sendAll(Protocol::pack(serialize(Task::ERROR_PACKAGE_ERROR)));
            $socket->close();
        }
    }

    protected function onException(\Throwable $throwable, ...$args)
    {
        if(is_callable($this->taskConfig->getOnException())){
            call_user_func($this->taskConfig->getOnException(),$throwable,$this->workerIndex);
        }else{
            throw $throwable;
        }
    }

    protected function runTask(Package $package,int $taskId)
    {
        $task = $package->getTask();
        $reply = null;
        if(is_string($task) && class_exists($task)){
            $ref = new \ReflectionClass($task);
            if($ref->implementsInterface(TaskInterface::class)){
                /** @var TaskInterface $ins */
                $task = $ref->newInstance();
            }
        }
        if($task instanceof TaskInterface){
            try{
                $reply = $task->run($taskId,$this->workerIndex);
            }catch (\Throwable $throwable){
                $reply = $task->onException($throwable,$taskId,$this->workerIndex);
            }
        }else if($task instanceof SuperClosure){
            $reply = $task($taskId,$this->workerIndex);
        }else if(is_callable($task)){
            $reply = call_user_func($task,$taskId,$this->workerIndex);
        }
        if(is_callable($package->getOnFinish())){
            $reply = call_user_func($package->getOnFinish(),$reply,$taskId,$this->workerIndex);
        }
        return $reply;
    }
}