<?php /***************************************************** **作者：张文晓	**创始时间：2017-02-24	**描述：商户菜单管理控制器类	*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class MerchantNav extends CI_Controller {	
	#.引用属性，每个控制器都需要有	
	private $includes;	private $session;	private $system;	private $service;
	/**		 ***********************************************************		 *方法::MerchantNav::__construct	 * ----------------------------------------------------------		 *描述::商户菜单管理初始化方法	 *----------------------------------------------------------	;	 *参数:	 	 *parm2:in--    无	 	 *----------------------------------------------------------		 	 *返回：	 	 *return:out--  无	 	 * ----------------------------------------------------------		 	 *日期:2017.02.24  Add by zwx		 	 ************************************************************			 */
	public function __construct(){ 			parent::__construct(); 		$this->includes=new Includes(__FILE__); 		$this->includes->libraries("CurrSystem"); 		$this->includes->libraries("CurrLog"); 		$this->includes->libraries("CurrPage"); 		$this->includes->services("MerchantNavService"); 		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();		$this->system=new CurrSystem();		$this->service=new MerchantNavService();		$this->load->helper("url"); 	}
	/**		***********************************************************	*方法::MerchantNav::index 	* ---------------------------------------------------------- 	*描述::商户菜单管理列表主页	*----------------------------------------------------------	*参数:	*parm2:in--    无	*----------------------------------------------------------	*返回：	*return:out--  无	* ----------------------------------------------------------	*日期:2017.02.24  Add by zwx		 	************************************************************	*/
	public function index(){ 		$this->session->checkSession('Admin');		$find=empty($_GET["p"])?1:$_GET["p"];		$Pid=empty($_GET['Pid'])?0:$_GET['Pid'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getTotal($Pid),100,$find);
		$data['page']=$page->showPage();
		$data['list']=$this->service->getList($Pid,$find);
		$data['name']=$this->findNames();		$data['Pid']=$Pid;
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'商户菜单管理','',4,NULL);
		$log->write();		$this->load->view("admin/NavList.html",$data);	}
	/** 	 ***********************************************************	*方法::MerchantNav::add	* ----------------------------------------------------------	*描述::商户菜单管理新增页面	*----------------------------------------------------------	*参数:	*parm2:in--    无	*----------------------------------------------------------	*返回：	*return:out--  无	* ----------------------------------------------------------	*日期:2017.02.24  Add by zwx		************************************************************	*/
	public function add(){ 		$this->load->view("admin/NavAdd.html");	}
	/** 	***********************************************************	*方法::MerchantNav::update	* ----------------------------------------------------------	*描述::商户菜单管理修改页面	*----------------------------------------------------------	*参数:	*parm2:in--    无	*----------------------------------------------------------	*返回：	*return:out--  无	* ----------------------------------------------------------	*日期:2017.02.24  Add by zwx 	************************************************************	*/
	public function update(){ 		$this->session->checkSession('Admin');
		$menu=$this->service->getMerchantNav(NULL,$_GET['id']);
		$data['one']=count($menu)>0?$menu[0]:NULL;
		(count($menu)>0 && $menu[0]['pId']>0) && $data['menu']=$this->service->getMerchantNav(0);
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'商户菜单管理','',4,$_GET['id']);
		$log->write();		$this->load->view("admin/NavUpdate.html",$data);	}
	/** 	 ***********************************************************	 *方法::MerchantNav::added	 * ----------------------------------------------------------	 *描述::商户菜单管理新增数据方法	 *----------------------------------------------------------	 *参数:	 *parm2:in--    无	 *----------------------------------------------------------	 *返回：	 *return:out--  无	 * ----------------------------------------------------------	 *日期:2017-02-24  Add by zwx	 ************************************************************	 */
	public function added(){		$this->session->checkSession('Admin');		$data=$_POST;
		$mess=$this->system->remind();
		if(!$this->service->checkMerchantNav($data['navTitle'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$this->service->addMerchantNav($data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(3);
		}		$this->load->view('admin/message.html',$mess);	}
	/**	 ***********************************************************	 *方法::MerchantNav::updated	 * ----------------------------------------------------------	 *描述::商户菜单管理修改数据方法	 *----------------------------------------------------------	 *参数:	 *parm2:in--    无	 *----------------------------------------------------------	 *返回：	 *return:out--  无	 * ----------------------------------------------------------	 *日期:2017.02.24  Add by zwx	 ************************************************************	 */
	public function updated(){ 		$this->session->checkSession('Admin');
		$data=$_POST;
		$mess=$this->system->remind();
		if($this->service->checkMerchantNav(NULL,$data['id'])){
			$data['operatorName']=$this->session->getSession('Admin','loginName');
			$data['operationTime']=$this->system->getSystemTime('A');
			$this->service->saveMerchantNav($data['id'],$data) && $mess=$this->system->remind(1);
		}else{
			$mess=$this->system->remind(4);
		}
		$this->load->view('admin/message.html',$mess);	}
	/**	***********************************************************	*方法::MerchantNav::delete	* ----------------------------------------------------------	*描述::商户菜单管理删除方法	*----------------------------------------------------------	*参数:	*parm2:in--    无	*----------------------------------------------------------	*返回：	*return:out--  无	* ----------------------------------------------------------	*日期:2017.02.24  Add by zwx	************************************************************	*/
	public function delete(){ 		$this->session->checkSession('Admin');
		header('Access-Control-Allow-Origin: *');
		echo $this->service->delete($_GET['id']) ? 4000:4004;
		$log=new CurrLog(2,4,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'商户菜单管理','',4,$_GET['id']);
		$log->write();	}	/**
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
	public function getMerchantNav(){		$this->session->checkSession('Admin');
		header('Access-Control-Allow-Origin: *');
		$list=$this->service->getMerchantNav($_POST['id']);
		$message=empty($list)?4004:$list;
		echo json_encode($message);
	}
	/**	***********************************************************	*方法::MerchantNav::search	* ----------------------------------------------------------	*描述::商户菜单管理搜索方法	*----------------------------------------------------------	*参数:	*parm2:in--    无	*----------------------------------------------------------	*返回：	*return:out--  无	* ----------------------------------------------------------	*日期:2017.02.24  Add by zwx	************************************************************	*/
	public function search(){ 		$this->session->checkSession('Admin');
		!empty($_POST) && $this->session->setSession($_POST,'navSearch');
		$session=$this->session->getSession('navSearch');
		$find=empty($_GET['p'])?1:$_GET['p'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$this->service->getSearchTotal($session['Pid'],$session['navTitle'],$session['startDate'],$session['lastDate']),100,$find);
		$data['page']=$page->showPage();
		$data['list']=$this->service->search($session['Pid'],$session['navTitle'],$session['startDate'],$session['lastDate'],$find);
		$data['name']=$this->findNames();		$data['Pid']=$session['Pid'];
		$log=new CurrLog(2,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'商户菜单管理','',4,NULL);
		$log->write();		$this->load->view("admin/NavList.html",$data);	}	/**	***********************************************************	*方法::MerchantNav::check	* ----------------------------------------------------------	*描述::检测记录状态接口	*----------------------------------------------------------	*参数:	*parm2:in--    无	*----------------------------------------------------------	*返回：	*return:out--  无	* ----------------------------------------------------------	*日期:2017.02.24  Add by zwx	************************************************************	*/
	public function check(){		header("Access-Control-Allow-Origin: *");		echo $this->service->checkMerchantNav(NULL,$_GET["id"]) ? 4000:4004;	}	/**
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