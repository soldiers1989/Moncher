<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：系统参数控制器
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Parameter extends CI_Controller {
	#.引用属性，每个控制器都需要有
	private $includes;
	private $session;
	private $system;
	private $service;
	/**
	 ***********************************************************
	 *方法::Parameter::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function __construct(){
		parent::__construct();
		$this->includes=new Includes(__FILE__);
		$this->includes->libraries('CurrSystem');
		$this->includes->services('ParameterService');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrPage');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->service=new ParameterService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法::Parameter::index
	 * ----------------------------------------------------------
	 * 描述::列表页面
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function index(){
		$this->session->checkSession('Admin');
		$find=empty($_GET['p'])?1:$_GET['p'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getTotal(),100,$find);
		$data['page']=$page->showPage();
		$data['list']=$this->service->getList($find);
		$data['code']=$this->findCodes();
		$data['name']=$this->findNames();
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'系统参数管理','',11,NULL);
		$log->write();
		$this->load->view('admin/ParameterList.html',$data);	
		
	}
	/**
	 ***********************************************************
	 *方法::Parameter::add
	 * ----------------------------------------------------------
	 * 描述::修改页面
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function add(){
		$this->session->checkSession('Admin');
		$this->load->view('admin/ParameterAdd.html');
	}
	/**
	 ***********************************************************
	 *方法::Parameter::update
	 * ----------------------------------------------------------
	 * 描述::修改页面
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function update(){
		$this->session->checkSession('Admin');
		$param=$this->service->getParam($_GET['id']);
		$data['one']=count($param)>0?$param[0]:NULL;
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'系统参数管理','',11,$_GET['id']);
		$log->write();
		$this->load->view('admin/ParameterUpdate.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Parameter::added
	 * ----------------------------------------------------------
	 * 描述::新增方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function added(){
		$this->session->checkSession('Admin');
		$data=$_POST;
		$mess=$this->system->remind();
		if(!$this->service->checkParam($data['name'],$data['code'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$this->service->addParam($data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(3);
		}
		$this->load->view('admin/message.html',$mess);
	}
	/**
	 ***********************************************************
	 *方法::Parameter::updated
	 * ----------------------------------------------------------
	 * 描述::修改方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function updated(){
		$this->session->checkSession('Admin');
		$data=$_POST;
		$mess=$this->system->remind();
		if($this->service->checkParam(NULL,NULL,$data['id'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$this->service->saveParam($data['id'],$data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(4);
		}
		$this->load->view('admin/message.html',$mess);
	}
	/**
	 ***********************************************************
	 *方法::Parameter::delete
	 * ----------------------------------------------------------
	 * 描述::删除方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function delete(){
		$this->session->checkSession('Admin');
		header('Access-Control-Allow-Origin: *');
		echo $this->service->delete($_GET['id']) ? 4000:4004;
		$log=new CurrLog(2,4,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'系统参数管理','',11,$_GET['id']);
		$log->write();
	}
	/**
	 ***********************************************************
	 *方法::Parameter::check
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
		echo $this->service->checkParam(NULL,NULL,$_GET['id']) ? 4000:4004;
	}
	/**
	 ***********************************************************
	 *方法::Parameter::search
	 * ----------------------------------------------------------
	 * 描述::搜索方法
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
		$dataso=$_POST;
		if(empty($dataso['name']))  unset($dataso['name']);
		if(empty($dataso['code']))  unset($dataso['code']);
		$data['page']='';
		$data['list']=$this->service->findParam($dataso);
		$data['code']=$this->findCodes();
		$data['name']=$this->findNames();
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'系统参数管理','',11,NULL);
		$log->write();
		$this->load->view('admin/ParameterList.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Dictionary::findNames
	 * ----------------------------------------------------------
	 * 描述::获取所有数据名称
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
	private function findNames(){
		$list=$this->service->findParam(array("status"=>1));
		$nameArray=array();
		foreach($list as $l){$nameArray[]=$l['name'];}
		return implode(",",$nameArray);
	}
	/**
	 ***********************************************************
	 *方法::Parameter::findCodes
	 * ----------------------------------------------------------
	 * 描述::获取所有数据编码
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
	private  function findCodes(){
		$list=$this->service->findParam(array("status"=>1));
		$nameArray=array();
		foreach($list as $l){$nameArray[]=$l['code'];}
		return implode(",",$nameArray);
	}
}
