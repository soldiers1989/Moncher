<?php 
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Record extends CI_Controller {	
#.引用属性，每个控制器都需要有	
		private $includes;	
	/**	
	public function __construct(){ 	
	/**	
	public function index(){ 
		$data['modelid']=empty($_SESSION['soso']['modelid'])?2:$_SESSION['soso']['modelid'];
		$data['groupid']=empty($_SESSION['soso']['groupid'])?0:$_SESSION['soso']['groupid'];
		$data['brandid']=empty($_SESSION['soso']['brandid'])?0:$_SESSION['soso']['brandid'];
		$data['areaid']=empty($_SESSION['soso']['areaid'])?0:$_SESSION['soso']['areaid'];
		$data['providerid']=empty($_SESSION['soso']['providerid'])?0:$_SESSION['soso']['providerid'];
		$data['startDate']=empty($_SESSION['soso']['startDate'])?date('Y-m-d',time()):$_SESSION['soso']['startDate'];
		$data['endDate']=empty($_SESSION['soso']['endDate'])?date('Y-m-d',time()):$_SESSION['soso']['endDate'];
		$data['model']=$this->service->getModelList();
		$data['group']=$this->service->getGroupList($data['modelid']);
		$data['area']=$this->service->getAreaList($data['groupid']);
		$data['brand']=$this->service->getBrandList($data['groupid']);
		$data['merchant']=$this->service->getMerchantList($data['groupid']);
		/**接受搜索的各种参数*/
		$data['modelid']=empty($_SESSION['soso']['modelid'])?2:$_SESSION['soso']['modelid'];
		$data['groupid']=empty($_SESSION['soso']['groupid'])?0:$_SESSION['soso']['groupid'];
		$data['brandid']=empty($_SESSION['soso']['brandid'])?0:$_SESSION['soso']['brandid'];
		$data['areaid']=empty($_SESSION['soso']['areaid'])?0:$_SESSION['soso']['areaid'];
		$data['providerid']=empty($_SESSION['soso']['providerid'])?0:$_SESSION['soso']['providerid'];
		$data['startDate']=empty($_SESSION['soso']['startDate'])?date('Y-m-d',time()):$_SESSION['soso']['startDate'];
		$data['endDate']=empty($_SESSION['soso']['endDate'])?date('Y-m-d',time()):$_SESSION['soso']['endDate'];
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
		$this->getXLS($think,'',$th);
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
	}
		header('Access-Control-Allow-Origin: *');
		echo json_encode($this->service->getModels($_POST['modelid']));
	}
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