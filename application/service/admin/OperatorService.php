<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：管理员管理service类。
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class OperatorService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $item=1;
	private $session;
	private $system;
	/**
	 ***********************************************************
	 *方法::OperatorService::__construct
	 * ----------------------------------------------------------
	 * 描述::操作员控制器初始化方法
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
		$this->includes->models('OperatorModel');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::OperatorService::__getList
	 * ----------------------------------------------------------
	 * 描述::操作员控制器获取列表方法
	 *----------------------------------------------------------
	 *参数:
	 *return:out--  Array :: bool ::返回数据类表
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 以获取数据列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getList($page){
		try{
			$bool=Array();
			$model=new OperatorModel();
			$list=$model->getOperatorList(1,($page-1)*20,20);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::OperatorService::addOpera
	 * ----------------------------------------------------------
	 * 描述::操作员控制器新增管理员方法
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
	public function addOpera($data=Array()){
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
	 *方法::OperatorService::saveOpera
	 * ----------------------------------------------------------
	 * 描述::操作员控制器保存数据方法
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
	public function saveOpera($id,$data=Array()){
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
	 *方法::OperatorService::getOpera
	 * ----------------------------------------------------------
	 * 描述::操作员控制器获取一个操作员详情
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id     :: 需要获取的id
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 以获取数据列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getOpera($id){
		try{
			$bool=Array();
			$rows=$this->data->select($this->item,Array('status'=>1,'id'=>$id));
			(!empty($rows) && count($rows)>0) && $bool=$rows;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::OperatorService::checkOpera
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
	public function checkOpera($name=NULL,$id=NULL){
		try{
			$bool=false;
			(!empty($name) && $where=Array("status"=>1,"loginName"=>$name)) ||
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
	 *方法::OperatorService::delete
	 * ----------------------------------------------------------
	 * 描述::操作员控制器删除一个管理员
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
			if($this->session->getSession('Admin','id')==$id ) return false;
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
	 *方法::OperatorService::findOpera
	 * ----------------------------------------------------------
	 * 描述::获取操作员外部接口
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    Array :: where        :: 需要获取的条件
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool            :: 获取的数据列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function findOpera($where=Array()){
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
	/**
	 ***********************************************************
	 *方法::OperatorService::getTotal
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
			$model=new OperatorModel();
			$rows=$model->getOperatorList(2);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::OperatorService::serach
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束
	 *parm4:in--    String :: name :: 用户名
	 *parm5:in--    String :: areaId   ::区域ID
	 *parm6:in--    String :: roleId   ::权限ID
	 *parm7:in--    String :: sector   :: 部门ID
	 *parm8:in--    String :: userStatus :: 用户状态
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function search($name,$roleId,$areaId,$sector,$userStatus,$page){
		try{
			$bool=Array();
			$model=new OperatorModel();
			$list=$model->getSearch(1,$name!=NULL?$name:NULL,$roleId!=NULL?$roleId:NULL,$areaId!=NULL?$areaId:NULL,$sector!=NULL?$sector:NULL,$userStatus!=NULL?$userStatus:NULL,($page-1)*20,20);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::OperatorService::serach
	 * ----------------------------------------------------------
	 * 描述::获取搜索分页数量
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm4:in--    String :: name :: 用户名
	 *parm5:in--    String :: areaId   ::区域ID
	 *parm6:in--    String :: roleId   ::权限ID
	 *parm7:in--    String :: sector   :: 部门ID
	 *parm8:in--    String :: userStatus :: 用户状态
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function getSearchTotal($name,$roleId,$areaId,$sector,$userStatus){
		try{
			$model=new OperatorModel();
			$rows=$model->getSearch(2,$name!=NULL?$name:NULL,$roleId!=NULL?$roleId:NULL,$areaId!=NULL?$areaId:NULL,$sector!=NULL?$sector:NULL,$userStatus!=NULL?$userStatus:NULL);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
}
