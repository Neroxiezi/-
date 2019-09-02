<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/8/29
	 * Time: 下午1:15
	 * ----------------------------------------
	 *
	 */

	class RedisQueue
	{
		const PREFIX = 'PF';
		const ERROR_QUEUE_NAME_EMPTY = 'Queue name can not be empty!';
		const PROCESSING_INDEX = 'PF_';
		const DATA_KEY = 'DK';

		public $queueName = '';
		public $redis = null;
		public $retryTimes = 3;
		public $waitTime = 3;

		public function __construct($queueName, $redisConfig, $retryTimes = 3, $waitTime = 3)
		{
			if (empty($queueName)) {
				throw new Exception('getCurrentIndex:'.self::ERROR_QUEUE_NAME_EMPTY);
			}
			if (empty($redisConfig)) {
				throw new Exception('Redis config name can not be empty!');
			}
			$this->queueName = $queueName;
			$this->retryTimes = $retryTimes;
			$this->waitTime = $waitTime;
			$ret = $this->init($redisConfig);
			if (false === $ret) {
				throw new Exception('Queue init failed!');
			}
		}

		public function getCurrentIndex($data)
		{
			$processingIndex = $this->getProcessingIndex($data);

			return $processingIndex;
		}

		/**
		 * 初始化redis
		 * @param $redisConfig
		 * @return bool
		 */
		public function init($redisConfig)
		{
			$this->redis = new Redis();
			$this->redis->connect($redisConfig['host'], $redisConfig['port']);
			if (!empty($redisConfig['auth'])) {
				$this->redis->auth($redisConfig['auth']);
			}
			if (!empty($redisConfig['index'])) {
				$this->redis->select($redisConfig['index']);
			}

			return true;
		}

		public function getProcessingIndexName($data)
		{
			$dataKey = $this->getDataKey($data);
			$keyName = self::PREFIX.':'.self::PROCESSING_INDEX.":".$this->queueName.":".$dataKey;

			return $keyName;
		}

		public function getProcessingIndex($data)
		{
			$keyName = $this->getProcessingIndexName($data);

			return $this->redis->get($keyName);
		}

		public function setProcessingIndex($data)
		{
			$keyName = $this->getProcessingIndexName($data);
			$index = $this->getDataKey($data);

			return $this->redis->set($keyName, $index);
		}


		public function getIndexListName()
		{
			return self::PREFIX.':IL:'.$this->queueName;
		}

		public function getBlockedListName()
		{
			return self::PREFIX.':BL:'.$this->queueName;
		}

		public function getDataHashName()
		{
			// data hash
			return self::PREFIX.':DH:'.$this->queueName;
		}

		public function getBlockedTimesHashName()
		{
			// blocked times hash
			return self::PREFIX.':BTH:'.$this->queueName;
		}

		public function getDataKey($data)
		{
			return $data[self::DATA_KEY];
		}

		public function setDataKey($data, $index)
		{
			$data[self::DATA_KEY] = $index;

			return $data;
		}

		public function removeProcessingIndex($data)
		{
			$keyName = $this->getProcessingIndexName($data);

			return $this->redis->del($keyName);
		}

		public function removeAllProcessingIndex()
		{
			$pattern = self::PREFIX.':'.self::PROCESSING_INDEX.':'.$this->queueName.':*';
			$keys = $this->redis->keys($pattern);
			foreach ($keys as $key) {
				$this->redis->del($key);
			}
		}

		public function getGuid()
		{
			return uniqid($this->queueName.'_');
		}

		public function addIndex($index)
		{
			# var_dump($this->getIndexListName());exit();
			$ret = $this->redis->lpush($this->getIndexListName(), $index);

			return $ret;
		}

		public function transferToBlocked($index)
		{
			$ret = $this->redis->lpush($this->getBlockedListName(), $index);

			return $ret;
		}

		public function getIndex()
		{
			$ret = $this->redis->rPop($this->getIndexListName());

			return $ret;
		}

		public function getData($index)
		{
			$ret = $this->redis->hGet($this->getDataHashName(), $index);
			$data = json_decode($ret, true);

			return $data;
		}

		public function addData($index, $data)
		{
			$data = json_encode($data, JSON_UNESCAPED_UNICODE);
			$ret = $this->redis->hSet($this->getDataHashName(), $index, $data);

			return $ret;
		}

		public function removeData($data)
		{
			$index = $this->getDataKey($data);
			$ret = $this->redis->hDel($this->getDataHashName(), $index);

			return $ret;
		}

		public function getBlockedTimes($processingIndex)
		{
			$ret = $this->redis->hGet($this->getBlockedTimesHashName(), $processingIndex);

			return intval($ret);
		}

		public function addBlocked($processingIndex)
		{
			$blockedTime = $this->redis->hGet($this->getBlockedTimesHashName(), $processingIndex);
			$blockedTime += 1;
			$ret = $this->redis->hSet($this->getBlockedTimesHashName(), $processingIndex, $blockedTime);

			return $ret;
		}

		public function getBlockedIndex()
		{
			$ret = $this->redis->rPop($this->getBlockedListName());

			return $ret;
		}

		public function removeBlockedTimes($index)
		{
			$ret = $this->redis->hDel($this->getBlockedTimesHashName(), $index);

			return $ret;
		}

		public function add($data)
		{
			$index = $this->getGuid();
			$ret = $this->addIndex($index);

			if (false == $ret) {
				throw  new Exception('Add index failed!');
			}

			$ret = $this->addData($index, $data);
			if (false == $ret) {
				throw  new Exception('Add index failed!');
			}

			return $index;
		}

		public function get()
		{
			$index = $this->getIndex();
			if (empty($index)) {
				sleep($this->waitTime);

				return null;
			}

			$data = $this->getData($index);
			if (empty($data)) { // invalid index
				$data = $this->setDataKey($data, $index);
				$this->remove($index);
			}
			$data = $this->setDataKey($data, $index);
			$this->setProcessingIndex($data);

			return $data;
		}

		public function remove($data)
		{
			$this->removeProcessingIndex($data);
			$ret = $this->removeData($data);

			return $ret;
		}

		public function rollback($data)
		{
			$processingIndex = $this->getProcessingIndex($data);
			if ($processingIndex) {
				$this->addBlocked($processingIndex);
				$blockTimes = $this->getBlockedTimes($processingIndex);
				if ($blockTimes >= $this->retryTimes) {
					$ret = $this->transferToBlocked($processingIndex);
				} else {
					$ret = $this->addIndex($processingIndex);
				}
				if (!empty($ret)) {
					// clear processing index
					$this->removeProcessingIndex($data);
				}
			}
		}

		public function repair()
		{
			$num = 0;
			$blockedIndex = $this->getBlockedIndex();
			while (!empty($blockedIndex)) {
				$this->addIndex($blockedIndex);
				$this->removeBlockedTimes($blockedIndex);
				$blockedIndex = $this->getBlockedIndex();
				$num += 1;
			}

			$this->removeAllProcessingIndex();

			return $num;
		}

		public function status()
		{
			$ret = [];
			$ret['total pending index'] = $this->redis->lLen($this->getIndexListName());
			$ret['total blocked index'] = $this->redis->lLen($this->getBlockedListName());

			return $ret;
		}


	}
