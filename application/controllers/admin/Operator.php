<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-18
**描述：管理员添加类。
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Operator extends CI_Controller {
	#.引用属性，每个控制器都需要有
	private $includes;
	private $session;
	private $system;
	private $service;
	/**
	 ***********************************************************
	 *方法::Operator::__construct
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
		$this->includes->services('AreaService');
		$this->includes->services('DictionaryService');
		$this->includes->services('RoleService');
		$this->includes->libraries('CurrPage');
		$this->includes->libraries('CurrLog');
		$this->includes->services('OperatorService');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->service=new OperatorService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法::Operator::__construct
	 * ----------------------------------------------------------
	 * 描述::管理员列表主页
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
		$AreaServ=new AreaService();
		$DictServ=new DictionaryService();
		$RoleServ=new RoleService();
		$find=empty($_GET['p'])?1:$_GET['p'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getTotal(),100,$find);
		$area=$AreaServ->findArea(array("status"=>1,"parentId"=>0));
		count($area)>0 && $data['area']=$area;
		$dict=$DictServ->findDict(array("status"=>1,"id<="=>6));
		count($dict)>0 && $data['dict']=$dict;
		$role=$RoleServ->findRole();
		count($role)>0 && $data['role']=$role;
		$data['page']=$page->showPage();
		$data['list']=$this->service->getList($find);
		$data['user']=$this->findOperas();
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'操作员管理','',1,NULL);
		$log->write();
		$this->load->view('admin/OperatorList.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Operator::__construct
	 * ----------------------------------------------------------
	 * 描述::管理员添加页面
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
		$AreaServ=new AreaService();
		$DictServ=new DictionaryService();
		$RoleServ=new RoleService();
		$area=$AreaServ->findArea(array("status"=>1,"parentId"=>0));
		count($area)>0 && $data['area']=$area;
		$dict=$DictServ->findDict(array("status"=>1,"id<="=>6));
		count($dict)>0 && $data['dict']=$dict;
		$role=$RoleServ->findRole();
		count($role)>0 && $data['role']=$role;
		$this->load->view('admin/OperatorAdd.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Operator::__construct
	 * ----------------------------------------------------------
	 * 描述::管理员修改页面
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
		$AreaServ=new AreaService();
		$DictServ=new DictionaryService();
		$RoleServ=new RoleService();
		$area=$AreaServ->findArea(array("status"=>1,"parentId"=>0));
		count($area)>0 && $data['area']=$area;
		$dict=$DictServ->findDict(array("status"=>1,"id<="=>6));
		count($dict)>0 && $data['dict']=$dict;
		$role=$RoleServ->findRole();
		count($role)>0 && $data['role']=$role;
		$user=$this->service->getOpera($_GET['id']);
		count($user)>0 && $data['one']=$user[0];
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'操作员管理','',1,$_GET['id']);
		$log->write();
		$this->load->view('admin/OperatorUpdate.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Operator::added
	 * ----------------------------------------------------------
	 * 描述::管理员新增方法
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
		if(!$this->service->checkOpera($data['loginName'])){
			$data['userStatus']=1;
			$data['userPwd']=md5($data['userPwd']);
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$this->service->addOpera($data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(3);
		}
		$this->load->view('admin/message.html',$mess);
	}
	public function updated(){
		$this->session->checkSession('Admin');
		$data=$_POST;
		$mess=$this->system->remind();
		if($this->service->checkOpera(NULL,$data['id'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$this->service->saveOpera($data['id'],$data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(4);
		}
		$this->load->view('admin/message.html',$mess);
	}
	/**
	 ***********************************************************
	 *方法::Operator::delete
	 * ----------------------------------------------------------
	 * 描述::管理员删除方法
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
		$log=new CurrLog(2,4,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'操作员管理','',1,$_GET['id']);
		$log->write();
	}
	/**
	 ***********************************************************
	 *方法::Operator::check
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
		echo $this->service->checkOpera(NULL,$_GET['id']) ? 4000:4004;
	}
	/**
	 ***********************************************************
	 *方法::Operator::findOpera
	 * ----------------------------------------------------------
	 * 描述::获取所有管理员名称
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
	private function findOperas(){
		$list=$this->service->findOpera(array("status"=>1));
		$nameArray=array();
		foreach($list as $l){$nameArray[]=$l['loginName'];}
		return implode(",",$nameArray);
	}
	/**
	 ***********************************************************
	 *方法::Operator::search
	 * ----------------------------------------------------------
	 * 描述::搜素所有管理员
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
		!empty($_POST) && $this->session->setSession($_POST,'userSearch');
		$session=$this->session->getSession('userSearch');
		$AreaServ=new AreaService();
		$DictServ=new DictionaryService();
		$RoleServ=new RoleService();
		$find=empty($_GET['p'])?1:$_GET['p'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getSearchTotal($session['name'],$session['roleId'],$session['areaId'],$session['sector'],$session['userStatus']),100,$find);
		$area=$AreaServ->findArea(array("status"=>1,"parentId"=>0));count($area)>0 && $data['area']=$area;
		$dict=$DictServ->findDict(array("status"=>1,"id<="=>6));count($dict)>0 && $data['dict']=$dict;
		$role=$RoleServ->findRole();count($role)>0 && $data['role']=$role;
		$data['page']=$page->showPage();
		$data['list']=$this->service->search($session['name'],$session['roleId'],$session['areaId'],$session['sector'],$session['userStatus'],$find);
		$data['user']=$this->findOperas();
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'操作员管理','',1,NULL);
		$log->write();
		$this->load->view('admin/OperatorList.html',$data);
	}
}