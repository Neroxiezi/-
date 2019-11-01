<?php


namespace EasySwoole\Task;


use EasySwoole\Spl\SplBean;

class Config extends SplBean
{
    protected $tempDir;
    protected $workerNum = 3;
    protected $serverName = 'EasySwoole';
    protected $maxRunningNum = 128;
    /**
     * @var float
     */
    protected $timeout = 30;
    protected $onException;

    /**
     * @return mixed
     */
    public function getTempDir()
    {
        return $this->tempDir;
    }

    /**
     * @param mixed $tempDir
     */
    public function setTempDir($tempDir): void
    {
        $this->tempDir = $tempDir;
    }

    /**
     * @return int
     */
    public function getWorkerNum(): int
    {
        return $this->workerNum;
    }

    /**
     * @param int $workerNum
     */
    public function setWorkerNum(int $workerNum): void
    {
        $this->workerNum = $workerNum;
    }

    /**
     * @return string
     */
    public function getServerName(): string
    {
        return $this->serverName;
    }

    /**
     * @param string $serverName
     */
    public function setServerName(string $serverName): void
    {
        $this->serverName = $serverName;
    }

    /**
     * @return int
     */
    public function getMaxRunningNum(): int
    {
        return $this->maxRunningNum;
    }

    /**
     * @param int $maxRunningNum
     */
    public function setMaxRunningNum(int $maxRunningNum): void
    {
        $this->maxRunningNum = $maxRunningNum;
    }

    /**
     * @return float
     */
    public function getTimeout(): float
    {
        return $this->timeout;
    }

    /**
     * @param float $timeout
     */
    public function setTimeout(float $timeout): void
    {
        $this->timeout = $timeout;
    }

    /**
     * @return mixed
     */
    public function getOnException()
    {
        return $this->onException;
    }

    /**
     * @param mixed $onException
     */
    public function setOnException($onException): void
    {
        $this->onException = $onException;
    }

    protected function initialize(): void
    {
        if(empty($this->tempDir)){
            $this->tempDir = getcwd();
        }
    }
}