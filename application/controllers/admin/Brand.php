<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：汽车品牌控制器类。
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Brand extends CI_Controller {
	#.引用属性，每个控制器都需要有
	private $includes;
	private $session;
	private $system;
	private $service;
	/**
	 ***********************************************************
	 *方法::Brand::__construct
	 * ----------------------------------------------------------
	 * 描述::品牌控制器初始化方法
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
	public function __construct(){
		parent::__construct();
		$this->includes=new Includes(__FILE__);
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrUpload');
		$this->includes->services('BrandService');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrPage');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->service=new BrandService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法::Brand::index
	 * ----------------------------------------------------------
	 * 描述::品牌控制器列表页面
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
	public function index(){
		$this->session->checkSession('Admin');
		$find=empty($_GET['p'])?1:$_GET['p'];
		$Pid=empty($_GET['Pid'])?0:$_GET['Pid'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getTotal($Pid),100,$find);
		$data['page']=$page->showPage();
		$data['list']=$this->service->getList($Pid,$find);
		$data['name']=$this->findBrands();
		$data['Pid']=$Pid;
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'品牌管理','',9,NULL);
		$log->write();
		$this->load->view('admin/BrandList.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Brand::add
	 * ----------------------------------------------------------
	 * 描述::品牌控制器新增页面
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
	public function add(){
		$this->session->checkSession('Admin');
		$this->load->view('admin/BrandAdd.html');
	}
	/**
	 ***********************************************************
	 *方法::Brand::update
	 * ----------------------------------------------------------
	 * 描述::品牌控制器修改页面
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
	public function update(){
		$this->session->checkSession('Admin');
		$brands=$this->service->getBrands(NULL,$_GET['id']);
		$data['one']=count($brands)>0?$brands[0]:NULL;
		(count($brands)>0 && $brands[0]['parentId']!=0) && $data['brand']=$this->service->getBrands($brands[0]['series']);
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'品牌管理','',9,$_GET['id']);
		$log->write();
		$this->load->view('admin/BrandUpdate.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Brand::getBrands
	 * ----------------------------------------------------------
	 * 描述::品牌控制器获取品牌接口
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
	public function getBrands(){
		header('Access-Control-Allow-Origin: *');
		$list=$this->service->getBrands($_POST['id']);
		$message=empty($list)?4004:$list;
		echo json_encode($message);
	}
	/**
	 ***********************************************************
	 *方法::Brand::added
	 * ----------------------------------------------------------
	 * 描述::品牌控制器获新增方法
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
	public function added(){
		$this->session->checkSession('Admin');
		$data=$_POST;
		$mess=$this->system->remind();
		if(!$this->service->checkBrands($data['name'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$data['status']=1;
			$this->service->addBrands($data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(3);
		}
		$this->load->view('admin/message.html',$mess);
	}
	/**
	 ***********************************************************
	 *方法::Brand::updated
	 * ----------------------------------------------------------
	 * 描述::品牌控制器修改方法
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
	public function updated(){
		$this->session->checkSession('Admin');
		$data=$_POST;
		$mess=$this->system->remind(0);
		if($this->service->checkBrands(NULL,$data['id'])){
		    $data['operatorName']=$this->session->getSession('Admin','loginName');
		    $data['operationTime']=$this->system->getSystemTime('A');
			$this->service->saveBrands($data['id'],$data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(4);
		}
		$this->load->view('admin/message.html',$mess);
	}
	/**
	 ***********************************************************
	 *方法::Brand::delete
	 * ----------------------------------------------------------
	 * 描述::品牌控制器删除方法
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
	public function delete(){
		$this->session->checkSession('Admin');
		header('Access-Control-Allow-Origin: *');
		echo $this->service->delete($_GET['id']) ? 4000:4004;
		$log=new CurrLog(2,4,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'品牌管理','',9,$_GET['id']);
		$log->write();
	}
	/**
	 ***********************************************************
	 *方法::Brand::check
	 * ----------------------------------------------------------
	 * 描述::检测记录状态接口
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
	public function check(){
		header('Access-Control-Allow-Origin: *');
		echo $this->service->checkBrands(NULL,$_GET['id']) ? 4000:4004;
	}
	/**
	 ***********************************************************
	 *方法::Brand::search
	 * ----------------------------------------------------------
	 * 描述::页面搜索方法
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
	public function search(){
		$this->session->checkSession('Admin');
		!empty($_POST) && $this->session->setSession($_POST,'brandSearch');
		$session=$this->session->getSession('brandSearch');
		$find=empty($_GET['p'])?1:$_GET['p'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getSearchTotal($session['Pid']==NULL?0:$session['Pid'],$session['series'],$session['rank'],$session['name'],$session['code']),100,$find);
		$data['page']=$page->showPage();
		$data['list']=$this->service->search($session['Pid']==NULL?0:$session['Pid'],$session['series'],$session['rank'],$session['name'],$session['code'],$find);
		$data['name']=$this->findBrands();
		$data['Pid']=$session['Pid'];
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'品牌管理','',9,NULL);
		$log->write();
		$this->load->view('admin/BrandList.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Brand::findBrands
	 * ----------------------------------------------------------
	 * 描述::获取所有汽车名称
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
	private function findBrands(){
		$list=$this->service->findBrand(array("status"=>1));
		$nameArray=array();
		foreach($list as $l){$nameArray[]=$l['name'];}
		return implode(",",$nameArray);
	}
}