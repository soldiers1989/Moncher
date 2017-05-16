<?php
/*****************************************************
 **作者：hjm
**创始时间：2017-03-18
**描述：门店评测分析管理
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class AnastoreModel extends CI_Model {
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
	 * 日期:2017.03.18  Add by hjm
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	
	}
    /**
	 * 数据分析-门店评测分析-总分
	 */
	public function getTotaldata($providerid,$modelid,$rank,$startDate,$endDate){
		$model=$this->getModels($modelid);
		$query=$this->db->query("SELECT 		 IFNULL(ROUND(SUM(C.A1)/SUM(C.A2)*100,2),0) 		AS F1,
																			 IFNULL((SELECT SUM(X.size) FROM (SELECT 1  AS size,merchantId  FROM cada_results_questionnaire WHERE  status=1 AND merchantId=".$providerid."  AND questionnaireId IN (".$model[0]['id'].",".$model[1]['id'].",".$model[2]['id'].",".$model[3]['id'].",".$model[4]['id']." )  GROUP  BY personsId) X GROUP BY X.merchantId ),0)  											AS F2,
																			 IFNULL((SELECT SUM(X.size) FROM (SELECT 1  AS size,1 AS merchantId FROM cada_results_questionnaire WHERE  status=1 AND questionnaireId IN (".$model[0]['id'].",".$model[1]['id'].",".$model[2]['id'].",".$model[3]['id'].",".$model[4]['id']." )  GROUP  BY personsId) X GROUP BY X.merchantId ),0)											    												AS F3,
																			 IFNULL((SELECT SUM(X.size) FROM (SELECT 1  AS size,merchantId FROM cada_results_questionnaire WHERE  status=1  AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())  AND merchantId=".$providerid."  AND questionnaireId=".$model[0]['id']."  GROUP  BY personsId) X GROUP BY X.merchantId ),0)                        						AS F4,
																			 IFNULL((SELECT SUM(X.size) FROM (SELECT 1  AS size,merchantId FROM cada_results_questionnaire WHERE  status=1  AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())  AND merchantId=".$providerid."  AND questionnaireId=".$model[1]['id']."  GROUP  BY personsId) X GROUP BY X.merchantId ),0)                        						AS F5,
																			 IFNULL((SELECT SUM(X.size) FROM (SELECT 1  AS size,merchantId FROM cada_results_questionnaire WHERE  status=1  AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())  AND merchantId=".$providerid."  AND questionnaireId=".$model[2]['id']."  GROUP  BY personsId) X GROUP BY X.merchantId ),0)                        						AS F6,
																			 IFNULL((SELECT SUM(X.size) FROM (SELECT 1  AS size,merchantId  FROM cada_results_questionnaire WHERE  status=1  AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())  AND merchantId=".$providerid."  AND questionnaireId=".$model[3]['id']."  GROUP  BY personsId) X GROUP BY X.merchantId ),0)                        						AS F7,
																			 IFNULL((SELECT SUM(X.size) FROM (SELECT 1  AS size,merchantId  FROM cada_results_questionnaire WHERE  status=1  AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())  AND merchantId=".$providerid."  AND questionnaireId=".$model[4]['id']." GROUP  BY personsId) X  GROUP BY X.merchantId ),0)                        						AS F8,
																			 IFNULL(ROUND(SUM(C.A9)/SUM(C.A4)*100,2),0) 	    AS F9,
																			 IFNULL(ROUND(SUM(C.A10)/SUM(C.A5)*100,2),0)    AS F10,
																			 IFNULL(ROUND(SUM(C.A11)/SUM(C.A6)*100,2),0)    AS F11,
																			 IFNULL(ROUND(SUM(C.A12)/SUM(C.A7)*100,2),0)    AS F12,
																			 IFNULL(ROUND(SUM(C.A13)/SUM(C.A8)*100,2),0)    AS F13,
																			 IFNULL(ROUND(SUM(C.A16)/SUM(C.A14)*100,2),0)  AS F14,
																			 IFNULL(ROUND(SUM(C.A17)/SUM(C.A15)*100,2),0)  AS F15,
																			 IFNULL(ROUND(SUM(C.A20)/SUM(C.A18)*100,2),0)  AS F16,
																			 IFNULL(ROUND(SUM(C.A21)/SUM(C.A19)*100,2),0)  AS F17
														FROM (SELECT   id,
																				 CASE  WHEN merchantId=".$providerid." 		THEN  (alreadyWeight/primitive)   				ELSE 0 END AS A1,
																				 CASE  WHEN merchantId=".$providerid." 		THEN  1                          			 					ELSE 0 END AS A2,
																				 CASE  WHEN id>0 												THEN  1                         	         						ELSE 0 END AS A3,
																				 CASE  WHEN merchantId=".$providerid." AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())     AND	questionnaireId=".$model[0]['id']."  		THEN 1 ELSE 0 END AS A4,
																				 CASE  WHEN merchantId=".$providerid." AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())     AND	questionnaireId=".$model[1]['id']."  		THEN 1 ELSE 0 END AS A5,
																				 CASE  WHEN merchantId=".$providerid." AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())     AND	questionnaireId=".$model[2]['id']."   		THEN 1 ELSE 0 END AS A6,
																				 CASE  WHEN merchantId=".$providerid." AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())     AND	questionnaireId=".$model[3]['id']."    	    THEN 1 ELSE 0 END AS A7,
																				 CASE  WHEN merchantId=".$providerid." AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())     AND	questionnaireId=".$model[4]['id']."    	    THEN 1 ELSE 0 END AS A8,
																				 CASE  WHEN merchantId=".$providerid." AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())     AND 	questionnaireId=".$model[0]['id']."  		    THEN (alreadyWeight/primitive) ELSE 0 END AS A9,
																				 CASE  WHEN merchantId=".$providerid." AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())		 AND 	questionnaireId=".$model[1]['id']."  		THEN (alreadyWeight/primitive) ELSE 0 END AS A10,
																				 CASE  WHEN merchantId=".$providerid." AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())     AND 	questionnaireId=".$model[2]['id']."    		THEN (alreadyWeight/primitive) ELSE 0 END AS A11,
																				 CASE  WHEN merchantId=".$providerid." AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())     AND 	questionnaireId=".$model[3]['id']."    		THEN (alreadyWeight/primitive) ELSE 0 END AS A12,
																				 CASE  WHEN merchantId=".$providerid." AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime) = MONTH(CURDATE())     AND  questionnaireId=".$model[4]['id']."    		THEN (alreadyWeight/primitive) ELSE 0 END AS A13,
																				 CASE  WHEN merchantId=".$providerid." AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'    								THEN 1 ELSE 0 END  AS A14,
																				 CASE  WHEN merchantId=".$providerid." AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."'  								THEN 1 ELSE 0 END  AS A15,
																				 CASE  WHEN merchantId=".$providerid." AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'    								THEN (alreadyWeight/primitive) ELSE 0 END  AS A16,
																				 CASE  WHEN merchantId=".$providerid." AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."'  								THEN (alreadyWeight/primitive) ELSE 0 END  AS A17,
																				 CASE  WHEN rank=".$rank."  				 		AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   								THEN 1 ELSE 0 END  AS A18,
																				 CASE  WHEN rank=".$rank."  						 AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' 								THEN 1 ELSE 0 END  AS A19,
																				 CASE  WHEN rank=".$rank."  				 		AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   								THEN (alreadyWeight/primitive) ELSE 0 END  AS A20,
																				 CASE  WHEN rank=".$rank."  				 		AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' 								THEN (alreadyWeight/primitive) ELSE 0 END  AS A21
																	FROM   cada_results_questionnaire  
																	WHERE  status=1 			 																																AND 
																				 questionnaireId IN (".$model[0]['id'].",".$model[1]['id'].",".$model[2]['id'].",".$model[3]['id'].",".$model[4]['id']." )   																							AND 
																				 YEAR(operationTime)= YEAR(CURDATE())
																	ORDER  BY id DESC ) AS C
														GROUP BY C.A3");
		return $query->result_array();
	}
	/**获取门店总排行*/
	public function getMerchantTop($providerid,$modelid,$rank){
		$model=$this->getModels($modelid);
		$query=$this->db->query("SELECT merchantId                                                              
															FROM   cada_results_questionnaire  
															WHERE  status=1 			 																												    	AND 
																		 rank=".$rank."																															AND 
																		 questionnaireId  IN (".$model[0]['id'].",".$model[1]['id'].",".$model[2]['id'].",".$model[3]['id'].",".$model[4]['id']." )    AND 
																		 YEAR(operationTime)= YEAR(CURDATE())		   
															GROUP  BY merchantId
															ORDER  BY  ROUND(AVG((alreadyWeight/primitive)*100),2) DESC ");
		return $query->result_array();
	}
	/**获取关键指标分析*/
	public  function getMerchantNPSi($providerid,$modelid,$startDate,$endDate){
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
	/**获取分析页面主页数据*/
	public function getEvalData($providerid,$modelid,$rank,$startDate,$endDate){
		$model=$this->getModels($modelid);
		$query=$this->db->query("SELECT IFNULL(ROUND(SUM(C.A24)/SUM(C.A22)*100,2),0)   AS F1,
															IFNULL(ROUND(SUM(C.A23)/SUM(C.A21)*100,2),0) 	AS F2,
															IFNULL(ROUND(SUM(C.A28)/SUM(C.A26)*100,2),0)   AS F3,
															IFNULL(ROUND(SUM(C.A27)/SUM(C.A25)*100,2),0)   AS F4,
															IFNULL(ROUND(SUM(C.A6)/SUM(C.A1)*100,2),0)      AS F5,
															IFNULL(ROUND(SUM(C.A7)/SUM(C.A2)*100,2),0)      AS F6,
															IFNULL(ROUND(SUM(C.A8)/SUM(C.A3)*100,2),0)      AS F7,
															IFNULL(ROUND(SUM(C.A9)/SUM(C.A4)*100,2),0)      AS F8,
															IFNULL(ROUND(SUM(C.A10)/SUM(C.A5)*100,2),0)    AS F9,
															IFNULL(ROUND(SUM(C.A16)/SUM(C.A11)*100,2),0)   AS F10,
															IFNULL(ROUND(SUM(C.A17)/SUM(C.A12)*100,2),0)   AS F11,
															IFNULL(ROUND(SUM(C.A18)/SUM(C.A13)*100,2),0)   AS F12,
															IFNULL(ROUND(SUM(C.A19)/SUM(C.A14)*100,2),0)   AS F13,
															IFNULL(ROUND(SUM(C.A20)/SUM(C.A15)*100,2),0)   AS F14,
															IFNULL(ROUND(SUM(C.A34)/SUM(C.A29)*100,2),0)   AS F15,
															IFNULL(ROUND(SUM(C.A35)/SUM(C.A30)*100,2),0)   AS F16,
															IFNULL(ROUND(SUM(C.A36)/SUM(C.A31)*100,2),0)   AS F17,
															IFNULL(ROUND(SUM(C.A37)/SUM(C.A32)*100,2),0)   AS F18,
															IFNULL(ROUND(SUM(C.A38)/SUM(C.A33)*100,2),0)   AS F19,
															IFNULL(ROUND(SUM(C.A44)/SUM(C.A39)*100,2),0)   AS F20,
															IFNULL(ROUND(SUM(C.A45)/SUM(C.A40)*100,2),0)   AS F21,
															IFNULL(ROUND(SUM(C.A46)/SUM(C.A41)*100,2),0)   AS F22,
															IFNULL(ROUND(SUM(C.A47)/SUM(C.A42)*100,2),0)   AS F23,
															IFNULL(ROUND(SUM(C.A48)/SUM(C.A43)*100,2),0)   AS F24
												FROM (SELECT id,
																		 CASE  WHEN  id>0 																										  					THEN 1 ELSE 0 END AS A0,
																		 CASE  WHEN  merchantId=".$providerid." AND questionnaireId=".$model[0]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END AS A1,
																		 CASE  WHEN  merchantId=".$providerid." AND questionnaireId=".$model[1]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END AS A2,
																		 CASE  WHEN  merchantId=".$providerid." AND questionnaireId=".$model[2]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END AS A3,
																		 CASE  WHEN  merchantId=".$providerid." AND  questionnaireId=".$model[3]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END AS A4,
																		 CASE  WHEN  merchantId=".$providerid." AND  questionnaireId=".$model[4]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END AS A5,
																		 CASE  WHEN  merchantId=".$providerid." AND  questionnaireId=".$model[0]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN (alreadyWeight/primitive) ELSE 0 END AS A6,
																		 CASE  WHEN  merchantId=".$providerid." AND  questionnaireId=".$model[1]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN (alreadyWeight/primitive) ELSE 0 END AS A7,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[2]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN (alreadyWeight/primitive) ELSE 0 END AS A8,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[3]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN (alreadyWeight/primitive) ELSE 0 END AS A9,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[4]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN (alreadyWeight/primitive) ELSE 0 END AS A10,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[0]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."' 	 THEN 1 ELSE 0 END AS A11,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[1]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."' 	 THEN 1 ELSE 0 END AS A12,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[2]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN 1 ELSE 0 END AS A13,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[3]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN 1 ELSE 0 END AS A14,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[4]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN 1 ELSE 0 END AS A15,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[0]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN (alreadyWeight/primitive) ELSE 0 END AS A16,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[1]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN (alreadyWeight/primitive) ELSE 0 END AS A17,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[2]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN (alreadyWeight/primitive) ELSE 0 END AS A18,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[3]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN (alreadyWeight/primitive) ELSE 0 END AS A19,
																		 CASE  WHEN  merchantId=".$providerid." AND	questionnaireId=".$model[4]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN (alreadyWeight/primitive) ELSE 0 END AS A20,
																		 CASE  WHEN  merchantId=".$providerid." AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'    							   THEN 1 ELSE 0 END  AS A21,
																		 CASE  WHEN  merchantId=".$providerid." AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."'  							   THEN 1 ELSE 0 END  AS A22,
																		 CASE  WHEN  merchantId=".$providerid." AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'    							   THEN (alreadyWeight/primitive) ELSE 0 END  AS A23,
																		 CASE  WHEN  merchantId=".$providerid." AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."'  	 						   THEN (alreadyWeight/primitive) ELSE 0 END  AS A24,
																		 CASE  WHEN  rank=".$rank."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'    THEN 1 ELSE 0 END  AS A25,
																		 CASE  WHEN  rank=".$rank."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."'  THEN 1 ELSE 0 END  AS A26,
																		 CASE  WHEN  rank=".$rank."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'    THEN (alreadyWeight/primitive) ELSE 0 END  AS A27,
																		 CASE  WHEN  rank=".$rank."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."'  THEN (alreadyWeight/primitive) ELSE 0 END  AS A28,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[0]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END  AS A29,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[1]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END  AS A30,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[2]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END  AS A31,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[3]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END  AS A32,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[4]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN 1 ELSE 0 END  AS A33,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[0]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN (alreadyWeight/primitive) ELSE 0 END AS A34,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[1]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN (alreadyWeight/primitive) ELSE 0 END AS A35,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[2]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN (alreadyWeight/primitive) ELSE 0 END AS A36,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[3]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN (alreadyWeight/primitive) ELSE 0 END AS A37,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[4]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$startDate."' THEN (alreadyWeight/primitive) ELSE 0 END AS A38,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[0]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."' 	 THEN 1 ELSE 0 END AS A39,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[1]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."' 	 THEN 1 ELSE 0 END AS A40,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[2]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN 1 ELSE 0 END AS A41,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[3]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN 1 ELSE 0 END AS A42,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[4]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN 1 ELSE 0 END AS A43,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[0]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN (alreadyWeight/primitive) ELSE 0 END AS A44,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[1]['id']."  AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN (alreadyWeight/primitive) ELSE 0 END AS A45,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[2]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN (alreadyWeight/primitive) ELSE 0 END AS A46,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[3]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN (alreadyWeight/primitive) ELSE 0 END AS A47,
																		 CASE  WHEN  rank=".$rank."  AND questionnaireId=".$model[4]['id']."   AND DATE_FORMAT(operationTime,'%Y-%m')='".$endDate."'   THEN (alreadyWeight/primitive) ELSE 0 END AS A48
															FROM   cada_results_questionnaire  
															WHERE  status=1 			 																																             AND
																		   questionnaireId  IN (".$model[0]['id'].",".$model[1]['id'].",".$model[2]['id'].",".$model[3]['id'].",".$model[4]['id']." )    AND 
																		   YEAR(operationTime)= YEAR(CURDATE())
															ORDER  BY id DESC ) AS C
												GROUP BY C.A0");
	 return  $query->result_array();
	}
	/**获取固定指标NPS一次修复率*/
	public function  getMerchantNPS($providerid,$modelid){
		$query=$this->db->query('SELECT  IFNULL(ROUND(SUM(CASE WHEN (F.code="S101") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN  (F.code IN("S101","S102","S103")) THEN 1 ELSE 0 END)*100,2),0) AS S1,
															IFNULL(ROUND(SUM(CASE WHEN (F.code="S103") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN  (F.code IN("S101","S102","S103")) THEN 1 ELSE 0 END)*100,2),0) AS S2,
															IFNULL(ROUND(SUM(CASE WHEN (F.code="S102") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN  (F.code IN("S101","S102","S103")) THEN 1 ELSE 0 END)*100,2),0) AS S3,
															IFNULL(ROUND(SUM(CASE WHEN (F.code="S202") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN  (F.code IN("S201","S202")) THEN 1 ELSE 0 END)*100,2),0) AS S4,
															IFNULL(ROUND(SUM(CASE WHEN (F.code="S201") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN  (F.code IN("S201","S202")) THEN 1 ELSE 0 END)*100,2),0) AS S5,
															IFNULL(ROUND(SUM(CASE WHEN (F.code="S302") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN  (F.code IN("S301","S302")) THEN 1 ELSE 0 END)*100,2),0) AS S6,
															IFNULL(ROUND(SUM(CASE WHEN (F.code="S301") THEN 1 ELSE 0 END) / 
																					SUM(CASE WHEN  (F.code IN("S301","S302")) THEN 1 ELSE 0 END)*100,2),0) AS S7
											FROM 	  cada_model A LEFT JOIN cada_module B
															ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
															ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
															LEFT JOIN cada_results_question_bank D ON C.id=D.resultsQuestionnaireId 
															LEFT JOIN cada_results_answer 			 E ON E.resultsQuestionId=D.id 
															LEFT JOIN cada_parameter 			       F ON E.primitiveAnswerId=F.value
											WHERE 	A.status=B.status=C.status AND A.status="1"  AND
															YEAR(C.operationTime)=YEAR(CURDATE())				 AND
															A.id='.$modelid.' AND C.merchantId='.$providerid.'  AND 
															F.code IN("S101","S102","S103","S201","S202","S301","S302")');
		return  $query->result_array();
	}
	/**获取门店最高/最低指标*/
	public function getQuestionTop($type='DESC',$questionnaireId,$providerid,$startDate,$endDate){
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
															 A.merchantId=".$providerid."														AND 
													         (DATE_FORMAT(A.operationTime,'%Y-%m')>='".$startDate."' 	    AND 
														     DATE_FORMAT(A.operationTime,'%Y-%m')<='".$endDate."') 		AND
													         A.questionnaireId=".$questionnaireId."
												 GROUP BY B.primitiveQuestionId 
												 ORDER BY A1 ".$type." 
												 LIMIT 0,5");
		return  $query->result_array();
	}
	/**获取门店日月季度年数据分析*/
	public function getMerchantStore($type='All',$providerid,$modelid){
		$model=$this->getModels($modelid);
		$keys=array();
	    /*时间条件数据*/
		$where=array("All"        =>" AND id<>0 ",
								 "Year"     =>" AND  YEAR(operationTime)= YEAR(CURDATE()) " ,
								 "Quar"    =>" AND  QUARTER(operationTime)=QUARTER(CURDATE()) AND YEAR(operationTime)= YEAR(CURDATE())  ",
								 "Month"  =>" AND  MONTH(operationTime)=MONTH(CURDATE()) AND YEAR(operationTime)= YEAR(CURDATE())  ",
								 "Day"      =>" AND  DAYOFYEAR(operationTime)=DAYOFYEAR(CURDATE()) AND YEAR(operationTime)= YEAR(CURDATE()) ");
		$sql=" SELECT IFNULL(ROUND(SUM(C.A1)/SUM(C.A2)*100,2),0) AS F1,
				    			  IFNULL((SELECT SUM(X.size) FROM (SELECT  1  AS size,merchantId  FROM cada_results_questionnaire WHERE  status=1 AND merchantId=".$providerid."  AND questionnaireId IN (".$model[0]['id'].",".$model[1]['id'].",".$model[2]['id'].",".$model[3]['id'].",".$model[4]['id']."  )  ".$where[$type]."  GROUP  BY personsId) X GROUP BY X.merchantId ),0)  AS F2,";
		for($i=1;$i<=count($model);$i++){
			$sql.="		IFNULL((SELECT SUM(X.size) FROM (SELECT   1  AS size,merchantId FROM cada_results_questionnaire WHERE  status=1 AND merchantId=".$providerid."  AND questionnaireId=".$model[($i-1)]['id']."  ".$where[$type]."  GROUP  BY personsId) X GROUP BY X.merchantId ),0)  AS F".($i+2).",";
		}
		for($i=1;$i<=count($model);$i++){
			$i==count($model)?$sql.="IFNULL(ROUND(SUM(C.A".($i+7).")/SUM(C.A".($i+2).")*100,2),0)  AS F".($i+7) :
								     $sql.="IFNULL(ROUND(SUM(C.A".($i+7).")/SUM(C.A".($i+2).")*100,2),0)  AS F".($i+7).",";
		}
		$sql.="	FROM ( SELECT  CASE  WHEN merchantId=".$providerid."  THEN  (alreadyWeight/primitive)   ELSE 0 END AS A1, CASE  WHEN merchantId=".$providerid."  THEN 1  ELSE 0 END AS A2," ;
		for($i=0;$i<count($model);$i++){
			$sql.="CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[$i]['id']."   THEN 1 ELSE 0 END AS A".($i+3).",";
			$keys[]=$model[$i]['id'];
		}
		for($i=0;$i<count($model);$i++){
			$sql.=" CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[$i]['id']."   THEN (alreadyWeight/primitive) ELSE 0 END AS A".($i+8).",";
		}
		$sql.="	CASE  WHEN id>0 THEN  1  ELSE 1 END AS A0	FROM   cada_results_questionnaire  ";
		$sql.="	WHERE  status=1  AND questionnaireId IN (".(implode(',',$keys)).")  AND  merchantId=".$providerid."	".$where[$type]." ORDER  BY id DESC ) AS C GROUP BY C.A0";
		$query=$this->db->query($sql);
		return  $query->result_array();
	}
	/**获取门店季度得分*/
	public function getQuarScore($providerid,$questionnaireId){
		$sql=" SELECT  ";
		for($i=1;$i<=4;$i++){
			$sql.="		IFNULL((SELECT SUM(X.size) FROM (SELECT  1  AS size,merchantId  FROM cada_results_questionnaire WHERE  status=1 AND merchantId=".$providerid."  AND questionnaireId=".$questionnaireId."  AND YEAR(operationTime)= YEAR(CURDATE()) AND QUARTER(operationTime)=".$i."  GROUP  BY personsId) X GROUP BY X.merchantId ),0)  AS F".$i.",";
		}
		for($i=1;$i<=4;$i++){
			$i==4?$sql.="IFNULL(ROUND(SUM(C.A".($i+4).")/SUM(C.A".$i.")*100,2),0)  AS F".($i+4)	:
					   $sql.="IFNULL(ROUND(SUM(C.A".($i+4).")/SUM(C.A".$i.")*100,2),0)   AS F".($i+4).",";
		}
	   $sql.="	FROM ( SELECT  " ;
	   for($i=1;$i<=4;$i++){
			$sql.="CASE  WHEN merchantId=".$providerid." AND QUARTER(operationTime)=".$i."  THEN 1 ELSE 0 END AS A".$i.",";
		}
		for($i=1;$i<=4;$i++){
			$sql.="CASE  WHEN merchantId=".$providerid." AND QUARTER(operationTime)=".$i."  THEN (alreadyWeight/primitive) ELSE 0 END AS A".($i+4).",";
		}
		$sql.="	CASE  WHEN id>0 THEN  1  ELSE 1 END AS A0	FROM   cada_results_questionnaire  ";
		$sql.="  WHERE status=1 AND YEAR(operationTime)= YEAR(CURDATE())   AND questionnaireId=".$questionnaireId."  AND merchantId=".$providerid."  ORDER  BY id DESC )  AS C  GROUP BY C.A0" ;
		$query=$this->db->query($sql);
		return  $query->result_array();
	}
	/**获取门店年度得分*/
	public function getYearScore($providerid,$questionnaireId){
		$sql=" SELECT  ";
		for($i=1;$i<=12;$i++){
			$sql.="		IFNULL((SELECT SUM(X.size) FROM (SELECT  1  AS size,merchantId  FROM cada_results_questionnaire WHERE  status=1 AND merchantId=".$providerid."  AND questionnaireId=".$questionnaireId."  AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime)=".$i."  GROUP  BY personsId) X GROUP BY X.merchantId ),0)  AS F".$i.",";
		}
		for($i=1;$i<=12;$i++){
			$i==12?$sql.="IFNULL(ROUND(SUM(C.A".($i+12).")/SUM(C.A".$i.")*100,2),0)  AS F".($i+12)	:
						$sql.="IFNULL(ROUND(SUM(C.A".($i+12).")/SUM(C.A".$i.")*100,2),0)   AS F".($i+12).",";
		}
	   $sql.="	FROM ( SELECT  " ;
	   for($i=1;$i<=12;$i++){
			$sql.="CASE  WHEN merchantId=".$providerid." AND MONTH(operationTime)=".$i."  THEN 1 ELSE 0 END AS A".$i.",";
		}
		for($i=1;$i<=12;$i++){
			$sql.="CASE  WHEN merchantId=".$providerid." AND MONTH(operationTime)=".$i."  THEN (alreadyWeight/primitive) ELSE 0 END AS A".($i+12).",";
		}
		$sql.="	CASE  WHEN id>0 THEN  1  ELSE 1 END AS A0	FROM   cada_results_questionnaire  ";
		$sql.="  WHERE status=1 AND YEAR(operationTime)= YEAR(CURDATE())   AND questionnaireId=".$questionnaireId."  AND merchantId=".$providerid."  ORDER  BY id DESC )  AS C  GROUP BY C.A0" ;
		$query=$this->db->query($sql);
		return  $query->result_array();
	}
	/**获取门店月份得分*/
	public function getMonthScore($providerid,$questionnaireId,$time='2017-03-01'){
		$mon=date('t',$time);
		$sql="SELECT ";
		for($i=1;$i<=$mon;$i++){
			$sql.="		IFNULL((SELECT SUM(X.size) FROM (SELECT  1  AS size,merchantId  FROM cada_results_questionnaire WHERE  status=1 AND merchantId=".$providerid."  AND questionnaireId=".$questionnaireId."  AND YEAR(operationTime)= YEAR('".$time."')  AND  MONTH(operationTime)=MONTH('".$time."')   AND   DAYOFMONTH(operationTime)=".$i."  GROUP  BY personsId) X GROUP BY X.merchantId ),0)  AS F".$i.",";
		}
		for($i=1;$i<=$mon;$i++){
			$i ==$mon ? $sql.="	IFNULL(ROUND(SUM(C.A".($i+$mon).")/SUM(C.A".$i.")*100,2),0) 	  		AS F".($i+$mon) : 
								$sql.="		IFNULL(ROUND(SUM(C.A".($i+$mon).")/SUM(C.A".$i.")*100,2),0) 	  		AS F".($i+$mon).",";
		}
		$sql.="	FROM ( SELECT  " ;
		for($i=1;$i<=$mon;$i++){
			$sql.="CASE  WHEN merchantId=".$providerid." AND DAYOFMONTH(operationTime)=".$i."   THEN 1 ELSE 0 END AS A".$i.",";
		}
		for($i=1;$i<=$mon;$i++){
			$sql.="CASE  WHEN merchantId=".$providerid." AND DAYOFMONTH(operationTime)=".$i."   THEN (alreadyWeight/primitive) ELSE 0 END AS A".($i+$mon).",";
		}
		$sql.="	 CASE  WHEN id>0 THEN  1  ELSE 1 END AS A0	FROM   cada_results_questionnaire  ";
		$sql.="   WHERE status=1 AND YEAR(operationTime)= YEAR('".$time."') AND MONTH(operationTime)=MONTH('".$time."') AND questionnaireId=".$questionnaireId." AND merchantId=".$providerid." ORDER  BY id DESC ) AS C GROUP BY C.A0" ;
		$query=$this->db->query($sql);
		return  $query->result_array();
	}
		/**获取模型列表*/
	public function getModels($modelid){
		$query=$this->db->query("SELECT  B.questionnaireId AS id,
															 B.title  
												 FROM   cada_model A LEFT JOIN cada_module B ON A.id=B.modelId  
												 WHERE  A.status=1 AND B.status=1 AND A.id=".$modelid."  ORDER BY B.sorting ASC ");
		return $query->result_array();
	}
}