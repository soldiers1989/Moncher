<?php
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
/**
public function __construct(){
/**
public function getList($id,$page){
		$one=$this->data->select(13,array("status"=>1,"id"=>$id));
		$one=count($one)==1?$one[0]:array("isCompany"=>-1);
/**
public function getCertification($id){
/**
public function addCertification($data=array()){
			$data['status']=1;
			$data['applicationTime']=$this->system->getSystemTime('A');
			$data['operatorName']=$this->session->getSession('Merchant','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$rows>0 && $bool=true;
/**
public function saveCertification($id,$data){
		$data['operationTime']=$this->system->getSystemTime('A');
/**
public function delete($id){
/**
public function checkCertification($name=NULL,$id=NULL){
			if(!empty($brand) && count($brand)>0) return false; 
/**
public function findCertification($where=array()){
/**
public function search($title,$id){
/**
public function getTotal($id){
    	$one=$this->data->select(13,array("status"=>1,"id"=>$id));
    	$one=count($one)==1?$one[0]:array("isCompany"=>-1);
 ***********************************************************
 *方法::CertificationService::getTotal
 * ----------------------------------------------------------
 *描述::获取所有记录行数
 *----------------------------------------------------------
 *参数:
 *parm1:in--    无
 *----------------------------------------------------------
 *返回：
 *return:out--  无
 * ----------------------------------------------------------
 *日期:2017.03.03  Add by zwx
 ************************************************************
 */
public function getSearchTotal($title,$id){
	try{
		#.获取数据基础信息
		$one=$this->data->select(13,array("status"=>1,"id"=>$id));
		$one=count($one)==1?$one[0]:array("isCompany"=>-1);
		$rows=$this->model->getSearch(2,$one['isCompany'],$title==NULL?NULL:$title,$id);
		return  $rows>0?$rows:0;
	}catch(Exception $e) {
		$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
		$log->error();
	}
}
 ***********************************************************
 *方法::CertificationService::findMerchant
 * ----------------------------------------------------------
 *描述::获取集团列表
 *----------------------------------------------------------
 *参数:
 *parm1:in--    无
 *----------------------------------------------------------
 *返回：
 *return:out--  无
 * ----------------------------------------------------------
 *日期:2017.03.03  Add by zwx
 ************************************************************
 */
		$bool=Array();
		$find=$this->data->select(13,array("status"=>1,"isCompany<>"=>$type,"auditStatus"=>1));
		(!empty($find) && count($find)>0) && $bool=$find;
		return $bool;
	}catch(Exception $e) {
		$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
		$log->error();
	}
}