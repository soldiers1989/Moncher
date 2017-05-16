<?php 
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Monitor extends CI_Controller {	
#.引用属性，每个控制器都需要有	
		private $includes;	
	/**	
	public function __construct(){ 	
	/**	
	public function index(){
	 ***********************************************************
	 *方法::Monitor::monitorAll
	 * ----------------------------------------------------------
	 * 描述::集团监控页面
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
	public function monitorAll(){
		$data['All']=$this->service->getGroupScore('All',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Year']=$this->service->getGroupScore('Year',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Quar']=$this->service->getGroupScore('Quar',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Month']=$this->service->getGroupScore('Month',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Day']=$this->service->getGroupScore('Day',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['querTree']=json_encode($this->service->getQuarScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['yearTree']=json_encode($this->service->getYearScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['monTree']=json_encode($this->service->getMonthScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],date('Y-m-d',time()),$data['rank'],$data['areaid'],$data['brandid']));
		$this->load->view('merchant/MonitorAll.html',$data);
	}
	 ***********************************************************
	 *方法::Monitor::monitorArea
	 * ----------------------------------------------------------
	 * 描述::集团监控页面
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
	public function monitorArea(){
		$data['area']=$service->getAreaList();
		$data['areaid']=empty($_POST['areaid'])?0:$_POST['areaid'];
		$data['rank']=empty($_GET['rank'])?2:$_GET['rank'];
		$data['All']=$this->service->getGroupScore('All',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Year']=$this->service->getGroupScore('Year',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Quar']=$this->service->getGroupScore('Quar',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Month']=$this->service->getGroupScore('Month',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Day']=$this->service->getGroupScore('Day',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['querTree']=json_encode($this->service->getQuarScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['yearTree']=json_encode($this->service->getYearScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['monTree']=json_encode($this->service->getMonthScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],date('Y-m-d',time()),$data['rank'],$data['areaid'],$data['brandid']));
		$this->load->view('merchant/MonitorArea.html',$data);
	}
	 ***********************************************************
	 *方法::Monitor::monitorBrand
	 * ----------------------------------------------------------
	 * 描述::集团监控页面
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
	public function monitorBrand(){
		$data['area']=$service->getAreaList();
		$data['brand']=$service->getBrandList();
		$data['areaid']=empty($_POST['areaid'])?0:$_POST['areaid'];
		$data['rank']=empty($_GET['rank'])?0:$_GET['rank'];
		$data['All']=$this->service->getGroupScore('All',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Year']=$this->service->getGroupScore('Year',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Quar']=$this->service->getGroupScore('Quar',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['Month']=$this->service->getGroupScore('Month',$this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']);
		$data['querTree']=json_encode($this->service->getQuarScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['yearTree']=json_encode($this->service->getYearScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],$data['rank'],$data['areaid'],$data['brandid']));
		$data['monTree']=json_encode($this->service->getMonthScore($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],date('Y-m-d',time()),$data['rank'],$data['areaid'],$data['brandid']));
		$this->load->view('merchant/MonitorBrand.html',$data);
	}
}