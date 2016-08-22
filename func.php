<?php
	
	/*
		PHP冒泡排序:
			要排序的一组数中,对当前未排好的,从前往后一次进行比较和调整,让较大的数组往下沉
			,较小的往上冒.

	*/
			//准备一个数组
			$arr = [1,54,32,45,6,46,78,29,10,23];

			function bSort($arr){
				//计算数组元素的个数
				$len = count($arr);
				//设置一个空数组 用来接收冒出来的泡
				//该层循环控制 需要冒泡的轮数
				for($i=1;$i<$len;$i++)
				{
					//该层循环用来控制每次 冒出一个数 需要比较的次数
					for($k=0;$k<$len-$i;$k++){
						//比较当前的数 与他后面的数
						if($arr[$k]>$arr[$k+1]){
							//把小的放在一个变量中
							$tmp=$arr[$k+1];
							//把大的放在后面
							$arr[$k+1]=$arr[$k];
							//把小的放在当前
							$arr[$k]=$tmp;
						}

					}

				}
				return $arr;
			}




	/*
	 *
	 * 	快速排序法
	 *    通过一趟排序将要要排序的数据分割成独立的两部分 其中一部分的所有数据都比另外一部分的所有数组都要笑
	 *    然后在按此方法对这两部分数分别进行快速排序
	 *
	 * */

			function quickSort($arr){
				//计算数组元素
				$len = count($arr);

				//找出一个分界线
				$key = $arr[0];

				//准备两个空数组
				$left_arr=[];
				$right_arr=[];


				//循环分两组组
				for($i=1;$i<$len;$i++){
					if($arr[$i]<=$key)
					{
						$left_arr[]=$arr[$i];
					}else{
						$right_arr[]=$arr[$i];
					}
				}
				//判断是否为空
				if(!empty($left_arr)){
					//递归调用自己
					$left_arr=quickSort($left_arr);
				}else{
					$left_arr=[];
				}

				if(!empty($right_arr)){
					//递归调用自己
					$right_arr=quickSort($right_arr);
				}else{
					$right_arr=[];
				}
				//把排序好的两个数组合并了
				return array_merge($left_arr,[$key],$right_arr);
			}


      /*
       *
       *   选择排序
       * 	 每一趟从待排序的数据元素中选出最小(或最大)的一个元素.顺序放在已经配好序的数列的
       *     最后 直到全部待排序的数据元素排完
       *
       *
       * */

			function select_sort($arr){
				//计算长度
				$len=count($arr);
				for($i=0;$i<$len;$i++){
					//向后比较
					for($j=$i+1;$j<$len;$j++){
						//与后面的一个比较
						if($arr[$i]>$arr[$j])
						{
							//把当前的存储在一个变量中
								$tmp=$arr[$i];
							//然后互换位置
							$arr[$i]=$arr[$j];
							$arr[$j]=$tmp;

						}

					}
				}
				return $arr;
			}

























