<?php
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php'); 
/*****************************************************
 **作者：hjm
**创始时间：2017-02-03
**描述：service层 平台商户管理模块 包括 : 商户审核、商户查询、活动审核
*****************************************************/
class ProviderService{
	private $model;
	/**
	 ***********************************************************
	 *方法::ProviderService::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.02.03  Add by hjm
	 ************************************************************
	 */
	function __construct(){
	$this->includes=new Includes(__FILE__);
	$this->includes->libraries('CurrLog');
	$this->includes->models('ProviderModel');
	}

	/**
	 ***********************************************************
	 *方法::ProviderService::getProviderList
	 * ----------------------------------------------------------
	 * 描述::获取商户列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.02.03  Add by hjm
	 ************************************************************
	 */
	public function getProviderList(){
		$Anymodel = new ProviderModel();
		$datalist      =$Anymodel->getProviderListData();
	
		return $datalist;
	}
	/**
	 ***********************************************************
	 *方法::ProviderService::getProviderList
	 * ----------------------------------------------------------
	 * 描述::获取区域列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.02.03  Add by hjm
	 ************************************************************
	 */
	public function getAreaList(){
		$Anymodel = new ProviderModel();
		$datalist      =$Anymodel->getAreaListData();
		
		return $datalist;
	}
	/**
	 ***********************************************************
	 *方法::ProviderService::getProviderList
	 * ----------------------------------------------------------
	 * 描述::获取活动审核列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.02.03  Add by hjm
	 ************************************************************
	 */
	public function getActivityList(){
		$Anymodel = new ProviderModel();
		$datalist      =$Anymodel->getActivityListData();
		
		return $datalist;
	}
	/**
	 * 商户管理-商户审核-审核
	 * 参数:
	 * parm1 : in --String : $id : 所要审核商户id
	 * 日期:2017.02.04  Add by hjm
	 */
	public function getProviderUpdate($id){
		$Anymodel = new ProviderModel();
		$datalist      =$Anymodel->getProviderUpdateData($id);
		return $datalist;
	}
	/**
	 * 商户管理-商户查询-列表
	 * 参数:
	 * parm1 : in --String : $city_name : $city_name区域名
	 * 日期:2017.02.04  Add by hjm
	 */
	public function getProviderAreaList($city_name){
		$Anymodel = new ProviderModel();
		$list             =$Anymodel->getProviderAreaData($city_name);
		return $list;
	}
	/**
	 * 商户管理-商户查询-列表添加分页获取
	 * 参数:
	 * parm1 : in --String :$page 第几页
	 * 日期:2017.03.07  Add by hjm
	 */
	public function getProAll($page){
		try{
			$bool=NULL;
			$model=new ProviderModel();
			$list=$model->getProAllData(1,($page-1)*100,100);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 * 商户管理-商户审核-列表添加分页获取
	 * 参数:
	 * parm1 : in --String :$page 第几页
	 * 日期:2017.03.07  Add by hjm
	 */
	public function getAuditData($page){
		try{
			$bool=NULL;
			$model=new ProviderModel();
			$list=$model->getAuditDataList(1,($page-1)*100,100);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e){
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 * 商户管理-商户维护-验证
	 * 参数:
	 * 日期:2017.03.14  Add by hjm
	 */
	public function checkProvider($name=NULL,$id=NULL){
		try{
			$bool=false;
			(!empty($name) && $where=array("status"=>1,"name"=>$name)) ||
			(!empty($id) && $where=array("status"=>1,"id"=>$id));
			$rows=$this->data->select(13,$where);
			(!empty($rows) && count($rows)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
	
	
}