<?php /***************************************************** **作者：张文晓	**创始时间：2017-03-01	**描述：平台系统消息控制器类	*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Messages extends CI_Controller {	
#.引用属性，每个控制器都需要有	
private $includes;	private $session;private $system;private $service;
/**	 ***********************************************************	 *方法::Messages::__construct * ----------------------------------------------------------	 *描述::平台系统消息初始化方法 *----------------------------------------------------------	; *参数:	  *parm2:in--    无	  *----------------------------------------------------------		  *返回：	  *return:out--  无	  * ----------------------------------------------------------		  *日期:2017.03.01  Add by zwx		  ************************************************************		 */
public function __construct(){ 		parent::__construct(); 	$this->includes=new Includes(__FILE__); 	$this->includes->libraries("CurrSystem"); 	$this->includes->libraries("CurrLog"); 	$this->includes->libraries("CurrPage"); 	$this->includes->services("MessagesService"); 	$this->includes->services("AreaService");	$this->includes->services("BrandService");	$this->includes->libraries("CurrSession");	$this->includes->libraries("CurrUpload");    $this->session=new CurrSession();	$this->system=new CurrSystem;	$this->service=new MessagesService();	$this->load->helper("url"); }
/**	************************************************************方法::Messages::index * ---------------------------------------------------------- *描述::平台系统消息列表主页*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx		 *************************************************************/
public function index(){ 	$find=empty($_GET["p"])?1:$_GET["p"];	$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getTotal(),100,$find);	$area=new AreaService();
	$brand=new BrandService();
	$data['area']=$area->findArea(array("status"=>1,"parentId"=>0));
	$data['brand']=$brand->findBrand(array("status"=>1,"parentId"=>0));	$data["page"]=$page->showPage();	$data["list"]=$this->service->getList($find);	$data['name']=$this->getProviderNames();	$log=new CurrLog(2,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"平台系统消息","",7,NULL);    $log->write();	$this->load->view("admin/MessagesList.html",$data);}
/**  ************************************************************方法::Messages::add* ----------------------------------------------------------*描述::平台系统消息新增页面*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx	*************************************************************/
public function add(){ 	$area=new AreaService();	$brand=new BrandService();	$data['area']=$area->findArea(array("status"=>1,"parentId"=>0));	$data['brand']=$brand->findBrand(array("status"=>1,"parentId"=>0));	$data['group']=$this->service->findGro();	$this->load->view("admin/MessagesAdd.html",$data);}
/** ************************************************************方法::Messages::update* ----------------------------------------------------------*描述::平台系统消息修改页面*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx *************************************************************/
public function update(){ 	$area=new AreaService();
	$brand=new BrandService();
	$data['area']=$area->findArea(array("status"=>1,"parentId"=>0));
	$data['brand']=$brand->findBrand(array("status"=>1,"parentId"=>0));	$one=$this->service->getMessages($_GET['id']);
	$data['one']=count($one)>0?$one[0]:array();	$log=new CurrLog(2,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"平台系统消息","",7,$_GET["id"]);    $log->write();	$this->load->view("admin/MessagesUpdate.html",$data);}
/**  *********************************************************** *方法::Messages::added * ---------------------------------------------------------- *描述::平台系统消息新增数据方法 *---------------------------------------------------------- *参数: *parm2:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- *日期:2017-03-01  Add by zwx ************************************************************ */
public function added(){ 	$data=$_POST;	(($data['groId']>0 && $data['merId']<=0)   &&  $data['groupId']=$data['groId'])  ||	(($data['groId']>0 && $data['merId']>0)      &&  $data['groupId']=$data['merId']) ||	(($data['groId']<=0 && $data['merId']<=0) &&  $data['groupId']=0);	unset($data['groId']);unset($data['merId']);	$mess=$this->system->remind();	$data['status']=1;	$data['operatorName']=$this->session->getSession('Admin','loginName');
	$data['operationTime']=$this->system->getSystemTime('A');
	$this->service->addMessages($data) && $mess=$this->system->remind(1);	$log=new CurrLog(2,6,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"平台系统消息","",7,NULL);    $log->write();    $this->load->view('admin/message.html',$mess);}
/** *********************************************************** *方法::Messages::updated * ---------------------------------------------------------- *描述::平台系统消息修改数据方法 *---------------------------------------------------------- *参数: *parm2:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- *日期:2017.03.01  Add by zwx ************************************************************ */
public function updated(){ 	$data=$_POST;
	(($data['groId']>0 && $data['merId']<=0)   &&  $data['groupId']=$data['groId'])  ||
	(($data['groId']>0 && $data['merId']>0)      &&  $data['groupId']=$data['merId']) ||
	(($data['groId']<=0 && $data['merId']<=0) &&  $data['groupId']=0);
	unset($data['groId']);unset($data['merId']);
	$mess=$this->system->remind();	if($this->service->checkMessages(NULL,$data['id'])){		$data['operatorName']=$this->session->getSession('Admin','loginName');
		$data['operationTime']=$this->system->getSystemTime('A');
		$this->service->saveMessages($data['id'],$data) && $mess=$this->system->remind(1);	}else{		$mess=$this->system->remind(4);	}	$this->load->view('admin/message.html',$mess);}
/**************************************************************方法::Messages::delete* ----------------------------------------------------------*描述::平台系统消息删除方法*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx*************************************************************/
public function delete(){ 	header("Access-Control-Allow-Origin: *");	echo $this->service->delete($_GET["id"]) ? 4000:4004; 	$log=new CurrLog(2,4,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"平台系统消息","",7,$_GET["id"]);    $log->write();}
/**************************************************************方法::Messages::search* ----------------------------------------------------------*描述::平台系统消息搜索方法*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx*************************************************************/
public function search(){ 	$this->session->checkSession('Admin');	$area=new AreaService();
	$brand=new BrandService();
	!empty($_POST) && $this->session->setSession($_POST,'messageSearch');
	$session=$this->session->getSession('messageSearch');
	$find=empty($_GET['p'])?1:$_GET['p'];	$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getSearchTotal($session['name'],$session['types'],$session['mark'],$session['startPublicDate'],$session['lastPublicDate'],$session['startPushDate'],$session['lastPushDate'],$session['areaId'],$session['brandId'],$session['operatorName']),100,$find);
	$data["page"]=$page->showPage();	$data['name']=$this->getProviderNames();
	$data['area']=$area->findArea(array("status"=>1,"parentId"=>0));
	$data['brand']=$brand->findBrand(array("status"=>1,"parentId"=>0));	$data['POSTS']=$session;
	$data["list"]=$this->service->search($session['name'],$session['types'],$session['mark'],$session['startPublicDate'],$session['lastPublicDate'],$session['startPushDate'],$session['lastPushDate'],$session['areaId'],$session['brandId'],$session['operatorName'],$find);	$log=new CurrLog(2,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"平台系统消息","",7,NULL);    $log->write();	$this->load->view("admin/MessagesList.html",$data);}
/**************************************************************方法::Messages::check* ----------------------------------------------------------*描述::检测记录状态接口*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx*************************************************************/
public function check(){	header("Access-Control-Allow-Origin: *");	echo $this->service->checkMessages(NULL,$_GET["id"]) ? 4000:4004;}/**
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
}/**
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
 */public function getProviderNames(){
	$list=$this->service->findProvider();
	$nameArray=array();
	foreach($list as $l){$nameArray[]=$l['name'];}
	return implode(",",$nameArray);}
}