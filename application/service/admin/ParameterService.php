<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：系统参数管理service类。
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class ParameterService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $item=11;
	private $session;
	private $system;
	/**
	 ***********************************************************
	 *方法::ParameterService::__construct
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
		$this->includes->models('ParameterModel');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::ParameterService::getList
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
			$model=new ParameterModel();
			$list=$model->getParamList(1,($page-1)*20,20);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::ParameterService::getParam
	 * ----------------------------------------------------------
	 * 描述::权限管理service类获取权限明细
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--   String :: id  			::参数id
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  String :: bool   ::已经获取的数组列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getParam($id){
		try{
			$bool=Array();
			$list=$this->data->select($this->item,Array('status'=>1,"id"=>$id));
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::ParameterService:addParam
	 * ----------------------------------------------------------
	 * 描述::新增品牌列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    Array :: data :: 需要新增的数据
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 新增成功id
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function  addParam($data=Array()){
		try{
			$bool=false;
			$rows=$this->data->insert($this->item,$data);
			$rows>0 && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,6,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::ParameterService::saveParam
	 * ----------------------------------------------------------
	 * 描述::系统参数保存数据方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id     :: 需要保存的id
	 *parm2:in--    Array :: data  ::需要保存的数据
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 操作成功状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function saveParam($id,$data=Array()){
		try{
			$bool=false;
			$rows=$this->data->update($this->item,$id,$data);
			$rows>0 && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,5,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::ParameterService::checkParam
	 * ----------------------------------------------------------
	 * 描述::检测名称或者记录的状态
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id        :: 需要获取的id
	 *parm2:in--    String :: name  ::需要验证的名称
	 *parm3:in--    String :: code    ::需要验证的编码
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 验证状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function checkParam($name=NULL,$code=NULL,$id=NULL){
		try{
			$bool=false;
			(!empty($name) && $where=Array("status"=>1,"name"=>$name,"code"=>$code)) ||
			(!empty($id) && $where=Array("status"=>1,"id"=>$id));
			$rows=$this->data->select($this->item,$where);
			(!empty($rows) && count($rows)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::ParameterService::delete
	 * ----------------------------------------------------------
	 * 描述::删除数据方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id        :: 需要删除的id
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool     :: 验证状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function delete($id){
		try{
			$bool=false;
			$rows=$this->data->delete($this->item,$id);
			$rows>0 && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,4,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::ParamService::getTotal
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
			$model=new ParameterModel();
			$rows=$model->getParamList(2);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::ParamService::findParam
	 * ----------------------------------------------------------
	 * 描述::提供外部获取所有记录
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
	public function findParam($where){
		try{
			$bool=Array();
			$find=$this->data->select($this->item,empty($where)?Array('status'=>1):$where);
			(!empty($find) && count($find)>0) && $bool=$find;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
}
