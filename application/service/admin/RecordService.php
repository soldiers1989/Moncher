<?php
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
/**
public function __construct(){
	/**
	public function getList($questionnaireId,$providerId,$groupId,$brandId,$areaId,$startTime,$endTime,$page){
	}
	/**
	public function getTotal($questionnaireId,$providerId,$groupId,$brandId,$areaId,$startTime,$endTime){
	public  function getMerchantList($groupid){
		return $this->model->getMerchantList($groupid);
	}
	/**获取搜索条件*/
	public function getBrandList($groupid){
		return $this->model->getBrandList($groupid);
	}
	/**获取搜索条件*/
	public function getAreaList($groupid){
		return $this->model->getAreaList($groupid);
	}
	/**获取搜索条件*/
	public function getGroupList($modelid){
		return $this->model->getGroupList($modelid);
	}
	/**获取搜索条件*/
	public function getModelList(){
		return $this->data->select(27,array("status"=>1));
	}
		try{
			$bool=Array();
			$list=$this->model->getRecordList(3,$questionnaireId,$providerId,$groupId,$brandId,$areaId,$startTime,$endTime);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
}