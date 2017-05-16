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
	 * 描述::商户端主页初始化页面
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
		$this->includes->services("InformationService");
		$this->includes->services("MessagesService");
		$this->includes->services("ModelsService");
		$this->includes->services('RoleService');
		$this->includes->models("DataBase","global");
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法:Index::index
	 * ----------------------------------------------------------
	 * 描述::商户端主页开始页面
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
		$Anydata    = new DataBase();
		$this->session->checkSession('Merchant');
		$this->session->getSession('Merchant','id');
		$message=new MessagesService();
		$data['mess']=$message->getList(1);
		$models=new ModelsService();
		$data['model']=$models->getModelList();
		empty($_SESSION['modelid']) && $_SESSION['modelid']=$data['model'][count($data['model'])-1]['id'];
		//--获取用户头像
		$data['head']=$Anydata->select(21,array("id"=>$this->session->getSession('Merchant','id'),"status<>"=>'2'));
		//print_r($data['head']);die;
		$data['jsonhead']=json_encode($data['head'][0]['headPicture']);
		$this->load->view('merchant/index.html',$data);
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
		$this->session->checkSession('Merchant');
		!empty($_SESSION['modelid']) && !empty($_POST['modelid']) && $_SESSION['modelid']=$_POST['modelid'];
		 echo 4000;
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
		 $_SESSION['Merchant']=NULL;
		 echo '<script>window.top.location.href="'.base_url().'index.php/merchant/login"</script>';
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
		 $this->load->view('merchant/think.html');
	 }
	 public function password(){
		$this->session->checkSession('Merchant');
		$data['id']=$this->session->getSession('Merchant','id');
		$this->load->view('merchant/password.html',$data);
	 }
	 public function help(){
	 	$this->load->view('merchant/Help.html');
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
		$this->session->checkSession('Merchant');
		$data=$_POST;
		$user= new OperatorService();
		$mess=$this->system->remind();
		if($user->checkOpera(NULL,$data['id'])){
			$data['userPwd']=md5($data['userPwd']);
			$data['operatorName']=$this->session->getSession('Merchant','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$user->saveOpera($data['id'],$data) && $mess=$this->system->remind(1,'merchant/Index/exiti');
		}else{
			$mess=$this->system->remind(4);
		}
		$this->load->view('merchant/message.html',$mess);
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
	 	$this->session->checkSession('Merchant');
	 	$role=new RoleService();
	 	$tree=$role->getRoleTree($this->session->getSession('Merchant','staffRoleId'));
	 	$service=new InformationService();
	 	$once=$service->getInformation($this->session->getSession("Merchant","providerId"));
	 	#.权限总数组
	 	$userRole=array();
	 	#.权限组用户基础信息
	 	$userRole['user']=array("id"=>$this->session->getSession('Merchant','id'),
	 												"name"=>$this->session->getSession('Merchant','loginName'),
	 												"logo"=>$this->session->getSession('Merchant','headPicture'),
	 												"status"=>$once['auditStatus'],
	 												"mess"=>$once['ontInfo']);
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
	/**
	 ***********************************************************
	 *方法:Index::mainPage
	 * ----------------------------------------------------------
	 * 描述::商户端主页
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.03.17  Add by hjm
	 ************************************************************
	 */
	public function main(){
		$service=new InformationService();
	    $once=$service->getInformation($this->session->getSession("Merchant","providerId"));
	    $once['isCompany']==1 && redirect('merchant/Anastore/storeMain'); 
	    $once['isCompany']==3 && redirect('merchant/Factory/FactoryIndex');
	    $once['isCompany']==0 && redirect('merchant/Maingroup/index');
	}
	/**保存用户图像*/
	public function setLogo(){
		$this->session->checkSession('Merchant');
		header('Access-Control-Allow-Origin: *');
		$data=$_POST;
		$user= new OperatorService();
		$data['operatorName']=$this->session->getSession('Merchant','loginName');
		$data['operationTime']=$this->system->getSystemTime('A');
		$rows=$user->saveOpera($this->session->getSession("Merchant","providerId"),$data);
		$_SESSION['Merchant']['headPicture']=$data['headPicture'];
		echo $rows>0?$rows:0;
	}
}