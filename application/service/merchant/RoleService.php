<?php
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
/**
public function __construct(){
/**
public function getList($page){
/**
public function getRole($id=NULL,$roleId=NULL){
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
}
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
 */
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
/**
public function addRole($data=array()){
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
/**
public function saveRole($id,$data){
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
/**
public function delete($id){
/**
public function checkRole($name=NULL,$id=NULL){
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
/**
public function findRole($where=array()){
/**
public function getTotal(){
}