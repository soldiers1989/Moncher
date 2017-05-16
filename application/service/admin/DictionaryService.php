<?php
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class DictionaryService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $item=12;
	private $session;
	private $system;
	/**
	 ***********************************************************
	 *方法::DictionaryService::__construct
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
		$this->includes->models('DictionaryModel');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::DictionaryService::getList
	 * ----------------------------------------------------------
	 * 描述::获取列表方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool ::获取数据列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getList($page){
		try{
			$bool=Array();
			$model=new DictionaryModel();
			$list=$model->getDictList(1,($page-1)*20,20);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::DictionaryService::getDict
	 * ----------------------------------------------------------
	 * 描述::获取字典详细信息
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
	public function getDict($id){
		try{
			$bool=Array();
			$list=$this->data->select($this->item,Array('status'=>1,'id'=>$id));
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::DictionaryService:addDict
	 * ----------------------------------------------------------
	 * 描述::新增字典方法
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
	public function addDict($data=Array()){
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
	 *方法::DictionaryService::saveDict
	 * ----------------------------------------------------------
	 * 描述::字典保存数据方法
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
	public function saveDict($id,$data=Array()){
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
	 *方法::DictionaryService::checkDict
	 * ----------------------------------------------------------
	 * 描述::检测名称或者记录的状态
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id        :: 需要获取的id
	 *parm2:in--    String :: name  ::需要验证的名称
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 验证状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function checkDict($name=NULL,$id=NULL){
		try{
			$bool=false;
			(!empty($name) && $where=Array("status"=>1,"name"=>$name)) ||
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
	 *方法::DictionaryService::delete
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
	 *方法::DictionaryService::findDict
	 * ----------------------------------------------------------
	 * 描述::提供给外部调用的查找字典方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    Array :: where  ::需要查找的条件
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  String :: bool   ::返回数据列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function findDict($where=Array()){
		try{
			$bool=NULL;
			$find=$this->data->select($this->item,empty($where)?Array('status'=>1):$where);
			(!empty($find) && count($find)>0) && $bool=$find;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::DictionaryService::getTotal
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
			$model=new DictionaryModel();
			$rows=$model->getDictList(2);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
}
