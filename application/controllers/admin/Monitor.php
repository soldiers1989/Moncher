<?php 
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Monitor extends CI_Controller {	
#.引用属性，每个控制器都需要有	
		private $includes;	
	/**	
	public function __construct(){ 	
	/**	
	public function index(){
		$data['areaid']=empty($_POST['areaid'])?0:$_POST['areaid'];
		$data['providerid']=empty($_POST['providerid'])?0:$_POST['providerid'];
		$data=array();
		$data['area']=$this->service->getAreaList($_POST['groupid']);
		$data['brand']=$this->service->getBrandList($_POST['groupid']);
		$data['merchant']=$this->service->getMerchantList($_POST['groupid']);
		echo json_encode($data);
}