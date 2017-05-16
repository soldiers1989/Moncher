<?php/***************************************************** **作者：张文晓**创始时间：2017-02-24**描述：商户权限管理service类。*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");class RoleService{	#.引用属性，每个控制器都需要有	private $includes;	private $data;	private $item=22;	private $system;	private $session;
/** *********************************************************** *方法::RoleService::__construct * ---------------------------------------------------------- *描述::商户权限管理service类初始化方法 *---------------------------------------------------------- *参数: *parm1:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- * 日期:2017.02.24  Add by zwx ************************************************************ */
public function __construct(){	$this->includes=new Includes(__FILE__);	$this->includes->models("DataBase","global");	$this->includes->models("RoleModel");	$this->includes->libraries("CurrSystem");    $this->includes->libraries("CurrLog");    $this->includes->libraries("CurrSession");    $this->session=new CurrSession();    $this->system=new CurrSystem();    $this->data=new DataBase();}
/** *********************************************************** *方法::RoleService::getList * ---------------------------------------------------------- * 描述::商户权限管理service类获取列表方法 *---------------------------------------------------------- *参数: *parm1:in--    无 *---------------------------------------------------------- *返回： *return:out--  Array :: bool :: 返回数据列表 * ---------------------------------------------------------- * 日期:2017.02.24  Add by zwx ************************************************************ */
public function getList($page){    try{		$bool=Array();		$model=new RoleModel();		$list=$model->getRoleList($this->session->getSession('Merchant','providerId'),1,($page-1)*20,20);		(!empty($list) && count($list)>0) && $bool=$list;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession('Merchant',"loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::RoleService::getRole * ---------------------------------------------------------- * 描述::商户权限管理service类获取数据详情 *---------------------------------------------------------- *参数: *parm2:in--   String :: id  			::需要获取的id *---------------------------------------------------------- *返回： *return:out--  String :: bool   ::已经获取的数组列表 * ---------------------------------------------------------- * 日期:2017.02.24  Add by zwx ************************************************************ */
public function getRole($id=NULL,$roleId=NULL){		try{			$bool=NULL;			(!empty($roleId) && $menu=$this->data->select(23,Array('status'=>1,"adminRolesID"=>$roleId))) ||			(!empty($id) && $menu=$this->data->select(22,Array('status'=>1,"id"=>$id)));			(!empty($menu) && count($menu)>0) && $bool=$menu;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession('Merchant','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());			$log->error();		}}/**
 ***********************************************************
 *方法::RoleService::getRoleTree
 * ----------------------------------------------------------
 * 描述::权限管理service类获取权限明细
 *----------------------------------------------------------
 *参数:
 *parm1:in--    String :: id        ::需要角色的基本ID
 *----------------------------------------------------------
 *返回：
 *return:out--  String :: bool   ::已经获取的数组列表
 * ----------------------------------------------------------
 * 日期:2017.02.17  Add by zwx
 ************************************************************
 */
public function getRoleTree($id=NULL){
	try{
		$bool=Array();
		$model=new RoleModel();
		$list=$model->getRoleTree($id);
		(!empty($list) && count($list)>0) && $bool=$list;
		return $bool;
	}catch(Exception $e) {
		$log=new CurrLog(1,3,$this->session->getSession('Merchant','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
		$log->error();
	}
}/**
 ***********************************************************
 *方法::RoleService::getNavList
 * ----------------------------------------------------------
 * 描述::权限管理service类获取权限明细
 *----------------------------------------------------------
 *参数:
 *parm1:in--    String :: id        ::需要角色的基本ID
 *----------------------------------------------------------
 *返回：
 *return:out--  String :: bool   ::已经获取的数组列表
 * ----------------------------------------------------------
 * 日期:2017.02.17  Add by zwx
 ************************************************************
 */public function getNavList($type){
	try{
		$bool=Array();
		$model=new RoleModel();
		$list=$model->getNavList($type);
		(!empty($list) && count($list)>0) && $bool=$list;
		return $bool;
	}catch(Exception $e) {
		$log=new CurrLog(1,3,$this->session->getSession('Merchant','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
		$log->error();
	}
}
/** *********************************************************** *方法::RoleService:addRole * ---------------------------------------------------------- * 描述::商户权限管理service类新增数据方法 *---------------------------------------------------------- *参数: *parm1:in--    Array :: data :: 需要新增的数据 *---------------------------------------------------------- *返回： *return:out--  Array :: bool :: 新增成功id * ---------------------------------------------------------- * 日期:2017.02.24  Add by zwx ************************************************************ */
public function addRole($data=array()){    try{		$bool=false;		$rows=$this->data->insert($this->item,$data);		$rows>0 && $bool=$rows;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,6,$this->session->getSession('Merchant',"loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}/**
 ***********************************************************
 *方法::RoleService::addRoleInfo
 * ----------------------------------------------------------
 * 描述::权限管理service类增加权限类
 *----------------------------------------------------------
 *参数:
 *parm1:in--    Array :: data ::需要新增的数组
 *----------------------------------------------------------
 *返回：
 *return:out--  bool :: bool  :: 增加数组的ID
 * ----------------------------------------------------------
 * 日期:2017.02.24  Add by zwx
 ************************************************************
 */
public function addRoleInfo($data=Array()){
	try{
		$bool=false;
		$rows=$this->data->insert(23,$data);
		$rows>0 && $bool=$rows;
		return $bool;
	}catch(Exception $e) {
		$log=new CurrLog(1,6,$this->session->getSession('Merchant','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
		$log->error();
	}
}
/** *********************************************************** *方法::RoleService::saveRole * ---------------------------------------------------------- * 描述::商户权限管理service类保存数据方法 *---------------------------------------------------------- *参数: *parm1:in--    String :: id     :: 需要保存的id *parm2:in--    Array :: data  ::需要保存的数据 *---------------------------------------------------------- *返回： *return:out--  Array :: bool :: 操作成功状态 * ---------------------------------------------------------- * 日期:2017.02.24  Add by zwx ************************************************************ */
public function saveRole($id,$data){    try{		$bool=false;		$rows=$this->data->update($this->item,$id,$data);		$rows>0 && $bool=true;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,5,$this->session->getSession('Merchant',"loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}/**
 ***********************************************************
 *方法::RoleService::saveRole
 * ----------------------------------------------------------
 * 描述::权限管理service类保存角色信息
 *----------------------------------------------------------
 *参数:
 *parm1:in--    String :: rid        ::需要角色的基本ID
 *parm2:in--    Array  :: data     ::需要保存的数组
 *parm3:in--    String :: mid      ::需要菜单ID
 *----------------------------------------------------------
 *返回：
 *return:out--  String :: bool   ::是否保存成功
 * ----------------------------------------------------------
 * 日期:2017.02.24  Add by zwx
 ************************************************************
 */
public function saveRoleInfo($rid,$mid,$data){
	try{
		$bool=false;
		$rows=$this->data->update(23,Array("status"=>1,"adminRolesID"=>$rid,"sector"=>$mid),$data);
		$rows>0 && $bool=true;
		return $bool;
	}catch(Exception $e) {
		$log=new CurrLog(1,5,$this->session->getSession('Merchant','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
		$log->error();
	}
}
/** *********************************************************** *方法::RoleService::delete * ---------------------------------------------------------- * 描述::商户权限管理service类删除数据方法 *---------------------------------------------------------- *参数: *parm1:in--    String :: id        :: 需要删除的id *---------------------------------------------------------- *返回： *return:out--  Array :: bool     :: 验证状态 * ---------------------------------------------------------- * 日期:2017.02.24  Add by zwx ************************************************************ */
public function delete($id){    try{		$bool=false;		$find=$this->data->select($this->item,array("providerId"=>$this->session->getSession('Merchant',"providerId")));		if(count($find)>=1 && $find[0]['id']==$id ) return $bool; 		$rows=$this->data->delete($this->item,$id);		$rows>0 && $bool=true;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,4,$this->session->getSession('Merchant',"loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/**************************************************************方法::RoleService::checkRole* ----------------------------------------------------------* 描述::商户权限管理service类检测名称或者记录的状态*----------------------------------------------------------*参数:*parm1:in--    String :: id        :: 需要获取的id*parm2:in--    String :: name  ::需要验证的名称*----------------------------------------------------------*返回：*return:out--  Array :: bool :: 验证状态* ----------------------------------------------------------* 日期:2017.02.24  Add by zwx*************************************************************/
public function checkRole($name=NULL,$id=NULL){    try{		$bool=false;		(!empty($name) && $where=array("status"=>1,"roleName"=>$name)) ||		(!empty($id) && $where=array("status"=>1,"id"=>$id));		$rows=$this->data->select($this->item,$where);		(!empty($rows) && count($rows)>0) && $bool=true;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession('Merchant',"loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}/**
 ***********************************************************
 *方法::RoleService::deleteRoleInfo
 * ----------------------------------------------------------
 * 描述::权限管理service类保存角色信息
 *----------------------------------------------------------
 *参数:
 *parm1:in--    String :: rid        ::删除角色的基本ID
 *parm2:in--    String :: mid      ::删除菜单的ID
 *----------------------------------------------------------
 *返回：
 *return:out--  String :: bool   ::是否保存成功
 * ----------------------------------------------------------
 * 日期:2017.02.24  Add by zwx
 ************************************************************
 */
public function deleteRoleInfo($rid,$mid){
	try{
		$bool=false;
		$rows=$this->data->delete(23,Array("status"=>1,"adminRolesID"=>$rid,"sector"=>$mid));
		$rows>0 && $bool=true;
		return $bool;
	}catch(Exception $e) {
		$log=new CurrLog(1,4,$this->session->getSession('Merchant','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
		$log->error();
	}
}
/** *********************************************************** *方法::RoleService::findRole * ---------------------------------------------------------- * 描述::商户权限管理service类提供给外部调用的查找方法 *---------------------------------------------------------- *参数: *parm1:in--    Array :: where  ::需要查找的条件 *---------------------------------------------------------- *返回： *return:out--  String :: bool   ::返回数据列表 * ---------------------------------------------------------- * 日期:2017.02.24  Add by zwx ************************************************************ */
public function findRole($where=array()){    try{		$bool=NULL;		$find=$this->data->select($this->item,empty($where)?array("status"=>1):$where);		(!empty($find) && count($find)>0) && $bool=$find;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession('Merchant',"loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/**************************************************************方法::RoleService::getTotal* ----------------------------------------------------------*描述::获取所有记录行数*----------------------------------------------------------*参数:*parm1:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.02.24  Add by zwx*************************************************************/
public function getTotal(){    try{		$model=new RoleModel();		$rows=$model->getRoleList($this->session->getSession('Merchant','providerId'),2);		return  $rows>0?$rows:0;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession('Merchant',"loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
}