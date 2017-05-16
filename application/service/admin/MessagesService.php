<?php
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
	/**
	public function __construct(){
	/**
	public function getList($page){
	/**
	public function getMessages($id){
	/**
	public function addMessages($data=array()){
	/**
	public function saveMessages($id,$data){
	/**
	public function delete($id){
	/**
	public function checkMessages($name=NULL,$id=NULL){
	/**
	public function findMessages($where=array()){
	/**
	public function search($name,$types,$mark,$startPublicDate,$lastPublicDate,$startPushTime,$lastPushTime,$areaId,$brandId,$operatorName,$page){
	/**
	public function getTotal(){
	 ***********************************************************
	 *方法::MessagesService::getTotal
	 * ----------------------------------------------------------
	 *描述::获取所有记录行数
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 *日期:2017.03.01  Add by zwx
	 ************************************************************
	 */
	public function getSearchTotal($name,$types,$mark,$startPublicDate,$lastPublicDate,$startPushTime,$lastPushTime,$areaId,$brandId,$operatorName){
		try{
			$rows=$this->model->getSearch(2,$name!=NULL?$name:NULL,$types!=NULL?$types:NULL,$mark!=NULL?$mark:NULL,$startPublicDate!=NULL?$startPublicDate:NULL,$lastPublicDate!=NULL?$lastPublicDate:NULL,$startPushTime!=NULL?$startPushTime:NULL,$lastPushTime!=NULL?$startPushTime:NULL,$areaId!=NULL?$areaId:NULL,$brandId!=NULL?$brandId:NULL,$operatorName!=NULL?$operatorName:NULL);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
	 ***********************************************************
	 *方法::MessagesService::findGro
	 * ----------------------------------------------------------
	 *描述::获取所有集团列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 *日期:2017.03.01  Add by zwx
	 ************************************************************
	 */
			$bool=Array();
			$find=$this->data->select(13,array("status"=>1,"isCompany"=>0));
			(!empty($find) && count($find)>0) && $bool=$find;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	 ***********************************************************
	 *方法::MessagesService::findProvider
	 * ----------------------------------------------------------
	 *描述::获取所有门店列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 *日期:2017.03.01  Add by zwx
	 ************************************************************
	 */
			$bool=Array();
			$find=$this->data->select(13,array("status"=>1));
			(!empty($find) && count($find)>0) && $bool=$find;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
}