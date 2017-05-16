<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：区域管理控制器类
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Area extends CI_Controller {
	#.引用属性，每个控制器都需要有
	private $includes;
	private $session;
	private $system;
	private $service;
	/**
	 ***********************************************************
	 *方法::Area::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
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
		$this->includes->services('AreaService');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrPage');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->service=new AreaService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法::Area::index
	 * ----------------------------------------------------------
	 * 描述::列表主页
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
		$data['code']=$this->findAreaCode();
		$data['name']=$this->findAreaName();
		$data['short']=$this->findShortCode();
		$data['Pid']=$Pid;
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'区域管理','',10,NULL);
		$log->write();
		$this->load->view('admin/AreaList.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Area::add
	 * ----------------------------------------------------------
	 * 描述::新增页面
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
		$this->load->view('admin/AreaAdd.html');
	}
	/**
	 ***********************************************************
	 *方法::Area::update
	 * ----------------------------------------------------------
	 * 描述::修改页面
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
		$area=$this->service->getArea(NULL,$_GET['id']);
		$data['one']=count($area)>0?$area[0]:NULL;
		(count($area)>0 && $area[0]['parentId']>0) && $data['city']=$this->service->getArea(0);
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'区域管理','',10,$_GET['id']);
		$log->write();
		$this->load->view('admin/AreaUpdate.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Area::added
	 * ----------------------------------------------------------
	 * 描述::新增数据方法
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
		if(!$this->service->checkArea($data['name'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$data['status']=1;
			$this->service->addArea($data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(3);
		}
		$this->load->view('admin/message.html',$mess);
	}
	/**
	 ***********************************************************
	 *方法::Area::updated
	 * ----------------------------------------------------------
	 * 描述::修改数据方法
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
		$mess=$this->system->remind();
		if($this->service->checkArea(NULL,$data['id'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$this->service->saveArea($data['id'],$data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(4);
		}
		$this->load->view('admin/message.html',$mess);
	}
	/**
	 ***********************************************************
	 *方法::Area::delete
	 * ----------------------------------------------------------
	 * 描述::删除方法
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
		$log=new CurrLog(2,4,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'区域管理','',10,$_GET['id']);
		$log->write();
	}
	/**
	 ***********************************************************
	 *方法::Area::check
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
		echo $this->service->checkArea(NULL,$_GET['id']) ? 4000:4004;
	}
	/**
	 ***********************************************************
	 *方法::Area::getCitys
	 * ----------------------------------------------------------
	 * 描述::获取城市接口
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
	public function getCitys(){
		header('Access-Control-Allow-Origin: *');
		$list=$this->service->getArea($_POST['id']);
		$message=empty($list)?4004:$list;
		echo json_encode($message);
	}
	/**
	 ***********************************************************
	 *方法::Area::findAreaName
	 * ----------------------------------------------------------
	 * 描述::获取区域全部名称
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
	private function findAreaName(){
		$list=$this->service->findArea(array("status"=>1));
		$nameArray=array();
		foreach($list as $l){$nameArray[]=$l['name'];}
		return implode(",",$nameArray);
	}
	/**
	 ***********************************************************
	 *方法::Area::findAreaCode
	 * ----------------------------------------------------------
	 * 描述::获取区域全部编码
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
	private function findAreaCode(){
		$list=$this->service->findArea(array("status"=>1));
		$nameArray=array();
		foreach($list as $l){$nameArray[]=$l['areaCode'];}
		return implode(",",$nameArray);
	}
	/**
	 ***********************************************************
	 *方法::Area::findShortCode
	 * ----------------------------------------------------------
	 * 描述::获取区域全部简码
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
	private function findShortCode(){
		$list=$this->service->findArea(array("status"=>1));
		$nameArray=array();
		foreach($list as $l){$nameArray[]=$l['shortCode'];}
		return implode(",",$nameArray);
	}
	/**
	 ***********************************************************
	 *方法::Area::search
	 * ----------------------------------------------------------
	 * 描述::区域搜索方法
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
		if(empty($dataso['name']))         unset($dataso['name']);
		if(empty($dataso['areaCode']))   unset($dataso['areaCode']);
		if(empty($dataso['shortCode']))  unset($dataso['shortCode']);
		$data['page']='';
		$data['list']=$this->service->findArea($dataso);
		$data['code']=$this->findAreaCode();
		$data['name']=$this->findAreaName();
		$data['short']=$this->findShortCode();
		$data['Pid']=$dataso['parentId'];
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'区域管理','',10,NULL);
		$log->write();
		$this->load->view('admin/AreaList.html',$data);
	}
}