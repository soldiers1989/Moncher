<?php 
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Certification extends CI_Controller {	
#.引用属性，每个控制器都需要有	
private $includes;	
/**	
public function __construct(){ 	
/**	
public function index(){ 
/** 
public function add(){ 
/** 
public function added(){ 
	if($this->service->checkCertification($data['title'],NULL)){
		$this->service->addCertification($data) && $mess=$this->system->remind(1);
	}else{
		$mess=$this->system->remind(5);
	}
	$log->write();
	$this->load->view('admin/message.html',$mess);
/**
public function updated(){ 
/**
public function delete(){ 
/**
public function search(){ 
/**
public function check(){
 ***********************************************************
 *方法::Certification::getMerchantNames
 * ----------------------------------------------------------
 *描述::获取商户名称列表
 *----------------------------------------------------------
 *参数:
 *parm2:in--    无
 *----------------------------------------------------------
 *返回：
 *return:out--  无
 * ----------------------------------------------------------
 *日期:2017.03.03  Add by zwx
 ************************************************************
 */
	foreach($list as $l){$nameArray[]=$l['name'];}
	return implode(",",$nameArray);
}