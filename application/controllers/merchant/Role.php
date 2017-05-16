<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-24
**描述：权限管理控制器类。
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Role extends CI_Controller {
	#.引用属性，每个控制器都需要有
	private $includes;
	private $session;
	private $system;
	private $service;
	/**
	 ***********************************************************
	 *方法::Role::__construct
	 * ----------------------------------------------------------
	 * 描述::权限管理控制器初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function __construct(){
		parent::__construct();
		$this->includes=new Includes(__FILE__);
		$this->includes->libraries('CurrSystem');
		$this->includes->services('RoleService');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrPage');
		$this->includes->libraries('CurrSession');
		$this->includes->services("InformationService");
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->service=new RoleService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法::Role::index
	 * ----------------------------------------------------------
	 * 描述::权限管理控制器主页
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.14  Add by zwx
	 ************************************************************
	 */
	public function index(){
		$this->session->checkSession('Merchant');
		$find=empty($_GET['p'])?1:$_GET['p'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getTotal(),20,$find);
		$data['page']=$page->showPage();
		$data['list']=$this->service->getList($find);
		$data['role']=$this->findRoles();
		$log=new CurrLog(2,3,$this->session->getSession('Merchant','loginName'),$this->system->getSystemTime('A'),'权限角色管理','',2,NULL);
		$log->write();
		$this->load->view('merchant/RoleList.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Role::add
	 * ----------------------------------------------------------
	 * 描述::权限管理控制器增加页面
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function add(){
		$this->session->checkSession('Merchant');
		$provider=new InformationService();
		$one=$provider->getInformation($this->session->getSession("Merchant","providerId"));
		$data['menu']=$this->service->getNavList($one['isCompany']);
		$this->load->view('merchant/RoleAdd.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Role::update
	 * ----------------------------------------------------------
	 * 描述::权限管理控制器修改页面
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function update(){
		$this->session->checkSession('Merchant');
		$provider=new InformationService();
		$one=$provider->getInformation($this->session->getSession("Merchant","providerId"));
		$data['menu']=$this->service->getNavList($one['isCompany']);
		$once=$this->service->getRole($_GET['id']);
		count($once)>0 && $data['ones']=$once[0];
		$role=$this->service->getRole(NULL,$_GET['id']);
		$data['role']=count($role)>0?$role:array(array('sector'=>0));
		$log=new CurrLog(2,3,$this->session->getSession('Merchant','loginName'),$this->system->getSystemTime('A'),'权限角色管理','',2,$_GET['id']);
		$log->write();
		$this->load->view('merchant/RoleUpdate.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Role::added
	 * ----------------------------------------------------------
	 * 描述::权限管理控制器新增方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function added(){
		$this->session->checkSession('Merchant');
		$data=$_POST;
		$mess=$this->system->remind();
		  if(!$this->service->checkRole($data['name'])){
			  	 $id=$this->service->addRole(array("roleName"=>$data['name'],
			  	 													   			"description"=>$data['description'],
					  	 														"status"=>1,
					  	 														"providerId"=>$this->session->getSession('Merchant','providerId'),
					  	 														"createTime"=>$this->session->getSession('Merchant','loginName'),
					  	 														"operatorName"=>$this->session->getSession('Merchant','loginName'),
					  	 														"operationTime"=>$this->system->getSystemTime('A')));
			  	 if($id){
			  	 	foreach ($data['role'] as $ro){
			  	 		$this->service->addRoleInfo(array("adminRolesID"=>$id,
			  	 														   "sector"=>$ro,
			  	 														   "symbol"=>implode(';',$data['H'.$ro]),
			  	 															"status"=>1,
			  	 				 											"operatorName"=>$this->session->getSession('Merchant','loginName'),
			  	 															"operationTime"=>$this->system->getSystemTime('A')));
			  	   }
			  	   $mess=$this->system->remind(1);
			  	 }else{
			  	  $mess=$this->system->remind(2);
			  	 }
		  }else{
		  	 $mess=$this->system->remind(3);
		  }
		$this->load->view('admin/message.html',$mess);
	}
	/**
	 ***********************************************************
	 *方法::Role::updated
	 * ----------------------------------------------------------
	 * 描述::权限管理控制器修改方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function updated(){
		$this->session->checkSession('Merchant');
		$data=$_POST;
		$role=array("roleName"=>$data['name'],
								"description"=>$data['description'],
							    "status"=>1,
								"operatorName"=>$this->session->getSession('Merchant','loginName'),
								"operationTime"=>$this->system->getSystemTime('A'));
		$mess=$this->system->remind();
		$before=$this->service->getRole(NULL,$data['id']);
		#.删除原有菜单
		foreach($before as $be){
			$this->service->deleteRoleInfo($data['id'],$be['sector']);
		}
		if($this->service->checkRole(NULL,$data['id'])){
			foreach ($data['role'] as $ro){
				$this->service->addRoleInfo(array("adminRolesID"=>$data['id'],
						"sector"=>$ro,
						"symbol"=>implode(';',$data['H'.$ro]),
						"status"=>1,
						"operatorName"=>$this->session->getSession('Merchant','loginName'),
						"operationTime"=>$this->system->getSystemTime('A')));
			}
			$mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(4);
		}
		$this->load->view('admin/message.html',$mess);
	}
	/**
	 ***********************************************************
	 *方法::Role::delete
	 * ----------------------------------------------------------
	 * 描述::权限管理控制器删除方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function delete(){
		$this->session->checkSession('Merchant');
		header('Access-Control-Allow-Origin: *');
		echo $this->service->delete($_GET['id']) ?4000:4004;
		$log=new CurrLog(2,4,$this->session->getSession('Merchant','loginName'),$this->system->getSystemTime('A'),'权限角色管理','',2,$_GET['id']);
		$log->write();
	}
	/**
	 ***********************************************************
	 *方法::Role::check
	 * ----------------------------------------------------------
	 * 描述::检测记录状态接口
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function check(){
		$this->session->checkSession('Merchant');
		header('Access-Control-Allow-Origin: *');
		echo $this->service->checkRole(NULL,$_GET['id']) ? 4000:4004;
	}
	/**
	 ***********************************************************
	 *方法::Role::search
	 * ----------------------------------------------------------
	 * 描述::权限搜索接口
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function search(){
		$this->session->checkSession('Merchant');
		$data=$_POST;
		$data['providerId']=$this->session->getSession('Merchant','providerId');
		$data['status']=1;
		$data['list']=$this->service->findRole($data);
		$data['role']=$this->findRoles();
		$data['page']='';
		$log=new CurrLog(2,3,$this->session->getSession('Merchant','loginName'),$this->system->getSystemTime('A'),'权限角色管理','',2,NULL);
		$log->write();
		$this->load->view('merchant/RoleList.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Role::findRoles
	 * ----------------------------------------------------------
	 * 描述::获取所有权限角色接口
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	private function findRoles(){
		$this->session->checkSession('Merchant');
		$list=$this->service->findRole(array("status"=>1,"providerId"=>$this->session->getSession('Merchant','providerId')));
		$nameArray=array();
		foreach($list as $l){$nameArray[]=$l['roleName'];}
		return implode(",",$nameArray);
	}
}