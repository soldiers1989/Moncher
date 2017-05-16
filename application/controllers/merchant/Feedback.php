<?php /***************************************************** **作者：张文晓	**创始时间：2017-02-28	**描述：商户端意见反馈控制器类	*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Feedback extends CI_Controller {	
#.引用属性，每个控制器都需要有	
private $includes;	private $session;private $system;private $service;
/**	 ***********************************************************	 *方法::Feedback::__construct * ----------------------------------------------------------	 *描述::商户端意见反馈初始化方法 *----------------------------------------------------------	; *参数:	  *parm2:in--    无	  *----------------------------------------------------------		  *返回：	  *return:out--  无	  * ----------------------------------------------------------		  *日期:2017.02.28  Add by zwx		  ************************************************************		 */
public function __construct(){ 		parent::__construct(); 	$this->includes=new Includes(__FILE__); 	$this->includes->libraries("CurrSystem"); 	$this->includes->libraries("CurrLog"); 	$this->includes->libraries("CurrPage"); 	$this->includes->libraries("CurrUpload");	$this->includes->services("FeedbackService"); 	$this->includes->libraries("CurrSession");    $this->session=new CurrSession();	$this->system=new CurrSystem;	$this->service=new FeedbackService();	$this->load->helper("url"); }
/**	************************************************************方法::Feedback::index * ---------------------------------------------------------- *描述::商户端意见反馈列表主页*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.02.28  Add by zwx		 *************************************************************/
public function index(){ 	$this->session->checkSession('Merchant');	$find=empty($_GET["p"])?1:$_GET["p"];	$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getTotal(),20,$find);	$data["page"]=$page->showPage();	$data["list"]=$this->service->getList($find);	$log=new CurrLog(3,3,$this->session->getSession('Merchant',"loginName"),$this->system->getSystemTime("A"),"商户端意见反馈","",8,NULL);    $log->write();	$this->load->view("merchant/FeedbackList.html",$data);}
/**  ************************************************************方法::Feedback::add* ----------------------------------------------------------*描述::商户端意见反馈新增页面*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.02.28  Add by zwx	*************************************************************/
public function add(){ 	$this->session->checkSession('Merchant');	$this->load->view("merchant/FeedbackAdd.html");}
/** ************************************************************方法::Feedback::update* ----------------------------------------------------------*描述::商户端意见反馈修改页面*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.02.28  Add by zwx *************************************************************/
public function update(){ 	$this->session->checkSession('Merchant');	$one=$this->service->getFeedback($_GET['id']);
	$data['one']=count($one)>0?$one[0]:array();	$log=new CurrLog(3,3,$this->session->getSession('Merchant',"loginName"),$this->system->getSystemTime("A"),"商户端意见反馈","",8,$_GET["id"]);    $log->write();	$this->load->view("merchant/FeedbackUpdate.html",$data);}
/**  *********************************************************** *方法::Feedback::added * ---------------------------------------------------------- *描述::商户端意见反馈新增数据方法 *---------------------------------------------------------- *参数: *parm2:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- *日期:2017-02-28  Add by zwx ************************************************************ */
public function added(){ 	$this->session->checkSession('Merchant');	$data=$_POST;
	$mess=$this->system->remind();	!empty($_FILES['picture']['name']) && $upload=new CurrUpload(array("max"=>1024,"min"=>1,"path"=>'./upload/merchant/images/',"files"=>$_FILES));
	$logo=!empty($upload)?$upload->getUrls(1):NULL;	(!empty($logo) && $logo['picture']['status']==1) && $data['picture']=$logo['picture']['url'];	$data['providerId']=$this->session->getSession('Merchant','providerId');	$data['feedbackTime']=$this->system->getSystemTime('A');	$data['ProcessingStatus']=1;$data['status']=1;$data['type']=1;
	$data['operatorName']=$this->session->getSession('Merchant','loginName');
	$data['operationTime']=$this->system->getSystemTime('A');
	$this->service->addFeedback($data) && $mess=$this->system->remind(1);	$log=new CurrLog(3,6,$this->session->getSession('Merchant',"loginName"),$this->system->getSystemTime("A"),"商户端意见反馈","",8,NULL);    $log->write();    $this->load->view('admin/message.html',$mess);}/**
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
public function updated(){	$this->session->checkSession('Merchant');
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
/**************************************************************方法::Feedback::search* ----------------------------------------------------------*描述::商户端意见反馈搜索方法*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.02.28  Add by zwx*************************************************************/
public function search(){ 	$this->session->checkSession('Merchant');	!empty($_POST) && $this->session->setSession($_POST,'feedSearch');	$session=$this->session->getSession('feedSearch');	$find=empty($_GET['p'])?1:$_GET['p'];	$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getSearchTotal($session['status'],$session['types'],$session['startFeedDate'],$session['lastFeedDate'],$session['startReplyDate'],$session['lastReplyDate']),20,$find);	$data["page"]=$page->showPage();	$data["list"]=$this->service->search($session['status'],$session['types'],$session['startFeedDate'],$session['lastFeedDate'],$session['startReplyDate'],$session['lastReplyDate'],$find);	$log=new CurrLog(3,3,$this->session->getSession('Merchant',"loginName"),$this->system->getSystemTime("A"),"商户端意见反馈","",8,NULL);    $log->write();	$this->load->view("merchant/FeedbackList.html",$data);}
/**************************************************************方法::Feedback::check* ----------------------------------------------------------*描述::检测记录状态接口*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.02.28  Add by zwx*************************************************************/
public function check(){	$this->session->checkSession('Merchant');	header("Access-Control-Allow-Origin: *");	echo $this->service->checkFeedback(NULL,$_GET["id"]) ? 4000:4004;}
}