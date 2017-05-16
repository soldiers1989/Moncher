<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：采集端数据类
*****************************************************/
defined('BASEPATH')  ||   exit();
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class WeChat extends CI_Controller{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $session;
	private $system;
	private $service;
	/**
	 ***********************************************************
	 *方法::Wechat::__construct
	 * ----------------------------------------------------------
	 * 描述::管理员类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2016.02.25  Add by zwx
	 ************************************************************
	 */
	public function __construct(){
		parent::__construct(); 
		$this->includes=new Includes(__FILE__);
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrSession');
		$this->includes->services('WeChatService');
		$this->session=new  CurrSession();
		$this->system=new  CurrSystem();
		$this->service=new  WeChatService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法::Wechat::index
	 * ----------------------------------------------------------
	 * 描述::微信端页面显示
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2016.02.25  Add by zwx
	 ************************************************************
	 */
	public function index(){
		$openId=$_GET['openid'];$merchantId=$_GET['id'];
		$provider=$this->service->findMerchantInfo($merchantId);
		$person=$this->service->findPersonInfo($openId);
		$tactic=$this->service->findSelStrategy();
		$model=$this->service->findSelModels($tactic['modelId']);
		$modul=$this->service->findSelMoudles($tactic['modelId']);
		$history=$this->service->findHistoryMoudles(empty($person['id'])?0:$person['id'],$merchantId,$tactic['modelId']);
		$user=array("merchantId"=>$merchantId,"areaId"=>$provider['areaId'],"groupId"=>$provider['groupId'],"openId"=>$openId,
								"moduleId"=>'','moduleTitle'=>'',"strategyId"=>$tactic['id'],"strategyTitle"=>$tactic['title'],
								 "modelId"=>$model['id'],"modelTitle"=>$model['title'], "questionnaireId"=>'0',"resultScore"=>'',"resultAllScore"=>'',
								 "personId"=>empty($person)?0:$person['id'],"carId"=>empty($person)?0:$person['carModelId'],
								 "brandId"=>empty($person)?0:$person['brandId'],"primitive"=>0,
								 "size"=>$this->service->findMerchantPersonSize($merchantId,$tactic['modelId']),
								 "beginTime"=>'',"endTime"=>'',"latitude"=>"","longitude"=>"",
								 "age"=>empty($person)?0:$person['age'],"rank"=>empty($person)?0:$person['rank'],"sex"=>empty($person)?0:$person['sex'],
								 "year"=>empty($person)?0:$person['carPeriod'],"vocation"=>empty($person)?0:$person['occupation'],"money"=>empty($person)?0:$person['income'],
								 "education"=>empty($person)?'':$person['qualifications'],"models"=>$modul,"historyScore"=>$history
		);
		$data['json']=json_encode($user);
		$this->load->view('wechat/wechat.html',$data); 
	}
	/**基础版本*/
	public function basis(){
		$openId=$_GET['openid'];$merchantId=$_GET['id'];
		$provider=$this->service->findMerchantInfo($merchantId);
		$person=$this->service->findPersonInfo($openId);
		$tactic=$this->service->findSelStrategy();
		$model=$this->service->findSelModels($tactic['modelId']);
		$modul=$this->service->findSelMoudles($tactic['modelId']);
		$history=$this->service->findHistoryMoudles(empty($person['id'])?0:$person['id'],$merchantId,$tactic['modelId']);
		$user=array("merchantId"=>$merchantId,"areaId"=>$provider['areaId'],"groupId"=>$provider['groupId'],"openId"=>$openId,
				"moduleId"=>'','moduleTitle'=>'',"strategyId"=>$tactic['id'],"strategyTitle"=>$tactic['title'],
				"modelId"=>$model['id'],"modelTitle"=>$model['title'], "questionnaireId"=>'0',"resultScore"=>'',"resultAllScore"=>'',
				"personId"=>empty($person)?0:$person['id'],"carId"=>empty($person)?0:$person['carModelId'],
				"brandId"=>empty($person)?0:$person['brandId'],"primitive"=>0,
				"size"=>$this->service->findMerchantPersonSize($merchantId,$tactic['modelId']),
				"beginTime"=>'',"endTime"=>'',"latitude"=>"","longitude"=>"",
				"age"=>empty($person)?0:$person['age'],"rank"=>empty($person)?0:$person['rank'],"sex"=>empty($person)?0:$person['sex'],
				"year"=>empty($person)?0:$person['carPeriod'],"vocation"=>empty($person)?0:$person['occupation'],"money"=>empty($person)?0:$person['income'],
				"education"=>empty($person)?'':$person['qualifications'],"models"=>$modul,"historyScore"=>$history
		);
		$data['json']=json_encode($user);
		$this->load->view('wechat/wechatone.html',$data);
	}
	/**三国版本*/
	public function sanguo(){
		$openId=$_GET['openid'];$merchantId=$_GET['id'];
		$provider=$this->service->findMerchantInfo($merchantId);
		$person=$this->service->findPersonInfo($openId);
		$tactic=$this->service->findSelStrategy();
		$model=$this->service->findSelModels($tactic['modelId']);
		$modul=$this->service->findSelMoudles($tactic['modelId']);
		$history=$this->service->findHistoryMoudles(empty($person['id'])?0:$person['id'],$merchantId,$tactic['modelId']);
		$user=array("merchantId"=>$merchantId,"areaId"=>$provider['areaId'],"groupId"=>$provider['groupId'],"openId"=>$openId,
								"moduleId"=>'','moduleTitle'=>'',"strategyId"=>$tactic['id'],"strategyTitle"=>$tactic['title'],
								"modelId"=>$model['id'],"modelTitle"=>$model['title'], "questionnaireId"=>'0',"resultScore"=>'',"resultAllScore"=>'',
								"personId"=>empty($person)?0:$person['id'],"carId"=>empty($person)?0:$person['carModelId'],
								"brandId"=>empty($person)?0:$person['brandId'],"primitive"=>0,
								"size"=>$this->service->findMerchantPersonSize($merchantId,$tactic['modelId']),
								"beginTime"=>'',"endTime"=>'',"latitude"=>"","longitude"=>"",
								"age"=>empty($person)?0:$person['age'],"rank"=>empty($person)?0:$person['rank'],"sex"=>empty($person)?0:$person['sex'],
								"year"=>empty($person)?0:$person['carPeriod'],"vocation"=>empty($person)?0:$person['occupation'],"money"=>empty($person)?0:$person['income'],
								"education"=>empty($person)?'':$person['qualifications'],"models"=>$modul,"historyScore"=>$history
		);
		$data['json']=json_encode($user);
		$this->load->view('wechat/wechat_sanguo.html',$data);
	}
	/**获取品牌列表*/
	public function getBrand(){
		header('Access-Control-Allow-Origin: *');
		echo  $this->service-> getBrand($_POST['brandid']);
	}
   /**获取试题接口*/
	public function getQuestionOne(){
		header('Access-Control-Allow-Origin: *');
		echo $this->service->getQuestionOne($_GET['id'],$_GET['qid'],$_GET['vid']);
	}
    /**保存微信问卷结果*/
	public function added(){
		date_default_timezone_set('PRC');
		#.接收用户提交数据
		$userdata = json_decode($_POST['userdata'],TRUE);
		#.接收答案的数据
		$answdata = json_decode($_POST['answdata'],TRUE);
		#.设置各种权重
		$personid=$userdata['personId']==0 ? $this->service->addPerson($userdata):$userdata['personId'];
		$resultid  =$this->service->addResult($userdata,$personid);
		$this->service->addProcess($userdata['questionnaireId'],$answdata,$resultid);
		$this->service->saveSelResult($resultid,$this->service->findSelResults($resultid));
		$userdata['personId']==0 && $userdata['personId']=$personid;
		$userdata['resultScore']=$this->service->findSelfResult($resultid);
		$userdata['resultAllScore']=$this->service->findAllResult($userdata['questionnaireId'],$userdata['merchantId']);
		unset($userdata['historyScore']);$userdata['historyScore']=$this->service->findHistoryMoudles($userdata['personId'],$userdata['merchantId'],$userdata['modelId']);
		echo json_encode($userdata);
	}
}
