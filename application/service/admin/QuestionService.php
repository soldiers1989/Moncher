<?php
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php'); 
/*****************************************************
 **作者：hjm
**创始时间：2017-02-07
**描述：service层 平台问卷管理模块 包括 : 新增试题、维护试题、维护权重、查询试题、生成试卷、维护试卷、查询试卷
*****************************************************/
class QuestionService{
	private $model;
	/**
	 ***********************************************************
	 *方法::QuestionService::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.02.03  Add by hjm
	 ************************************************************
	 */
	function __construct(){
	$this->includes=new Includes(__FILE__);
	$this->includes->models('QuestionModel');
	$this->includes->libraries('CurrLog');
	}

	
	/**
	 * 问卷管理-试题列表-获取数据&分页
	 * 日期:2017.03.07  Add by hjm
	 */
	public function getQuestionData($page){
		try{
			$bool=NULL;
			$model=new QuestionModel();
			$list=$model->getQuestionList(1,($page-1)*50,50);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e){
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 * 问卷管理-试题列表-验证记录
	 * 
	 * 日期:2017.03.14  Add by hjm
	 */
	public function checkQuestion($name=NULL,$id=NULL){
		try{
			$bool=false;
			(!empty($name) && $where=array("status"=>1,"name"=>$name)) ||
			(!empty($id) && $where=array("status"=>1,"id"=>$id));
			$rows=$this->data->select(14,$where);
			(!empty($rows) && count($rows)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
		$log->error();
	}
	}
	
}









