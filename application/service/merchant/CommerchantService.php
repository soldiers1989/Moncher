<?php
/*****************************************************
 **作者：武靖人
**创始时间：2017-02-24
**描述：门店service类。
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class CommerchantService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $system;
	private $session;
	private $model;
	/**
	 ***********************************************************
	 *方法::RoleService::__construct
	 * ----------------------------------------------------------
	 *描述::数据监控service类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.05  Add by 武靖人
	 ************************************************************
	 */
	public function __construct(){

		$this->includes=new Includes(__FILE__);
		$this->includes->models("DataBase","global");
		$this->includes->models("CommerchantModel");
		$this->includes->libraries("CurrSystem");
	    $this->includes->libraries("CurrLog");
	    $this->includes->libraries("CurrSession");
	    $this->session=new CurrSession();
	    $this->system=new  CurrSystem();
	    $this->model=new CommerchantModel();
	    $this->data=new DataBase();


	}
	// 总体总样本量
	public function getSize($mid){
		return $this->model->getSizeData($mid);
	}
	//总体总平均分
	public function getAllSize($fid){
		return $this->model->getAllSizeData($fid);
	}
	// 总体各模块平均分
	public function getMean($pid){
		return $this->model->getMeanData($pid);
	}
	// 总体各模块数量
	public function getCount($sid){
		return $this->model->getCountData($sid);
	} 
	// // 集团各月份得分
	// public function getMonth($mfid){
	// 	return $this->model->getMonthData($mfid);
	// }
	// // 四个季度样本量
	// public function getQuarter($jyid){
	// 	return $this->model->getQuarterData($jyid);
	// }
}