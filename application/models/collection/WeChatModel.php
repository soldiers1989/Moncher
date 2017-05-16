<?php
/*****************************************************
 **作者：zwx
**创始时间：2017-03-18
**描述：微信采集端MODEL类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class WeChatModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::WeChatModel::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.03.18  Add by zwx
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**获取当前问卷得分*/
	public function findSelfResult($id){
		$query=$this->db->query(" SELECT 	ROUND(IFNULL(alreadyWeight,0)/IFNULL(primitive,0)*100,2) 	AS score 
														  FROM   	cada_results_questionnaire   
														  WHERE     status=1 AND id=".$id);
		$list=$query->result_array();
		return empty($list)	? 82.57:$list[0]['score'];
	}
	/**获取当前模块的总得分*/
	public function findAllResult($modelid,$providerid){
		$query=$this->db->query(" SELECT 	ROUND(AVG(IFNULL(alreadyWeight,0)/IFNULL(primitive,0))*100,2) 	AS score 
														  FROM       cada_results_questionnaire   
														  WHERE     status=1  AND merchantId=".$providerid." AND 
																			alreadyWeight IS NOT NULL AND 
																			questionnaireId=".$modelid);
		$list=$query->result_array();
		return empty($list)	? 82.57:$list[0]['score'];
	}
	/**获取问卷总体权重*/
	public function findSelResults($id){
		$query=$this->db->query('SELECT   IFNULL(ROUND(SUM(E.primitiveWeight),6),0) AS weight
														FROM     cada_results_questionnaire     C  															   LEFT JOIN 
																		cada_results_question_bank    D   ON C.id=D.resultsQuestionnaireId  LEFT JOIN 
																		cada_results_answer 			     E   ON E.resultsQuestionId=D.id 
													     WHERE  D.primitiveWeight  IS NOT NULL  AND 
																		C.status=D.status=E.status  AND  C.status=1  AND 
																		C.id='.$id.'  
														 GROUP  BY C.id ');
		$list=$query->result_array();
		return empty($list)	? 0.00:$list[0]['weight'];
	}
	/**获取一个问卷的所有题目*/
	public function findQuestionnaireQuestion($id){
		$query=$this->db->query("SELECT   A.questionId  AS questionid,B.title 	AS name,B.type,A.id,B.weight,B.description
	                                                       FROM   cada_questionnaire_info     AS A	LEFT JOIN 
																		 cada_question_bank            AS B     ON A.questionId=B.id
														  WHERE   A.status=1 AND B.status=1 AND A.questionnaireId=".$id."
	                                                      ORDER   BY  A.questionId   ASC");
		$list=$query->result_array();
		return empty($list)	? array():$list;
	}
	/**获取一个问卷的任意一道试题*/
	public function findQuestionOne($id,$modelid){
		if($id>0){
			$query=$this->db->query("SELECT    A.id,B.type,B.title AS name,A.questionId AS questionid,B.description
		  			                                         FROM      cada_questionnaire_info   AS A  LEFT JOIN 
																			  cada_question_bank           AS B     ON  A.questionId=B.id
		  			                                       WHERE      A.status=1 AND B.status=1 AND A.id=".$id);
		}else{
			$query=$this->db->query("SELECT   A.questionId 		AS questionid,B.title 	AS name,B.type,A.id
		                                                       FROM   cada_questionnaire_info     AS A	LEFT JOIN 
																			 cada_question_bank            AS B    ON A.questionId=B.id
															  WHERE  A.status=1 AND B.status=1 AND  A.questionnaireId=".$modelid."
		                                                      ORDER   BY  A.questionId   ASC 
															  LIMIT 0,1");
		}
		$row=$query->result_array();
		return $row[0];
	}
	/**获取任意问题的选项列表*/
	public function findQuestionAnswers($questionid){
		$query=$this->db->query("SELECT   id,questionId AS questionid,title	 AS name,jump  AS tolink ,description,answerValue  AS value,symbol  AS labels,weight
														 FROM     cada_question_bank_answer       
														 WHERE   status=1 AND questionId=".$questionid."  
														 ORDER    BY id ASC ");
	return $query->result_array();
	}
	/**获取用户基础信息*/
	public function findPersonInfo($openId){
		$query=$this->db->query('SELECT  A.id,A.sex,A.age,A.merchantId,A.carModelId,A.brandId,A.qualifications,A.income,A.occupation,A.carPeriod,A.openId,A.createtime,A.areaId,B.rank
														FROM    cada_persons  A LEFT JOIN cada_car_info B ON B.id=A.brandId
														WHERE  A.openId="'.$openId.'" 
														ORDER  BY A.id DESC  
														LIMIT 0,1');
		$row=$query->result_array();
		return $row[0];
	}
	/**获取正在执行的策略*/
	public function findSelStrategy(){
		$query=$this->db->query('SELECT  * 
														 FROM    cada_strategy 
				                                         WHERE  DATE_FORMAT(endTime,"%Y-%m-%d")>="'.(date("Y-m-d",time())).'" AND  
																		DATE_FORMAT(beginTime,"%Y-%m-%d")<="'.(date("Y-m-d",time())).'" AND 
																		status=1');
		$row=$query->result_array();
		return $row[0];
	}
	/**获取调研模型模型*/
	public function findSelModels($modelid){
		$query=$this->db->query('SELECT  id,title,startTime,stopTime,status  
														FROM    cada_model  
														WHERE  status=1 AND id='.$modelid);
		$row=$query->result_array();
		return $row[0];
	}
	/**获取调研模块列表*/
	public function findSelMoudles($modelid){
		$query=$this->db->query('SELECT  A.id AS moduleId,
																	   A.modelId,
																	   A.questionnaireId,
																	   A.title,
																	   B.weight
														FROM    cada_module  A LEFT JOIN 
																	   cada_questionnaire B ON B.id=A.questionnaireId 
														WHERE  A.status=1 AND B.status=1 AND A.modelId='.$modelid.' 
														ORDER   BY A.sorting ASC');
		$row=$query->result_array();
		return $row;
	}
	/**获取已参与模块列表*/
	public function findHistoryMoudles($personid,$providerid,$modelid){
		$query=$this->db->query('SELECT  A.id AS moduleId,
																	   A.modelId,
																	   A.questionnaireId,
																	   A.title,
																	   ROUND((C.alreadyWeight/C.primitive)*100,2) AS score
														FROM    cada_module  					  A  												   LEFT JOIN
																	   cada_questionnaire 			  B    ON  B.id=A.questionnaireId  LEFT JOIN 
																	   cada_results_questionnaire C   ON   C.questionnaireId=A.questionnaireId
														WHERE  A.status=1 AND B.status=1 		AND  A.modelId='.$modelid.' AND 
																	   C.personsId='.$personid.'    		AND  C.merchantId='.$providerid.' 
														ORDER   BY A.sorting  ASC');
		$row=$query->result_array();
		return $row;
	}
	/**获取门店基础信息*/
	public function findMerchantInfo($providerid){
		$query=$this->db->query('SELECT     B.id AS groupId,
																		    CASE WHEN D.parentId=0 THEN C.areaId  ELSE D.parentId   END AS areaId 
														  FROM       cada_provider_certification 	 A 							          LEFT JOIN 
																		    cada_merchant_info             B  ON B.id=A.pId  				LEFT JOIN 
																		    cada_merchant_info             C  ON C.id=A.providerId  LEFT JOIN 
																		    cada_area                      D  ON D.id=C.areaId 
														    WHERE 	C.id='.$providerid.'  AND B.isCompany=0 AND A.status=1 AND B.status=1 AND C.status=1 AND D.status=1');
		$row=$query->result_array();
		return count($row)<=0?array():$row[0];
	}
	/**获取门店参与总数*/
	public function findMerchantPersonSize($providerid,$modelid){
		$query=$this->db->query('SELECT  COUNT(1) AS size
														FROM    cada_module  					    A  												   LEFT JOIN
																	   cada_results_questionnaire  C   ON   C.questionnaireId=A.questionnaireId
														WHERE  A.status=1 AND C.status=1 		 AND  A.modelId='.$modelid.'  
																	   AND  C.merchantId='.$providerid.'
														GROUP   BY 	 C.merchantId');
		$row=$query->result_array();
		return count($row)<=0?0:$row[0]['size'];
	}
	/**获取任意问题的选项列表*/
	public function findQuestionAnswersOne($id){
		$query=$this->db->query("SELECT   id,
																		  questionId AS questionid,
																		  title			 AS name,
																		  jump          AS tolink ,
																		  description,
																		  answerValue AS value,
																		  symbol           AS labels,
																		  weight
															 FROM  cada_question_bank_answer
															 WHERE  status=1 AND id=".$id);
		return $query->result_array();
	}
	/**获取品牌列表*/
	public function findBrandList($brandid){
		if($brandid==0){
			$query=$this->db->query("SELECT    id,name,logoUrl AS logo,SUBSTRING(shortCode,1,1) AS code,rank
		     											    FROM       cada_car_info
		     												WHERE     status=1 AND parentid=0 AND shortCode IS NOT NULL");
			return $query->result_array();
		}else{
			$query=$this->db->query("SELECT    id,name
		     											     FROM       cada_car_info
		     												 WHERE     status=1    AND parentId=".$brandid);
			return $query->result_array();
		}
	}
}