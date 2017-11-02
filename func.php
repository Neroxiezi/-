<?php
	
	/*
		PHP冒泡排序:
			要排序的一组数中,对当前未排好的,从前往后一次进行比较和调整,让较大的数组往下沉
			,较小的往上冒.

	*/
			//准备一个数组
			$arr = [1,54,'a',45,12,'c',1,1,12,[1,1,'a',['a','b','a']]];

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


            function pf_array_unique($arr) {
                $dime = array_depth($arr);
                if($dime <= 1) {
                    $data =array_unique($arr);
                } else {
                    foreach ($arr as $key=>$v) {
                       if(is_array($v)) {
                           $new_data = pf_array_unique($v);
                       } else {
                           $temp[$key]=$v;
                       }
                    }
                    $data=array_unique($temp);
                    array_push($data,$new_data);
                }
                return $data;
            }



            function array_depth($array) {
                if(!is_array($array)) return 0;
                $max_depth = 1;
                foreach ($array as $value) {
                    if (is_array($value)) {
                        $depth = array_depth($value) + 1;

                        if ($depth > $max_depth) {
                            $max_depth = $depth;
                        }
                    }
                }
                return $max_depth;
        }

/*$arr1 = pf_array_unique($arr);
			print_r($arr1);*/



            function pf_array_col($array, $columnKey, $indexKey = null)
{
                $result = array();
                if(!empty($array)) {
                    if (!function_exists('array_column')) {
                        foreach ($array as $val) {
                            if (!is_array($val)) {
                                continue;
                            } elseif (is_null($indexKey) && array_key_exists($columnKey, $val)) {
                                $result[] = $val[$columnKey];
                            } elseif (array_key_exists($indexKey, $val)) {
                                if (is_null($columnKey)) {
                                    $result[$val[$indexKey]] = $val;
                                } elseif (array_key_exists($columnKey, $val)) {
                                    $result[$val[$indexKey]] = $val[$columnKey];
                                }
                            }
                        }
                    } else {
                        $result = array_column($array, $columnKey, $indexKey);
                    }
                }
                return $result;
            }















