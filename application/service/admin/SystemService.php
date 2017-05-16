<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：系统日志service类。
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class SystemService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $item=6;
	private $session;
	private $system;
	/**
	 ***********************************************************
	 *方法::SystemService::__construct
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
		$this->includes->models('SystemModel');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::SystemService::getList
	 * ----------------------------------------------------------
	 * 描述::获取列表方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 返回数据列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getList($page){
		try{
			$bool=Array();
			$model=new SystemModel();
			$list=$model->getSystemList(1,($page-1)*100,100);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {			
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::SystemService::getTotal
	 * ----------------------------------------------------------
	 * 描述::获取所有记录行数
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
	public function getTotal(){
		try{
			$model=new SystemModel();
			$rows=$model->getSystemList(2);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::SystemService::search
	 * ----------------------------------------------------------
	 * 描述::获取所有记录行数
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: logType :: 日志类型
	 *parm3:in--    String :: operationType :: 操作类型
	 *parm4:in--    String :: operatorName  :: 操作人员
	 *parm4:in--    String :: startDate   		  ::开始时间
	 *parm5:in--    String :: lastDate             ::结束时间
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function search($logType,$operationType,$operatorName,$startDate,$lastDate,$page){
		try{
			$bool=Array();
			$model=new SystemModel();
			$list=$model->getSearch(1,$logType!=NULL?$logType:NULL,$operationType!=NULL?$operationType:NULL,$operatorName!=NULL?$operatorName:NULL,$startDate!=NULL?$startDate:NULL,$lastDate!=NULL?$lastDate:NULL,($page-1)*100);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::SystemService::getSearchTotal
	 * ----------------------------------------------------------
	 * 描述::获取搜索所有记录行数
	 *----------------------------------------------------------
	 *parm2:in--    String :: logType :: 日志分类
	 *parm3:in--    String :: operationType :: 操作类型
	 *parm4:in--    String :: operatorName  :: 操作人员
	 *parm4:in--    String :: startDate   ::开始时间
	 *parm5:in--    String :: lastDate     ::结束时间
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getSearchTotal($logType,$operationType,$operatorName,$startDate,$lastDate){
		try{
			$model=new SystemModel();
			$rows=$model->getSearch(2,$logType!=NULL?$logType:NULL,$operationType!=NULL?$operationType:NULL,$operatorName!=NULL?$operatorName:NULL,$startDate!=NULL?$startDate:NULL,$lastDate!=NULL?$lastDate:NULL);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
}
