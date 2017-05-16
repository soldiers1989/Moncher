<?php
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php'); 
/*****************************************************
 **作者：hjm
**创始时间：2017-02-24
**描述：调研模型管理
*****************************************************/
class Mould extends CI_Controller {
	private $includes;
	/**
	 ***********************************************************
	 *方法:: Mould ::__construct
	 * ----------------------------------------------------------
	 * 描述::登录类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by hjm
	 ************************************************************
	 */
	Public function __construct(){
		parent::__construct();
		$this->includes=new Includes(__FILE__);
		$this->includes->models('MouldModel');
		$this->includes->services('MouldService');
		$this->includes->models('DataBase','global');
		$this->includes->libraries('CurrUpload');
		$this->includes->libraries('CurrPage');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->load->helper('url');
	}
	/**
	 * 调研管理-生成模型
	 * 日期:2017.02.24  Add by hjm
	 */
	public function addMould(){
	$this->session->checkSession('Admin');
	$Anydata    = new DataBase();
	$data['company']  = $Anydata->select(13,array('status<>'=>2));
	$data['questionnaire']=$Anydata->select(16,array('status<>'=>2));
	$this->load->view("admin/addMould.html",$data);
	}
	
	/**
	 * 调研管理-完成新增调研
	 * 日期:2017.02.24  Add by hjm 
	 */
	public function addedMould(){
// 			echo "<pre>";
// 			print_r($_POST);die;
	$this->session->checkSession('Admin');
	$Anydata    = new DataBase();
	$resinfo=$Anydata->select(27,array("title",$_POST['title']));
	if(!empty($resinfo) || @$resinfo[0]['status']=='2'){
		$this->load->view('admin/message.html',array("status"=>2,"mess"=>"录入记录重复","url"=>'admin/Mould/listmould'));
	}
	

	$muse=array(
		"title"=>$_POST['title'],			
		"description"=>$_POST['description'],
		"startTime"  =>$_POST['startTime'],
		"stopTime"	 =>$_POST['stopTime'],
		"skinId"=>$_POST['skinId'],
		"operatorName"=>$this->session->getSession('Admin','loginName'),
		"operationTime"=>date('Y-m-d H:i:s'),
		"status"=>1,
		"image"=>$_POST['imgss']	?$_POST['imgss']:""
	);
// 		echo "<pre>";
// 		print_r($muse);die;
	$insert=$Anydata->insert(27,$muse);
/* 	$modelId=$Anydata->select(27,array("title"=>$_POST['title']));
	if(!empty($_POST['questionnaire'])){
	foreach($_POST['questionnaire'] as $vv){
		if(!empty($vv)){
		$quetitle=$Anydata->select(16,array("id"=>$vv));
		$modelresInfo=$Anydata->select(28,array("modelId"=>$insert,"questionnaireId"=>$vv));	
		if(!empty($modelresInfo) || $modelresInfo[0]['status']=='2'){
			$this->load->view('admin/message.html',array("status"=>2,"mess"=>"录入记录重复"));
		}
		$muses=array(
				"modelId"=>$insert,
				"questionnaireId"=>$vv,
				"title"=>$quetitle[0]['name'],
				"description"=>$_POST['description'],
				"image"=>$_POST['imgss']	?$_POST['imgss']:"",
				"operatorName"=>$this->session->getSession('Admin','loginName'),
				"operationTime"=>date('Y-m-d H:i:s'),
				"status"=>1
		);	
		$modelsinsert=$Anydata->insert(28,$muses);		
		}
	}
	} */

	$this->load->view('admin/message.html',array("status"=>1,"mess"=>"添加记录成功"));
	}
	/**
	 * 调研管理-维护调研-调研列表
	 * 日期:2017.02.24  Add by hjm
	 */
	public function listMould(){
		$this->session->checkSession('Admin');
		$data['json']='{}';
		$Anydata    = new DataBase();
		$AnyService=new MouldService();
		$cou=count($Anydata->select(28,array("status<>"=>'2')));
		$find=empty($_GET['p'])?1:$_GET['p'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$cou,5,$find);
		$data['page']=$page->showPage();
		$data['list']=$AnyService->getModelData($find);
		$data['modeldata']=$Anydata->select(28,array("status<>"=>'2'));
		$this->load->view("admin/listMould.html",$data);
	}
	/**
	 * 调研管理-查询调研-更改调研状态(禁用)
	 * 日期:2017.02.24  Add by hjm
	 */
	public function disableMould(){
	$this->session->checkSession('Admin');
	$Anydata    = new DataBase();
	$muse=array(
			"status"=>'3'        //禁用模型
	);
	$up_model=$Anydata->update(27,array("id"=>$_REQUEST['id']),$muse);
	$up_mould=$Anydata->update(28,array("modelId"=>$_REQUEST['id']),$muse);
	if(!empty($up_model) && !empty($up_mould)){
		echo 4000;
	}else{
		echo 4004;
	}
	}
	/**
	 * 调研管理-查询调研-更改调研状态(恢复)
	 * 日期:2017.02.24  Add by hjm
	 */
	public function backMould(){
		$this->session->checkSession('Admin');
		$Anydata    = new DataBase();
		$muse=array(
				"status"=>'1'        //禁用模型
		);
		$up_model=$Anydata->update(27,array("id"=>$_REQUEST['id']),$muse);
		$up_mould=$Anydata->update(28,array("modelId"=>$_REQUEST['id']),$muse);
		if(!empty($up_model) && !empty($up_mould)){
			echo 4000;
		}else{
			echo 4004;
		}
	}
	/**
	 * 调研管理-模型列表-模型删除
	 * 日期:2017.03.14  Add by hjm
	 */
	public function deleteMould(){
		$this->session->checkSession('Admin');
		$Anydata = new DataBase();
		$muse  =array("status"=>2);
		$where=array("id"=>$_REQUEST['id']);
		echo $Anydata->update(27,$where,$muse)?4000:4004;
	}
	/**
	 * 调研管理-模型列表-验证
	 * 日期:2017.03.14  Add by hjm
	 */
	public function check(){
	
		$AnyService= new MouldService();
		header("Access-Control-Allow-Origin: *");
		echo $AnyService->checkMould(NULL,$_GET["id"])?4000:4004;
	}
	
	
	/**
	 * 调研管理-维护调研-查询调研
	 * 日期:2017.02.24  Add by hjm
	 */
	public function Seek(){
		$this->session->checkSession('Admin');
	$Anydata   = new DataBase();
	$Anymodel= new MouldModel();
	$data['json']=$_POST['jsondata'];
	if(empty($_POST['startTime']) && empty($_POST['stopTime']) && empty($_POST['title'])){
	$this->load->view('admin/message.html',array("status"=>2,"mess"=>"请选择条件","url"=>'admin/Mould/listMould'));
	}
	$core=$_POST;
	$select="SELECT * FROM cada_model WHERE status<>2 ";
	//名称判断
	if(!empty($core['title'])){
	$select.=" AND title LIKE  '%".$core['title']."%' ";	
	}
	//时间判断
	if(!empty($core['startTime']) && !empty($core['stopTime'])){
	$select.="  AND  DATE_FORMAT(NOW(),'%Y-%m-%d') >='".$core['startTime']."'  AND   DATE_FORMAT(NOW(),'%Y-%m-%d') <= '".$core['stopTime']."' ";	
	}
	if(!empty($select)){
	$data['list']            =$Anymodel->getMouldSearch($select);
	$data['modeldata']=$Anydata->select(28,array("status<>"=>'2'));
// 	echo "<pre>";
// 	print_r($data['modeldata']);die;
	}
	$this->load->view("admin/listMould.html",$data);
	}
	/**
	 * 调研管理-维护模型-模型修改
	 * 日期:2017.02.25  Add by hjm
	 */
	public function updateMould(){
	$this->session->checkSession('Admin');
	$Anydata    = new DataBase();
	$data['questionnaire']=$Anydata->select(16,array('status<>'=>2));
	//列表主项
	$data['lists']=$Anydata->select(27,array("id"=>$_GET['id'],"status<>"=>'2'));
	$data['modeldata']=$Anydata->select(28,array("modelId"=>$_GET['id'],"status<>"=>'2'));
	foreach($data['modeldata'] as $vv){
		$modelque_arr[]=$vv['questionnaireId'];
	}
	$data['company']  = $Anydata->select(13,array('status<>'=>2));
	$questionnaire=$Anydata->select(16,array('status<>'=>2));
	foreach($questionnaire as $vs){
		$que_arr[]=$vs['id'];
	}
// 	echo "<pre>";
// 	print_r($que_arr);print_r($modelque_arr);
	$c=array_diff($que_arr,$modelque_arr);

// 	print_r($c);die;
	foreach($c as $vv){
		$un_same[]=$Anydata->select(16,array('id'=>$vv),array('status<>'=>'2'));
	}
	
	foreach($un_same as $v){
		foreach($v as $vs){
		$ars[]=$vs;
		}
	}
    $data['que_ars']=$ars;
//     echo "<pre>";
//     print_r($data['que_ars']);die;
	$data['list']=$data['lists'][0];
	
	$this->load->view('admin/updateMould.html',$data);
	}
	/**
	 * 调研管理-维护模型-模型修改
	 * 日期:2017.02.25  Add by hjm
	 */
	public function updateedMould(){
// 		echo "<pre>";
// 		print_r($_REQUEST);die;
			$Anydata    = new DataBase();
			$this->session->checkSession('Admin');

/* 			$que_all=$Anydata->select(28,array('modelId'=>$_POST['id']));
			foreach($que_all as $vs){
				$que_id[]=$vs['id'];
			}
		$queArr=explode(",",$_POST['modelId']);

		if(count($queArr)!=5){
			$this->load->view('admin/message.html',array("status"=>2,"mess"=>"请选择五个问卷"));
		}else{
 		
		$model=$Anydata->select(28,array('modelId'=>$_POST['id'],'status<>'=>2));
		foreach($model as $vu){
			$Anydata->update(28,array("id"=>$vu['id']),array("status"=>'2'));
		}
		foreach($queArr as $vv){
			$ques[]=$Anydata->select(28,array('id'=>$vv));
		}
		foreach($ques as $vl){
			foreach($vl as $vk){
				$qu_ans[]=$vk;
			}
		}
		foreach($qu_ans as $vh){
				$arr['modelId']=$_POST['id'];
				$arr['pId']=$vh['pId'];
				$arr['questionnaireId']=$vh['questionnaireId'];
				$arr['title']=$vh['title'];
				$arr['description']=$vh['description'];
				$arr['image']=$vh['image'];
				$arr['sorting']=$vh['sorting'];
				$arr['status']='1';
				$arr['operatorName']=$vh['operatorName'];
				$arr['operationTime']=$vh['operationTime'];
			$Anydata->insert(28,$arr);
		}  */
/* 		$sameArr = array();
		for($i=0; $i<count($queArr); $i++){
			$pos = array_search($queArr[$i], $que_id);
			if($pos>0){
				$sameArr[] = $que_id[$i];												//--获取不同问卷
				unset($que_id[$i]);
				unset($queArr[$pos]);
			}
	} */
		//	 	print_r($sameArr);die;
/* 	foreach($sameArr as $vv){
		$Anydata->update(28,array('id'=>$vv),array('status'=>'2'));
	} */
	
	$modelInfo=$Anydata->select(27,array('id'=>$_REQUEST['id']));
	if(!empty($modelInfo) && $modelInfo[0]['status']!='2'){
	$this->load->view('admin/message.html',array("status"=>2,"mess"=>"记录已删除","url"=>'admin/Mould/listMould'));
	}
	$muse=array(
			"title"=>$_POST['title']?$_POST['title']:$modelInfo[0]['title'],
			"skinId"=>$_POST['skinId']?$_POST['skinId']:$modelInfo[0]['skinId'],
			"status"=>'1',
			"description"=>$_POST['description']?$_POST['description']:$modelInfo[0]['description'],
			"startTime"=>$_POST['startTime']?$_POST['startTime']:$modelInfo[0]['startTime'],
			"stopTime"=>$_POST['stopTime']?$_POST['stopTime']:$modelInfo[0]['stopTime'],
			"image"=>$_POST['providerLicense']?$_POST['providerLicense']:$modelInfo[0]['ico']
	);
	$upmodel=$Anydata->update(27,array("id"=>$_REQUEST['id']),$muse);
// 	echo "<pre>";
// 	print_r($upmodel);die;
// 	redirect("admin/Mould/listMould");
	$this->load->view('admin/message.html',array("status"=>1,"url"=>'',"mess"=>"修改记录成功"));
	
	}
	/**
	 * 接口，获取商户名
	 * 日期:2017.04.28  Add by hjm
	 */
	public function getpro(){
		$Anydata    = new DataBase();
		$pro=$Anydata->select(26,array("pId"=>$_REQUEST['data'],"status<>"=>'2'));
		foreach($pro as $vp){
		$pro_name[]=$Anydata->select(13,array("id"=>$vp['providerId'],"status<>"=>'2'));
		}
		foreach($pro_name as $vl){
			foreach($vl as $vb){
				$arr[]=$vb;
			}
		}
   echo json_encode($arr); 
	}
	
	/**
	 * 接口，模块管理
	 * 日期:2017.04.28  Add by hjm
	 */
	public function listblock(){
		$this->session->checkSession('Admin');
		$data['json']='{}';
		$Anydata    = new DataBase();
		$AnyService=new MouldService();
		$cou=count($Anydata->select(28,array("status<>"=>'2')));
		$find=empty($_GET['p'])?1:$_GET['p'];
		$page=new CurrPage($_SERVER['PHP_SELF'],$cou,10,$find);
		$data['page']=$page->showPage();
		$data['list']=$AnyService->getModelblockData($find);
		$data['model_list']=$Anydata->select(27,array("status<>"=>'2'));
// 		echo "<pre>";
// 		print_r($data['model_list']);die;
		//$data['modeldata']=$Anydata->select(28,array("status<>"=>'2'));
		$this->load->view("admin/listblock.html",$data);
	}
	/**
	 * 调研管理-生成模块
	 * 日期:2017.02.24  Add by hjm
	 */
	public function addBlock(){
		$this->session->checkSession('Admin');
		$Anydata    = new DataBase();
		$data['questionnaire']=$Anydata->select(16,array('status<>'=>2));
		$data['model']=$Anydata->select(27,array('status<>'=>2));
// 		echo "<pre>";
//  		print_r($data['model']);die;
		$this->load->view("admin/addBlock.html",$data);
	}
	/**
	 * 调研管理-完成模块添加检验
	 * 日期:2017.02.24  Add by hjm
	 */
 	public function Blockcheck(){

 		$AnyService= new MouldService();
 		header("Access-Control-Allow-Origin: *");
 		echo $AnyService->checkblock(NULL,$_GET["id"])?4000:4004;
	} 
	
	/**
	 * 调研管理-完成模块添加
	 * 日期:2017.02.24  Add by hjm
	 */
	public function addedblock(){
// 					echo "<pre>";
// 					print_r($_POST);die;
		$this->session->checkSession('Admin');
		$Anydata    = new DataBase();
	/* 	$resinfo=$Anydata->select(28,array("title",$_POST['title']));
		if(!empty($resinfo) || @$resinfo[0]['status']=='2'){
			$this->load->view('admin/message.html',array("status"=>2,"mess"=>"录入记录重复","url"=>'admin/Mould/listmould'));
		} */
		$muses=array(
				"pId"=>0,
				"title"=>$_POST['title'],
				"description"=>$_POST['description'],
				"modelId"=>$_POST['modelId'],
				"questionnaireId"=>$_POST['questionnaire'],
				"operatorName"=>$this->session->getSession('Admin','loginName'),
				"operationTime"=>date('Y-m-d'),
				"status"=>'1',
				"sorting"=>$_POST['sorting'],
				"image"=>$_POST['imgss']	?$_POST['imgss']:""
		);
// 		echo "<pre>";
// 		print_r($muses);die;
	$Anydata->insert(28,$muses);
		$this->load->view('admin/message.html',array("status"=>1,"mess"=>"添加记录成功"));
	}

	/**
	 * 调研管理-模块查询
	 * 日期:2017.02.24  Add by hjm
	 */
	public function 	Seekblock(){
		$this->session->checkSession('Admin');
		$Anydata   = new DataBase();
		$Anymodel= new MouldModel();
		$data['json']=$_POST['jsondata'];
		if(empty($_POST['startTime']) && empty($_POST['stopTime']) && empty($_POST['title'])){
		$this->load->view('admin/message.html',array("status"=>2,"mess"=>"请选择条件","url"=>'admin/Mould/listMould'));
		}
		$core=$_POST;
		$select="SELECT * FROM cada_module WHERE status<>2 ";
		//名称判断
		if(!empty($core['title'])){
			$select.=" AND title LIKE  '%".$core['title']."%' ";
		}
		if(!empty($core['startTime']) && !empty($core['stopTime'])){
			$select.="  AND  DATE_FORMAT(operationTime,'%Y-%m-%d') >='".$core['startTime']."'  AND   DATE_FORMAT(operationTime,'%Y-%m-%d') <= '".$core['stopTime']."' ";
		}
// 		echo "<pre>";
// 		echo $select;die;
		if(!empty($select)){
			$data['list']            =$Anymodel->getBlockSearch($select);
			$data['modeldata']=$Anydata->select(28,array("status<>"=>'2'));
			$data['model_list']=$Anydata->select(27,array("status<>"=>'2'));
		}
// 		echo "<pre>";
// 		print_r($data['list']);die;	
		$this->load->view("admin/listblock.html",$data);
	}
	/**
	 * 调研管理-模块修改
	 * 日期:2017.02.24  Add by hjm
	 */
	public function updateBlock(){
		
		$this->session->checkSession('Admin');
		$Anydata    = new DataBase();
		$data['questionnaire']=$Anydata->select(16,array("id"=>$_REQUEST['id'],'status<>'=>2));
		$data['list']=$Anydata->select(28,array("id"=>$_REQUEST['id'],"status<>"=>'2'));
		$data['questionnaire']=$Anydata->select(16,array('status<>'=>2));
		$data['model']=$Anydata->select(27,array('status<>'=>2));
		$this->load->view("admin/updateBlock.html",$data);
	}
	/**
	 * 调研管理-模块修改完成
	 * 日期:2017.02.24  Add by hjm
	 */
	public function updateedBlock(){
// 		echo "<pre>";
// 		print_r($_REQUEST);die;
		$this->session->checkSession('Admin');
		$Anydata   = new DataBase();
		$modelInfo=$Anydata->select(28,array('id'=>$_REQUEST['id']));
		if(!empty($modelInfo) && $modelInfo[0]['status']!='2'){
		$this->load->view('admin/message.html',array("status"=>2,"mess"=>"记录已删除","url"=>'admin/Mould/listMould'));
		}
		$muse=array(
				"pId"=>0,
				"title"=>$_POST['title']?$_POST['title']:$modelInfo[0]['title'],
				"description"=>$_POST['description']?$_POST['description']:$modelInfo[0]['title'],
				"modelId"=>$_POST['modelId']?$_POST['modelId']:$modelInfo[0]['modelId'],
				"questionnaireId"=>$_POST['questionnaire']?$_POST['questionnaire']:$modelInfo[0]['questionnaire'],
				"operatorName"=>$this->session->getSession('Admin','loginName'),
				"operationTime"=>date('Y-m-d'),
				"status"=>'1',
				"sorting"=>$_POST['sorting']?$_POST['sorting']:$modelInfo[0]['sorting'],
				"image"=>$_POST['imgss']	?$_POST['imgss']:$modelInfo[0]['imgss']
		);
		$upmodel=$Anydata->update(28,array("id"=>$_REQUEST['id']),$muse);
		$this->load->view('admin/message.html',array("status"=>1,"url"=>'',"mess"=>"修改记录成功"));
	}
	/**
	 * 调研管理-删除
	 * 日期:2017.02.24  Add by hjm
	 */
	public function deleteBlock(){
		$this->session->checkSession('Admin');
		$Anydata = new DataBase();
		$muse  =array("status"=>2);
		$where=array("id"=>$_REQUEST['id']);
		echo $Anydata->update(28,$where,$muse)?4000:4004;
	}
}




















