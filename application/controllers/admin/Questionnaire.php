<?php
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php'); 
/*****************************************************
 **作者：hjm
**创始时间：2017-02-09
**描述：平台问卷管理模块 包括 : 生成试卷、维护试卷、查询试卷
*****************************************************/
class Questionnaire extends CI_Controller {
	private $includes;
	/**
	 ***********************************************************
	 *方法:: Questionnaire ::__construct
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
 		$this->includes->services('QuestionnaireService');
 		$this->includes->models('QuestionnaireModel');
		$this->includes->models('DataBase','global');
		$this->includes->libraries('CurrUpload');
		$this->includes->libraries('CurrPage');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->load->helper('url');
	}
	/**
	 * 问卷管理-生成试卷
	 * 日期:2017.02.09  Add by hjm
	 */
	public function add(){
		$this->session->checkSession('Admin');
		$Anydata     = new DataBase();
		$Anymodel= new QuestionnaireModel();
		$data['list']=$Anymodel->getques();
		$data['con']=$Anymodel->getcon();
		$data['arr']=ceil($data['con'][0]['num']/50);
		$this->load->view('admin/addQuestionnaire.html',$data);
}
/**
 * 问卷管理-生成试卷(完成)
 * 日期:2017.02.09  Add by hjm
 */
    public function addedQuestionnaire(){
     $this->session->checkSession('Admin');
     date_default_timezone_set('PRC');
     $model = new DataBase();
     $array=explode('|',$_POST['quesIdStr']);
     #.存取问卷基本信息
     $muse=array(
	     "name"=>$_POST['name'],
	     "description"=>$_POST['description'],
	     "operatorName"	=>$this->session->getSession('Admin','loginName'),
	     "operationTime"=>date('Y-m-d H:i:s'),
	     "status"=>1
     );
     $qid= $model->insert(16,$muse);
     $weight=0;$index=1;
     for($i=0;$i<count($array);$i++){
     	if($array[$i]==0){continue;}{
     		$one=$model->select(14,array("status"=>1,"id"=>$array[$i]));
     		$weight+=$one[0]['weight'];
     		$info=array(
     				"questionnaireId"=>$qid,
     				"questionId"=>$one[0]['id'],
     				"status"=>1,
     				"operatorName"=>$this->session->getSession('Admin','loginName'),
     				"operationTime"=>date('Y-m-d',time()),
     				"sorting"=>$index
     		);
     		$index++;
     	   $model->insert(17,$info);
     	}
     }
    $model->update(16,$qid,array("weight"=>$weight));
	 redirect("admin/Questionnaire/datalist");
}

	/**
	 * 问卷管理-数据列表
	 * 日期:2017.02.09  Add by hjm
	 */
		 public function datalist(){
		 $this->session->checkSession('Admin');
		 $Anydata     = new DataBase();
		 $AnyService =new QuestionnaireService();
		 $data['json']='{}';
		 $cou=count($Anydata->select(16,array('status<>'=>"2")));
		 $find=empty($_GET['p'])?1:$_GET['p'];
		 $page=new CurrPage($_SERVER['PHP_SELF'],$cou,50,$find);
		 $data['page']=$page->showPage();
		 $data['list']=$AnyService->getQuestionnaireData($find);
		 $this->load->view('admin/listQuestionnaire.html',$data);
	 	}
	 	/**
	 	 * 问卷管理-删除
	 	 * 日期:2017.02.09  Add by hjm
	 	 */
	 	public function deleteQuestionnaire(){
	 	header('Access-Control-Allow-Origin: *');
	 	$this->session->checkSession('Admin');
	 	$Anydata     = new DataBase();
	 	echo $Anydata->update(16,array('ID'=>$_GET['id']),array('status'=>'2'))?4000:4004;
	 	}
	 	/**
	 	 * 问卷管理-维护试题-验证
	 	 * 日期:2017.03.14  Add by hjm
	 	 */
	 	public function check(){
	 		header('Access-Control-Allow-Origin: *');
	 		$AnyService= new QuestionnaireService();
	 		header("Access-Control-Allow-Origin: *");
	 		echo $AnyService->checkQuestionnaire(NULL,$_GET["id"])?4000:4004;
	 	}
	 	
	 	/**
	 	 * 问卷管理-修改
	 	 * 日期:2017.02.09  Add by hjm
	 	 */
	 	public function updateQuestionnaire(){
		 	$this->session->checkSession('Admin');
		 	$Anymodel = new QuestionnaireModel();
		 	$Anydata    = new DataBase(); 	
		 	$data['lists']=$Anydata->select(16,array('id'=>$_REQUEST['id']));
		 	$data['list']=$data['lists'][0];
		 	$data['queinfo']=$Anydata->select(17,array('questionnaireId'=>$_REQUEST['id']));
		 	$data['all'] =$Anymodel->getquestionList($_REQUEST['id']);
		 	$data['ans']=$Anymodel->getQsAns($_REQUEST['id']);
		 	$data['answer']=$Anymodel->getAllAnswer();
		 	$data['jsonAnswer']=json_encode($data['answer']);
		    $data['All']=$Anymodel->getAllquestionList($_REQUEST['id']);
		    $data['listtitle']=$Anymodel->getAllquestionList($_REQUEST['id'],1);
			$data['arr']=ceil(count($data['All'])/50);
		 	$this->load->view('admin/updateQuestionnaire.html',$data);
	 	}
	 	/**
	 	 * 问卷管理-修改(完成)
	 	 * 日期:2017.02.10  Add by hjm
	 	 */
	 	public function updateedQuestionnaire(){
	 	$Anymodel = new QuestionnaireModel();
	 	$Anydata    = new DataBase();
	 	foreach($_POST['id'] as $key=>$vo){
	 		$que[]=$Anydata->select(14,array("id"=>$vo));
	 	}
	 	foreach($que as $vf){
	 		foreach($vf as $vl){$q_wei[]=$vl;}
	 	}
	 	foreach($q_wei as $vc){
	 		$weight+=$vc['weight'];
	 	}
	 	$resinfo=$Anydata->select(17,array('id'=>$_POST['naireid']));
	 	if(!empty($resinfo) && $resinfo[0]['status']=='2'){
	 		$this->load->view('admin/message.html',array("status"=>2,"mess"=>"记录以存在!","url"=>'admin/Question/updateQuestion'));
	 	}
	 	$muse=array(
	 			"name"=>$_POST['name']?$_POST['name']:$resinfo[0]['name'],
	 			"description"=>$_POST['description']?$_POST['description']:$resinfo[0]['description'],
	 			"weight"=>$weight?$weight:$resinfo[0]['weight']
	 	);
	 	$naire=$Anydata->update(16,array('id'=>$_POST['naireid']),$muse);
	 	$select=$Anydata->select(17,array("questionnaireId"=>$_POST['naireid'],"status<>"=>'2'));
	 	foreach($select as $vs){
	 		$arr[]=$vs['questionId'];
	 	}
		//移除和添加判断操作
	 	$match=array_merge(array_diff($_POST['id'],$arr),array_diff($arr,$_POST['id']));
	 	if(count($_POST['id'])>count($arr)){
	 		foreach($match as $vv){
	 		$selinfo=$Anydata->select(17,array("questionnaireId"=>$_POST['naireid'],"questionId"=>$vv));
        if(!empty($selinfo)){
        	$museup=array("status"=>'1');
        	$info_in=$Anydata->update(17,array("questionnaireId"=>$_POST['naireid'],"questionId"=>$vv),$museup);
        }else{
	 	$muse    =array("questionnaireId"=>$_POST['naireid'],"questionId"=>$vv);
	 	$info_in =$Anydata->insert(17,$muse);
	
	 	$upmuse=array('status'=>'1');
	 	$upnew =$Anydata->update(17,array("questionnaireId"=>$_POST['naireid'],"questionId"=>$vv),$upmuse);
	 		}
	 		}
	 	}else{
	 		foreach($match as $vs){
	 	$muse=array("status"=>'2');
	 	$info_in=$Anydata->update(17,array("questionnaireId"=>$_POST['naireid'],"questionId"=>$vs),$muse);
	 		}
	 	}
		redirect("admin/Questionnaire/datalist");
  		}
  		/**
  		 * 问卷管理-列表-排序
  		 * 日期:2017.02.22  Add by hjm
  		 */
  		public function sortQuestionnaire(){
  			$this->session->checkSession('Admin');
  			$Anymodel = new QuestionnaireModel();
  			$Anydata    = new DataBase();
  			$data['all'] =$Anymodel->getquestionList($_REQUEST['id']);
  			$data['ans']=$Anymodel->getQsAns($_REQUEST['id']);
  			$data['queinfo']=$Anydata->select(17,array('questionnaireId'=>$_REQUEST['id']));
  			$data['id']  =$_REQUEST['id'];
  			$data['quenaireid']=$_REQUEST['id'];
  			$this->load->view('admin/sortQuestionnaire.html',$data);
  		}
  		/**
  		 * 问卷管理-列表-排序完成
  		 * 日期:2017.02.22  Add by hjm
  		 */
  		public function sortedQuestionnaire(){
  			$this->session->checkSession('Admin');
  			$Anymodel = new QuestionnaireModel();
  			$Anydata    = new DataBase();
			foreach($_POST['jump'] as $key=>$vo){
			  $sel_info=$Anydata->select(15,array('id'=>$key));
				$muse  =array(
						"jump"=>$vo?$vo:$sel_info[0]['jump'],
				);
				$in_ans=$Anydata->update(15,array("id"=>$key),$muse);
			}
			foreach($_POST['sorting'] as $key=>$vs){
				$sel_info=$Anydata->select(17,array('id'=>$key));
			
				$muse_info=array(
						"sorting"=>$vs?$vs:$sel_info[0]['sorting'],
				);
			  $in_info=$Anydata->update(17,array("id"=>$key),$muse_info);	
			}
  		redirect("admin/Questionnaire/datalist");
  		}
	 	/**
	 	 * 问卷管理-列表-查询
	 	 * 日期:2017.02.14  Add by hjm
	 	 */
	 	public function Seek(){
	 		$this->session->checkSession('Admin');
	 		$Anydata   = new DataBase();
	 		$Anymodel = new QuestionnaireModel();
	 		$data['json']=$_POST['jsondata'];
	 	if(empty($_POST['cci']) && empty($_POST['ccii']) && empty($_POST['CA'])){
		$this->load->view('admin/message.html',array("status"=>1,"mess"=>"请选择条件","url"=>'admin/Qusetionnaire/datalist'));
	 	}
	 	$core  =$_POST;
	 	
	 	if(!empty($core['cci']) && !empty($core['ccii'])){
		$cci=$core['cci'] ." 00:00:00";
		$ccii=$core['ccii'] ." 23:59:59";
	   }
		$select="SELECT * FROM cada_questionnaire   WHERE status<>2" ;
		
		if(!empty($core['CA'])){
			$select.="  AND  name  LIKE '%".$core['CA']."%'";
		}
		if(!empty($core['cci']) && !empty($core['ccii'])){
			$select.="  AND   operationTime   BETWEEN  '".$cci."'       AND     '".$ccii."'     ";
		}
		if(!empty($select)){
			$data['list']  =$Anymodel->getQuestionnaireSearch($select);
		}
		$this->load->view('admin/listQuestionnaire.html',$data);
	 }
	 /**
	  * 问卷管理-修改-判断添加移除问卷试题
	  * 日期:2017.02.17  Add by hjm
	  */
	 public function changeQuestionnaire(){
	 	$this->session->checkSession('Admin');
	 	$Anydata   = new DataBase();
	 	$id=$_GET['quenaireid'];
	 	if($_GET['qud']=='1'){
	 		$Anydata   = new DataBase();
	 		$updata     =$Anydata->update(18,array("questionId"=>$_GET['id'],"questionnaireId"=>$_GET['quenaireid']),array("questionnaireId"=>0));
	 	}elseif($_GET['qud']=='2'){
	 		$resinfo=$Anydata->select(18,array('questionId'=>$_GET['id'],'questionnaireId'=>$_GET['quenaireid']));
	 		if(!empty($resinfo) && $resinfo[0]['questionnaireId']==$_GET['quenaireid']  && $resinfo[0]['questionId']==$_GET['id']){
	 		$this->load->view('admin/message.html',array("status"=>1,"mess"=>"试题已存在","url"=>'admin/Qusetionnaire/datalist'));
	 		}
	 		$ins=$Anydata->insert(18,array('questionnaireId'=>$_GET['quenaireid'],'questionId'=>$_GET['id'],'status'=>1,'operationTime'=>date('Y-m-d H:i:s')));
	 	}
	 	$Anymodel = new QuestionnaireModel();
	 	$data['lists']=$Anydata->select(17,array('ID'=>$id));
		if(!empty($data['lists'])){
			$data['list']=$data['lists'][0];
		}
	 	$data['queinfo']=$Anydata->select(18,array('questionnaireId'=>$id));
	 	$data['all'] =$Anymodel->getquestionList($id);
	 	$data['ans']=$Anymodel->getQsAns($id);
	 	$data['listtitle']=$Anymodel->getAllquestionList();
	 	$data['listans'] =$Anydata->select(16);
	 	$data['quenaireid']=$id;
	 	$this->load->view('admin/updateQuestionnaire.html',$data);
	 }
	 
	 /**
	  * 问卷管理-修改-获取题目接口
	  * 日期:2017.02.21  Add by hjm
	  */
	 public function getTitleData(){
	 	header('Access-Control-Allow-Origin: *');
	 	$model=new QuestionnaireModel();
	 	echo json_encode($model->getquestionList($_REQUEST['id']));
	 }
	 /**
	  * 问卷管理-修改-获取答案接口
	  * 日期:2017.02.22  Add by hjm
	  */
	 public function getansdata(){
	 	header('Access-Control-Allow-Origin: *');
	 	$Anymodel = new QuestionnaireModel();
	 	$ans=$Anymodel->ansData($_REQUEST['id']);
	 	echo json_encode($ans);
	 }
	 /**
	  * 问卷管理-修改-获取试题接口
	  * 日期:2017.02.22  Add by hjm
	  */
	 public function getqueinfo(){
	 	header('Access-Control-Allow-Origin: *');
	 	$Anymodel = new QuestionnaireModel();
	 	$name=$_REQUEST['name'];
	 	$que=$Anymodel->getquejk($name);
	 	echo json_encode($que);
	 }
	 /***/
	 public function getquecop(){
	 	header('Access-Control-Allow-Origin: *');
	 	$Anymodel = new QuestionnaireModel();
	 	$page=$_REQUEST['page'];
	 	$que=$Anymodel->getquejk(NULL,$page);
	 	echo json_encode($que);
	 }
	/**问卷维护题目搜*/
	 public  function  findQuestionsOne(){
	 	header('Access-Control-Allow-Origin: *');
	 	$model = new QuestionnaireModel();
	 	echo json_encode($model->findQuestionsOne($_REQUEST['id'],$_REQUEST['name']));
	 }
	 /**问卷维护分页搜索*/
	 public  function  findQuestionsLimit(){
	 	header('Access-Control-Allow-Origin: *');
	 	 $model= new QuestionnaireModel();
	 	 echo json_encode($model->getAllquestionList($_REQUEST['id'],$_REQUEST['page']));
	 }
	 /**删除一条记录问卷*/
	 public  function delQuestionsInfo(){
	 	header('Access-Control-Allow-Origin: *');
	 	$model= new DataBase();
	 	$info=$model->select(17,array("status"=>1,"id"=>$_REQUEST['id']));
	 	$resultid=$model->select(16,array("status"=>1,"id"=>$info[0]['questionnaireId']));
	 	$question=$model->select(14,array("status"=>1,"id"=>$info[0]['questionId']));
	 	$rows=$model->delete(17,$_REQUEST['id']);
	 	$model->update(16,$info[0]['questionnaireId'],array("weight"=>$resultid[0]['weight']-(empty($question[0]['weight'])?0:$question[0]['weight'])));
	 	echo $rows>0?1:0;
	 }
	 /**新增一条记录问卷*/
	 public  function addQuestionsInfo(){
	 	header('Access-Control-Allow-Origin: *');
	 	$model= new DataBase();
	 	$resultid=$model->select(16,array("status"=>1,"id"=>$_REQUEST['id']));
	 	$question=$model->select(14,array("status"=>1,"id"=>$_REQUEST['questionId']));
	 	$info=array(
	 			"questionnaireId"=>$_REQUEST['id'],
	 			"questionId"=>$_REQUEST['questionId'],
	 			"status"=>1,
	 			"operatorName"=>$this->session->getSession('Admin','loginName'),
	 			"operationTime"=>date('Y-m-d',time()),
	 			"sorting"=>$index
	 	);
	 	$rows=$model->insert(17,$info);
	 	/**修改问卷权重*/
	 	$model->update(16,$_REQUEST['id'],array("weight"=>$resultid[0]['weight']+(empty($question[0]['weight'])?0:$question[0]['weight'])));
	 	echo $rows>0?1:0;
	 }
	 /**保存问卷的跳转位置*/
	 public function saveJump(){
	 	header('Access-Control-Allow-Origin: *');
	 	$model= new DataBase();
	 	$rows=$model->update(15,$_REQUEST['id'],array("jump"=>$_REQUEST['jump'],"operatorName"=>$this->session->getSession('Admin','loginName'),"operationTime"=>date('Y-m-d',time())));
	 	echo $rows>0?1:0;
	 }
}
















