<?php
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php'); 
/*****************************************************
 **作者：zwx
**创始时间：2017-03-01
**描述：报告管理-维护-修改-删除 -生成-商户报告-集团报告-厂商报告
*****************************************************/
class Report extends CI_Controller {
		private $includes;
		private $system;
		private $session;
		private $service;
	/**
	 ***********************************************************
	 *方法:: Report ::__construct
	 * ----------------------------------------------------------
	 * 描述::登录类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.03.01  Add by zwx
	 ************************************************************
	 */
	Public function __construct(){
		parent::__construct();
		$this->includes=new Includes(__FILE__);
		$this->includes->services('ReportService');
		$this->includes->models('ReportModel');
		$this->includes->models('DataBase','global');
		$this->includes->libraries('CurrUpload');
		$this->includes->libraries('CurrExport');
		$this->includes->libraries('CurrPage');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->service=new ReportService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法:: Report ::index
	 * ----------------------------------------------------------
	 * 描述::门店报告下载
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.03.01  Add by zwx
	 ************************************************************
	 */
	public function index(){
		/**
		 * type==1 :: 门店报告类型
		 * type==2 :: 集团报告类型
		 * type==3 :: 厂家报告类型
		 * type==4 :: 行业报告类型
		 * 备注:: 可以不使用上述方式，只是权宜之计，如果有更好的方式不必采用此种写法
		 * */
		$type=$_GET['t'];
		if($type==1){
			/**设置默认搜索参数*/
			$data['modelid']=empty($_POST['modelid'])?2:$_POST['modelid'];
			$data['groupid']=empty($_POST['groupid'])?0:$_POST['groupid'];
			$data['providerid']=empty($_POST['providerid'])?0:$_POST['providerid'];
			$data['startDate']=empty($_POST['startDate'])?date('Y-m',strtotime('-1 month')):$_POST['startDate'];
			$data['endDate']=empty($_POST['endDate'])?date('Y-m',time()):$_POST['endDate'];
			/**搜索条件下的列表*/
			$data['model']=$this->service->getModelList();
			$data['group']=$this->service->getGroupList($data['modelid']);
			$data['merchant']=$this->service->getMerchantList($data['groupid']);
			/**主体数据传输到页面*/
			$page=new CurrPage($_SERVER["PHP_SELF"],$this->service->getTotal($data['modelid'],$data['groupid'],$data['providerid'],$data['startDate'],$data['endDate']),100,1);
			$data["page"]=$page->showPage();
			$data["list"]=$this->service->getList($data['modelid'],$data['groupid'],$data['providerid'],$data['startDate'],$data['endDate']);
			$this->load->view("admin/ReportList.html",$data);
		}
	}
	/**
	 ***********************************************************
	 *方法:: Report ::addReport
	 * ----------------------------------------------------------
	 * 描述::新增报告页面
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.03.01  Add by zwx
	 ************************************************************
	 */
	public function addReport(){
		$this->load->view('admin/addReport.html');
	}
	/**
	 ***********************************************************
	 *方法:: Report ::addedReport
	 * ----------------------------------------------------------
	 * 描述::新增报告方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.03.01  Add by zwx
	 ************************************************************
	 */
	public function addedReport(){
	}
	/**
	 ***********************************************************
	 *方法:: Report ::deleteReport
	 * ----------------------------------------------------------
	 * 描述::删除报告方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.03.01  Add by zwx
	 ************************************************************
	 */
	public function deleteReport(){
		
	}
	/**
	 ***********************************************************
	 *方法:: Report ::updateReport
	 * ----------------------------------------------------------
	 * 描述::修改报告页面
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.03.01  Add by zwx
	 ************************************************************
	 */
	public function updateReport(){
		
	}
	/**
	 ***********************************************************
	 *方法:: Report ::saveReport
	 * ----------------------------------------------------------
	 * 描述::保存报告信息
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.03.01  Add by zwx
	 ************************************************************
	 */
	public function saveReport(){
		
	}
	/*获取集团列表*/
	public function getGroupList(){
		header('Access-Control-Allow-Origin: *');
		echo json_encode($this->service->getGroupList($_POST['modelid']));
	}
	/*获取门店列表*/
	public function findMBAList(){
		header('Access-Control-Allow-Origin: *');
		echo json_encode($this->service->getMerchantList($_POST['groupid']));
	}
		
		
		
		
		
		
		
		
		
		
}