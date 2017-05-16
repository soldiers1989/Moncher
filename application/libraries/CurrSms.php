<?php
require_once ('CurrSession.php');
/*****************************************************
 **作者：hjm
**创始时间：2017-01-05
**描述：验证码类，包括发送验证码以及验证 
******************************************************
**修改：张文晓
**修改时间：2017-01-11
**备注：1.新增对外发送验证码方法
*			   2.修改类结构加入短信模板
*			   3.新增 验证验证码方法    
*			   4.修改类结构加入有效时间
*****************************************************/
class CurrSms{
	#.短信模板
	private  $model="您的验证码是:%CODE%，有效期10分钟。";
	#.短信有效时间
	private  $valid=600;
	/**
	 ***********************************************************
	 *方法 : CurrSms ::sms
	 * ----------------------------------------------------------
	 * 描述::验证短信验证码
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : code      :: 短信验证码
	 *parm1:in--   String : number :: 手机号码
	 *----------------------------------------------------------
	 *返回：
	 *return::out-- bool : bool   ::是否正确
	 * ----------------------------------------------------------
	 * 日期:2017.1.6   by zwx
	 ************************************************************
	 */
	function sms($number,$code){
		$bool='';
		$session=new CurrSession();
		(!empty($number)&&!empty($code)) && $bool=$this->sendSms($number,str_replace("%CODE%",$code,$this->model));
	}
	/**
	 ***********************************************************
	 *方法 : CurrSms ::checkSms
	 * ----------------------------------------------------------
	 * 描述::验证短信验证码
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : code :: 短信验证码
	 *----------------------------------------------------------
	 *返回：
	 *return::out-- bool : bool   ::是否正确
	 * ----------------------------------------------------------
	 * 日期:2017.1.11   by zwx
	 ************************************************************
	 */
	function checkSms($code){
		$bool=false;
		$smsCode=array();
		$session=new CurrSession();
		!empty($code) && $smsCode=$session->getSession('smsCode');
		($smsCode['code']==$code&& time-$smsCode['createTime']<$this->valid) && $bool=true;
		return $bool;
	}
	/**
	 ***********************************************************
	 *方法 : CurrSms ::Code
	 * ----------------------------------------------------------
	 * 描述::发送短信验证码
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : number :: 电话号
	 *parm2:in--   String : message :: 短信信息
	 *----------------------------------------------------------
	 *返回：
	 *return::out-- 无
	 * ----------------------------------------------------------
	 * 日期:2017.1.6   by hjm
	 ************************************************************
	 */
	private function sendSms($number,$message){
		$post_data = array(
				'account'=>iconv('GB2312', 'GB2312',"hui123"),
				'pswd'=>iconv('GB2312', 'GB2312',"Tch123456"),
				'mobile'=>$number,
				'msg'=>iconv("UTF-8","UTF-8",$message)
		);
		$str=""; 
		foreach ($post_data as $k=>$v){
			$str.=$k."=".urlencode($v)."&";
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL,'http://222.73.117.158/msg/HttpBatchSendSM?');
		curl_setopt($ch, CURLOPT_POSTFIELDS,substr($str,0,-1));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result =curl_exec($ch);
		return  substr($result,15,1);
	}
}
