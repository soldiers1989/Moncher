<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-01-09
**描述：数据算法类，包含插入排序算法和
*			   二分法查找算法。
*****************************************************/
class CurrAlgor{
	#.插入排序法(小到大排序)  效率又比 选择排序法要高一些
	/**
	 ***********************************************************
	 *方法::CurrAlgor::insertSort
	 * ----------------------------------------------------------
	 * 描述::数据算法类插入排序法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    Array : arr :: 需要排序的数组
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array : arr :: 已经排序的数组
	 * ----------------------------------------------------------
	 * 日期:2017.01.09  Add by zwx
	 ************************************************************
	 */
	function insertSort($arr){
		#.先默认下标为0的这个数已经是有序
		for($i=1;$i<count($arr);$i++){
			$insertVal=$arr[$i];
			$inserIndex=$i-1;
			while($inserIndex >= 0 && $insertVal < $arr[$inserIndex]){
				$arr[$inserIndex+1] = $arr[$inserIndex];
				$inserIndex--;
			}
			$arr[$inserIndex+1] = $insertVal;
		}
		return $arr;
	}
	/**
	 ***********************************************************
	 *方法::CurrAlgor::insertSort
	 * ----------------------------------------------------------
	 * 描述::二分法查找，需要一个递增数组才可使用
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    Array : arr   :: 需要查找的数组
	 *parm4:in--    Int     : value :: 需要查找的值
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array : arr :: 已经查找到的下表
	 * ----------------------------------------------------------
	 * 日期:2017.01.09  Add by zwx
	 ************************************************************
	 */
	function binSearch($arr,$value) {
		$low || $low=0;
		$high || $high=floor(count($arr)/2);
		while($low<=$high) {
			$mid=floor(($low+$high)/2);
			if($value==$arr[$mid]) return $mid;
			($value<$arr[$mid]) ? $high=$mid-1 : $low=$mid+1;
		}
		return false;
	}
}