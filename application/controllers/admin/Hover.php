<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：操作日志控制器类
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Hover extends CI_Controller {
	#.引用属性，每个控制器都需要有
	private $includes;
	private $session;
	private $system;
	private $service;
	/**
	 ***********************************************************
	 *方法:Hover::construct
	 * ----------------------------------------------------------
	 * 描述::操作日志初始化方法
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
		$this->includes->services('HoverService');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrPage');
		$this->includes->services('OperatorService');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->service=new HoverService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法:Hover::index
	 * ----------------------------------------------------------
	 * 描述::操作日志列表页面
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
		$data['user']=$this->findOperator();
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'操作日志','',5,NULL);
		$log->write();
		$this->load->view('admin/hover.html',$data);
	}
	/**
	 ***********************************************************
	 *方法:Hover::search
	 * ----------------------------------------------------------
	 * 描述::操作日志搜索方法
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
	public function search(){
		$this->session->checkSession('Admin');
		!empty($_POST) && $this->session->setSession($_POST,'systemSearch');
		$session=$this->session->getSession('systemSearch');
		$find=empty($_GET['p'])?1:$_GET['p'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getSearchTotal($session['type'],$session['operatorType'],$session['operatorName'],$session['startDate'],$session['lastDate']),100,$find);
		$data['page']=$page->showPage();
		$data['list']=$this->service->search($session['type'],$session['operatorType'],$session['operatorName'],$session['startDate'],$session['lastDate'],$find);
		$data['user']=$this->findOperator();
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'系统日志管理','',6,NULL);
		$log->write();
		$this->load->view('admin/hover.html',$data);
	}
	/**
	 ***********************************************************
	 *方法:Hover::findOperator
	 * ----------------------------------------------------------
	 * 描述::系统日志获取操作员列表
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
	private function findOperator(){
		$user=new OperatorService();
		$list=$user->findOpera(array("status"=>1));
		$nameArray=array();
		foreach($list as $l){$nameArray[]=$l['loginName'];}
		return implode(",",$nameArray);
	}
}
