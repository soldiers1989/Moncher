<?php
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
	/**
	public function __construct(){
	/**
	public function getList($Pid,$page){
	/**
	public function getMerchantNav($Pid,$id=0){
	/**
	public function addMerchantNav($data=array()){
	/**
	public function saveMerchantNav($id,$data){
	/**
	public function delete($id){
	/**
	public function checkMerchantNav($name=NULL,$id=NULL){
	/**
	public function findMerchantNav($where=array()){
	/**
	public function getTotal($Pid){
	 ***********************************************************
	 *方法::MerchantNav::search
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束
	 *parm4:in--    String :: Pid    :: 父级id
	 *parm5:in--    String :: navTitle   ::导航标题
	 *parm6:in--    String :: startDate ::起始时间
	 *parm7:in--    String :: lastDate   ::结束时间
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function search($Pid,$navTitle,$startDate,$lastDate,$page){
		try{
			$bool=NULL;
			$model=new MerchantNavModel();
			$menu=$model->getSearch(1,$Pid!=NULL?$Pid:NULL,$navTitle!=NULL?$navTitle:NULL,$startDate!=NULL?$startDate:NULL,$lastDate!=NULL?$lastDate:NULL,($page-1)*20,20);
			(!empty($menu) && count($menu)>0) && $bool=$menu;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::MerchantNav::getSearchTotal
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束
	 *parm4:in--    String :: Pid    :: 父级id
	 *parm5:in--    String :: navTitle   ::导航标题
	 *parm6:in--    String :: startDate ::起始时间
	 *parm7:in--    String :: lastDate   ::结束时间
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function getSearchTotal($Pid,$navTitle,$startDate,$lastDate){
		try{
			$model=new MerchantNavModel();
			$rows=$model->getSearch(2,$Pid!=NULL?$Pid:NULL,$navTitle!=NULL?$navTitle:NULL,$startDate!=NULL?$startDate:NULL,$lastDate!=NULL?$lastDate:NULL);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
}