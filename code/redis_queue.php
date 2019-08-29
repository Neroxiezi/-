<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/8/28
	 * Time: 下午4:15
	 * ----------------------------------------
	 *
	 */

	class RedisQueue
	{
		protected $client;

		public function __construct(\Predis\Client $client)
		{
			$this->client = $client;
		}

		/**
		 * Add an element to the end of the queue
		 * @param string $key
		 * @param int $delay
		 * @param mixed $value
		 * @return mixed
		 */
		public function push($key, $value, $delay = null)
		{
			if (is_null($delay)) {
				return $this->client->rpush($key, $value);
			}
			$time = time() + $delay;
			if ($time > time()) {
				$hash_key = md5($this->randString(16).'_'.time().'_'.$value);

				return $this->client->transaction(
					function ($tx) use ($key, $time, $hash_key, $value) {
						/** @var \Predis\Client $tx */
						$tx->zadd(
							$key.':zset',
							[
								$hash_key => $time,
							]
						);
						$tx->hset($key.':hlist', $hash_key, $value);
						$tx->expire($key.':zset', 7 * 86400);
						$tx->expire($key.':hlist', 7 * 86400);
					}
				);
			}
		}

		public function receive($key)
		{
			if ($this->getLock($key.':lock')) {
				$keys = $this->client->zrangebyscore($key.':zset', 0, time());
				if (!empty($keys)) {
					$message_datas = $this->client->hmget($key.':hlist', $keys);
					$this->client->transaction(
						function ($tx) use ($key, $keys, $message_datas) {
							/** @var \Predis\Client $tx */
							foreach ($message_datas as $i => $message_data) {
								$tx->rpush($key, $message_data);
								$hash_key = $keys[$i];
								$tx->hdel($key.':hlist', $hash_key);
								$tx->zrem($key.':zset', $hash_key);
							}
						}
					);
				}
				$this->releaseLock($key.':lock');
			}

			return $this->client->lpop($key);
		}

		public function getLock($key)
		{
			$ret = true;
			if ($this->client->incr($key) != 1) {
				$ret = false;
			}
			$ttl = $this->client->ttl($key);
			if ($ttl == -1) {    //forever
				$this->client->expire($key, 60);
			}

			return $ret;
		}

		public function releaseLock($key)
		{
			$this->client->del($key);
		}

		/**
		 * Take an element from the queue header
		 * @param string $key
		 * @return mixed
		 */
		public function pop($key)
		{
			return $this->client->lpop($key);
		}

		protected function randString($length)
		{
			$str = '';
			$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
			$max = strlen($strPol) - 1;
			for ($i = 0; $i < $length; $i++) {
				$str .= $strPol[mt_rand(0, $max)];
			}

			return $str;
		}
	}
