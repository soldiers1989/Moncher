<?php /***************************************************** **作者：张文晓	**创始时间：2017-04-12	**描述：集团监控控制器类	*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Monitor extends CI_Controller {	
#.引用属性，每个控制器都需要有	
		private $includes;			private $session;		private $system;		private $service;
	/**		 ***********************************************************		 *方法::Monitor::__construct	 * ----------------------------------------------------------		 *描述::集团监控初始化方法	 *----------------------------------------------------------	;	 *参数:	 	 *parm2:in--    无	 	 *----------------------------------------------------------		 	 *返回：	 	 *return:out--  无	 	 * ----------------------------------------------------------		 	 *日期:2017.04.12  Add by zwx		 	 ************************************************************			 */
	public function __construct(){ 				parent::__construct(); 			$this->includes=new Includes(__FILE__); 			$this->includes->libraries("CurrSystem"); 			$this->includes->libraries("CurrLog"); 			$this->includes->libraries("CurrPage"); 			$this->includes->services("MonitorService"); 			$this->includes->services('AnagroupService');			$this->includes->libraries("CurrSession");			$this->session=new CurrSession();			$this->system=new CurrSystem;			$this->service=new MonitorService();			$this->load->helper("url"); 		}
	/**			***********************************************************		*方法::Monitor::index 		* ---------------------------------------------------------- 		*描述::集团监控列表主页		*----------------------------------------------------------		*参数:		*parm2:in--    无		*----------------------------------------------------------		*返回：		*return:out--  无		* ----------------------------------------------------------		*日期:2017.04.12  Add by zwx		 		************************************************************		*/
	public function index(){		$find=empty($_GET["p"])?1:$_GET["p"];		$service=new AnagroupService();		$data['area']=$service->getAreaList();		$data['brand']=$service->getBrandList();		$data['merchant']=$service->getMerchantList();		$data['brandid']=empty($_POST['brandid'])?0:$_POST['brandid'];		$data['areaid']=empty($_POST['areaid'])?0:$_POST['areaid'];		$data['providerid']=empty($_POST['providerid'])?0:$_POST['providerid'];		$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getTotal($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['brandid'],$data['areaid'],$data['providerid']),100,$find);		$data["page"]=$page->showPage();	    $data["list"]=$this->service->getList($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['brandid'],$data['areaid'],$data['providerid'],$find);		$log=new CurrLog(3,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"集团监控","",29,NULL);		$log->write();		$this->load->view("merchant/MonitorList.html",$data);	}	/**
	 ***********************************************************
	 *方法::Monitor::monitorAll
	 * ----------------------------------------------------------
	 * 描述::集团监控页面
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
	public function monitorAll(){		$data['brandid']=empty($_GET['brandid'])?0:$_GET['brandid'];		$data['areaid']=empty($_GET['areaid'])?0:$_GET['areaid'];		$data['rank']=empty($_GET['rank'])?2:$_GET['rank'];
		$data['All']=$this->service->getGroupScore('All',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Year']=$this->service->getGroupScore('Year',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Quar']=$this->service->getGroupScore('Quar',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Month']=$this->service->getGroupScore('Month',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Day']=$this->service->getGroupScore('Day',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['querTree']=json_encode($this->service->getQuarScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['yearTree']=json_encode($this->service->getYearScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['monTree']=json_encode($this->service->getMonthScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],date('Y-m-d',time()),$data['rank'],$data['areaid'],$data['brandid']));
		$this->load->view('merchant/MonitorAll.html',$data);
	}	/**
	 ***********************************************************
	 *方法::Monitor::monitorArea
	 * ----------------------------------------------------------
	 * 描述::集团监控页面
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
	public function monitorArea(){		$service=new AnagroupService();
		$data['area']=$service->getAreaList();		$data['brandid']=empty($_GET['brandid'])?0:$_GET['brandid'];
		$data['areaid']=empty($_POST['areaid'])?0:$_POST['areaid'];
		$data['rank']=empty($_GET['rank'])?2:$_GET['rank'];
		$data['All']=$this->service->getGroupScore('All',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Year']=$this->service->getGroupScore('Year',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Quar']=$this->service->getGroupScore('Quar',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Month']=$this->service->getGroupScore('Month',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Day']=$this->service->getGroupScore('Day',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['querTree']=json_encode($this->service->getQuarScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['yearTree']=json_encode($this->service->getYearScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['monTree']=json_encode($this->service->getMonthScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],date('Y-m-d',time()),$data['rank'],$data['areaid'],$data['brandid']));
		$this->load->view('merchant/MonitorArea.html',$data);
	}	/**
	 ***********************************************************
	 *方法::Monitor::monitorBrand
	 * ----------------------------------------------------------
	 * 描述::集团监控页面
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
	public function monitorBrand(){		$service=new AnagroupService();
		$data['area']=$service->getAreaList();
		$data['brand']=$service->getBrandList();		$data['brandid']=empty($_POST['brandid'])?0:$_POST['brandid'];
		$data['areaid']=empty($_POST['areaid'])?0:$_POST['areaid'];
		$data['rank']=empty($_GET['rank'])?0:$_GET['rank'];
		$data['All']=$this->service->getGroupScore('All',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Year']=$this->service->getGroupScore('Year',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Quar']=$this->service->getGroupScore('Quar',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);		$data['Day']=$this->service->getGroupScore('Day',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Month']=$this->service->getGroupScore('Month',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['querTree']=json_encode($this->service->getQuarScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['yearTree']=json_encode($this->service->getYearScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['monTree']=json_encode($this->service->getMonthScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],date('Y-m-d',time()),$data['rank'],$data['areaid'],$data['brandid']));
		$this->load->view('merchant/MonitorBrand.html',$data);
	}
}