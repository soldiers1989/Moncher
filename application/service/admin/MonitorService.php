<?php
	/*****************************************************
	 **作者：张文晓
	**创始时间：2017-04-12
	**描述：门店预警service类。
	*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
	class MonitorService{
		#.引用属性，每个控制器都需要有
		private $includes;
		private $data;
		private $model;
		private $system;
		private $session;
/**
	 ***********************************************************
	 *方法::MonitorService::__construct
	 * ----------------------------------------------------------
	 *描述::门店预警service类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.12  Add by zwx
	 ************************************************************
	 */
public function __construct(){
		$this->includes=new Includes(__FILE__);
		$this->includes->models("DataBase","global");
		$this->includes->models("MonitorModel");
		$this->includes->libraries("CurrSystem");
		$this->includes->libraries("CurrLog");
		$this->includes->libraries("CurrSession");
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->model=new MonitorModel();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::MonitorService::getList
	 * ----------------------------------------------------------
	 * 描述::门店预警service类获取列表方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 返回数据列表
	 * ----------------------------------------------------------
	 * 日期:2017.04.12  Add by zwx
	 ************************************************************
	 */
	public function getList($groupid,$modelid,$brandid,$areaid,$providerid,$startDate,$endDate){
			try{
				$bool=Array();
				$list=$this->model->getMonitorList(1,$groupid,$modelid,$brandid,$areaid,$providerid,$startDate,$endDate);
				(!empty($list) && count($list)>0) && $bool=$list;
				return $bool;
			}catch(Exception $e) {
				$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
				$log->error();
			}
	}
	/**
	***********************************************************
	*方法::MonitorService::getTotal
	* ----------------------------------------------------------
	*描述::获取所有记录行数
	*----------------------------------------------------------
	*参数:
	*parm1:in--    无
	*----------------------------------------------------------
	*返回：
	*return:out--  无
	* ----------------------------------------------------------
	*日期:2017.04.12  Add by zwx
	************************************************************
	*/
	public function getTotal($groupid,$modelid,$brandid,$areaid,$providerid,$startDate,$endDate){
			try{
				$rows=$this->model->getMonitorList(2,$groupid,$modelid,$brandid,$areaid,$providerid,$startDate,$endDate);
				return  $rows>0?$rows:0;
			}catch(Exception $e) {
				$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
				$log->error();
			}
	}
	/**获取搜索条件*/
	public  function getMerchantList($groupid){
		return $this->model->getMerchantList($groupid);
	}
	/**获取搜索条件*/
	public function getBrandList($groupid){
		return $this->model->getBrandList($groupid);
	}
	/**获取搜索条件*/
	public function getAreaList($groupid){
		return $this->model->getAreaList($groupid);
	}
	/**获取搜索条件*/
	public function getGroupList($modelid){
		return $this->model->getGroupList($modelid);
	}
	/**获取搜索条件*/
	public function getModelList(){
		return $this->data->select(27,array("status"=>1));
	}
}