<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：登录操作service类。
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class WeChatService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $session;
	private $system;
	private $model;
	/**
	 ***********************************************************
	 *方法::LoginService::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function __construct(){
		$this->includes=new Includes(__FILE__);
		$this->includes->models('DataBase','global');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrLog');
		$this->includes->models('WeChatModel');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->model=new WeChatModel();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::LoginService::checkUser
	 * ----------------------------------------------------------
	 * 描述::检测用户是否回答过问卷
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String :: userName ::用户名
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  bool :: bool ::检测状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function checkUser($openid=''){
		return '{}';
	}
	/**
	 ***********************************************************
	 *方法::LoginService::addPerson
	 * ----------------------------------------------------------
	 * 描述::保存车主基本信息
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String :: userdata ::用户基础信息数据
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  bool :: bool ::检测状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function addPerson($userdata){
		$muse=array("sex"=>$userdata['sex'],
								 "age"=>$userdata['age'],
								 "merchantId"=>$userdata['merchantId'],
								 "carModelId"=>$userdata['carId'],
								 "brandId"=>$userdata['brandId'],
								 'qualifications'=>$userdata['education'],
								 "income"=>$userdata['money'],
								  "occupation"=>$userdata['vocation'],
 								  "carPeriod"=>$userdata['year'],
								  "openId"=>$userdata['openId'],
								  "createtime"=>date('Y-m-d H:i:s'),
								  "areaId"=>$userdata['areaId'],
								  "operatorName"=>"微信提交",
								  "status"=>1);
		$personId = $this->data->insert(29,$muse);
		return $personId;
	}
	/**
	 ***********************************************************
	 *方法::LoginService::addPerson
	 * ----------------------------------------------------------
	 * 描述::保存结果问卷记录
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String :: userdata ::用户基础信息数据
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  bool :: bool ::检测状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function addResult($userdata,$personid){
		$muse=array("questionnaireId" => $userdata['questionnaireId'],
									"personsId"=>$personid,
									"strategyId"=>$userdata['strategyId'],
									"merchantId"=>$userdata['merchantId'],
									"groupId"=>$userdata['groupId'],
									"areaId"=>$userdata['areaId'],
									"brandId"=>$userdata['brandId'],
									"rank"=>$userdata['rank'],
									"primitiveModelId"=>$userdata['modelId'],
									"primitivemoduleId"=>$userdata['moduleId'],
									"primitiveTitle"=>$userdata['moduleTitle'],
									"primitive"=>$userdata['primitive'],
									"primitiveModelTitle"=>$userdata['modelTitle'],
									"primitiveModuleTitle"=>$userdata['moduleTitle'],
									"longitude"=>$userdata['longitude'],
									"latitude"=>$userdata['latitude'],
									"beginTime"=>$userdata['beginTime'],
									"endTime"=>$userdata['endTime'],
									"source"=> 1,
									"operatorName"=>"微信端",
									"operationTime"=>date('Y-m-d H:i:s'),
									"status"=> 1);
		$resultId = $this->data->insert(20,$muse);
		return $resultId;
	}
	/**
	 ***********************************************************
	 *方法::LoginService::addQuestionAnswer
	 * ----------------------------------------------------------
	 * 描述::保存结果问卷记录
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String :: userdata ::用户基础信息数据
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  bool :: bool ::检测状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function addQuestionAnswer($questionid,$resultid,$type,$content,$PW,$description,$id,$value,$key=NULL,$val=NULL){
		if(!empty($id)	&&	!empty($value) &&	 empty($key)	&&	empty($val)){
			$anyone=$this->data->select(15,array("id"=>$id,"status"=>1));
			$Qids=$this->data->insert(18,array("primitiveQuestionId"=>$questionid,
																			"resultsQuestionnaireId"=>$resultid,
																			"primitiveTitle"=>$content,
																			"primitiveType"=>$type,
																			"primitiveWeight"=>$PW,
																			"alreadyWeight"=>$anyone[0]['weight'],
																			"primitiveDescription"=>$description,
																			"operatorName"=>"微信端",
																			"operationTime"=>date('Y-m-d H:i:s'),
																			"status"=>1));
			#.获取选项的基本信息
			$idxx=$this->data->insert(19,array('resultsQuestionId'=>$Qids,
																			"primitiveAnswerId"=>$anyone[0]['id'],
																			"primitiveJump"=>$anyone[0]['jump'],
																			"primitiveWeight"=>$anyone[0]['weight'],
																			"primitiveSymbol"=>$anyone[0]['symbol'],
																		    'operatorName'=>"微信端",
																		    'status'=>1,
																		    'operationTime'=>date('Y-m-d H:i:s'),
																		    'answerValue'=>$value,
																			"chooseSymbol"=>1,
																			'primitiveTitle'=>$anyone[0]['title']));
		}else if($id==0	 && $value==0 	&&	!empty($key)	&&	!empty($val)){
			$Qids=$this->data->insert(18,array("primitiveQuestionId"=>$questionid,
																			"resultsQuestionnaireId"=>$resultid,
																			"primitiveTitle"=>$content,
																			"primitiveType"=>$type,
																			"primitiveWeight"=>$PW,
																			"primitiveDescription"=>$description,
																			"operatorName"=>"微信端",
																			"operationTime"=>date('Y-m-d H:i:s'),
																			"status"=>1));
			$RW=0;
			for($i=0;$i<count($key);$i++){
				#.获取选项的基本信息
				$anyone=$this->data->select(15,array("id"=>$key[$i],"status"=>1));
				$RW+=empty($anyone[0]['weight'])?0:$anyone[0]['weight'];
				$this->data->insert(19,array('resultsQuestionId'=>$Qids,
																	"primitiveAnswerId"=>$anyone[0]['id'],
																	"primitiveJump"=>$anyone[0]['jump'],
																	"primitiveWeight"=>$anyone[0]['weight'],
																	"primitiveSymbol"=>$anyone[0]['symbol'],
																	'operatorName'=>"微信端",
																	'status'=>1,
																	'operationTime'=>date('Y-m-d H:i:s'),
																	'answerValue'=>$val[$i],
																	"chooseSymbol"=>1,
																	'primitiveTitle'=>$anyone[0]['title']));
			}
			$this->data->update(18,$Qids,array("alreadyWeight"=>$RW));
		}else if($id==0	 && $value==0 	&&	empty($key)	&&	empty($val)){
			$this->data->insert(18,array("primitiveQuestionId"=>$questionid,
																 "resultsQuestionnaireId"=>$resultid,
																  "primitiveTitle"=>$content,
																  "primitiveType"=>$type,
																  "primitiveWeight"=>$PW,
																  "alreadyWeight"=>0,
																  "primitiveDescription"=>$description,
																  "operatorName"=>"微信端",
																  "operationTime"=>date('Y-m-d H:i:s'),
																   "status"=>1));
		}
	}
	/**
	 ***********************************************************
	 *方法::LoginService::getBrand
	 * ----------------------------------------------------------
	 * 描述::获取汽车品牌数据
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String :: userdata ::获
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  bool :: bool ::检测状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getBrand($brandid){
		if($brandid==0){
			$brandArray=array('A'=>array(),'B'=>array(),'C'=>array(),'D'=>array(),'E'=>array(),'F'=>array(),'G'=>array(),'H'=>array(),'I'=>array(),'J'=>array(),'K'=>array(),'L'=>array(),'M'=>array(),'N'=>array(),'O'=>array(),'P'=>array(),'Q'=>array(),'R'=>array(),'S'=>array(),'T'=>array(),'U'=>array(),'V'=>array(),'W'=>array(),'X'=>array(),'Y'=>array(),'Z'=>array());
			$array=$this->model->findBrandList($brandid);
			foreach ($brandArray as $key=>$val){
				for($i=0;$i<count($array);$i++){ ($array[$i]['code']==$key) && $brandArray[$key][]=$array[$i];}
				if(count($brandArray[$key])<=0) unset($brandArray[$key]);
			}
			return  json_encode($brandArray);
		}else{
			$array=$this->model->findBrandList($brandid);
			return  json_encode($array);
		}
	}
	/**答案组成要素*/
	private function setAnswer($test=array(),$index=1){
		$list=Array();
		$list['we']['id']=$test['id'];
		$list['we']['type']=$test['type'];
		$list['we']['questionid']=$test['questionid'];
		$list['we']['index']=$index;
		$list['we']['name']=$test['name'];
		$list['options']=$this->model->findQuestionAnswers($list['we']['questionid']);
		return $list;
	}
	/**获取问卷试题*/
	public function getQuestionOne($id,$qid,$vid){
		#.获取问卷的所有题目
		$All=$this->model->findQuestionnaireQuestion($id);
		if($qid==0&&$vid==0){
			$test=$this->model->findQuestionOne($qid,$id);
			return  json_encode($this->setAnswer($test,1));exit;
		}
		#.获取当前求的题目详情
		$one=$this->model->findQuestionOne($qid,0);$football=strlen($one['description'])>0?$one['description']:0;
		#.遇到填空,或者多选
	   if($vid==-1){
			$idi=0;$index=0;
			foreach ($All as $key=>$val){if($val['id']==$qid){$idi=((int)$football!=0 && $All[($key+1)]['type']==3) ? $All[($key+2)]['id']:$All[($key+1)]['id'];$index=($key+2)!=count($All)?($key+2):($key+2)*-1;break;}}
	    	$test=$this->model->findQuestionOne($idi,0);
			return json_encode($this->setAnswer($test,$index));exit;
		}
		#.检测跳题逻辑
		$tolink=$this->model->findQuestionAnswersOne($vid);
		if($tolink[0]['tolink']>0){
			$index=0;
			foreach ($All as $key=>$val){ if($val['id']==$tolink[0]['tolink']){ $index=($key+2)!=count($All) ? ($key+2):($key+2)*-1;break;} }
			$once=$this->model->findQuestionOne($tolink[0]['tolink'],0);
			$footballi=strlen($once['description'])>0?$once['description']:0;
			$test=$this->model->findQuestionOne($tolink[0]['tolink'],0);
			return json_encode($this->setAnswer($test,(int)$footballi>=0?$index:$footballi));exit;
		}else{
			$idi=0;$index=0;
			foreach ($All as $key=>$val){ if($val['id']==$qid){$idi=$All[($key+1)]['id'];$index=($key+2)!=count($All)?($key+2) : ($key+2)*-1;break;} }
			$test=$this->model->findQuestionOne($idi,0);
			return json_encode($this->setAnswer($test,(int)$football>=0?$index:$football));exit;
		}
  }
	/**获取当前问卷的得分*/
	public function findSelfResult($rid){
		return $this->model->findSelfResult($rid);
	}
	/**获取门店此模块整体得分*/
	public function findAllResult($questionid,$providerid){
		return $this->model->findAllResult($questionid,$providerid);
	}
	/**保存问卷已得权重*/
	public function saveSelResult($id,$weight){
		$resultId=$this->data->update(20,array("id"=>$id),array("alreadyWeight"=>$weight));
		return $resultId;
	}
	/*获取刚入库问卷权重*/
	public function findSelResults($id){
		return $this->model->findSelResults($id);
	}
	/*获取用户基础信息*/
	public function findPersonInfo($openId){
		return $this->model->findPersonInfo($openId);
	}
	/**获取执行的策略*/
	public function findSelStrategy(){
		return $this->model->findSelStrategy();
	}
	/**获取调研模型信息*/
	public function findSelModels($modelid){
		return $this->model->findSelModels($modelid);
	}
	/**获取正在执行的模块列表*/
	public function findSelMoudles($modelid){
		return $this->model->findSelMoudles($modelid);
	}
	/**获取历史执行模块*/
	public function findHistoryMoudles($personid,$providerid,$modelid){
		return $this->model->findHistoryMoudles($personid,$providerid,$modelid);
	}
	/**获取门店基础信息*/
	public function findMerchantInfo($providerid){
		return $this->model->findMerchantInfo($providerid);
	}
	/*获取门店参与总数*/
	public function findMerchantPersonSize($providerid,$modelid){
		return $this->model->findMerchantPersonSize($providerid,$modelid);
	}
	/**存储题库过程*/
	public function addProcess($questionnaireid,$answdata,$rid){
		$quesList=$this->model->findQuestionnaireQuestion($questionnaireid);
		for($i=0;$i<count($quesList);$i++){
			$status=false;
			if($quesList[$i]['type']==1 || $quesList[$i]['type']==3){#.如果是单选题或者填空题
				for($j=0;$j<count($answdata);$j++){
					if($answdata[$j]['value']!="0" &&  strlen($answdata[$j]['value'])>=1){
						if($quesList[$i]['id']==$answdata[$j]['parentid']){
							$this->addQuestionAnswer($quesList[$i]['questionid'],$rid,$quesList[$i]['type'],$quesList[$i]['name'],$quesList[$i]['weight'],$quesList[$i]['description'],$answdata[$j]['id'],$answdata[$j]['value'],NULL,NULL);
							$status=true;break;
						}
					}
				}
			}else if($quesList[$i]['type']==2){#.如果是多选题
				$index=0;$key=array();$val=array();
				for($j=0;$j<count($answdata);$j++){
					if($quesList[$i]['id']==$answdata[$j]['parentid']){if($answdata[$j]['value']!="0" &&  strlen($answdata[$j]['value'])>=1){$key[]=$answdata[$j]['id'];$val[]=$answdata[$j]['value'];$index++;}}
				}
				#.如果有多个选项就存储多个选项
				if($index>0){$this->addQuestionAnswer($quesList[$i]['questionid'],$rid,$quesList[$i]['type'],$quesList[$i]['name'],$quesList[$i]['weight'],$quesList[$i]['description'],0,0,$key,$val);$status=true;continue;}
		  }/*类型结束*/
				#.如果本题在答案中并未出现则只存储题目不存储答案
		      if(!$status){$this->addQuestionAnswer($quesList[$i]['questionid'],$rid,$quesList[$i]['type'],$quesList[$i]['name'],$quesList[$i]['weight'],$quesList[$i]['description'],NULL,NULL,NULL,NULL);continue;}
		}/*循环结束*/
	}
}