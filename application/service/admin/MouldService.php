<?php
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php'); 
/*****************************************************
 **作者：hjm
**创始时间：2017-03-14
**描述：service层 模型 
*****************************************************/
class MouldService{
	private $model;
	/**
	 ***********************************************************
	 *方法::ModelService::__construct
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
	$this->includes->models('MouldModel');
	$this->includes->models('DataBase','global');
	$this->includes->libraries('CurrSession');
	$this->includes->libraries('CurrSystem');
	$this->includes->libraries('CurrLog');
	$this->session=new CurrSession();
	$this->system=new CurrSystem();
	$this->data=new DataBase();
	}

	/**
	 * 问卷管理-模型列表-验证
	 * 
	 * 日期:2017.03.14  Add by hjm
	 */
	public function checkMould($name=NULL,$id=NULL){
		try{
			$bool=false;
			(!empty($name) && $where=array("status"=>1,"name"=>$name)) ||
			(!empty($id) && $where=array("status"=>1,"id"=>$id));
			$rows=$this->data->select(27,$where);
			(!empty($rows) && count($rows)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
		$log->error();
	}
	}

	public function 	checkblock($name=NULL,$id=NULL){
		try{
			$bool=false;
			(!empty($name) && $where=array("status"=>1,"name"=>$name)) ||
			(!empty($id) && $where=array("status"=>1,"id"=>$id));
			$rows=$this->data->select(28,$where);
			(!empty($rows) && count($rows)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
	
	/**
	 * 问卷管理-模型列表-获取列表数据
	 *
	 * 日期:2017.03.15  Add by hjm
	 */
	public function getModelData($page){
		$model=new MouldModel();
		$list=$model->getModelList(1,($page-1)*10,10);
		return $list;
	}
	/**
	 * 问卷管理-模型列表-获取模块列表数据
	 *
	 * 日期:2017.03.15  Add by hjm
	 */
	public function getModelblockData($page){
		$model=new MouldModel();
		$list=$model->getModelblockList(1,($page-1)*10,10);
		return $list;
	}
}









