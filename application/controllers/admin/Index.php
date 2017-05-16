<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：系统主页控制器类
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Index extends CI_Controller {
	#.引用属性，每个控制器都需要有
	private $includes;
	private $session;
	private $system;
	private $service;
	/**
	 ***********************************************************
	 *方法:Index::__construct
	 * ----------------------------------------------------------
	 * 描述::后台主页初始化页面
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
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrSession');
		$this->includes->services('OperatorService');
		$this->includes->services('RoleService');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法:Index::index
	 * ----------------------------------------------------------
	 * 描述::后台主页开始页面
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
		$this->load->view('admin/index.html');
	}
	/**
	 ***********************************************************
	 *方法:Index::start
	 * ----------------------------------------------------------
	 * 描述::后台主页开始页面
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
	public function start(){
		$this->session->checkSession('Admin');
		$this->load->view('admin/start.html');
	}
		/**
	 ***********************************************************
	 *方法:Index::exiti
	 * ----------------------------------------------------------
	 * 描述::后台主页用户退出登录操作
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
	 public function exiti(){
		 $_SESSION['Admin']=NULL;
		 echo '<script>window.top.location.href="'.base_url().'index.php/admin/login"</script>';
	 }
	 /**
	 ***********************************************************
	 *方法:Index::pssword
	 * ----------------------------------------------------------
	 * 描述::后台主页用户修改密码主页
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
	 public function think(){
		 $this->load->view('admin/think.html');
	 }
	 /**
	  ***********************************************************
	  *方法:Index::pssword
	  * ----------------------------------------------------------
	  * 描述::后台主页用户修改密码主页
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
	 public function password(){
		$this->session->checkSession('Admin');
		$data['id']=$this->session->getSession('Admin','id');
		$this->load->view('admin/password.html',$data);
	 }
	 /**
	 ***********************************************************
	 *方法:Index::setPssword
	 * ----------------------------------------------------------
	 * 描述::后台主页用户修改密码
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
	 public function setPassword(){
		$this->session->checkSession('Admin');
		$data=$_POST;
		$user= new OperatorService();
		$mess=$this->system->remind();
		if($user->checkOpera(NULL,$data['id'])){
			$data['userPwd']=md5($data['userPwd']);
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$user->saveOpera($data['id'],$data) && $mess=$this->system->remind(1,'admin/Index/exiti');
		}else{
			$mess=$this->system->remind(4);
		}
		$this->load->view('admin/message.html',$mess);
	 }
	/**
	 ***********************************************************
	 *方法:Index::getUserRole
	 * ----------------------------------------------------------
	 * 描述::后台主页获取用户权限
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
	public function getUserRole(){
		header('Access-Control-Allow-Origin: *');
		$role=new RoleService();
		$tree=$role->getRoleTree($this->session->getSession('Admin','staffRoleId'));
		#.权限总数组
		$userRole=array();
		#.权限组用户基础信息
		$userRole['user']=array("id"=>$this->session->getSession('Admin','id'),"name"=>$this->session->getSession('Admin','loginName'),"logo"=>'admin/images/admin-index-logo.png');
		$userRole['role']=array();
		#.设置循环菜单变量
		$menuId=0;
		$index=0;
		#.循环设置权限组
		for($i=0;$i<count($tree);$i++){
			if($menuId != $tree[$i]['pId']){
				$menuId=$tree[$i]['pId'];
				$userRole['role'][$index]=array('id'=>$tree[$i]['pId'],'icon'=>$tree[$i]['iconUrl'],'title'=>$tree[$i]['title']);
				for($s=$i;$s<count($tree);$s++){
					if($menuId==$tree[$s]['pId']){
						$userRole['role'][$index]['menu'][]=array('title'=>$tree[$s]['navTitle'],"url"=>$tree[$s]['navUrl'],"symbol"=>$tree[$s]['symbol']);
					}else{
						$i=$s-1;
						break;
					}
				}
				$index++;
			}
		}
		echo json_encode($userRole);
	}
}