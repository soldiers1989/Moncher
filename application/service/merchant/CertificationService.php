<?php/***************************************************** **作者：张文晓**创始时间：2017-03-03**描述：商户端认证service类。*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");class CertificationService{	#.引用属性，每个控制器都需要有	private $includes;	private $data;	private $model;	private $item=26;	private $system;	private $session;
/** *********************************************************** *方法::CertificationService::__construct * ---------------------------------------------------------- *描述::商户端认证service类初始化方法 *---------------------------------------------------------- *参数: *parm1:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- * 日期:2017.03.03  Add by zwx ************************************************************ */
public function __construct(){	$this->includes=new Includes(__FILE__);	$this->includes->models("DataBase","global");	$this->includes->models("CertificationModel");	$this->includes->libraries("CurrSystem");    $this->includes->libraries("CurrLog");    $this->includes->libraries("CurrSession");    $this->session=new CurrSession();    $this->system=new CurrSystem();	$this->model=new CertificationModel();    $this->data=new DataBase();}
/** *********************************************************** *方法::CertificationService::getList * ---------------------------------------------------------- * 描述::商户端认证service类获取列表方法 *---------------------------------------------------------- *参数: *parm1:in--    无 *---------------------------------------------------------- *返回： *return:out--  Array :: bool :: 返回数据列表 * ---------------------------------------------------------- * 日期:2017.03.03  Add by zwx ************************************************************ */
public function getList($id,$page){    try{		$bool=Array();		#.获取数据基础信息
		$one=$this->data->select(13,array("status"=>1,"id"=>$id));
		$one=count($one)==1?$one[0]:array("isCompany"=>-1);		$list=$this->model->getCertificationList(1,$one['isCompany'],$id,($page-1)*20,20);		(!empty($list) && count($list)>0) && $bool=$list;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::CertificationService::getCertification * ---------------------------------------------------------- * 描述::商户端认证service类获取数据详情 *---------------------------------------------------------- *参数: *parm2:in--   String :: id  			::需要获取的id *---------------------------------------------------------- *返回： *return:out--  String :: bool   ::已经获取的数组列表 * ---------------------------------------------------------- * 日期:2017.03.03  Add by zwx ************************************************************ */
public function getCertification($id){    try{		$bool=Array();		$area=$this->data->select($this->item,array("status"=>1,"id"=>$id));		(!empty($area) && count($area)>0) && $bool=$area[0];		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::CertificationService:addCertification * ---------------------------------------------------------- * 描述::商户端认证service类新增数据方法 *---------------------------------------------------------- *参数: *parm1:in--    Array :: data :: 需要新增的数据 *---------------------------------------------------------- *返回： *return:out--  Array :: bool :: 新增成功id * ---------------------------------------------------------- * 日期:2017.03.03  Add by zwx ************************************************************ */
public function addCertification($data=array()){    try{		$bool=false;		#.查询商户id		$one=$this->data->select(13,array("status"=>1,"name"=>$data['title']));unset($data['title']);		if(count($one)>0){			$data['pId']=$one[0]['id'];			$data['providerId']=$this->session->getSession('Merchant','providerId');			$data['certificationStatus']=0;
			$data['status']=1;
			$data['applicationTime']=$this->system->getSystemTime('A');
			$data['operatorName']=$this->session->getSession('Merchant','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');			$rows=$this->data->insert($this->item,$data);
			$rows>0 && $bool=true;		}		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,6,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::CertificationService::saveCertification * ---------------------------------------------------------- * 描述::商户端认证service类保存数据方法 *---------------------------------------------------------- *参数: *parm1:in--    String :: id     :: 需要保存的id *parm2:in--    Array :: data  ::需要保存的数据 *---------------------------------------------------------- *返回： *return:out--  Array :: bool :: 操作成功状态 * ---------------------------------------------------------- * 日期:2017.03.03  Add by zwx ************************************************************ */
public function saveCertification($id,$data){    try{		$bool=false;		$data['certificationStatus']==1 && $data['processingTime']=$this->system->getSystemTime("A");		$data['operatorName']=$this->session->getSession('Merchant','loginName');
		$data['operationTime']=$this->system->getSystemTime('A');		$rows=$this->data->update($this->item,$id,$data);		$rows>0 && $bool=true;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,5,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::CertificationService::delete * ---------------------------------------------------------- * 描述::商户端认证service类删除数据方法 *---------------------------------------------------------- *参数: *parm1:in--    String :: id        :: 需要删除的id *---------------------------------------------------------- *返回： *return:out--  Array :: bool     :: 验证状态 * ---------------------------------------------------------- * 日期:2017.03.03  Add by zwx ************************************************************ */
public function delete($id){    try{		$bool=false;		$rows=$this->data->delete($this->item,$id);		$rows>0 && $bool=true;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,4,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/**************************************************************方法::CertificationService::checkCertification* ----------------------------------------------------------* 描述::商户端认证service类检测名称或者记录的状态*----------------------------------------------------------*参数:*parm1:in--    String :: id        :: 需要获取的id*parm2:in--    String :: name  ::需要验证的名称*----------------------------------------------------------*返回：*return:out--  Array :: bool :: 验证状态* ----------------------------------------------------------* 日期:2017.03.03  Add by zwx*************************************************************/
public function checkCertification($name=NULL,$id=NULL){    try{		$bool=false;		#.检测商户是否存在		if(!empty($name)){			$muses=$this->model->getProvider($name);			$brand=$this->model->getCertificationProvider($this->session->getSession("Merchant","providerId"),$muses['isCompany']);
			if(!empty($brand) && count($brand)>0) return false; 			$rows=$this->model->getCertification($name,$this->session->getSession("Merchant","providerId"));			if (empty($rows) && count($rows)<=0) return true;		}		#.检测商户状态		!empty($id) && $where=array("status"=>1,"id"=>$id);		$rows=$this->data->select($this->item,$where);		(!empty($rows) && count($rows)>0) && $bool=true;		 return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::CertificationService::findCertification * ---------------------------------------------------------- * 描述::商户端认证service类提供给外部调用的查找方法 *---------------------------------------------------------- *参数: *parm1:in--    Array :: where  ::需要查找的条件 *---------------------------------------------------------- *返回： *return:out--  String :: bool   ::返回数据列表 * ---------------------------------------------------------- * 日期:2017.03.03  Add by zwx ************************************************************ */
public function findCertification($where=array()){    try{		$bool=NULL;		$find=$this->data->select($this->item,empty($where)?array("status"=>1):$where);		(!empty($find) && count($find)>0) && $bool=$find;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::CertificationService::search * ---------------------------------------------------------- * 描述::商户端认证service类页面搜索方法 *---------------------------------------------------------- *参数: *parm1:in--    Array :: where  ::需要查找的条件 *---------------------------------------------------------- *返回： *return:out--  String :: bool   ::返回数据列表 * ---------------------------------------------------------- * 日期:2017.03.03  Add by zwx ************************************************************ */
public function search($title,$id){	try{		#.获取数据基础信息		$one=$this->data->select(13,array("status"=>1,"id"=>$id));		$one=count($one)==1?$one[0]:array("isCompany"=>-1);		$rows=$this->model->getSearch(1,$one['isCompany'],$title==NULL?NULL:$title,$id);		return  empty($rows)?array():$rows;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/**************************************************************方法::CertificationService::getTotal* ----------------------------------------------------------*描述::获取所有记录行数*----------------------------------------------------------*参数:*parm1:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.03  Add by zwx*************************************************************/
public function getTotal($id){    try{    	#.获取数据基础信息
    	$one=$this->data->select(13,array("status"=>1,"id"=>$id));
    	$one=count($one)==1?$one[0]:array("isCompany"=>-1);		$rows=$this->model->getCertificationList(2,$one['isCompany'],$id);		return  $rows>0?$rows:0;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}/**
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
}/**
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
 */public function findMerchant($type){	try{
		$bool=Array();
		$find=$this->data->select(13,array("status"=>1,"isCompany<>"=>$type,"auditStatus"=>1));
		(!empty($find) && count($find)>0) && $bool=$find;
		return $bool;
	}catch(Exception $e) {
		$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
		$log->error();
	}}
}