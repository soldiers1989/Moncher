<?php
/*****************************************************
 **作者：zwx
**创始时间：2017-04-08
**描述：集团分析
*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class Anagroup extends CI_Controller {
	#.引用属性，每个控制器都需要有
	private $includes;
	private $system;
	private $session;
	private $service;
	/**
	 ***********************************************************
	 *方法::Anagroup::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.08  Add by zwx
	 ************************************************************
	 */
	public function __construct(){
		parent::__construct();
		$this->includes=new Includes(__FILE__);
		$this->includes->services('AnagroupService');
		$this->includes->services('AnastoreService');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrSession');
		$this->includes->libraries('CurrLog');
		$this->system=new CurrSystem();
	    $this->session=new CurrSession();
		$this->service=new AnastoreService();
		$this->load->helper('url');
	}
	/**
	 ***********************************************************
	 *方法::Anagroup::groupEvala
	 * ----------------------------------------------------------
	 * 描述::评测分析总体模式
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.08  Add by zwx
	 ************************************************************
	 */
	public function groupEvala(){
		$service=new AnagroupService();
		$data['area']=$service->getAreaList();
		$data['brand']=$service->getBrandList();
		$data['merchant']=$service->getMerchantList();
		$data['startDate']=empty($_POST['startDate'])?date('Y-m',strtotime('-1 month')):$_POST['startDate'];
		$data['lastDate']=empty($_POST['lastDate'])?date('Y-m',time()):$_POST['lastDate'];
		$mon=array('01'=>"一月","02"=>"二月","03"=>"三月","04"=>"四月","05"=>"五月","06"=>"六月","07"=>"七月","08"=>"八月","09"=>"十月","11"=>"十一月","12"=>"十二月");
		$data['start']=$mon[date('m',strtotime($data['startDate']))];
		$data['last']=$mon[date('m',strtotime($data['lastDate']))];
		$data['score']=$service->getEvalAllScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['startDate'],$data['lastDate']);
		$data['model']=$service->getEvalAllModelScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['startDate'],$data['lastDate']);
		$data=$service->getEvalaQuestionTop($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['startDate'],$data['lastDate'],$data);
		$this->load->view('merchant/GroupEvala.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Anagroup::groupEvali
	 * ----------------------------------------------------------
	 * 描述::评测分析总体单店模式
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.08  Add by zwx
	 ************************************************************
	 */
	public function groupEvali(){
		$service=new AnagroupService();
		$data['area']=$service->getAreaList();
		$data['brand']=$service->getBrandList();
		$data['merchant']=$service->getMerchantList();
		$data['startDate']=empty($_POST['startDate'])?date('Y-m',strtotime('-1 month')):$_POST['startDate'];
		$data['lastDate']=empty($_POST['lastDate'])?date('Y-m',time()):$_POST['lastDate'];
		$mon=array('01'=>"一月","02"=>"二月","03"=>"三月","04"=>"四月","05"=>"五月","06"=>"六月","07"=>"七月","08"=>"八月","09"=>"十月","11"=>"十一月","12"=>"十二月");
		$data['start']=$mon[date('m',strtotime($data['startDate']))];
		$data['last']=$mon[date('m',strtotime($data['lastDate']))];
		$data['providerid']=empty($_POST['providerid'])?0:$_POST['providerid'];
		$data['score']=$service->getEvaliScore($data['providerid'],$_SESSION['modelid'],$data['startDate'],$data['lastDate']);
		$data['model']=$service->getEvaliModelScore($data['providerid'],$_SESSION['modelid'],$data['startDate'],$data['lastDate']);
		$data=$service->getEvaliQuestionTop($data['providerid'],$_SESSION['modelid'],$data['startDate'],$data['lastDate'],$data);
		$NPS=$service->getNPS($data['providerid'],$_SESSION['modelid'],$data['startDate'],$data['lastDate']);
		$data['jsonNPS']=json_encode($NPS);
	    $data['treeNPS']=$NPS;
		$this->load->view('merchant/GroupEvali.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Anagroup::groupEvalii
	 * ----------------------------------------------------------
	 * 描述::评测分析总体双店模式
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.08  Add by zwx
	 ************************************************************
	 */
	public function groupEvalii(){
		$service=new AnagroupService();
		$data['area']=$service->getAreaList();
		$data['brand']=$service->getBrandList();
		$data['merchant']=$service->getMerchantList();
		$data['startDate']=empty($_POST['startDate'])?date('Y-m',time()):$_POST['startDate'];
		$data['start']=empty($_POST['m1'])?'':$_POST['m1'];
		$data['last']=empty($_POST['m2'])?'':$_POST['m2'];
		$data['provideri']=empty($_POST['provideri'])?0:$_POST['provideri'];
		$data['providerii']=empty($_POST['providerii'])?0:$_POST['providerii'];
		$data['score']=$service->getEvaliiScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['startDate'],$data['provideri'],$data['providerii']);
		$data['model']=$service->getEvaliiModelScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['startDate'],$data['provideri'],$data['providerii']);
		$data=$service->getEvaliiQuestionTop(2,$data['provideri'],$data['providerii'],$data['startDate'],$data);
		$this->load->view('merchant/GroupEvalii.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Anagroup::groupBrandi
	 * ----------------------------------------------------------
	 * 描述::评测分析单品牌模式
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.08  Add by zwx
	 ************************************************************
	 */
	public function groupBrandi(){
		$service=new AnagroupService();
		$data['area']=$service->getAreaList();
		$data['brand']=$service->getBrandList();
		$data['merchant']=$service->getMerchantList();
		$data['startDate']=empty($_POST['startDate'])?date('Y-m',strtotime('-1 month')):$_POST['startDate'];
		$data['lastDate']=empty($_POST['lastDate'])?date('Y-m',time()):$_POST['lastDate'];
		$mon=array('01'=>"一月","02"=>"二月","03"=>"三月","04"=>"四月","05"=>"五月","06"=>"六月","07"=>"七月","08"=>"八月","09"=>"十月","11"=>"十一月","12"=>"十二月");
		$data['start']=$mon[date('m',strtotime($data['startDate']))];
		$data['last']=$mon[date('m',strtotime($data['lastDate']))];
		$data['brandid']=empty($_POST['brandid'])?0:$_POST['brandid'];
		$data['areaid']=empty($_POST['areaid'])?0:$_POST['areaid'];
		$data['score']=$service->getBrandiScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['brandid'],$data['startDate'],$data['lastDate'],$data['areaid']);
		$data['model']=$service->getBrandiModelScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['brandid'],$data['startDate'],$data['lastDate'],$data['areaid']);
		$data=$service->getBrandiQuestionTop($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['brandid'],$data['startDate'],$data['lastDate'],$data);
		$this->load->view('merchant/GroupBrandi.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Anagroup::groupBrandii
	 * ----------------------------------------------------------
	 * 描述::评测分析双品牌模式
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.08  Add by zwx
	 ************************************************************
	 */
	public function groupBrandii(){
		$service=new AnagroupService();
		$data['area']=$service->getAreaList();
		$data['brand']=$service->getBrandList();
		$data['merchant']=$service->getMerchantList();
		$data['startDate']=empty($_POST['startDate'])?date('Y-m',time()):$_POST['startDate'];
		$data['start']=empty($_POST['m1'])?'品牌一':$_POST['m1'];
		$data['last']=empty($_POST['m2'])?'品牌二':$_POST['m2'];
		$data['areaid']=empty($_POST['areaid'])?0:$_POST['areaid'];
		$data['brandi']=empty($_POST['brandi'])?0:$_POST['brandi'];
		$data['brandii']=empty($_POST['brandii'])?0:$_POST['brandii'];
	    $data['score']=$service->getBrandiiScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['startDate'],$data['areaid'],$data['brandi'],$data['brandii']);
		$data['model']=$service->getBrandiiModelScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['startDate'],$data['areaid'],$data['brandi'],$data['brandii']);
		$data=$service->getBrandiiQuestionTop($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['brandi'],$data['brandii'],$data['startDate'],$data);
		$this->load->view('merchant/GroupBrandii.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Anagroup::groupAreai
	 * ----------------------------------------------------------
	 * 描述::评测分析单区域模式
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.08  Add by zwx
	 ************************************************************
	 */
	public function groupAreai(){
		$service=new AnagroupService();
		$data['area']=$service->getAreaList();
		$data['brand']=$service->getBrandList();
		$data['merchant']=$service->getMerchantList();
		$data['startDate']=empty($_POST['startDate'])?date('Y-m',strtotime('-1 month')):$_POST['startDate'];
		$data['lastDate']=empty($_POST['lastDate'])?date('Y-m',time()):$_POST['lastDate'];
		$mon=array('01'=>"一月","02"=>"二月","03"=>"三月","04"=>"四月","05"=>"五月","06"=>"六月","07"=>"七月","08"=>"八月","09"=>"十月","11"=>"十一月","12"=>"十二月");
		$data['start']=$mon[date('m',strtotime($data['startDate']))];
		$data['last']=$mon[date('m',strtotime($data['lastDate']))];
		$data['areaid']=empty($_POST['areaid'])?0:$_POST['areaid'];
		$data['score']=$service->getAreaiScore($this->session->getSession("Merchant","providerId"),$data['areaid'],$_SESSION['modelid'],$data['startDate'],$data['lastDate']);
		$data['model']=$service->getAreaiModelScore($this->session->getSession("Merchant","providerId"),$data['areaid'],$_SESSION['modelid'],$data['startDate'],$data['lastDate']);
	    $data=$service->getAreaiQuestionTop($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['areaid'],$data['startDate'],$data['lastDate'],$data);
		$this->load->view('merchant/GroupAreai.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Anagroup::groupAreaii
	 * ----------------------------------------------------------
	 * 描述::评测分析双品牌模式
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.08  Add by zwx
	 ************************************************************
	 */
	public function groupAreaii(){
		$service=new AnagroupService();
		$data['area']=$service->getAreaList();
		$data['brand']=$service->getBrandList();
		$data['merchant']=$service->getMerchantList();
		$data['startDate']=empty($_POST['startDate'])?date('Y-m',time()):$_POST['startDate'];
		$data['start']=empty($_POST['m1'])?'区域一':$_POST['m1'];
		$data['last']=empty($_POST['m2'])?'区域二':$_POST['m2'];
		$data['areai']=empty($_POST['areai'])?0:$_POST['areai'];
		$data['areaii']=empty($_POST['areaii'])?0:$_POST['areaii'];
		$data['score']=$service->getAreaiiScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['startDate'],$data['areai'],$data['areaii']);
		$data['model']=$service->getAreaiiModelScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['startDate'],$data['areai'],$data['areaii']);
		$data=$service->getAreaiiQuestionTop($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['areai'],$data['areaii'],$data['startDate'],$data);
		$this->load->view('merchant/GroupAreaii.html',$data);
	}
	/**
	 ***********************************************************
	 *方法::Anagroup::findEvalaQuestionTop
	 * ----------------------------------------------------------
	 * 描述::评测分析双品牌模式
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.08  Add by zwx
	 ************************************************************
	 */
	public function findEvalaQuestionTop(){
		header('Access-Control-Allow-Origin: *');
		$service=new AnagroupService();
		$data['startDate']=empty($_POST['startDate'])?date('Y-m',time()):$_POST['startDate'];
		$data['endDate']=empty($_POST['endDate'])?date('Y-m',time()):$_POST['endDate'];
		$data['questionnaireid']=empty($_POST['questionnaireid'])?0:$_POST['questionnaireid'];
		$data['rank']=empty($_POST['rank'])?2:$_POST['rank'];
		$list=$service->findEvalaQuestionTop($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['questionnaireid'],$data['startDate'],$data['endDate'],$data['rank']);
		echo json_encode($list);
	}
	/**
	 ***********************************************************
	 *方法::Anagroup::findAreaiQuestionTop
	 * ----------------------------------------------------------
	 * 描述::评测分析双品牌模式
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.08  Add by zwx
	 ************************************************************
	 */
	public function findAreaiQuestionTop(){
		header('Access-Control-Allow-Origin: *');
		$service=new AnagroupService();
		$data['startDate']=empty($_POST['startDate'])?date('Y-m',time()):$_POST['startDate'];
		$data['endDate']=empty($_POST['endDate'])?date('Y-m',time()):$_POST['endDate'];
		$data['rank']=empty($_POST['rank'])?1:$_POST['rank'];
		$data['areaid']=empty($_POST['areaid'])?0:$_POST['areaid'];
		$data['questionnaireid']=empty($_POST['questionnaireid'])?11:$_POST['questionnaireid'];
		$list=$service->findAreaiQuestionTop($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['questionnaireid'],$data['areaid'],$data['startDate'],$data['endDate'],$data['rank']);
		echo json_encode($list);
	}
	/**
	 ***********************************************************
	 *方法::Anagroup::findAreaiiQuestionTop
	 * ----------------------------------------------------------
	 * 描述::评测分析双品牌模式
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.08  Add by zwx
	 ************************************************************
	 */
	public function findAreaiiQuestionTop(){
		header('Access-Control-Allow-Origin: *');
		$service=new AnagroupService();
		$data['startDate']=empty($_POST['startDate'])?date('Y-m',time()):$_POST['startDate'];
		$data['areai']=empty($_POST['areai'])?0:$_POST['areai'];
		$data['areaii']=empty($_POST['areaii'])?0:$_POST['areaii'];
		$data['rank']=empty($_POST['rank'])?1:$_POST['rank'];
		$data['questionnaireid']=empty($_POST['questionnaireid'])?11:$_POST['questionnaireid'];
	    $list=$service->findAreaiiQuestionTop($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['questionnaireid'],$data['areai'],$data['areaii'],$data['startDate'],$data['rank']);
	    echo json_encode($list);
	}
}
