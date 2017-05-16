<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：权限管理service类。
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class RoleService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $session;
	private $system;
	/**
	 ***********************************************************
	 *方法::RoleService::__construct
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
		$this->includes->models('RoleModel');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::RoleService::getList
	 * ----------------------------------------------------------
	 * 描述::权限管理service类获取列表方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool ::返回数据类表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getList($page){
		try{
			$bool=Array();
			$model=new RoleModel();
			$list=$model->getRoleList(1,($page-1)*20,20);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RoleService::getMenus
	 * ----------------------------------------------------------
	 * 描述::权限管理service类获取菜单类
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool ::返回数据类表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public  function getMenus(){
		try{
			$bool=Array();
			$menu=$this->data->select(4,Array('status'=>1,"id>"=>'1'));
			(!empty($menu) && count($menu)>0) && $bool=$menu;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RoleService::addRole
	 * ----------------------------------------------------------
	 * 描述::权限管理service类增加role类
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    Array :: data ::需要新增的数组
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  bool :: bool  :: 增加数组的ID
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function addRole($data=Array()){
		try{
			$bool=false;
			$rows=$this->data->insert(2,$data);
			$rows>0 && $bool=$rows;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,6,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
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
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function addRoleInfo($data=Array()){
		try{
			$bool=false;
			$rows=$this->data->insert(3,$data);
			$rows>0 && $bool=$rows;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,6,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RoleService::getRole
	 * ----------------------------------------------------------
	 * 描述::权限管理service类获取权限明细
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id        ::需要角色的基本ID
	 *parm2:in--   String :: roleId  ::需要获取的角色ID
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  String :: bool   ::已经获取的数组列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getRole($id=NULL,$roleId=NULL){
		try{
			$bool=Array();
			(!empty($roleId) && $menu=$this->data->select(3,Array('status'=>1,"adminRolesID"=>$roleId))) ||
			(!empty($id) && $menu=$this->data->select(2,Array('status'=>1,"id"=>$id)));
			(!empty($menu) && count($menu)>0) && $bool=$menu;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
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
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RoleService::getRole
	 * ----------------------------------------------------------
	 * 描述::权限管理service类获取权限明细
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id        ::需要角色的基本ID
	 *parm2:in--   String :: roleId  ::需要获取的角色ID
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  String :: bool   ::已经获取的数组列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function checkRole($name=NULL,$id=NULL){
		try{
			$bool=false;
			(!empty($name) && $where=Array("status"=>1,"roleName"=>$name)) ||
			(!empty($id) && $where=Array("status"=>1,"id"=>$id));
			$rows=$this->data->select(2,$where);
			(!empty($rows) && count($rows)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RoleService::saveRole
	 * ----------------------------------------------------------
	 * 描述::权限管理service类保存角色信息
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id        ::需要角色的基本ID
	 *parm2:in--    Array :: data     ::需要保存的数组
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  String :: bool   ::是否保存成功
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function saveRole($id,$data){
		try{
			$bool=false;
			$rows=$this->data->update(2,$id,$data);
			$rows>0 && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,5,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
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
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function saveRoleInfo($rid,$mid,$data){
		try{
			$bool=false;
			$rows=$this->data->update(3,Array("status"=>1,"adminRolesID"=>$rid,"sector"=>$mid),$data);
			$rows>0 && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,5,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RoleService::saveRole
	 * ----------------------------------------------------------
	 * 描述::权限管理service类删除角色ID
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id        ::需要删除的ID
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  String :: bool   ::是否删除成功
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function deleteRole($id){
		try{
			$bool=false;
			if($this->session->getSession('Admin','adminRolesID')==$id ) return $bool;
			$rows=$this->data->delete(2,$id);
			$rows>0 && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,4,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RoleService::saveRole
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
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function deleteRoleInfo($rid,$mid){
		try{
			$bool=false;
			$rows=$this->data->delete(3,Array("status"=>1,"adminRolesID"=>$rid,"sector"=>$mid));
			$rows>0 && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,4,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RoleService::findRole
	 * ----------------------------------------------------------
	 * 描述::提供给外部调用的查找菜单方法
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
	public function findRole($where=Array()){
		try{
			$bool=Array();
			$find=$this->data->select(2,empty($where)?Array('status'=>1):$where);
			(!empty($find) && count($find)>0) && $bool=$find;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::RoleService::getTotal
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
			$model=new RoleModel();
			$rows=$model->getRoleList(2);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
}
