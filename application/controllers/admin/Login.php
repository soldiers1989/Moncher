<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：登录操作控制器类
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Login extends CI_Controller {
	#.引用属性，每个控制器都需要有
	private $includes;
	private $session;
	private $system;
	private $service;
	/**
	 ***********************************************************
	 *方法::Login::__construct
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
		$this->includes->services('LoginService');
		$this->includes->libraries('CurrVerify');
		$this->includes->libraries('CurrEncode');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrSession');
		$this->includes->libraries('CurrLog');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->service=new LoginService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法::Login::index
	 * ----------------------------------------------------------
	 * 描述::登录页面
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
	public function index($error){
		$data['error']=$error==''?'':$error;
		$this->load->view('admin/Login.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Login::logined
	 * ----------------------------------------------------------
	 * 描述::登录方法
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
	public function Logined(){
		$encode=new CurrEncode();
		if($this->checkVerify()){
			$user=$this->service->checkLogin($_POST['userName'],$encode->getMd5($_POST['passWord']));
			if(!empty($user)){
				/**此处跳转到修改密码页面*/
				if($_POST['passWord']=='000000') return;
				$data=array(
						"token"=>$encode->getBase64($_POST['userName'].$this->system->getSystemTime('T')),
						"lastTime"=>$this->system->getSystemTime('A'),
						"lastIP"=>$this->system->getClientIP()
				);
				$this->service->saveUser($user['id'],$data);
				$last=$this->service->checkLogin($_POST['userName'],$encode->getMd5($_POST['passWord']));
				if(!empty($last)){
					$log=new CurrLog(2,1,$user['loginName'],$this->system->getSystemTime('A'),'平台登录','',1,$last['id']);
					$log->write($user,$last);
					$this->session->setSession($last,'Admin');
					redirect('admin/index');
				}
			}else{
				    $data['error']='登录失败！请核对用户名和密码！';
					$this->index( $data['error']);
			}
		}else{
			 $data['error']='验证码无效！';
			 $this->index( $data['error']);
		}
	}
	/**
	 ***********************************************************
	 *方法::Login::checkUser
	 * ----------------------------------------------------------
	 * 描述::检测用户名合法性
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
	public function checkUser(){
		header('Access-Control-Allow-Origin: *');
		$message=4004;
		$this->service->checkUser($_POST['userName']) && $message=4000;
		echo $message;
	}
	/**
	 ***********************************************************
	 *方法::Login::checkVerify
	 * ----------------------------------------------------------
	 * 描述::检测验证码合法性
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
	public function checkVerify(){
		header('Access-Control-Allow-Origin: *');
		$message=false;
		$verify=new CurrVerify();
		$verify->check($_POST['code']) && $message=true;
		return  $message;
	}
	/**
	 ***********************************************************
	 *方法::Login::findCode
	 * ----------------------------------------------------------
	 * 描述::获取验证码接口
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
	public function findCode(){
		$verify=new CurrVerify(array('useZh'=>false,'length'=>4,'imageW'=>96,'imageH'=>50,'fontSize'=>24));
		$verify->entry();
	}
}