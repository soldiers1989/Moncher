<?php
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
/**
public function __construct(){
/**
public function getList($page){
/**
public function getFeedback($id){
/**
public function addFeedback($data=array()){
/**
public function saveFeedback($id,$data){
/**
public function delete($id){
/**
public function checkFeedback($name=NULL,$id=NULL){
/**
public function findFeedback($where=array()){
/**
public function search($name,$status,$types,$startFeedTime,$lastFeedTime,$startReplyTime,$lastReplyTime,$baseType,$satisfaction,$operatorName,$page){
    	$list=$this->model->getSearch(1,$name!=NULL?$name:NULL,$status!=NULL?$status:NULL,$types!=NULL?$types:NULL,$startFeedTime!=NULL?$startFeedTime:NULL,$lastFeedTime!=NULL?$lastFeedTime:NULL,$startReplyTime!=NULL?startReplyTime:NULL,$lastReplyTime!=NULL?$lastReplyTime:NULL,$baseType!=NULL?$baseType:NULL,$satisfaction!=NULL?$satisfaction:NULL,$operatorName!=NULL?$operatorName:NULL,($page-1)*100,100);
    	(!empty($list) && count($list)>0) && $bool=$list;
    	return $bool;
public function getTotal(){
/**
 ***********************************************************
 *方法::FeedbackService::getSearchTotal
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
public function getSearchTotal($name,$status,$types,$startFeedTime,$lastFeedTime,$startReplyTime,$lastReplyTime,$baseType,$satisfaction,$operatorName){
	try{
		$rows=$this->model->getSearch(2,$name!=NULL?$name:NULL,$status!=NULL?$status:NULL,$types!=NULL?$types:NULL,$startFeedTime!=NULL?$startFeedTime:NULL,$lastFeedTime!=NULL?$lastFeedTime:NULL,$startReplyTime!=NULL?startReplyTime:NULL,$lastReplyTime!=NULL?$lastReplyTime:NULL,$baseType!=NULL?$baseType:NULL,$satisfaction!=NULL?$satisfaction:NULL,$operatorName!=NULL?$operatorName:NULL);
		return  $rows>0?$rows:0;
	}catch(Exception $e) {
		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
		$log->error();
	}
}
 ***********************************************************
 *方法::FeedbackService::findProvider
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
public function findProvider(){
	try{
		$bool=Array();
		$find=$this->data->select(13,array("status"=>1));
		(!empty($find) && count($find)>0) && $bool=$find;
		return $bool;
	}catch(Exception $e) {
		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
		$log->error();
	}
}
}