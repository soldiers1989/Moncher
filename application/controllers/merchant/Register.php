<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：登录操作控制器类
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Register extends CI_Controller {
	#.引用属性，每个控制器都需要有
	private $includes;
	private $system;
	private $session;
	private $service;
	/**
	 ***********************************************************
	 *方法::Register::__construct
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
		$this->includes->services('RegisterService');
		$this->includes->libraries('CurrVerify');
		$this->includes->libraries('CurrEncode');
		$this->includes->libraries('CurrUpload');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrLog');
		$this->includes->models("DataBase","global");
		$this->service=new RegisterService();
		$this->system=new CurrSystem();
		$this->session=new CurrSession();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法::Register::index
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
	public function index(){
		$this->load->view('merchant/Register.html');
	}
	public function roleAdd(){
	   $this->service->addRoots();
	}
	/**
	 ***********************************************************
	 *方法::Register::logined
	 * ----------------------------------------------------------
	 * 描述::注册方法
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
	public function Registed(){
		$data=$_POST;
		$user=array("loginName"=>$data['loginName'],"userPwd"=>md5($data['userPwd']));
		$type=array("0"=>2,"1"=>1,"3"=>3);
		$provider=array( "isCompany"=>$data['isCompany'],
										"cellPhone"=>$data['cellPhone'],
										"personName"=>$data['personName'],
										"hasSigning"=>$data['hasSigning'],
										"status"=>1,
										"auditStatus"=>0,
										"operatorName"=>"商户注册",
										"operationTime"=>$this->system->getSystemTime("A"));
		if($data['isCompany']==0){
			$provider['name']=$data['G-name'];
			$provider['addrRess']=$data['G-address'];
			$provider['logo']=$data['G-logo'];
			$provider['areaId']=$data['G-areaId'];
			$provider['picture']=$data['G-picture'];
			$provider['descriPtion']=$data['G-descriPtion'];
			$id=$this->service->addMerchant($provider);
			$rid=$this->service->addRoot($id,$type[$data['isCompany']],$user);
			$mess=$rid>0?$this->system->remind(1,'merchant/Login/index'):$this->system->remind(4,'merchant/Register/index');
			$this->load->view('admin/message.html',$mess);
		}else if($data['isCompany']==1){
			$provider['name']=$data['M-name'];
			$provider['addrRess']=$data['M-address'];
			$provider['areaId']=$data['M-areaId'];
			$provider['logo']=$data['M-logo'];
			$provider['telePhone']=$data['M-telePhone'];
			$provider['wechat']=$data['M-wechat'];
			$provider['employeeNumber']=$data['M-employeeNumber'];
			$provider['stationNum']=$data['M-stationNum'];
			$provider['acreage']=$data['M-acreage'];
			$provider['picture']=$data['M-picture'];
			$provider['revenue']=$data['M-revenue'];
			$provider['license']=$data['M-license'];
			$provider['brandId1']=$data['M-brandId1'];
			$provider['brandId2']=$data['M-brandId2'];
			$provider['brandId3']=$data['M-brandId3'];
			$provider['descriPtion']=$data['M-descriPtion'];
			$provider['openingTime']=$data['M-openingTime'];
			$provider['openTime']=$data['startTime'].'-'.$data['endTime'];
			$provider['qualification']=$data['qualification'];
			$provider['serviceDescription']=implode(";",$data['serviceDescription']);
			$id=$this->service->addMerchant($provider);
			$rid=$this->service->addRoot($id,$type[$data['isCompany']],$user);
			$mess=$rid>0?$this->system->remind(1,'merchant/Login/index'):$this->system->remind(4,'merchant/Register/index');
			$this->load->view('admin/message.html',$mess);
		}else if($data['isCompany']==3){
			$provider['name']=$data['B-name'];
			$provider['addrRess']=$data['B-address'];
			$provider['areaId']=$data['B-areaId'];
			$provider['brandId1']=$data['B-brandId'];
			$provider['descriPtion']=$data['B-descriPtion'];
			$id=$this->service->addMerchant($provider);
			$rid=$this->service->addRoot($id,$type[$data['isCompany']],$user);
			$mess=$rid>0?$this->system->remind(1,'merchant/Login/index'):$this->system->remind(4,'merchant/Register/index');
			$this->load->view('admin/message.html',$mess);
		}
	}
	/**
	 ***********************************************************
	 *方法::Register::checkUser
	 * ----------------------------------------------------------
	 * 描述::检测名称合法性
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
		echo $this->service->checkUser($_POST['userName'])?4004:4000;
	}
	/**
	 ***********************************************************
	 *方法::Register::checkNumber
	 * ----------------------------------------------------------
	 * 描述::检测电话合法性
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
	public function checkNumber(){
		header('Access-Control-Allow-Origin: *');
		echo $this->service->checkNumber($_POST['number'])?4004:4000;
	}
	/**
	 ***********************************************************
	 *方法::Register::checkName
	 * ----------------------------------------------------------
	 * 描述::检测商户名合法性
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
	public function checkName(){
		header('Access-Control-Allow-Origin: *');
		echo $this->service->checkName($_POST['name'])?4004:4000;
	}
	/**
	 ***********************************************************
	 *方法::Register::addPic
	 * ----------------------------------------------------------
	 * 描述::上传图片接口
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
	public function addPic(){
		header('Access-Control-Allow-Origin: *');
		$upload=new CurrUpload(array("max"=>1024,"min"=>1,"path"=>'./upload/merchant/images/',"files"=>$_FILES));
		
		$logo=!empty($upload)?$upload->getUrls(1):NULL;
		echo json_encode($logo);
	}
	/**
	 ***********************************************************
	 *方法::Register::addPic
	 * ----------------------------------------------------------
	 * 描述::上传图片接口(头像)
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
	public function addPichead(){
		$Anydata    = new DataBase();
		$this->session->checkSession('Merchant');
		$userid=$_POST['id'];
		header('Access-Control-Allow-Origin: *');
		$upload=new CurrUpload(array("max"=>1024,"min"=>1,"path"=>'./upload/merchant/images/',"files"=>$_FILES));
		$logo=!empty($upload)?$upload->getUrls(1):NULL;
		$loguser=$Anydata->select(21,array("id"=>$userid,"status<>"=>'2'));
		$muse=array("headPicture"=>$logo['image']['url']?$logo['image']['url']:$loguser[0]['headPicture']);
		$where=array("id"=>$userid,"status<>"=>'2');
		$uped= $Anydata->update(21,$where,$muse);
		echo json_encode($logo);
	}
	/**
	 ***********************************************************
	 *方法::Register::addPic
	 * ----------------------------------------------------------
	 * 描述::获取品牌列表接口
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
	public function getBrand(){
		header('Access-Control-Allow-Origin: *');
		echo json_encode($this->service->getBrand($_POST['brandId']));
	}
	/**
	 ***********************************************************
	 *方法::Register::addPic
	 * ----------------------------------------------------------
	 * 描述::获取区域列表接口
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
	public function getArea(){
		header('Access-Control-Allow-Origin: *');
		echo json_encode($this->service->getArea($_POST['areaId']));
	}
	/*会养车服务条款*/
   public function Agreement(){
   	$this->load->view('merchant/Agreement.html');
   }
}
