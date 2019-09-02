<?php
	/**
	 * Created By ${ROJECT_NAME}.
	 * User: pfinal
	 * Date: 2019/9/2
	 * Time: 下午2:28
	 * ----------------------------------------
	 *
	 */

	class CartService
	{
		protected $redis;
		protected $pre_key;
		protected $uid;

		public function __construct($uid)
		{
			$this->redis = new Redis();
			$this->redis->connect('127.0.0.1', 6379);
			$this->pre_key = 'PFinal_cart:';
			$this->uid = $uid;
		}

		/**
		 *  加入购物车
		 */

		public function add_to_cart($gid, $cartNum = 1)
		{

			if ($gid <= 0) {
				throw new Exception("请输入商品ID");
			}
			$this->redis->watch('goods_total:'.$gid);
			// 根据商品查ID查询除商品
			//$goodData = $this->getGood($gid);
			$goodData = ['goods_name' => 'PFinal社区', 'price' => '12.05', 'num' => '10'];
			$key = $this->pre_key.$this->uid.':'.$gid;
			$data = $this->redis->exists($key);
			//判断购物车中是否有无商品，然后根据情况加入购物车
			if (!$data) {
				if ($goodData['num'] >= $cartNum) {
					$this->redis->set('goods_total:'.$gid, $goodData['num']);
					$goodData['num'] = $cartNum;
					$this->redis->hmset($key, $goodData);
					// 存储商品的id在集合中 方便遍历
					$goods_key = $this->pre_key.'gds:'.$this->uid;
					$this->redis->sAdd($goods_key, $gid);
					$this->redis->incrBy('goods_total:'.$gid, -$cartNum);
					$this->redis->exec();

					return json_encode(['code' => 200, 'msg' => '加入购物车成功'], JSON_UNESCAPED_UNICODE);
				} else {
					throw new Exception("商品库存不足");
				}

			} else {
				//			var_dump($this->redis->get('goods_total:'.$gid));
				if ($this->redis->get('goods_total:'.$gid) >= $cartNum) {
					$originNum = $this->redis->hget($key, 'num');
					$newNum = $originNum + $cartNum;
					$this->redis->hset($key, 'num', $newNum);
					$this->redis->incrBy('goods_total:'.$gid, -$cartNum);

					return json_encode(['code' => 200, 'msg' => '加入购物车成功'], JSON_UNESCAPED_UNICODE);
				} else {
					throw new Exception("商品库存不足");
				}
			}
		}

		/**
		 * 清空购物车
		 */
		public function empty_cart()
		{
			if ($this->redis->exists($this->pre_key.'gds:'.$this->uid)) {
				$goods_ids = $this->redis->sMembers($this->pre_key.'gds:'.$this->uid);
				if (count($goods_ids) > 0) {
					$this->redis->multi();
					foreach ($goods_ids as $gid) {
						$this->redis->del($this->pre_key.$this->uid.':'.$gid);
						$this->redis->del('goods_total:'.$gid);
					}
					$this->redis->del($this->pre_key.'gds:'.$this->uid);
					$this->redis->exec();
				}
			}

			return json_encode(['code' => 200, 'msg' => '清空成功'], JSON_UNESCAPED_UNICODE);
		}

		public function goods_del($gid)
		{
			$key = $this->pre_key.$this->uid.':'.$gid;
			$data = $this->redis->exists($key);
			if ($data) {
				$this->redis->del($key);
				$this->redis->del('goods_total:'.$gid);
				$this->redis->srem($this->pre_key.'gds:'.$this->uid, $gid);

				return json_encode(['code' => 200, 'msg' => '删除成功'], JSON_UNESCAPED_UNICODE);
			} else {
				throw new Exception('商品不在购物车中');
			}
		}

		
	}


	$cart = new CartService(2);
	try {
		$cart->goods_del(5);
	} catch (\Exception $e) {
		print_r($e->getMessage());
	}
	//$res = $cart->empty_cart();
	//print_r($res);
	//	try {
	//		$cart->add_to_cart(5, 1);
	//	} catch (\Exception $e) {
	//		print_r($e->getMessage());
	//	}
