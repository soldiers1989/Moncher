<?php 
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class MerchantNav extends CI_Controller {	
	#.引用属性，每个控制器都需要有	
	private $includes;
	/**	
	public function __construct(){ 	
		$this->session=new CurrSession();
	/**	
	public function index(){ 
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getTotal($Pid),100,$find);
		$data['page']=$page->showPage();
		$data['list']=$this->service->getList($Pid,$find);
		$data['name']=$this->findNames();
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'商户菜单管理','',4,NULL);
		$log->write();
	/** 
	public function add(){ 
	/** 
	public function update(){ 
		$menu=$this->service->getMerchantNav(NULL,$_GET['id']);
		$data['one']=count($menu)>0?$menu[0]:NULL;
		(count($menu)>0 && $menu[0]['pId']>0) && $data['menu']=$this->service->getMerchantNav(0);
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'商户菜单管理','',4,$_GET['id']);
		$log->write();
	/** 
	public function added(){
		$mess=$this->system->remind();
		if(!$this->service->checkMerchantNav($data['navTitle'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$this->service->addMerchantNav($data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(3);
		}
	/**
	public function updated(){ 
		$data=$_POST;
		$mess=$this->system->remind();
		if($this->service->checkMerchantNav(NULL,$data['id'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$this->service->saveMerchantNav($data['id'],$data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(4);
		}
		$this->load->view('admin/message.html',$mess);
	/**
	public function delete(){ 
		header('Access-Control-Allow-Origin: *');
		echo $this->service->delete($_GET['id']) ? 4000:4004;
		$log=new CurrLog(2,4,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'商户菜单管理','',4,$_GET['id']);
		$log->write();
	 ***********************************************************
	 *方法::MerchantNav:: getMerchantNav
	 * ----------------------------------------------------------
	 * 描述::获取菜单接口
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
	public function getMerchantNav(){
		header('Access-Control-Allow-Origin: *');
		$list=$this->service->getMerchantNav($_POST['id']);
		$message=empty($list)?4004:$list;
		echo json_encode($message);
	}
	/**
	public function search(){ 
		!empty($_POST) && $this->session->setSession($_POST,'navSearch');
		$session=$this->session->getSession('navSearch');
		$find=empty($_GET['p'])?1:$_GET['p'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getSearchTotal($session['Pid'],$session['navTitle'],$session['startDate'],$session['lastDate']),100,$find);
		$data['page']=$page->showPage();
		$data['list']=$this->service->search($session['Pid'],$session['navTitle'],$session['startDate'],$session['lastDate'],$find);
		$data['name']=$this->findNames();
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'商户菜单管理','',4,NULL);
		$log->write();
	public function check(){
	 ***********************************************************
	 *方法::MerchantNav::findNames
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
		$list=$this->service->findMerchantNav(array("status"=>1));
		$nameArray=array();
		foreach($list as $l){$nameArray[]=$l['navTitle'];}
		return implode(",",$nameArray);
	}
}