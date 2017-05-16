<?php
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php'); 
/*****************************************************
 **作者：hjm
**创始时间：2017-02-07
**描述：平台问卷管理模块 包括 : 新增试题、维护试题、维护权重、查询试题、生成试卷、维护试卷、查询试卷
*****************************************************/
class Question extends CI_Controller {
	private $includes;
	/**
	 ***********************************************************
	 *方法:: Provider ::__construct
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
	 * 日期:2017.02.07  Add by hjm
	 ************************************************************
	 */
	Public function __construct(){
		parent::__construct();
		$this->includes=new Includes(__FILE__);
		$this->includes->models('QuestionModel');
 		$this->includes->services('QuestionService');
		$this->includes->models('DataBase','global');
		$this->includes->libraries('CurrUpload');
		$this->includes->libraries('CurrPage');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->load->helper('url');
	}
	/**
	 * 问卷管理-新增试题查看页面
	 * 日期:2017.02.07  Add by hjm
	 */
	public function addedQuestion(){
		$this->session->checkSession('Admin');
		date_default_timezone_set('PRC');
		$model=new DataBase();
		$muse=array("title"=>$_POST['name'],"description"=>$_POST['description'],"type"=>$_POST['type'],"ico"=>$_POST['providerLicense']?$_POST['providerLicense']:'',"operatorName"=>$this->session->getSession('Admin','loginName'),"operationTime"=>date('Y-m-d H:i:s'),"status"=>1);
		$questionid=$model->insert(14,$muse);
		for($i=1;$i<=count($_POST['value']);$i++){
			if( $_POST['type']!=3  &&  empty($_POST['value'][$i]) ){continue;}
			$answer=array("title"=>$_POST['value'][$i],
										"questionId"=>$questionid,
										"answerValue"=>1,
										"weight"=>empty($_POST['weight'][$i])?0:$_POST['weight'][$i],
										"image"  =>empty($_POST['providerLicenseans'][$i])?'':$_POST['providerLicenseans'][$i],
										"operatorName"=>$this->session->getSession('Admin','loginName'),
										"description"=>!empty($_POST['remark'][$i])?$_POST['remark'][$i]:'',
										"operationTime"=>date('Y-m-d H:i:s'),
										"status"=>1);
			$model->insert(15,$answer);
		}
		$Any= new QuestionModel();
		$model->update(14,$questionid,array("weight"=>$Any->findQuestionWeight($_POST['type'],$questionid)));
		$this->load->view('admin/message.html',array("status"=>1,"mess"=>"操作已成功！","url"=>'admin/Question/maintainQuestion'));
	}
	
	/**
	 * 问卷管理-新增试题查看页面
	 * 日期:2017.02.07  Add by hjm 
	 */
	public function addQuestion(){
	$this->session->checkSession('Admin');
	$data['type']=json_encode(0);
	$this->load->view('admin/addQuestion.html',$data);
	}
	/**
	 * 问卷管理-维护试题-列表
	 * 日期:2017.02.09  Add by hjm
	 */
	public function maintainQuestion(){
$this->session->checkSession('Admin');
	$AnyServic = new QuestionService();
	$Anydata    = new DataBase();
	$list= $Anydata-> select(14,array("status<>"=>2));
	foreach($list as $s){
	$any=$Anydata->select(15,array("status<>"=>2,"questionId"=>$s['id']));
	if(empty($any)){
		$Any=array(
				"questionId"    =>$s['id'],
				"answerValue"=>1,
				"operatorName"      =>$this->session->getSession('Admin','loginName'),
				"operationTime"     =>date('Y-m-d H:i:s'),
				"status"           =>1
		);
		$Anydata->insert(15,$Any);
	}
	}
	$cou=count($Anydata->select(14,array("status<>"=>2)));
	$data['json']='{}';
	$find=empty($_GET['p'])?1:$_GET['p'];
	$page=new CurrPage($_SERVER['PHP_SELF'],$cou,50,$find);
	$data['page']=$page->showPage();
	$data['list']=$AnyServic->getQuestionData($find);
	$this->load->view('admin/maintainQuestion.html',$data);
	}
	/**
	 * 问卷管理-维护权重(修改)
	 * 日期:2017.02.07  Add by hjm
	 */
	public function weightQuestion(){
		$data['list']=array();
		$this->load->view('admin/weightQuestion.html',$data);
	}
	
	/**
	 * 问卷管理-维护试题-修改展示
	 * 日期:2017.02.09  Add by hjm
	 */
	public function updateQuestion(){
	$this->session->checkSession('Admin');
	$Anydata       = new DataBase();
	$Any =$Anydata->select(14,array("id"=>$_REQUEST['id']));
	$data['ans']  = $Anydata->select(15,array("status<>"=>2,"questionId"=>$_GET['id']));
	$data['type']=json_encode($Any[0]['type']);
	$data['Any']=$Any[0];
	$this->load->view('admin/updateQuestion.html',$data);
	}
	
	/**
	 * 问卷管理-维护试题-获取图片接口
	 * 日期:2017.02.16  Add by hjm
	 */
	public function getimg(){
		ini_set('date.timezone','Asia/Shanghai');
		$upload=new CurrUpload(array("max"=>1024,"min"=>1,"path"=>'./upload/admin/images/',"files"=>$_FILES));
		$uploadimg=$upload->getUrls(1);
		$data=array("error"=>0,"url"=>$uploadimg['img1']['url']);
		echo json_encode($data);
	}
	/**
	 * 商户图片接口
	 * 日期:2017.02.16  Add by hjm
	 */
	public function getimgpro(){
		ini_set('date.timezone','Asia/Shanghai');
		$upload=new CurrUpload(array("max"=>1024,"min"=>1,"path"=>'./upload/merchant/images/',"files"=>$_FILES));
		$uploadimg=$upload->getUrls(1);
		$data=array("error"=>0,"url"=>$uploadimg['img1']['url']);
		echo json_encode($data);
	}
	/**
	 * 问卷管理-维护试题-修改完成
	 * 日期:2017.02.09  Add by hjm
	 */
	public function updatedQuestion(){
		$this->session->checkSession('Admin');
		date_default_timezone_set('PRC');
		$model=new DataBase();
		$muse=array("title"=>$_POST['name'],
								 "description"=>$_POST['description'],
				                 "type"=>$_POST['type'],
				                 "ico"=>!empty($_POST['providerLicense'])?$_POST['providerLicense']:'',
								 "operatorName"=>$this->session->getSession('Admin','loginName'),
				                 "operationTime"=>date('Y-m-d H:i:s'),"status"=>1);
		/**修改试题信息*/
		$model->update(14,$_POST['id'],$muse);
		/**删除已经移除的指标*/
		$delArr=explode('|',$_POST['delstr']);
		for($i=0;$i<count($delArr);$i++){if($delArr[$i]>0) $model->delete(15,$delArr[$i]);}
		/**修改现有指标*/
		for($i=1;$i<=$_POST['numx'];$i++){
			/**填空题不需要修改选项*/
			if($_POST['type']==3){break;}
			/**非填空题过滤移除掉的数据*/
			if($_POST['type']!=3  &&  empty($_POST['value'][$i]) ){continue;}
			/**非填空题修改现有选项*/
			if($_POST['type']!=3  && ! empty($_POST['value'][$i]) && $_POST['answerId'][$i]!=0){
				$answer=array("title"=>$_POST['value'][$i],
											"weight"=>empty($_POST['weight'][$i])?0:$_POST['weight'][$i],
											"image"  =>empty($_POST['providerLicenseans'][$i])?'':$_POST['providerLicenseans'][$i],
											"operatorName"=>$this->session->getSession('Admin','loginName'),
											"description"=>!empty($_POST['remark'][$i])?$_POST['remark'][$i]:'',
											"operationTime"=>date('Y-m-d H:i:s'),
											"status"=>1);
				$model->update(15,$_POST['answerId'][$i],$answer);
			}else if($_POST['type']!=3  && ! empty($_POST['value'][$i]) && $_POST['answerId'][$i]==0){
				$answer=array("title"=>$_POST['value'][$i],
											"questionId"=>$_POST['id'],
											"answerValue"=>1,
											"weight"=>empty($_POST['weight'][$i])?0:$_POST['weight'][$i],
											"image"  =>empty($_POST['providerLicenseans'][$i])?'':$_POST['providerLicenseans'][$i],
											"operatorName"=>$this->session->getSession('Admin','loginName'),
											"description"=>!empty($_POST['remark'][$i])?$_POST['remark'][$i]:'',
											"operationTime"=>date('Y-m-d H:i:s'),
											"status"=>1);
				$model->insert(15,$answer);
			}
		}
		$Any= new QuestionModel();
		$model->update(14,$_POST['id'],array("weight"=>$Any->findQuestionWeight($_POST['type'],$_POST['id'])));
		$this->load->view('admin/message.html',array("status"=>1,"mess"=>"操作已成功！","url"=>'admin/Question/maintainQuestion'));
	}
	/**
	 * 问卷管理-维护试题-删除试题
	 * 日期:2017.02.09  Add by hjm
	 */
	public function deleteQuestion(){
	$this->session->checkSession('Admin');
	$Anydata = new DataBase();
		$muse  =array("status"=>2);
		$where=array("id"=>$_GET['id']);
		echo $Anydata->update(14,$where,$muse)?4000:4004;
	}
	/**
	 * 问卷管理-维护试题-验证
	 * 日期:2017.03.14  Add by hjm
	 */
	public function check(){
		$AnyService= new QuestionService();
		header("Access-Control-Allow-Origin: *");
		echo $AnyService->checkQuestion(NULL,$_GET["id"])?4000:4004;
	}
	
	/**
	 * 问卷管理-维护试题-查找
	 * 日期:2017.02.12  Add by hjm
	 */
	public function Seek(){
// 		print_r($_REQUEST);die;
	$this->session->checkSession('Admin');
	$Anydata   = new DataBase();
	$Anymodel= new QuestionModel();
	$data['json']=$_POST['jsondata'];
	if(empty($_POST['cci']) && empty($_POST['ccii']) && empty($_POST['CA'])) {
	$this->load->view('admin/message.html',array("status"=>2,"mess"=>"请选择条件","url"=>'admin/Question/maintainQuestion'));
	}
	
	$core  =$_POST;
	if(!empty($core['cci']) && !empty($core['ccii'])){
		$cci=$core['cci']." 00:00:00";
		$ccii=$core['ccii']." 23:59:59";
	}
	
	$select="SELECT * FROM cada_question_bank  WHERE status<>2 ";
	//--使用操作员查询
	if(!empty($core['CA'])){
		$select.=" AND   title LIKE '%".$core['CA']."%'";
	}
	if(!empty($core['cci']) && !empty($core['ccii'])){
		$select.="  AND   operationTime   BETWEEN  '".$cci."'       AND     '".$ccii."'     ";
	}
	if(!empty($select)){
		
	$data['list']  =$Anymodel->getQuestionSearch($select);
	$find=empty($_GET['p'])?1:$_GET['p'];
	$page=new CurrPage($_SERVER['PHP_SELF'],count($data['list']),50,$find);
	$data['page']=$page->showPage();
	}
	$this->load->view('admin/maintainQuestion.html',$data);
	}
	
}




















