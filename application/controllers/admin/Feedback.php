<?php /***************************************************** **作者：张文晓	**创始时间：2017-03-01	**描述：平台意见反馈控制器类	*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Feedback extends CI_Controller {	
#.引用属性，每个控制器都需要有	
private $includes;	private $session;private $system;private $service;
/**	 ***********************************************************	 *方法::Feedback::__construct * ----------------------------------------------------------	 *描述::平台意见反馈初始化方法 *----------------------------------------------------------	; *参数:	  *parm2:in--    无	  *----------------------------------------------------------		  *返回：	  *return:out--  无	  * ----------------------------------------------------------		  *日期:2017.03.01  Add by zwx		  ************************************************************		 */
public function __construct(){ 		parent::__construct(); 	$this->includes=new Includes(__FILE__); 	$this->includes->libraries("CurrSystem"); 	$this->includes->libraries("CurrLog"); 	$this->includes->libraries("CurrPage"); 	$this->includes->services("FeedbackService"); 	$this->includes->libraries("CurrSession");    $this->session=new CurrSession();	$this->system=new CurrSystem;	$this->service=new FeedbackService();	$this->load->helper("url"); }
/**	************************************************************方法::Feedback::index * ---------------------------------------------------------- *描述::平台意见反馈列表主页*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx		 *************************************************************/
public function index(){ 	$find=empty($_GET["p"])?1:$_GET["p"];	$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getTotal(),100,$find);	$data["page"]=$page->showPage();	$data["list"]=$this->service->getList($find);	$data['name']=$this->getProviderNames();	$log=new CurrLog(2,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"平台意见反馈","",8,NULL);    $log->write();	$this->load->view("admin/FeedbackList.html",$data);}
/** ************************************************************方法::Feedback::update* ----------------------------------------------------------*描述::平台意见反馈修改页面*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx *************************************************************/
public function update(){ 	$one=$this->service->getFeedback($_GET['id']);	$data['one']=count($one)>0?$one[0]:array();	$log=new CurrLog(2,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"平台意见反馈","",8,$_GET["id"]);    $log->write();	$this->load->view("admin/FeedbackUpdate.html",$data);}
/** *********************************************************** *方法::Feedback::updated * ---------------------------------------------------------- *描述::平台意见反馈修改数据方法 *---------------------------------------------------------- *参数: *parm2:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- *日期:2017.03.01  Add by zwx ************************************************************ */
public function updated(){ 	$data=$_POST;	$mess=$this->system->remind();
	if($this->service->checkFeedback(NULL,$data['id'])){		$data['replyTime']=$this->system->getSystemTime('A');
		$data['operatorName']=$this->session->getSession('Admin','loginName');
		$data['operationTime']=$this->system->getSystemTime('A');
		$this->service->saveFeedback($data['id'],$data) && $mess=$this->system->remind(1);
	}else{
		$mess=$this->system->remind(4);
	}
	$this->load->view('admin/message.html',$mess);}
/**************************************************************方法::Feedback::delete* ----------------------------------------------------------*描述::平台意见反馈删除方法*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx*************************************************************/
public function delete(){ 	header("Access-Control-Allow-Origin: *");	echo $this->service->delete($_GET["id"]) ? 4000:4004; 	$log=new CurrLog(2,4,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"平台意见反馈","",8,$_GET["id"]);    $log->write();}
/**************************************************************方法::Feedback::search* ----------------------------------------------------------*描述::平台意见反馈搜索方法*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx*************************************************************/
public function search(){ 	$this->session->checkSession('Admin');
	!empty($_POST) && $this->session->setSession($_POST,'feedSearch');
	$session=$this->session->getSession('feedSearch');
	$find=empty($_GET['p'])?1:$_GET['p'];
	$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getSearchTotal($session['name'],$session['status'],$session['types'],$session['startFeedDate'],$session['lastFeedDate'],$session['startReplyDate'],$session['lastReplyDate'],$session['baseType'],$session['satisfaction'],$session['operatorName']),100,$find);
	$data["page"]=$page->showPage();
	$data['name']=$this->getProviderNames();	$data['POSTS']=$session;
	$data["list"]=$this->service->search($session['name'],$session['status'],$session['types'],$session['startFeedDate'],$session['lastFeedDate'],$session['startReplyDate'],$session['lastReplyDate'],$session['baseType'],$session['satisfaction'],$session['operatorName'],$find);	$log=new CurrLog(2,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"平台意见反馈","",8,NULL);    $log->write();	$this->load->view("admin/FeedbackList.html",$data);}
/**************************************************************方法::Feedback::check* ----------------------------------------------------------*描述::检测记录状态接口*----------------------------------------------------------*参数:*parm2:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx*************************************************************/
public function check(){	header("Access-Control-Allow-Origin: *");	echo $this->service->checkFeedback(NULL,$_GET["id"]) ? 4000:4004;}/**
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