<?php /***************************************************** **作者：张文晓	**创始时间：2017-03-03	**描述：商户端认证控制器类	*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Certification extends CI_Controller {	
#.引用属性，每个控制器都需要有	
private $includes;	private $session;private $system;private $service;
/**	 ***********************************************************	 *方法::Certification::__construct * ----------------------------------------------------------	 *描述::商户端认证初始化方法 *----------------------------------------------------------	; *参数:	  *parm2:in--    无	  *----------------------------------------------------------		  *返回：	  *return:out--  无	  * ----------------------------------------------------------		  *日期:2017.03.03  Add by zwx		  ************************************************************		 */
public function __construct(){ 		parent::__construct(); 	$this->includes=new Includes(__FILE__); 	$this->includes->libraries("CurrSystem"); 	$this->includes->libraries("CurrLog"); 	$this->includes->libraries("CurrPage"); 	$this->includes->libraries("CurrSession");	$this->includes->services("CertificationService"); 	$this->includes->services("InformationService");    $this->session=new CurrSession();	$this->system=new CurrSystem;	$this->service=new CertificationService();	$this->load->helper("url"); }
/**	************************************************************方法::Certification::index * ---------------------------------------------------------- *描述::商户端认证列表主页*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.03  Add by zwx		 *************************************************************/
public function index(){ 	$this->session->checkSession('Merchant');	$service=new InformationService();	$data['one']=$service->getInformation($this->session->getSession("Merchant","providerId"));	$find=empty($_GET["p"])?1:$_GET["p"];	$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getTotal($this->session->getSession("Merchant","providerId")),20,$find);	$data["page"]=$page->showPage();	$data["list"]=$this->service->getList($this->session->getSession("Merchant","providerId"),$find);	$log=new CurrLog(3,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"商户端认证","",1,NULL);    $log->write();	$this->load->view("merchant/CertiList.html",$data);}
/**  ************************************************************方法::Certification::add* ----------------------------------------------------------*描述::商户端认证新增页面*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.03  Add by zwx	*************************************************************/
public function add(){ 	$this->session->checkSession('Merchant');	$data['name']=$this->getMerchantNames(1);	$this->load->view("merchant/CertiAdd.html",$data);}
/**  *********************************************************** *方法::Certification::added * ---------------------------------------------------------- *描述::商户端认证新增数据方法 *---------------------------------------------------------- *参数: *parm2:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- *日期:2017-03-03  Add by zwx ************************************************************ */
public function added(){ 	$this->session->checkSession('Merchant');	$data=$_POST;	$mess=$this->system->remind();
	if($this->service->checkCertification($data['title'],NULL)){
		$this->service->addCertification($data) && $mess=$this->system->remind(1);
	}else{
		$mess=$this->system->remind(5);
	}	$log=new CurrLog(3,6,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"商户端认证","",1,NULL);
	$log->write();
	$this->load->view('admin/message.html',$mess);}
/** *********************************************************** *方法::Certification::updated * ---------------------------------------------------------- *描述::商户端认证修改数据方法 *---------------------------------------------------------- *参数: *parm2:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- *日期:2017.03.03  Add by zwx ************************************************************ */
public function updated(){ 	$this->session->checkSession('Merchant');    header("Access-Control-Allow-Origin: *");    $one=$this->service->findCertification(array("status"=>1,"id"=>$_GET["id"]));	echo $this->service->saveCertification($_GET["id"],$_GET) ? 4000:4004; 	$log=new CurrLog(3,4,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"商户端认证","",1,$_GET["id"]);    $log->write();}
/**************************************************************方法::Certification::delete* ----------------------------------------------------------*描述::商户端认证删除方法*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.03  Add by zwx*************************************************************/
public function delete(){ 	$this->session->checkSession('Merchant');	header("Access-Control-Allow-Origin: *");	echo $this->service->delete($_GET["id"]) ? 4000:4004; 	$log=new CurrLog(3,4,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"商户端认证","",1,$_GET["id"]);    $log->write();}
/**************************************************************方法::Certification::search* ----------------------------------------------------------*描述::商户端认证搜索方法*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.03  Add by zwx*************************************************************/
public function search(){ 	$this->session->checkSession('Merchant');	$service=new InformationService();	$data['one']=$service->getInformation($this->session->getSession("Merchant","providerId"));	$find=empty($_GET["p"])?1:$_GET["p"];	$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getSearchTotal($_POST['title'],$this->session->getSession("Merchant","providerId")),20,$find);	$data["page"]=$page->showPage();	$data["list"]=$this->service->search($_POST['title'],$this->session->getSession("Merchant","providerId"));	$log=new CurrLog(3,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"商户端认证","",1,NULL);    $log->write();	$this->load->view("merchant/CertiList.html",$data);}
/**************************************************************方法::Certification::check* ----------------------------------------------------------*描述::检测记录状态接口*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.03  Add by zwx*************************************************************/
public function check(){	$this->session->checkSession('Merchant');	header("Access-Control-Allow-Origin: *");	echo $this->service->checkCertification(NULL,$_GET["id"]) ? 4000:4004;}/**
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
 */private function getMerchantNames($type){	$this->session->checkSession('Merchant');	$list=$this->service->findMerchant($type);	$nameArray=array();
	foreach($list as $l){$nameArray[]=$l['name'];}
	return implode(",",$nameArray);}
}