<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-24
**描述：商户注册service类。
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class RegisterService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $system;
	private $session;
	/**
	 ***********************************************************
	 *方法::RoleService::__construct
	 * ----------------------------------------------------------
	 *描述::商户注册service类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function __construct(){
		$this->includes=new Includes(__FILE__);
		$this->includes->models("DataBase","global");
		$this->includes->libraries("CurrSystem");
	    $this->includes->libraries("CurrLog");
	    $this->includes->libraries("CurrSession");
	    $this->session=new CurrSession();
	    $this->system=new CurrSystem();
	    $this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::RegisterService::checkUser
	 * ----------------------------------------------------------
	 *描述::商户注册service类验证用户名
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : userName
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function checkUser($userName){
		try{
			$bool=false;
			$rows=$this->data->select(21,array("status"=>1,"loginName"=>$userName));
			(!empty($rows) && count($rows)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,'商户注册',$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RegisterService::checkNumber
	 * ----------------------------------------------------------
	 *描述::商户注册service验证手机号
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : number
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function checkNumber($number){
		try{
			$bool=false;
			$rows=$this->data->select(13,array("status"=>1,"cellPhone"=>$number));
			(!empty($rows) && count($rows)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,'商户注册',$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RegisterService::checkName
	 * ----------------------------------------------------------
	 *描述::商户注册service验证商户名
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : name
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function checkName($name){
		try{
			$bool=false;
			$rows=$this->data->select(13,array("status"=>1,"name"=>$number));
			(!empty($rows) && count($rows)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,'商户注册',$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RegisterService::getBrand
	 * ----------------------------------------------------------
	 *描述::商户注册service获取品牌类表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : name
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function getBrand($id){
		try{
			$bool=array();
			$rows=$this->data->select(9,array("status"=>1,"parentId"=>0,"series"=>$id));
			(!empty($rows) && count($rows)>0) && $bool=$rows;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,'商户注册',$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RegisterService::getArea
	 * ----------------------------------------------------------
	 *描述::商户注册service获取区域列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : name
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function getArea($id){
		try{
			$bool=array();
			$rows=$this->data->select(10,array("status"=>1,"parentId"=>$id));
			(!empty($rows) && count($rows)>0) && $bool=$rows;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,'商户注册',$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RegisterService::addMerchant
	 * ----------------------------------------------------------
	 *描述::商户注册service商户新增接口
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : name
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function addMerchant($data){
		try{
			$bool=false;
			$rows=$this->data->insert(13,$data);
			$rows>0 && $bool=$rows;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,6,'商户注册',$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RegisterService::addRoot
	 * ----------------------------------------------------------
	 *描述::商户注册service商户最高权限
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : name
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function addRoot($providerid,$isConpany,$data){
		try{
			/*先获取root权限所有菜单*/
			$isConpany==0 && $isConpany=2;
			$open=$this->data->select(24,array("status"=>1,"merchantType"=>0));
			$self=$this->data->select(24,array("status"=>1,"merchantType"=>$isConpany));
			$roleArray=array();
			if(count($open)>0)  foreach ($open as $i){ if($i['pId']<=0)  continue; else $roleArray[]=$i['id'];}
			if(count($self)>0) 		foreach ($self as $i){ if($i['pId']<=0)  continue; else $roleArray[]=$i['id'];}
			/**保存权限信息*/
			$root=$this->data->insert(22,array("providerId"=>$providerid,
																			"roleName"=>"root",
																			"description"=>"门店最高权限",
																			"status"=>1,
																			"createTime"=>$this->system->getSystemTime("A"),
																			"operatorName"=>"商户注册",
																			"operationTime"=>$this->system->getSystemTime("A")));
			/**保存权限明细信息*/
			if(count($roleArray)>0){
				foreach ($roleArray AS $ro){
					if($ro<=0){continue;}else{
						$this->data->insert(23,array("adminRolesId"=>$root,
																			"sector"=>$ro,
																			"symbol"=>"1;2;3;4;5;6",
																			"status"=>1,
																			"operatorName"=>"商户注册",
																			"operationTime"=>$this->system->getSystemTime("A")));
					}
				}
			}
			/**保存管理员信息*/
			$user=$this->data->insert(21,array("loginName"=>$data['loginName'],
																			"userPwd"=>$data['userPwd'],
																			"areaId"=>0,
																			"carId"=>0,
																			"staffName"=>"root",
																			"staffRoleId"=>$root,
																			"providerId"=>$providerid,
																			"status"=>1,
																			"createTime"=>$this->system->getSystemTime("A"),
																			"operatorName"=>"商户注册",
																			"operationTime"=>$this->system->getSystemTime("A")));
			return $user>0?$user:false;
		}catch(Exception $e) {
			$log=new CurrLog(1,6,'商户注册',$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
	public function addRoots($providerid,$isConpany,$data){
		try{
			$list=$this->data->select(13,array("status"=>1));
			for($i=0;$i<count($list);$i++){
				/*先获取root权限所有菜单*/
				$isConpany=$list[$i]['isCompany'];
				$isConpany==0 && $isConpany=2;
				$open=$this->data->select(24,array("status"=>1,"merchantType"=>0));
				$self=$this->data->select(24,array("status"=>1,"merchantType"=>$isConpany));
				$roleArray=array();
				if(count($open)>0)   foreach ($open as $x){ if($x['pId']<=0)  continue; else $roleArray[]=$x['id'];}
				if(count($self)>0) 		foreach ($self as $x){ if($x['pId']<=0)  	   continue; else $roleArray[]=$x['id'];}
				/**保存权限信息*/
				$root=$this->data->insert(22,array("providerId"=>$list[$i]['id'],
																				"roleName"=>"管理员",
																				"description"=>"商户平台管理员",
																				"status"=>1,
																				"createTime"=>$this->system->getSystemTime("A"),
																				"operatorName"=>"商户注册",
																				"operationTime"=>$this->system->getSystemTime("A")));
				/**保存权限明细信息*/
				if(count($roleArray)>0){
					foreach ($roleArray AS $ro){
						if($ro<=0){continue;}else{
							$this->data->insert(23,array("adminRolesId"=>$root,
																				"sector"=>$ro,
																				"symbol"=>"1;2;3;4;5;6",
																				"status"=>1,
																				"operatorName"=>"商户注册",
																				"operationTime"=>$this->system->getSystemTime("A")));
						}
					}
			   }
			   /**保存门店用户新信息*/
			   $one=$this->data->select(21,array("providerId"=>$list[$i]['id']));
			   $this->data->update(21,$one[0]['id'],array("userPwd"=>md5($one[0]['userPwd']),"staffRoleId"=>$root));
			}
		}catch(Exception $e) {
			$log=new CurrLog(1,6,'商户注册',$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
}