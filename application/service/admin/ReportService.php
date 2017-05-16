<?php
	/*****************************************************
	 **作者：张文晓
	**创始时间：2017-04-12
	**描述：门店预警service类。
	*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
	class ReportService{
		#.引用属性，每个控制器都需要有
		private $includes;
		private $data;
		private $model;
		private $system;
		private $session;
/**
	 ***********************************************************
	 *方法::ReportService::__construct
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
		$this->includes->models("ReportModel");
		$this->includes->libraries("CurrSystem");
		$this->includes->libraries("CurrLog");
		$this->includes->libraries("CurrSession");
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->model=new ReportModel();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::ReportService::getList
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
	public function getList($modelid,$groupid,$providerid,$startDate,$endDate){
			try{
				$bool=Array();
				$list=$this->model->getReportList(1,$modelid,$groupid,$providerid,$startDate,$endDate);
				(!empty($list) && count($list)>0) && $bool=$list;
				return $bool;
			}catch(Exception $e) {
				$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
				$log->error();
			}
	}
	/**
	***********************************************************
	*方法::ReportService::getTotal
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
	public function getTotal($modelid,$groupid,$providerid,$startDate,$endDate){
			try{
				$rows=$this->model->getReportList(2,$modelid,$groupid,$providerid,$startDate,$endDate);
				return  $rows>0?$rows:0;
			}catch(Exception $e) {
				$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
				$log->error();
			}
	}
	/**
	 ***********************************************************
	 *方法::ReportService::getModelList
	 * ----------------------------------------------------------
	 *描述::获取调研模型列表
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
	public function getModelList(){
		return $this->data->select(27,array("status"=>1));
	}
	/**
	 ***********************************************************
	 *方法::ReportService::getMerchantList
	 * ----------------------------------------------------------
	 *描述::获取集团下门店类表
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
	public function getMerchantList($groupid){
		return $this->model->getMerchantList($groupid);
	}
	/**
	 ***********************************************************
	 *方法::ReportService::getGroupList
	 * ----------------------------------------------------------
	 *描述::获取调研集团列表
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
	public function getGroupList($modelid){
		return $this->model->getGroupList($modelid);
	}
}