<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：菜单管理控制器类
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Menu extends CI_Controller {
	private $includes;
	private $session;
	private $system;
	private $service;
	/**
	 ***********************************************************
	 *方法::Menu:: __construct
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
		$this->includes->services('MenuService');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrPage');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->service=new MenuService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法::Menu:: index
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
		$Pid=empty($_GET['Pid'])?0:$_GET['Pid'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getTotal($Pid),100,$find);
		$data['page']=$page->showPage();
		$data['list']=$this->service->getList($Pid,$find);
		$data['name']=$this->findNames();
		$data['Pid']=$Pid;
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'菜单管理','',4,NULL);
		$log->write();
		$this->load->view('admin/MenuList.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Menu:: add
	 * ----------------------------------------------------------
	 * 描述::新增页面
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
		$this->load->view('admin/MenuAdd.html');
	}
	/**
	 ***********************************************************
	 *方法::Menu:: update
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
		$menu=$this->service->getMenus(NULL,$_GET['id']);
		$data['one']=count($menu)>0?$menu[0]:NULL;
		(count($menu)>0 && $menu[0]['pId']>0) && $data['menu']=$this->service->getMenus(0);
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'菜单管理','',4,$_GET['id']);
		$log->write();
		$this->load->view('admin/MenuUpdate.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Menu:: added
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
		if(!$this->service->checkMenu($data['navTitle'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$this->service->addMenu($data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(3);
		}
		$this->load->view('admin/message.html',$mess);
	}
	/**
	 ***********************************************************
	 *方法::Menu:: updated
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
	public function updated(){
		$this->session->checkSession('Admin');
		$data=$_POST;
		$mess=$this->system->remind();
		if($this->service->checkMenu(NULL,$data['id'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$this->service->saveMenu($data['id'],$data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(4);
		}
		$this->load->view('admin/message.html',$mess);
	}
	/**
	 ***********************************************************
	 *方法::Menu:: delete
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
		$log=new CurrLog(2,4,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'菜单管理','',4,$_GET['id']);
		$log->write();
	}
	/**
	 ***********************************************************
	 *方法::Menu:: search
	 * ----------------------------------------------------------
	 * 描述::搜索方法
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
		!empty($_POST) && $this->session->setSession($_POST,'menuSearch');
		$session=$this->session->getSession('menuSearch');
		$find=empty($_GET['p'])?1:$_GET['p'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getSearchTotal($session['Pid'],$session['navTitle'],$session['startDate'],$session['lastDate']),100,$find);
		$data['page']=$page->showPage();
		$data['list']=$this->service->search($session['Pid'],$session['navTitle'],$session['startDate'],$session['lastDate'],$find);
		$data['name']=$this->findNames();
		$data['Pid']=$session['Pid'];
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'菜单管理','',4,NULL);
		$log->write();
		$this->load->view('admin/MenuList.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Menu:: getMenus
	 * ----------------------------------------------------------
	 * 描述::获取菜单接口
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
	public function getMenus(){
		header('Access-Control-Allow-Origin: *');
		$list=$this->service->getMenus($_POST['id']);
		$message=empty($list)?4004:$list;
		echo json_encode($message);
	}
	/**
	 ***********************************************************
	 *方法::Menu::check
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
		echo $this->service->checkMenu(NULL,$_GET['id']) ? 4000:4004;
	}
	/**
	 ***********************************************************
	 *方法::Menu::findNames
	 * ----------------------------------------------------------
	 * 描述::获取所有菜单名称
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
		$list=$this->service->findMenu(array("status"=>1));
		$nameArray=array();
		foreach($list as $l){$nameArray[]=$l['navTitle'];}
		return implode(",",$nameArray);
	}
}
