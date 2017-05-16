<?php
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php'); 
/*****************************************************
 **作者：hjm
**创始时间：2017-02-07
**描述：service层 平台问卷管理模块 包括 : 新增问卷、维护问卷、维护权重、查询问卷
*****************************************************/
class QuestionnaireService{
	private $model;
	/**
	 ***********************************************************
	 *方法::QuestionnaireService::__construct
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
	 * 日期:2017.03.07  Add by hjm
	 ************************************************************
	 */
	function __construct(){
	$this->includes=new Includes(__FILE__);
	$this->includes->models('QuestionnaireModel');
	$this->includes->libraries('CurrLog');
	}

	
	/**
	 * 问卷管理-问卷列表-获取数据&分页
	 * 日期:2017.03.07  Add by hjm
	 */
	public function getQuestionnaireData($page){
		try{
			$bool=NULL;
			$model=new QuestionnaireModel();
			$list=$model->getQuestionnaireData(1,($page-1)*50,50);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e){
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 * 问卷管理-问卷列表-删除验证
	 * 日期:2017.03.15  Add by hjm
	 */
	public function checkQuestionnaire(){
		try{
			$bool=false;
			(!empty($name) && $where=array("status"=>1,"name"=>$name)) ||
			(!empty($id) && $where=array("status"=>1,"id"=>$id));
			$rows=$this->data->select(16,$where);
			(!empty($rows) && count($rows)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
	
}