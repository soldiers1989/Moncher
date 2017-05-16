<?php
/*****************************************************
 **作者：zwx
**创始时间：2017-03-15
**描述：门店分析
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Anastore extends CI_Controller {
	#.引用属性，每个控制器都需要有
	private $includes;
	private $system;
	private $session;
	private $service;
	/**
	 ***********************************************************
	 *方法::Anastore::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.03.15  Add by zwx
	 ************************************************************
	 */
	public function __construct(){
		parent::__construct();
		$this->includes=new Includes(__FILE__);
		$this->includes->services('AnastoreService');
		$this->includes->services("InformationService");
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrSession');
		$this->includes->libraries('CurrLog');
		$this->includes->models("DataBase","global");
		$this->system=new CurrSystem();
	    $this->session=new CurrSession();
		$this->service=new AnastoreService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法::Anastore::storeEval
	 * ----------------------------------------------------------
	 * 描述::门店主页
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
	public function storeMain(){
	  $this->session->checkSession('Merchant');
	  $providerid=empty($_GET['id'])?$this->session->getSession("Merchant","providerId"):$_GET['id'];
	  $service=new InformationService();
	  $once=$service->getInformation($providerid);
	  $json=$this->service->getTotal($providerid,$_SESSION['modelid'],$once['rank'],date('Y-m',strtotime('-1 month')),date('Y-m',time()));
	  $NPS=$this->service->getNPS($providerid,$_SESSION['modelid']);
	  $top=$this->service->getTop($providerid,$_SESSION['modelid'],$once['rank']);
	  $data['json']=json_encode($json);$data['jsonNPS']=json_encode($NPS);$data['jsonTOP']=json_encode($top);
	  $data['tree']=$json;$data['treeNPS']=$NPS;$data['treeTOP']=$top;
	  $this->load->view('merchant/MerchantMain.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Anastore::storeNum
	 * ----------------------------------------------------------
	 * 描述::门店监控页面
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
	public function storeNum(){
		$this->session->checkSession('Merchant');
		$providerid=empty($_GET['id'])?$this->session->getSession("Merchant","providerId"):$_GET['id'];
		$data['All']=$this->service->getMerchantStore('All',$providerid,$_SESSION['modelid']);
		$data['Year']=$this->service->getMerchantStore('Year',$providerid,$_SESSION['modelid']);
		$data['Quar']=$this->service->getMerchantStore('Quar',$providerid,$_SESSION['modelid']);
		$data['Month']=$this->service->getMerchantStore('Month',$providerid,$_SESSION['modelid']);
		$data['Day']=$this->service->getMerchantStore('Day',$providerid,$_SESSION['modelid']);
		$data['querTree']=json_encode($this->service->getQuarScore($providerid,$_SESSION['modelid']));
		$data['yearTree']=json_encode($this->service->getYearScore($providerid,$_SESSION['modelid']));
		$data['monTree']=json_encode($this->service->getMonthScore($providerid,$_SESSION['modelid'],date('Y-m-d',time())));
		$this->load->view('merchant/MerchantWarn.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Anastore::storeEval
	 * ----------------------------------------------------------
	 * 描述::评测分析
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
	public function storeEval(){
		$this->session->checkSession('Merchant');
		$providerid=empty($_GET['id'])?$this->session->getSession("Merchant","providerId"):$_GET['id'];
		$service=new InformationService();
		$once=$service->getInformation($providerid);
	    $data['startDate']=empty($_POST['startDate'])?date('Y-m',strtotime('-1 month')):$_POST['startDate'];
		$data['lastDate']=empty($_POST['lastDate'])?date('Y-m',time()):$_POST['lastDate'];
		$mon=array('01'=>"一月","02"=>"二月","03"=>"三月","04"=>"四月","05"=>"五月","06"=>"六月","07"=>"七月","08"=>"八月","09"=>"十月","11"=>"十一月","12"=>"十二月");
		$data['start']=$mon[date('m',strtotime($data['startDate']))];
		$data['last']=$mon[date('m',strtotime($data['lastDate']))];
		$json=$this->service->getEvalData($providerid,$_SESSION['modelid'],$once['rank'],$data['startDate'],$data['lastDate']);
		$NPS=$this->service->getNPSi($providerid,$_SESSION['modelid'],$data['startDate'],$data['lastDate']);
		$data['json']=json_encode($json);$data['tree']=$json;
		$data['jsonNPS']=json_encode($NPS);$data['treeNPS']=$NPS;
		$data=$this->service->getQuestionTop($providerid,$_SESSION['modelid'],$data['startDate'],$data['lastDate'],$data);
		$this->load->view('merchant/MerchantEval.html',$data);
	}
}
