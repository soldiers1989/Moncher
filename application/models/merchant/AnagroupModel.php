<?php
/*****************************************************
 **作者：ZWX
**创始时间：'.$startDate.'-18
**描述：门店评测分析管理
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class AnagroupModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::AnastoreModel::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.03.18  Add by ZWX
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**获取集团的调研区域*/
	public function getAreaList($groupid){
	 $query=$this->db->query("SELECT    A.areaId,
															B.name
												FROM  cada_results_questionnaire A LEFT JOIN 
														   cada_area           		       B ON B.id=A.areaId
												WHERE A.groupId=".$groupid." 
												GROUP BY A.areaId");
	  return $query->result_array();		
	}
	/**获取集团的调研品牌*/
	public function getBrandList($groupid){
		$query=$this->db->query("SELECT A.brandId,
															B.name
												FROM  cada_results_questionnaire A LEFT JOIN 
														   cada_car_info           		   B ON B.id=A.brandId
												WHERE A.groupId=".$groupid." AND A.brandId IS NOT NULL 
												GROUP BY A.brandId");
		return $query->result_array();
	}
	/**获取集团的调研门店*/
	public function getMerchantList($groupid){
		$query=$this->db->query("SELECT A.merchantId,
															B.name
												FROM  cada_results_questionnaire A LEFT JOIN 
														   cada_merchant_info           B ON B.id=A.merchantId
												WHERE A.groupId=".$groupid." 
												GROUP BY A.merchantId");
		return $query->result_array();
	}
	/**获取集团正在用的模块列表*/
	public function getModels($modelid){
		$query=$this->db->query("SELECT  B.questionnaireId,
															 B.title  
												 FROM   cada_model A LEFT JOIN cada_module B ON A.id=B.modelId  
												 WHERE  A.status=1 AND B.status=1 AND A.id=".$modelid."  ORDER BY B.sorting");
		return $query->result_array();
	}
	/**获取集团总体监控分析得分*/
	public function getEvalAllScore($groupid,$modelid,$startDate,$endDate){
		$query=$this->db->query('SELECT IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				  SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F1,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F2, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F3,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F4, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F5,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F6, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F7,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F8, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F9,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F10, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F11,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F12 
											FROM 	cada_model A LEFT JOIN cada_module B
														ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
														ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
											WHERE A.status=B.status=C.status AND A.status="1"  AND
														DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
														(DATE_FORMAT(C.operationTime,"%Y-%m")>="'.$startDate.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")<="'.$endDate.'") AND
														A.id='.$modelid);
		return $query->result_array();	
	}
	/**获取集团总体各模块得分*/
	public function getEvalAllModelScore($groupid,$modelid,$startDate,$endDate){
		   $query=$this->db->query('SELECT 	MAX(B.title) AS title,
																B.questionnaireId,
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																						SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F1,
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																						SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F2, 
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F3,
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F4, 
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F5,
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F6, 
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F7,
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																						SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F8, 
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F9,
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F10, 
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F11,
																IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F12 
														  FROM cada_model A LEFT JOIN cada_module B
																	ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
																	ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
														 WHERE A.status=B.status=C.status AND A.status="1"  AND
																	DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
																	(DATE_FORMAT(C.operationTime,"%Y-%m")>="'.$startDate.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")<="'.$endDate.'") AND
																	A.id="'.$modelid.'" 
														 GROUP BY B.id,B.questionnaireId ORDER BY B.sorting');
	return $query->result_array();
	}
	/**获取集团的区域单店分析得分*/
	public function getAreaiScore($groupid,$areaid,$modelid,$startDate,$endDate){
		$query=$this->db->query('SELECT IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F1,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F2, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F3,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F4, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F5,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F6, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F7,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F8, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F9,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F10, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F11,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F12 
											FROM 	cada_model A LEFT JOIN cada_module B
														ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
														ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
											WHERE A.status=B.status=C.status AND A.status="1"  AND
														DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
														(DATE_FORMAT(C.operationTime,"%Y-%m")>="'.$startDate.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")<="'.$endDate.'") AND
														A.id='.$modelid.' AND C.areaId='.$areaid);
	 return $query->result_array();
	}
   /**获取集团单店分析高中低档模块得分*/
   public function getAreaiModelScore($groupid,$areaid,$modelid,$startDate,$endDate){
	   $query=$this->db->query('SELECT 	MAX(B.title) AS title,
															B.questionnaireId,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F1,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F2, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F3,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F4, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F5,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F6, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F7,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				    SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F8, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F9,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.groupId="'.$groupid.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F10, 
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
															                       SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F11,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="3") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				   SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.rank="3") THEN 1 ELSE 0 END),2),0)*100 AS F12 
													  FROM cada_model A LEFT JOIN cada_module B
																ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
																ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
													 WHERE A.status=B.status=C.status AND A.status="1"  AND
																DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
																(DATE_FORMAT(C.operationTime,"%Y-%m")>="'.$startDate.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")<="'.$endDate.'") AND
																A.id="'.$modelid.'" AND C.areaId="'.$areaid.'"
													 GROUP BY B.id,B.questionnaireId ORDER BY B.sorting');
	return $query->result_array();
   }
   /**获取集团区域双店分析得分*/
   public function getAreaiiScore($groupid,$modelid,$startDate,$areai,$areaii){
	   $query=$this->db->query('SELECT 	IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.' AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.' AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F1,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.' AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F2, 
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.' AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.' AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F3,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.' AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F4, 
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.' AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.' AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F5,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.' AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F6, 
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.' AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.' AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F7,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.' AND  C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F8, 
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.'  AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.'  AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F9,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.' AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F10, 
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.' AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.' AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F11,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.' AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F12 
										  FROM  cada_model A LEFT JOIN cada_module B
													 ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
													 ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
										 WHERE A.status=B.status=C.status AND A.status="1" AND 
													 DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
													 A.id='.$modelid.' AND DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.areaId IN('.$areai.','.$areaii.')');
	return $query->result_array();
   }
   /**获取集团区域双店模块得分*/
   public function getAreaiiModelScore($groupid,$modelid,$startDate,$areai,$areaii){
	   $query=$this->db->query('SELECT	 MAX(B.title) AS title,
															B.questionnaireId,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.' AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.' AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F1,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.' AND C.groupId="'.$groupid.'" AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.groupId="'.$groupid.'" AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F2, 
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.'  AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.' AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F3,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.' AND C.rank="1") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.rank="1") THEN 1 ELSE 0 END),2),0)*100 AS F4, 
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.'  AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.' AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F5,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.' AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F6, 
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.'  AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.'  AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F7,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.' AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F8, 
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.'  AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.'  AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F9,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.'  AND C.groupId="'.$groupid.'" AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.groupId="'.$groupid.'" AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F10, 
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areai.'  AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areai.' AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F11,
															IFNULL(ROUND(SUM(CASE WHEN (C.areaId='.$areaii.' AND C.rank="2") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (C.areaId='.$areaii.' AND C.rank="2") THEN 1 ELSE 0 END),2),0)*100 AS F12 
													  FROM cada_model A LEFT JOIN cada_module B
																ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
																ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
													 WHERE A.status=B.status=C.status AND A.status="1"  AND
																DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
																A.id='.$modelid.' AND DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.areaId IN('.$areai.','.$areaii.')
													 GROUP BY B.id,B.questionnaireId ORDER BY B.sorting');
	   return $query->result_array();
   }
   /**获取集团单品牌评测得分*/
   public function getBrandiScore($groupid,$modelid,$brandid,$startDate,$endDate,$areaid){
   		$str=$areaid==0?'	C.areaId<>0': 'C.areaId='.$areid;
	    $query=$this->db->query('SELECT IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.brandId="'.$brandid.'" AND C.groupId="'.$groupid.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																								SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.brandId="'.$brandid.'" AND C.groupId="'.$groupid.'") THEN 1 ELSE 0 END),2),0)*100 AS F1,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.brandId="'.$brandid.'" AND C.groupId="'.$groupid.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																								SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.brandId="'.$brandid.'" AND C.groupId="'.$groupid.'") THEN 1 ELSE 0 END),2),0)*100 AS F2,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																								SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'") THEN 1 ELSE 0 END),2),0)*100 AS F3,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																								SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'") THEN 1 ELSE 0 END),2),0)*100 AS F4 
															FROM cada_model A LEFT JOIN cada_module B
															ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
															ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
															WHERE A.status=B.status=C.status AND A.status="1" AND C.source="1" AND
															DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
															(DATE_FORMAT(C.operationTime,"%Y-%m")>="'.$startDate.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")<="'.$endDate.'") AND
															A.id="'.$modelid.'" AND EXISTS(SELECT 1 FROM cada_car_info D WHERE D.rank=C.rank AND D.id="'.$brandid.'") AND
															'.$str);
		return $query->result_array();
   }
   /**获取集团单品牌各模块评测得分*/
   public function getBrandiModelScore($groupid,$modelid,$brandid,$startDate,$endDate,$areaid){
   		$str=$areaid==0?'	C.areaId<>0': 'C.areaId='.$areid;
	  	$query=$this->db->query('SELECT MAX(B.title) AS title,
															B.questionnaireId,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.brandId="'.$brandid.'" AND C.groupId="'.$groupid.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				    SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.brandId="'.$brandid.'" AND C.groupId="'.$groupid.'") THEN 1 ELSE 0 END),2),0)*100 AS F1,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'"   AND C.brandId="'.$brandid.'" AND C.groupId="'.$groupid.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'"   AND C.brandId="'.$brandid.'" AND C.groupId="'.$groupid.'") THEN 1 ELSE 0 END),2),0)*100 AS F2,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'") THEN 1 ELSE 0 END),2),0)*100 AS F3,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'") THEN 1 ELSE 0 END),2),0)*100 AS F4 
												  FROM cada_model A LEFT JOIN cada_module B
															ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
															ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
												 WHERE A.status=B.status=C.status AND A.status="1"  AND
															 DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
															 (DATE_FORMAT(C.operationTime,"%Y-%m")>="'.$startDate.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")<="'.$endDate.'") AND
															 A.id="'.$modelid.'" AND EXISTS(SELECT 1 FROM cada_car_info D WHERE D.rank=C.rank AND D.id="'.$brandid.'") AND
															 '.$str.'
												 GROUP  BY B.id,B.questionnaireId ORDER BY B.sorting');
		return $query->result_array(); 
   }
   /**获取集团单门店评测得分*/
   public function getEvaliScore($merchantid,$modelid,$startDate,$endDate){
	   $query=$this->db->query('SELECT 	IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.merchantId="'.$merchantid.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.merchantId="'.$merchantid.'") THEN 1 ELSE 0 END),2),0)*100 AS F1,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.merchantId="'.$merchantid.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																			SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.merchantId="'.$merchantid.'") THEN 1 ELSE 0 END),2),0)*100 AS F2,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																			SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'") THEN 1 ELSE 0 END),2),0)*100 AS F3,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'") THEN 1 ELSE 0 END),2),0)*100 AS F4 
											  FROM cada_model A LEFT JOIN cada_module B
														ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
														ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
											 WHERE A.status=B.status=C.status AND A.status="1"  									AND
														DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
														(DATE_FORMAT(C.operationTime,"%Y-%m")>="'.$startDate.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")<="'.$endDate.'") AND
														A.id="'.$modelid.'" AND EXISTS(SELECT 1 FROM cada_merchant_info D LEFT JOIN cada_car_info E  ON (D.brandId1=E.id OR D.brandId2=E.id OR D.brandId3=E.id)  WHERE E.rank=C.rank AND D.id="'.$merchantid.'")');
	   return $query->result_array();
   }
   /**获取集团单门店各模块评测得分*/
   public function getEvaliModelScore($merchantid,$modelid,$startDate,$endDate){
	   $query=$this->db->query('SELECT MAX(B.title) AS title,
														   B.questionnaireId,
														   IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.merchantId="'.$merchantid.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				  SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND C.merchantId="'.$merchantid.'") THEN 1 ELSE 0 END),2),0)*100 AS F1,
														   IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.merchantId="'.$merchantid.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				  SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND C.merchantId="'.$merchantid.'") THEN 1 ELSE 0 END),2),0)*100 AS F2,
														   IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				  SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'") THEN 1 ELSE 0 END),2),0)*100 AS F3,
														   IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'") THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				 SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'") THEN 1 ELSE 0 END),2),0)*100 AS F4 
											FROM cada_model A LEFT JOIN cada_module B
													  ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
													  ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
											WHERE  A.status=B.status=C.status AND A.status="1"  AND
														 DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
														 (DATE_FORMAT(C.operationTime,"%Y-%m")>="'.$startDate.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")<="'.$endDate.'") AND
														 A.id="'.$modelid.'" AND EXISTS(SELECT 1 FROM cada_merchant_info D LEFT JOIN cada_car_info E ON (D.brandId1=E.id OR D.brandId2=E.id OR D.brandId3=E.id)  WHERE E.rank=C.rank AND D.id="'.$merchantid.'") 
									    GROUP BY B.id,B.questionnaireId ORDER BY B.sorting');
	   return $query->result_array();
   }
   /**获取集团双品牌评测得分*/
   public function getBrandiiScore($groupid,$modelid,$startDate,$areaid,$brandi,$brandii){
   		$str=$areaid==0?'	C.areaId<>0': 'C.areaId='.$areid;
	 	$query=$this->db->query('SELECT 	IFNULL(ROUND(SUM(CASE WHEN C.brandId="'.$brandi.'" THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																						SUM(CASE WHEN C.brandId="'.$brandi.'" THEN 1 ELSE 0 END),2),0)*100 AS F1,
																IFNULL(ROUND(SUM(CASE WHEN C.brandId="'.$brandii.'" THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																						SUM(CASE WHEN C.brandId="'.$brandii.'" THEN 1 ELSE 0 END),2),0)*100 AS F2 
												FROM cada_model A LEFT JOIN cada_module B
														  ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
														  ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
												WHERE A.status=B.status=C.status AND A.status="1"  AND
															DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
															A.id="'.$modelid.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND
															C.brandId IN('.$brandi.','.$brandii.') AND '.$str.'  AND 
															C.groupId="'.$groupid.'"');
		return $query->result_array();
   }
   /**获取集团双品牌各模块评测得分*/
   public function getBrandiiModelScore($groupid,$modelid,$startDate,$areaid,$brandi,$brandii){
   		$str=$areaid==0?'	C.areaId<>0': 'C.areaId='.$areid;
	 	$query=$this->db->query('SELECT MAX(B.title) AS title,
															B.questionnaireId,
															IFNULL(ROUND(SUM(CASE WHEN C.brandId="'.$brandi.'" THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN C.brandId="'.$brandi.'" THEN 1 ELSE 0 END),2),0)*100 AS F1,
															IFNULL(ROUND(SUM(CASE WHEN C.brandId="'.$brandii.'" THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN C.brandId="'.$brandii.'" THEN 1 ELSE 0 END),2),0)*100 AS F2 
												FROM 	cada_model A LEFT JOIN cada_module B
															ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
															ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
											    WHERE A.status=B.status=C.status AND A.status="1"  AND
															DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
															A.id="'.$modelid.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND
															C.brandId IN('.$brandi.','.$brandii.') AND '.$str.'  AND 
															C.groupId="'.$groupid.'"');
		return $query->result_array();
   }
   /**获取集团双门店得分*/
   public function getEvaliiScore($groupid,$modelid,$startDate,$merchantidi,$merchantidii){
	   $query=$this->db->query('SELECT 	IFNULL(ROUND(SUM(CASE WHEN C.merchantId="'.$merchantidi.'" THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				   SUM(CASE WHEN C.merchantId="'.$merchantidi.'" THEN 1 ELSE 0 END),2),0)*100 AS F1,
															IFNULL(ROUND(SUM(CASE WHEN C.merchantId="'.$merchantidii.'" THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																				   SUM(CASE WHEN C.merchantId="'.$merchantidii.'" THEN 1 ELSE 0 END),2),0)*100 AS F2 
											  FROM 	cada_model A LEFT JOIN cada_module B
															ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
															ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
											 WHERE 	A.status=B.status=C.status AND A.status="1"  									AND
															DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
															A.id="'.$modelid.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND
															C.merchantId IN('.$merchantidi.','.$merchantidii.') AND C.groupId="'.$groupid.'"');
	   return $query->result_array();
   }
   /**获取集团双门店模块得分*/
   public function getEvaliiModelScore($groupid,$modelid,$startDate,$merchantidi,$merchantidii){
	   $query=$this->db->query('SELECT 	MAX(B.title) AS title,
															B.questionnaireId,
															IFNULL(ROUND(SUM(CASE WHEN C.merchantId="'.$merchantidi.'" THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN C.merchantId="'.$merchantidi.'" THEN 1 ELSE 0 END),2),0)*100 AS F1,
															IFNULL(ROUND(SUM(CASE WHEN C.merchantId="'.$merchantidii.'" THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
																					SUM(CASE WHEN C.merchantId="'.$merchantidii.'" THEN 1 ELSE 0 END),2),0)*100 AS F2 
											  FROM 	cada_model A LEFT JOIN cada_module B
															ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
															ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
											 WHERE 	A.status=B.status=C.status AND A.status="1"  									AND
															DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
															A.id="'.$modelid.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND
															C.merchantId IN('.$merchantidi.','.$merchantidii.') AND C.groupId="'.$groupid.'"
										GROUP BY 	B.id,B.questionnaireId ORDER BY B.sorting');
	   return $query->result_array();  
   }
  	/**获取集团最高/最低指标*/
	public function getEvalaQuestionTop($type='DESC',$questionnaireId,$groupid,$startDate,$endDate,$rank){
		$query=$this->db->query("SELECT  B.primitiveTitle  AS title,
													               		IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0)*100 AS A1,
													      				 IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							  SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0)*100 AS A2, 
																		 (IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							   SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0) -
													       				IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0))*100 AS A3
												  FROM cada_results_questionnaire   A  LEFT JOIN 
															cada_results_question_bank  B   ON A.id=B.resultsQuestionnaireId
												 WHERE B.status=1 																				        AND 
															 A.status=1 																				        AND 
															 B.primitiveWeight>0 																	     AND
															 A.groupId=".$groupid."																      AND 
															 A.rank=".$rank."																			       AND
													         (DATE_FORMAT(A.operationTime,'%Y-%m')>='".$startDate."' 	    AND 
														     DATE_FORMAT(A.operationTime,'%Y-%m')<='".$endDate."') 		AND
													         A.questionnaireId=".$questionnaireId."
												 GROUP BY B.primitiveQuestionId 
												 ORDER BY A1 ".$type." 
												 LIMIT 0,5");
		return  $query->result_array();
	}
  	/**获取集团最高/最低指标*/
	public function getEvaliQuestionTop($type='DESC',$questionnaireId,$providerid,$startDate,$endDate){
		$query=$this->db->query("SELECT  B.primitiveTitle  AS title,
													               		IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                   								 SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0)*100 AS A1,
													      				 IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0)*100 AS A2, 
																		 (IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0) -
													       				IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0))*100 AS A3
												  FROM cada_results_questionnaire   A  LEFT JOIN 
															cada_results_question_bank  B   ON A.id=B.resultsQuestionnaireId
												 WHERE B.status=1 																				AND 
															 A.status=1 																				AND 
															 B.primitiveWeight>0 																	AND
															 A.merchantId=".$providerid."													    AND 
													         (DATE_FORMAT(A.operationTime,'%Y-%m')>='".$startDate."' 	    AND 
														     DATE_FORMAT(A.operationTime,'%Y-%m')<='".$endDate."') 		AND
													         A.questionnaireId=".$questionnaireId."
												 GROUP BY B.primitiveQuestionId 
												 ORDER BY A1 ".$type." 
												 LIMIT 0,5");
		return  $query->result_array();
	}
  	/**获取集团最高/最低指标*/
	public function getEvaliiQuestionTop($type='DESC',$questionnaireId,$provideri,$providerii,$startDate){
		$query=$this->db->query("SELECT  B.primitiveTitle  AS title,
													               		IFNULL(ROUND(SUM(CASE WHEN 	A.merchantId=".$provideri." AND  DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN 	A.merchantId=".$provideri." AND  DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0)*100 AS A1,
													      				 IFNULL(ROUND(SUM(CASE WHEN 	A.merchantId=".$providerii." AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							  SUM(CASE WHEN  A.merchantId=".$providerii."  AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0)*100 AS A2, 
																		 (IFNULL(ROUND(SUM(CASE WHEN A.merchantId=".$providerii."  AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							   SUM(CASE WHEN A.merchantId=".$providerii."  AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0) -
													       				IFNULL(ROUND(SUM(CASE WHEN   A.merchantId=".$provideri." AND   DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							  SUM(CASE WHEN  A.merchantId=".$provideri." AND  DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0))*100 AS A3
												  FROM cada_results_questionnaire   A  LEFT JOIN 
															cada_results_question_bank  B   ON A.id=B.resultsQuestionnaireId
												 WHERE B.status=1 																				AND 
															 A.status=1 																				AND 
															 B.primitiveWeight>0 																	AND
															 A.merchantId IN (".$provideri.",".$providerii.")							    AND 
													         DATE_FORMAT(A.operationTime,'%Y-%m')>='".$startDate."' 	    AND 
													         A.questionnaireId=".$questionnaireId."
												 GROUP BY B.primitiveQuestionId 
												 ORDER BY A1 ".$type." 
												 LIMIT 0,5");
		return  $query->result_array();
	}
  	/**获取集团最高/最低指标*/
	public function getAreaiQuestionTop($type='DESC',$questionnaireId,$groupid,$areaid,$startDate,$endDate,$rank){
		$query=$this->db->query("SELECT  B.primitiveTitle  AS title,
													               		IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0)*100 AS A1,
													      				 IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							  SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0)*100 AS A2, 
																		 (IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							   SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0) -
													       				IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0))*100 AS A3
												  FROM cada_results_questionnaire   A  LEFT JOIN 
															cada_results_question_bank  B   ON A.id=B.resultsQuestionnaireId
												 WHERE B.status=1 																							AND 
															 A.status=1 																							AND 
															 B.primitiveWeight>0 																			AND
															 A.groupId=".$groupid."													          			AND 
															 A.areaId=".$areaid."																	  			 AND 
															  A.rank=".$rank."																					AND
													         (DATE_FORMAT(A.operationTime,'%Y-%m')>='".$startDate."' 	    AND 
														     DATE_FORMAT(A.operationTime,'%Y-%m')<='".$endDate."') 		AND
													         A.questionnaireId=".$questionnaireId."
												 GROUP BY B.primitiveQuestionId 
												 ORDER BY A1 ".$type." 
												 LIMIT 0,5");
		return  $query->result_array();
	}
	  	/**获取集团最高/最低指标*/
	public function getAreaiiQuestionTop($type='DESC',$questionnaireId,$groupid,$areai,$areaii,$startDate,$rank){
		$query=$this->db->query("SELECT  B.primitiveTitle  AS title,
													               		IFNULL(ROUND(SUM(CASE WHEN 	A.areaId=".$areai." AND  DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN 	A.areaId=".$areai." AND  DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0)*100 AS A1,
													      				 IFNULL(ROUND(SUM(CASE WHEN 	A.areaId=".$areaii." AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							  SUM(CASE WHEN  A.areaId=".$areaii."  AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0)*100 AS A2, 
																		 (IFNULL(ROUND(SUM(CASE WHEN A.areaId=".$areaii."  AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							   SUM(CASE WHEN A.areaId=".$areaii."  AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0) -
													       				IFNULL(ROUND(SUM(CASE WHEN   A.areaId=".$areai." AND   DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							  SUM(CASE WHEN  A.areaId=".$areai." AND  DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0))*100 AS A3
												  FROM cada_results_questionnaire   A  LEFT JOIN 
															cada_results_question_bank  B   ON A.id=B.resultsQuestionnaireId
												 WHERE B.status=1 																				  AND 
															 A.status=1 																				   AND 
															 A.groupId=".$groupid."													            AND 
															 B.primitiveWeight>0 																	AND
															 A.areaId IN (".$areai.",".$areaii.")							    					AND 
															 A.rank=".$rank."																			AND
													         DATE_FORMAT(A.operationTime,'%Y-%m')>='".$startDate."' 	    AND 
													         A.questionnaireId=".$questionnaireId."
												 GROUP BY B.primitiveQuestionId 
												 ORDER BY A1 ".$type." 
												 LIMIT 0,5");
		return  $query->result_array();
	}
  	/**获取集团最高/最低指标*/
	public function getBrandiQuestionTop($type='DESC',$questionnaireId,$groupid,$brandid,$startDate,$endDate){
		$query=$this->db->query("SELECT  B.primitiveTitle  AS title,
													               		IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0)*100 AS A1,
													      				 IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							  SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0)*100 AS A2, 
																		 (IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							   SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0) -
													       				IFNULL(ROUND(SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0))*100 AS A3
												  FROM cada_results_questionnaire   A  LEFT JOIN 
															cada_results_question_bank  B   ON A.id=B.resultsQuestionnaireId
												 WHERE B.status=1 																				AND 
															 A.status=1 																				AND 
															 B.primitiveWeight>0 																	AND
															 A.groupId=".$groupid."													            AND 
															 A.brandId=".$brandid."																	AND 
													         (DATE_FORMAT(A.operationTime,'%Y-%m')>='".$startDate."' 	    AND 
														     DATE_FORMAT(A.operationTime,'%Y-%m')<='".$endDate."') 		AND
													         A.questionnaireId=".$questionnaireId."
												 GROUP BY B.primitiveQuestionId 
												 ORDER BY A1 ".$type." 
												 LIMIT 0,5");
		return  $query->result_array();
	}
    /**获取集团最高/最低指标*/
	public function getBrandiiQuestionTop($type='DESC',$questionnaireId,$groupid,$brandi,$brandii,$startDate){
		$query=$this->db->query("SELECT  B.primitiveTitle  AS title,
													               		IFNULL(ROUND(SUM(CASE WHEN 	A.brandId=".$brandi."  AND  DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							 SUM(CASE WHEN 	A.brandId=".$brandi."  AND  DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0)*100 AS A1,
													      				 IFNULL(ROUND(SUM(CASE WHEN 	A.brandId=".$brandii." AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							  SUM(CASE WHEN  A.brandId=".$brandii."  AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0)*100 AS A2, 
																		 (IFNULL(ROUND(SUM(CASE WHEN A.brandId=".$brandii."  AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							   SUM(CASE WHEN A.brandId=".$brandii."  AND DATE_FORMAT(A.operationTime,'%Y-%m')='".$endDate."' THEN 1 ELSE 0 END),2),0) -
													       				IFNULL(ROUND(SUM(CASE WHEN   A.brandId=".$brandi."   AND   DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN IFNULL(B.alreadyWeight,0)/IFNULL(B.primitiveWeight,0) ELSE 0 END)/
													                    							  SUM(CASE WHEN  A.brandId=".$brandi."   AND  DATE_FORMAT(A.operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END),2),0))*100 AS A3
												  FROM cada_results_questionnaire   A  LEFT JOIN 
															cada_results_question_bank  B   ON A.id=B.resultsQuestionnaireId
												 WHERE B.status=1 																				AND 
															 A.status=1 																				AND 
															 A.groupId=".$groupid."													            AND 
															 B.primitiveWeight>0 																	AND
															 A.brandId IN (".$brandi.",".$brandii.")							    	AND 
													         DATE_FORMAT(A.operationTime,'%Y-%m')>='".$startDate."' 	    AND 
													         A.questionnaireId=".$questionnaireId."
												 GROUP BY B.primitiveQuestionId 
												 ORDER BY A1 ".$type." 
												 LIMIT 0,5");
		return  $query->result_array();
	}
	/**获取单店指标*/
	public function getNPS($providerid,$modelid,$startDate,$endDate){
		$query=$this->db->query('SELECT  IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code="S101") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code IN("S101","S102","S103")) THEN 1 ELSE 0 END)*100,2),0) AS S1,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code="S103") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code IN("S101","S102","S103")) THEN 1 ELSE 0 END)*100,2),0) AS S2,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code="S102") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code IN("S101","S102","S103")) THEN 1 ELSE 0 END)*100,2),0) AS S3,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code="S101") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code IN("S101","S102","S103")) THEN 1 ELSE 0 END)*100,2),0) AS S4,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code="S103") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code IN("S101","S102","S103")) THEN 1 ELSE 0 END)*100,2),0) AS S5,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code="S102") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code IN("S101","S102","S103")) THEN 1 ELSE 0 END)*100,2),0) AS S6,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code="S202") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code IN("S201","S202")) THEN 1 ELSE 0 END)*100,2),0) AS S7,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code="S201") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code IN("S201","S202")) THEN 1 ELSE 0 END)*100,2),0) AS S8,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code="S202") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code IN("S201","S202")) THEN 1 ELSE 0 END)*100,2),0) AS S9,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code="S201") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code IN("S201","S202")) THEN 1 ELSE 0 END)*100,2),0) AS S10,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code="S302") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code IN("S301","S302")) THEN 1 ELSE 0 END)*100,2),0) AS S11,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code="S301") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$startDate.'" AND F.code IN("S301","S302")) THEN 1 ELSE 0 END)*100,2),0) AS S12,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code="S302") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code IN("S301","S302")) THEN 1 ELSE 0 END)*100,2),0) AS S13,
															IFNULL(ROUND(SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code="S301") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN (DATE_FORMAT(C.operationTime,"%Y-%m")="'.$endDate.'" AND F.code IN("S301","S302")) THEN 1 ELSE 0 END)*100,2),0) AS S14
												FROM 	cada_model A LEFT JOIN cada_module B
															ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
															ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
															LEFT JOIN cada_results_question_bank D ON C.id=D.resultsQuestionnaireId 
															LEFT JOIN cada_results_answer E ON E.resultsQuestionId=D.id 
															LEFT JOIN cada_parameter F ON E.primitiveAnswerId=F.value
											WHERE 	A.status=B.status=C.status AND A.status="1"  AND
															DATE_FORMAT(C.operationTime,"%Y")=DATE_FORMAT(NOW(),"%Y") AND 
															(DATE_FORMAT(C.operationTime,"%Y-%m")>="'.$startDate.'" AND DATE_FORMAT(C.operationTime,"%Y-%m")<="'.$endDate.'") AND
															A.id="'.$modelid.'" AND C.merchantId="'.$providerid.'" AND 
															F.code IN("S101","S102","S103","S201","S202","S301","S302")');
		return $query->result_array();
	}
}