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
public function update(){ 
/**
public function updated(){ 
	if($this->service->checkFeedback(NULL,$data['id'])){
		$data['operatorName']=$this->session->getSession('Admin','loginName');
		$data['operationTime']=$this->system->getSystemTime('A');
		$this->service->saveFeedback($data['id'],$data) && $mess=$this->system->remind(1);
	}else{
		$mess=$this->system->remind(4);
	}
	$this->load->view('admin/message.html',$mess);
/**
public function delete(){ 
/**
public function search(){ 
	!empty($_POST) && $this->session->setSession($_POST,'feedSearch');
	$session=$this->session->getSession('feedSearch');
	$find=empty($_GET['p'])?1:$_GET['p'];
	$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getSearchTotal($session['name'],$session['status'],$session['types'],$session['startFeedDate'],$session['lastFeedDate'],$session['startReplyDate'],$session['lastReplyDate'],$session['baseType'],$session['satisfaction'],$session['operatorName']),100,$find);
	$data["page"]=$page->showPage();
	$data['name']=$this->getProviderNames();
	$data["list"]=$this->service->search($session['name'],$session['status'],$session['types'],$session['startFeedDate'],$session['lastFeedDate'],$session['startReplyDate'],$session['lastReplyDate'],$session['baseType'],$session['satisfaction'],$session['operatorName'],$find);
/**
public function check(){
 ***********************************************************
 *方法::Feedback::getProviderNames
 * ----------------------------------------------------------
 * 描述::获取所有商户的名称
 *----------------------------------------------------------
 *参数:
 *parm2:in--    无
 *----------------------------------------------------------
 *返回：
 *return:out--  无
 * ----------------------------------------------------------
 * 日期:2017.03.01  Add by zwx
 ************************************************************
 */
public function getProviderNames(){
	$list=$this->service->findProvider();
	$nameArray=array();
	foreach($list as $l){$nameArray[]=$l['name'];}
	return implode(",",$nameArray);
}
}