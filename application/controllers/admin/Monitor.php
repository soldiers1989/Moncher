<?php /***************************************************** **作者：张文晓	**创始时间：2017-04-12	**描述：集团监控控制器类	*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Monitor extends CI_Controller {	
#.引用属性，每个控制器都需要有	
		private $includes;			private $session;		private $system;		private $service;
	/**		 ***********************************************************		 *方法::Monitor::__construct	 * ----------------------------------------------------------		 *描述::集团监控初始化方法	 *----------------------------------------------------------	;	 *参数:	 	 *parm2:in--    无	 	 *----------------------------------------------------------		 	 *返回：	 	 *return:out--  无	 	 * ----------------------------------------------------------		 	 *日期:2017.04.12  Add by zwx		 	 ************************************************************			 */
	public function __construct(){ 				parent::__construct(); 			$this->includes=new Includes(__FILE__); 			$this->includes->libraries("CurrSystem"); 			$this->includes->libraries("CurrLog"); 			$this->includes->libraries("CurrPage"); 			$this->includes->services("MonitorService"); 			$this->includes->libraries("CurrSession");			$this->session=new CurrSession();			$this->system=new CurrSystem;			$this->service=new MonitorService();			$this->load->helper("url"); 		}
	/**			***********************************************************		*方法::Monitor::index 		* ---------------------------------------------------------- 		*描述::集团监控列表主页		*----------------------------------------------------------		*参数:		*parm2:in--    无		*----------------------------------------------------------		*返回：		*return:out--  无		* ----------------------------------------------------------		*日期:2017.04.12  Add by zwx		 		************************************************************		*/
	public function index(){		$find=empty($_GET["p"])?1:$_GET["p"];		$data['modelid']=empty($_POST['modelid'])?2:$_POST['modelid'];		$data['groupid']=empty($_POST['groupid'])?0:$_POST['groupid'];		$data['brandid']=empty($_POST['brandid'])?0:$_POST['brandid'];
		$data['areaid']=empty($_POST['areaid'])?0:$_POST['areaid'];
		$data['providerid']=empty($_POST['providerid'])?0:$_POST['providerid'];		$data['startDate']=empty($_POST['startDate'])?date('Y-m-d',time()):$_POST['startDate'];		$data['endDate']=empty($_POST['endDate'])?date('Y-m-d',time()):$_POST['endDate'];		$data['model']=$this->service->getModelList();		$data['group']=$this->service->getGroupList($data['modelid']);		$data['area']=$this->service->getAreaList($data['groupid']);		$data['brand']=$this->service->getBrandList($data['groupid']);		$data['merchant']=$this->service->getMerchantList($data['groupid']);		$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getTotal($data['groupid'],$data['modelid'],$data['brandid'],$data['areaid'],$data['providerid'],$data['startDate'],$data['endDate']),100,$find);		$data["page"]=$page->showPage();	    $data["list"]=$this->service->getList($data['groupid'],$data['modelid'],$data['brandid'],$data['areaid'],$data['providerid'],$data['startDate'],$data['endDate']);		$log=new CurrLog(3,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"集团监控","",29,NULL);		$log->write();		$this->load->view("admin/MonitorList.html",$data);	}	/*获取集团列表*/	public function getGroupList(){		header('Access-Control-Allow-Origin: *');		echo json_encode($this->service->getGroupList($_POST['modelid']));	}	public function findMBAList(){		header('Access-Control-Allow-Origin: *');
		$data=array();
		$data['area']=$this->service->getAreaList($_POST['groupid']);
		$data['brand']=$this->service->getBrandList($_POST['groupid']);
		$data['merchant']=$this->service->getMerchantList($_POST['groupid']);
		echo json_encode($data);	}
}