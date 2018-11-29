<?php
declare(strict_types = 1);
// 线性查找

$arr = ['a','b','e'];

function linearSearch(array $arr, string $needle): bool {
    for ($i = 0, $count = count($arr); $i < $count; $i++) {
        if ($needle === $arr[$i]) {
            return true;
        }
    }
    return false;
}
var_dump(linearSearch($arr,'a'));

//二分搜索
/**
线性搜索的平均时间复杂度或最坏时间复杂度是O(n)，这不会随着待搜索数组的顺序改变而改变。所以如果数组中的项按特定顺序排序，我们不必进行线性搜索。
我们可以通过执行选择性搜索而可以获得更好的结果。最流行也是最著名的搜索算法是“二分搜索”。
*/

function binarySearch(array $arr,  string $needle): bool {
	$low = 0;
    $high = count($arr) - 1;
	while($low <= $high) {
		$middle = (int)(($high + $low) / 2);
		if($arr[$middle] < $needle) {
			$low = $middle + 1;
		} elseif($arr[$middle]>$needle) {
			$high = $middle - 1;
		}else {
			return true;
		}
	} 
	return false;
}

var_dump(binarySearch($arr,"e"));

//递归 二分搜索
function binarySearchRecursion(array $arr, string $needle, int $low, int $high): bool {
	
    if ($high < $low) return false;

    $middle = (int)(($high + $low) / 2);
	//var_dump($middle);
    if ($arr[$middle] < $needle) {
        return binarySearchRecursion($arr, $needle, $middle + 1, $high);
    } elseif ($arr[$middle] > $needle) {
        return binarySearchRecursion($arr, $needle, $low, $middle - 1);
    } else {
        return true;
    }
}

var_dump(binarySearchRecursion($arr,"e",0, count($arr)-1));
