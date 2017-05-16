<?php 	/***************************************************** 	**作者：张文晓		**创始时间：2017-04-12		**描述：样本查询控制器类		*****************************************************/
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Record extends CI_Controller {	
#.引用属性，每个控制器都需要有	
		private $includes;			private $session;		private $system;		private $service;
	/**			 ***********************************************************			 *方法::Record::__construct		 * ----------------------------------------------------------			 *描述::样本查询初始化方法		 *----------------------------------------------------------	;		 *参数:	 		 *parm2:in--    无	 		 *----------------------------------------------------------		 		 *返回：	 		 *return:out--  无	 		 * ----------------------------------------------------------		 		 *日期:2017.04.12  Add by zwx		 		 ************************************************************				 */
	public function __construct(){ 				parent::__construct(); 			$this->includes=new Includes(__FILE__); 			$this->includes->libraries("CurrSystem"); 			$this->includes->libraries("CurrLog"); 			$this->includes->libraries("CurrPage"); 			$this->includes->services("RecordService");			$this->includes->libraries("CurrSession");			$this->session=new CurrSession();			$this->system=new CurrSystem;			$this->service=new RecordService();			$this->load->helper("url"); 		}
	/**			***********************************************************		*方法::Record::index 		* ---------------------------------------------------------- 		*描述::样本查询列表主页		*----------------------------------------------------------		*参数:		*parm2:in--    无		*----------------------------------------------------------		*返回：		*return:out--  无		* ----------------------------------------------------------		*日期:2017.04.12  Add by zwx		 		************************************************************		*/
	public function index(){ 		$find=empty($_GET["p"])?1:$_GET["p"];		!empty($_POST)	&&	$_SESSION['soso']=$_POST;		/**接受搜索的各种参数*/
		$data['modelid']=empty($_SESSION['soso']['modelid'])?2:$_SESSION['soso']['modelid'];
		$data['groupid']=empty($_SESSION['soso']['groupid'])?0:$_SESSION['soso']['groupid'];
		$data['brandid']=empty($_SESSION['soso']['brandid'])?0:$_SESSION['soso']['brandid'];
		$data['areaid']=empty($_SESSION['soso']['areaid'])?0:$_SESSION['soso']['areaid'];
		$data['providerid']=empty($_SESSION['soso']['providerid'])?0:$_SESSION['soso']['providerid'];
		$data['startDate']=empty($_SESSION['soso']['startDate'])?date('Y-m-d',time()):$_SESSION['soso']['startDate'];
		$data['endDate']=empty($_SESSION['soso']['endDate'])?date('Y-m-d',time()):$_SESSION['soso']['endDate'];		/**页面搜索列表*/
		$data['model']=$this->service->getModelList();		$data['module']=$this->service->getModels($data['modelid']);
		$data['group']=$this->service->getGroupList($data['modelid']);
		$data['area']=$this->service->getAreaList($data['groupid']);
		$data['brand']=$this->service->getBrandList($data['groupid']);
		$data['merchant']=$this->service->getMerchantList($data['groupid']);		$data['questionnaireid'] =empty($_SESSION['soso']['questionnaireid'])?$data['module'][0]['id']:$_SESSION['soso']['questionnaireid'];		/**页面显示数据*/		$page=new CurrPage('admin/Record/index',$this->service->getTotal($data['questionnaireid'],$data['providerid'],$data['groupid'],$data['brandid'],$data['areaid'],$data['startDate'],$data['endDate']),100,$find);		$data["page"]=$page->showPage();		$data["list"]=$this->service->getList($data['questionnaireid'],$data['providerid'],$data['groupid'],$data['brandid'],$data['areaid'],$data['startDate'],$data['endDate'],$find);		$data['ques']=$this->service->getQuestions($data['questionnaireid']);		$this->load->view("admin/RecordList.html",$data);	}	/*导出数据*/	public function xls(){
		/**接受搜索的各种参数*/		header('content-type:text/html;charset=utf-8');
		$data['modelid']=empty($_SESSION['soso']['modelid'])?2:$_SESSION['soso']['modelid'];
		$data['groupid']=empty($_SESSION['soso']['groupid'])?0:$_SESSION['soso']['groupid'];
		$data['brandid']=empty($_SESSION['soso']['brandid'])?0:$_SESSION['soso']['brandid'];
		$data['areaid']=empty($_SESSION['soso']['areaid'])?0:$_SESSION['soso']['areaid'];
		$data['providerid']=empty($_SESSION['soso']['providerid'])?0:$_SESSION['soso']['providerid'];
		$data['startDate']=empty($_SESSION['soso']['startDate'])?date('Y-m-d',time()):$_SESSION['soso']['startDate'];
		$data['endDate']=empty($_SESSION['soso']['endDate'])?date('Y-m-d',time()):$_SESSION['soso']['endDate'];		$data['questionnaireid'] =empty($_SESSION['soso']['questionnaireid'])?11:$_SESSION['soso']['questionnaireid'];
		$th=array('性别','年龄','学历','职业','收入','购车年限','区域','品牌','车型');
		$question=$this->service->getQuestions($data['questionnaireid']);
		foreach ($question as $i){ $th[]=$i['title'];}
		$result=$this->service->getXlsList($data['questionnaireid'],$data['providerid'],$data['groupid'],$data['brandid'],$data['areaid'],$data['startDate'],$data['endDate']);
		$think=array();
		for($i=0;$i<count($result);$i++){
			$muse=array();
			foreach($result[$i] as  $re){$muse[]=$re;}
			$think[$i]=$muse;
		}
		$this->getXLS($think,'',$th);	}	/*获取集团列表*/
	public function getGroupList(){
		header('Access-Control-Allow-Origin: *');
		echo json_encode($this->service->getGroupList($_POST['modelid']));
	}
	public function findMBAList(){
		header('Access-Control-Allow-Origin: *');
		$data=array();
		$data['area']=$this->service->getAreaList($_POST['groupid']);
		$data['brand']=$this->service->getBrandList($_POST['groupid']);
		$data['merchant']=$this->service->getMerchantList($_POST['groupid']);
		echo json_encode($data);
	}	public function getModuleList(){
		header('Access-Control-Allow-Origin: *');
		echo json_encode($this->service->getModels($_POST['modelid']));
	}	/**导出数据方法*/
	public function getXLS($data,$name,$th){
		header('Content-Type: text/xls');
		header( "Content-type:application/vnd.ms-excel;charset=utf-8" );
		header('Content-Disposition: attachment;filename="datalist.xls"');
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		$table_data = '<table border="1"><tr>';
		foreach($th as $i){
			$table_data.="<th>".$i."</th>";
		}
		$table_data.='</tr>';
		foreach ($data as $line){
			$table_data .= '<tr>';
			foreach ($line as $key => &$item){
				$item = $item;
				$table_data .= '<td>' . $item . '</td>';
			}
			$table_data .= '</tr>';
		}
		$table_data .='</table>';
		echo $table_data;
		die();
	}
}