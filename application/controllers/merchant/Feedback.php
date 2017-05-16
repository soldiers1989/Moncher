<?php 
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Feedback extends CI_Controller {	
#.引用属性，每个控制器都需要有	
private $includes;	
/**	
public function __construct(){ 	
/**	
public function index(){ 
/** 
public function add(){ 
/** 
public function update(){ 
	$data['one']=count($one)>0?$one[0]:array();
/** 
public function added(){ 
	$mess=$this->system->remind();
	$logo=!empty($upload)?$upload->getUrls(1):NULL;
	$data['operatorName']=$this->session->getSession('Merchant','loginName');
	$data['operationTime']=$this->system->getSystemTime('A');
	$this->service->addFeedback($data) && $mess=$this->system->remind(1);
 ***********************************************************
 *方法::Feedback::updated
 * ----------------------------------------------------------
 *描述::平台意见反馈修改数据方法
 *----------------------------------------------------------
 *参数:
 *parm2:in--    无
 *----------------------------------------------------------
 *返回：
 *return:out--  无
 * ----------------------------------------------------------
 *日期:2017.03.01  Add by zwx
 ************************************************************
 */
public function updated(){
	$data=$_POST;
	$mess=$this->system->remind();
	if($this->service->checkFeedback(NULL,$data['id'])){
		$data['operatorName']=$this->session->getSession('Merchant','loginName');
		$data['operationTime']=$this->system->getSystemTime('A');
		$this->service->saveFeedback($data['id'],$data) && $mess=$this->system->remind(1);
	}else{
		$mess=$this->system->remind(4);
	}
	$this->load->view('admin/message.html',$mess);
}
/**
public function search(){ 
/**
public function check(){
}