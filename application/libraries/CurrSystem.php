<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-01-06
**描述：系统通用类，主要包括获取客服端访问IP地址
*				和获取服务器时间。
*****************************************************/
class CurrSystem{
	/**
	 ***********************************************************
	 *方法::CurrSystem::getClientIP
	 * ----------------------------------------------------------
	 * 描述::系统类获取访问端IP地址
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  String : clientIP  :: 客户点IP地址
	 * ----------------------------------------------------------
	 * 日期:2017.01.06  Add by zwx
	 ************************************************************
	 */
	public function getClientIP(){
		$clientIP='unknow';
		(getenv('HTTP_CLIENT_IP') && $clientIP= getenv('HTTP_CLIENT_IP')) || 
		(getenv('HTTP_X_FORWARDED_FOR') && $clientIP=getenv('HTTP_X_FORWARDED_FOR')) ||
		(getenv('REMOTE_ADDR') && $clientIP=getenv('REMOTE_ADDR') ) ||
		(isset($_SERVER['REMOTE_ADDR']) && $clientIP=$_SERVER['REMOTE_ADDR']) ;
		return $clientIP;
	}
	/**
	 ***********************************************************
	 *方法::CurrSystem::getSystemTime
	 * ----------------------------------------------------------
	 * 描述::系统类获取服务器时间戳
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : index       :: 获取时间类型
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  String : dateTime :: 日期/时间字符串
	 * ----------------------------------------------------------
	 *示例:
     *case1:use--  getSystemTime('A') :: 获取完整日期时间格式
     *case2:use--  getSystemTime('B') :: 获取完整日期
     *case3:use--  getSystemTime('C') :: 获取完整时间
     *case4:use--  getSystemTime('T') :: 获取时间戳
     *case5:use--  getSystemTime('Y') :: 获取年份
     *case6:use--  getSystemTime('S') :: 获取秒数
     *----------------------------------------------------------
	 * 日期:2017.01.06  Add by zwx
	 ************************************************************
	 */
   public function getSystemTime($index=NULL){
   	date_default_timezone_set('PRC');
	   	$dateTime=array(
	   			"A"=>date("Y-m-d H:i:s"),
	   			"B"=>date("Y-m-d"),
	   			"C"=>date("H:i:s"),
	   			"T"=>time(),
	   			"Y"=>date("Y"),
	   			"M"=>date("m"),
	   			"D"=>date("d"),
	   			"H"=>date("H"),
	   			"I"=>date("i"),
	   			"S"=>date("s")
	   	);
	  return empty($index)?$dateTime['A']:$dateTime[$index];
   }
   /**
    ***********************************************************
    *方法::CurrSystem::remind
    * ----------------------------------------------------------
    * 描述::系统类生成提醒信息
    *----------------------------------------------------------
    *参数:
    *parm1:in--   String : status       :: 获取时间类型
    *parm2:in--   String : mess        :: 提醒文本信息
    *parm3:in--   String : url             :: 提醒跳转地址  
    *----------------------------------------------------------
    *返回：
    *return:out--  Array : mess 		  :: 提醒数组 
    * ----------------------------------------------------------
    * 日期:2017.01.06  Add by zwx
    ************************************************************
    */
   public function remind($status=2,$url=''){
   		($status==1 && $str='操作成功！') ||  ($status==2 && $str='操作失败！') || 	($status==3 && $str='此条记录已存在！') || ($status==4 && $str='此条记录已删除！') || 	($status==5 && $str='门店已经认证商户！');
   		$mess=Array( "status"=>$status>1?2:1,"mess"=>$str,"url"=>$url);
   		return $mess;
   }
}