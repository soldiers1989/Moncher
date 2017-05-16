<?php 
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Messages extends CI_Controller {	
#.引用属性，每个控制器都需要有	
private $includes;	
/**	
public function __construct(){ 	
/**	
public function index(){ 
	$brand=new BrandService();
	$data['area']=$area->findArea(array("status"=>1,"parentId"=>0));
	$data['brand']=$brand->findBrand(array("status"=>1,"parentId"=>0));
/** 
public function add(){ 
/** 
public function update(){ 
	$brand=new BrandService();
	$data['area']=$area->findArea(array("status"=>1,"parentId"=>0));
	$data['brand']=$brand->findBrand(array("status"=>1,"parentId"=>0));
	$data['one']=count($one)>0?$one[0]:array();
/** 
public function added(){ 
	$data['operationTime']=$this->system->getSystemTime('A');
	$this->service->addMessages($data) && $mess=$this->system->remind(1);
/**
public function updated(){ 
	(($data['groId']>0 && $data['merId']<=0)   &&  $data['groupId']=$data['groId'])  ||
	(($data['groId']>0 && $data['merId']>0)      &&  $data['groupId']=$data['merId']) ||
	(($data['groId']<=0 && $data['merId']<=0) &&  $data['groupId']=0);
	unset($data['groId']);unset($data['merId']);
	$mess=$this->system->remind();
		$data['operationTime']=$this->system->getSystemTime('A');
		$this->service->saveMessages($data['id'],$data) && $mess=$this->system->remind(1);
/**
public function delete(){ 
/**
public function search(){ 
	$brand=new BrandService();
	!empty($_POST) && $this->session->setSession($_POST,'messageSearch');
	$session=$this->session->getSession('messageSearch');
	$find=empty($_GET['p'])?1:$_GET['p'];
	$data["page"]=$page->showPage();
	$data['area']=$area->findArea(array("status"=>1,"parentId"=>0));
	$data['brand']=$brand->findBrand(array("status"=>1,"parentId"=>0));
	$data["list"]=$this->service->search($session['name'],$session['types'],$session['mark'],$session['startPublicDate'],$session['lastPublicDate'],$session['startPushDate'],$session['lastPushDate'],$session['areaId'],$session['brandId'],$session['operatorName'],$find);
/**
public function check(){
 ***********************************************************
 *方法::Message::addPic
 * ----------------------------------------------------------
 * 描述::上传图片接口
 *----------------------------------------------------------
 *参数:
 *parm2:in--    无
 *----------------------------------------------------------
 *返回：
 *return:out--  无
 * ----------------------------------------------------------
 * 日期:2017.02.08  Add by zwx
 ************************************************************
 */
public function addPic(){
	header('Access-Control-Allow-Origin: *');
	$upload=new CurrUpload(array("max"=>1024,"min"=>1,"path"=>'./upload/admin/images/',"files"=>$_FILES));
	$logo=!empty($upload)?$upload->getUrls(1):NULL;
	echo json_encode($logo);
}
 ***********************************************************
 *方法::Message::getProviderNames
 * ----------------------------------------------------------
 * 描述::获取所有商户的名称
 *----------------------------------------------------------
 *参数:
 *parm2:in--    无
 *----------------------------------------------------------
 *返回：
 *return:out--  无
 * ----------------------------------------------------------
 * 日期:2017.02.08  Add by zwx
 ************************************************************
 */
	$list=$this->service->findProvider();
	$nameArray=array();
	foreach($list as $l){$nameArray[]=$l['name'];}
	return implode(",",$nameArray);
}