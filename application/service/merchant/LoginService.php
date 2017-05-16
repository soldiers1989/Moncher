<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：登录操作service类。
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class LoginService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $item=21;
	private $session;
	private $system;
	/**
	 ***********************************************************
	 *方法::LoginService::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function __construct(){
		$this->includes=new Includes(__FILE__);
		$this->includes->models('DataBase','global');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::LoginService::checkUser
	 * ----------------------------------------------------------
	 * 描述::检测用户合法性
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String :: userName ::用户名
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  bool :: bool ::检测状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function checkUser($userName=''){
		try{
			$bool=false;
			$user=$this->data->select($this->item,Array('loginName'=>$userName,"status"=>1));
			(!empty($user) && count($user)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::LoginService::checkLogin
	 * ----------------------------------------------------------
	 * 描述::检测用户登录
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: userName :: 用户名
	 *parm2:in--    String :: passWord ::密码
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  bool  :: bool ::检测状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function checkLogin($userName='',$passWord=''){
		try{
			$bool=NULL;
			$user=$this->data->select($this->item,Array('loginName'=>$userName,'userPwd'=>$passWord,"status"=>1));
			!empty($user) && $one=$this->data->select(13,array("status"=>1,"id"=>$user[0]['providerId']));
			(!empty($user) && count($user)>0 && count($one)>0 && !empty($one) ) && $bool=$user[0];
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::LoginService::saveUser
	 * ----------------------------------------------------------
	 * 描述::保存用户方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id     :: 需要保存的id
	 *parm2:in--    Array :: data  ::保存数据数组
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  bool :: bool   ::返回操作状态 
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function saveUser($id,$data=Array()){
		try{
			$bool=false;
			$rows=$this->data->update($this->item,$id,$data);
			$rows>0 && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**重置密码操作*/
	public function resetPass($number,$password){
		$provider=$this->data->select(13,array("status"=>1,"cellPhone"=>$number));
		$userone=$this->data->select($this->item,array("status"=>1,"providerId"=>$provider[0]['id']));
		$rows=$this->data->update($this->item,$userone[0]['id'],array("userPwd"=>md5($password)));
		return $rows>0?$rows:0;
	}
}