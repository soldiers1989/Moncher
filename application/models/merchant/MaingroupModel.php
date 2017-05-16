<?php
/*****************************************************
 **作者：hjm
**创始时间：2017-04-7
**描述：集团主页
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class MaingroupModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::WarngroupModel::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.7  Add by hjm
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**
	 * 数据分析-集团主页-样本量
	 * 日期:2017.04.7  Add by hjm
	 */
 	public function getQueData($model){
		$sql="SELECT questionnaireId,title   FROM cada_module WHERE modelId=".$model."  ORDER BY sorting";
		return $this->db->query($sql)->result_array();
	} 
		/**
	 * 数据分析-集团主页-样本量
	 * 日期:2017.04.7  Add by hjm
	 */
 	public function getGroupNumData($model,$groupId){
 		$model=$this->getQueData($model);
 		$sql="SELECT SUM(X.size)  AS g_num
 			      FROM (SELECT 1  AS size,groupId  
 							  FROM 	  cada_results_questionnaire 
 							  WHERE  status=1   AND   groupId=".$groupId."  AND questionnaireId IN (".$model[0]['questionnaireId'].",".$model[1]['questionnaireId'].",".$model[2]['questionnaireId'].",".$model[3]['questionnaireId'].",".$model[4]['questionnaireId']." )  GROUP  BY personsId) X GROUP BY X.groupId";
		$list=$this->db->query($sql)->result_array();
		$sql1="SELECT SUM(X.size) AS h_num
 			        FROM (SELECT 1  AS size,1 AS groupId  
 							  FROM 	  cada_results_questionnaire 
 							  WHERE  status=1     AND questionnaireId IN (".$model[0]['questionnaireId'].",".$model[1]['questionnaireId'].",".$model[2]['questionnaireId'].",".$model[3]['questionnaireId'].",".$model[4]['questionnaireId']." )  GROUP  BY personsId) X GROUP BY X.groupId";
		$list1=$this->db->query($sql1)->result_array();
		return  array(array("g_num"=>empty($list[0]['g_num'])?0:$list[0]['g_num'],
										 "h_num"=>empty($list1[0]['h_num'])?0:$list1[0]['h_num']));
	} 
	/**
	 * 数据分析-集团主页-总分
	 * 日期:2017.04.7  Add by hjm
	 */
	public function getAllScoreData($model,$group_id){
		$sql="
	SELECT 
						ROUND(IFNULL(SUM(CASE WHEN C.groupId=".$group_id." AND C.rank='1' THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
            				 SUM(CASE WHEN C.groupId=".$group_id." AND C.rank='1' THEN 1 ELSE 0 END),0),2) * 100 AS g_top,
						ROUND(IFNULL(SUM(CASE WHEN C.rank='1' THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
						 	 SUM(CASE WHEN  C.rank='1' THEN 1 ELSE 0 END),0),2) * 100 AS h_top,
						ROUND(IFNULL(SUM(CASE WHEN C.groupId=".$group_id." AND C.rank='2' THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
             				 SUM(CASE WHEN C.groupId=".$group_id." AND C.rank='2' THEN 1 ELSE 0 END),0),2) * 100 AS g_mid,
						ROUND(IFNULL(SUM(CASE WHEN C.rank='2' THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
						 	 SUM(CASE WHEN  C.rank='2' THEN 1 ELSE 0 END),0),2) * 100 AS h_mid,
						ROUND(IFNULL(SUM(CASE WHEN C.groupId=".$group_id." AND C.rank='3' THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
            				 SUM(CASE WHEN C.groupId=".$group_id." AND C.rank='3' THEN 1 ELSE 0 END),0),2) * 100 AS g_low,
						ROUND(IFNULL(SUM(CASE WHEN C.rank='3' THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
						 	 SUM(CASE WHEN  C.rank='3' THEN 1 ELSE 0 END),0),2) * 100 AS h_low
  FROM 			cada_model A LEFT JOIN cada_module B
			 			ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
       					ON B.questionnaireId=C.questionnaireId
 WHERE            A.status=B.status=C.status AND C.status='1' AND A.id=".$model." AND
			 			DATE_FORMAT(C.operationTime,'%Y')=DATE_FORMAT(NOW(),'%Y') ";
		return $this->db->query($sql)->result_array();
	}
	/**
	 * 数据分析-集团主页-各模块得分
	 * 日期:2017.04.25  Add by hjm
	 */
	public function getModelScoreData($group_id,$model){
		$sql="
						SELECT 	MAX(B.title) AS title,
							B.questionnaireId,
							IFNULL(ROUND(SUM(CASE WHEN (C.groupId=".$group_id." AND C.rank='1') THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
													SUM(CASE WHEN ( C.groupId=".$group_id." AND C.rank='1') THEN 1 ELSE 0 END),2),0)*100 AS top_gr,
							IFNULL(ROUND(SUM(CASE WHEN (C.rank='1') THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
												   SUM(CASE WHEN ( C.rank='1') THEN 1 ELSE 0 END),2),0)*100 AS top_hr,
							IFNULL(ROUND(SUM(CASE WHEN ( C.groupId=".$group_id." AND C.rank='2') THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
												   SUM(CASE WHEN ( C.groupId=".$group_id." AND C.rank='2') THEN 1 ELSE 0 END),2),0)*100 AS mid_gr, 
							IFNULL(ROUND(SUM(CASE WHEN ( C.rank='2') THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
												   SUM(CASE WHEN (C.rank='2') THEN 1 ELSE 0 END),2),0)*100 AS mid_hr,
							IFNULL(ROUND(SUM(CASE WHEN ( C.groupId=".$group_id." AND C.rank='3') THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
												   SUM(CASE WHEN (C.groupId=".$group_id." AND C.rank='3') THEN 1 ELSE 0 END),2),0)*100 AS low_gr,
							IFNULL(ROUND(SUM(CASE WHEN ( C.rank='3') THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
												   SUM(CASE WHEN ( C.rank='3') THEN 1 ELSE 0 END),2),0)*100 AS low_hr
			  FROM  cada_model A LEFT JOIN cada_module B
						  ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
						  ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
						
				WHERE A.status=B.status AND A.status='1'  AND
								DATE_FORMAT(C.operationTime,'%m')=DATE_FORMAT(NOW(),'%m') 
								 AND  A.id=".$model." 
		 GROUP BY B.id,B.questionnaireId ORDER BY B.sorting ";
// 		echo "<pre>";
// 		echo $sql;die;
		return $this->db->query($sql)->result_array();
	}
	/**
	 * 数据分析-集团主页-各模块样本量
	 * 日期:2017.04.25  Add by hjm
	 */
	public function getModelSizeData($group_id,$model){
		$model=$this->getQueData($model);
		$sql="
SELECT  '".$model[0]['questionnaireId']."' AS questionnaireId,
			   '".$model[0]['title']."'					AS  title,
			  IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) 		AND status=1   AND   rank=1 			AND 	groupId=".$group_id."   AND questionnaireId=".$model[0]['questionnaireId']."  GROUP  BY personsId) X GROUP BY X.groupId) ,0)    AS top_gs,
			  IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND status=1   AND   rank=2      AND   groupId=".$group_id."   AND questionnaireId=".$model[0]['questionnaireId']."  GROUP  BY personsId) X GROUP BY X.groupId) ,0)    AS mid_gs,
		      IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND  status=1  AND   rank=3      AND   groupId=".$group_id."   AND questionnaireId=".$model[0]['questionnaireId']."   GROUP  BY personsId) X GROUP BY X.groupId) ,0)   AS low_gs
UNION ALL 
SELECT  '".$model[1]['questionnaireId']."' AS questionnaireId,
			   '".$model[1]['title']."'					AS  title,
		      	IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND status=1   AND   rank=1 			AND 	groupId=".$group_id."  AND questionnaireId=".$model[1]['questionnaireId']."  GROUP  BY personsId) X GROUP BY X.groupId) ,0)    AS top_gs,
				IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND status=1   AND   rank=2      AND   groupId=".$group_id."   AND questionnaireId=".$model[1]['questionnaireId']."  GROUP  BY personsId) X GROUP BY X.groupId) ,0)    AS mid_gs,
				IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND  status=1  AND   rank=3      AND   groupId=".$group_id."   AND questionnaireId=".$model[1]['questionnaireId']."   GROUP  BY personsId) X GROUP BY X.groupId) ,0)   AS low_gs
UNION  ALL  
SELECT  '".$model[2]['questionnaireId']."' AS questionnaireId,
			   '".$model[2]['title']."'					AS  title,
				IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND status=1   AND   rank=1 			AND 	groupId=".$group_id."   AND questionnaireId=".$model[2]['questionnaireId']." GROUP  BY personsId) X GROUP BY X.groupId) ,0)    AS top_gs,
				IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND status=1   AND   rank=2      AND   groupId=".$group_id."  AND questionnaireId=".$model[2]['questionnaireId']."  GROUP  BY personsId) X GROUP BY X.groupId) ,0)    AS mid_gs,
				IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND  status=1  AND   rank=3      AND   groupId=".$group_id."  AND questionnaireId=".$model[2]['questionnaireId']."   GROUP  BY personsId) X GROUP BY X.groupId) ,0)   AS low_gs
UNION  ALL   
SELECT  '".$model[3]['questionnaireId']."' AS questionnaireId,
			   '".$model[3]['title']."'					AS  title,
				IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND status=1   AND   rank=1 			AND 	groupId=".$group_id."  AND questionnaireId=".$model[3]['questionnaireId']."  GROUP  BY personsId) X GROUP BY X.groupId) ,0)    AS top_gs,
				IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND status=1   AND   rank=2      AND   groupId=".$group_id."  AND questionnaireId=".$model[3]['questionnaireId']."  GROUP  BY personsId) X GROUP BY X.groupId) ,0)    AS mid_gs,
				IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND  status=1  AND   rank=3      AND   groupId=".$group_id."  AND questionnaireId=".$model[3]['questionnaireId']."  GROUP  BY personsId) X GROUP BY X.groupId) ,0)   AS low_gs
UNION   ALL 
SELECT  '".$model[4]['questionnaireId']."'  AS questionnaireId,
			   '".$model[4]['title']."'					   AS  title,
				IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND status=1   AND   rank=1 			AND 	groupId=".$group_id." AND questionnaireId=".$model[4]['questionnaireId']." GROUP  BY personsId) X GROUP BY X.groupId) ,0)    AS top_gs,
				IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND status=1   AND   rank=2      AND   groupId=".$group_id."  AND questionnaireId=".$model[4]['questionnaireId']."  GROUP  BY personsId) X GROUP BY X.groupId) ,0)    AS mid_gs,
				IFNULL((SELECT SUM(X.size)   FROM (SELECT 1  AS size,groupId   FROM 	  cada_results_questionnaire  WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) AND  status=1  AND   rank=3      AND   groupId=".$group_id." AND questionnaireId=".$model[4]['questionnaireId']." GROUP  BY personsId) X GROUP BY X.groupId) ,0)   AS low_gs";
		return $this->db->query($sql)->result_array();
	}
	/**
	 * 数据分析-集团主页-高中低排名
	 * 日期:2017.04.25  Add by hjm
	 */
	public function getRankData($rank,$group_id,$model){
		$sql.="SELECT  C.groupId                                                              
			FROM   cada_model                  AS A 									 LEFT JOIN
						 cada_module  							 AS B ON A.id=B.modelId  LEFT JOIN
						 cada_results_questionnaire  AS C ON C.questionnaireId=B.questionnaireId		
			WHERE  A.status=B.status=C.status    AND A.status='1'			 							AND 
						 C.rank=".$rank."																										AND 
						 A.id=".$model."  AND 
						 YEAR(C.operationTime)= YEAR(CURDATE())		   
			GROUP  BY groupId
			ORDER  BY  ROUND(AVG((C.alreadyWeight/C.primitive)*100),2) DESC";
// 		echo "<pre>";
// 		echo $sql;die;
		return $this->db->query($sql)->result_array();
	}
	/**
	 * 数据分析-集团主页-集团下门店num
	 * 日期:2017.04.25  Add by hjm
	 */
 	public function getStoreNumData($group_id){
$sql=" SELECT 	SUM(H.top_n)     n_t,
					SUM(H.mid_n)     n_m,
					SUM(H.low_n)     n_l
	 FROM(SELECT 	
								merchantId,
								CASE WHEN rank='1' THEN 1 ELSE 0 END     top_n,
								CASE WHEN rank='2' THEN 1 ELSE 0 END     mid_n,
								CASE WHEN rank='3' THEN 1 ELSE 0 END     low_n
					FROM  cada_results_questionnaire  
				WHERE   status='1'  AND groupId=".$group_id." 
		 GROUP BY  merchantId)         AS  H";
// echo "<pre>";
// echo $sql;die;
		return $this->db->query($sql)->result_array();
	} 
	/**
	 * 数据分析-集团主页-集团下门店num
	 * 日期:2017.04.25  Add by hjm
	 */
	public function getKeyIndexData($group_id,$model){
		$sql=							'SELECT  IFNULL(ROUND(SUM(CASE WHEN (F.code="S101") THEN 1 ELSE 0 END) / 
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
															A.id='.$model.' AND C.groupId='.$group_id.'  AND 
															F.code IN("S101","S102","S103","S201","S202","S301","S302")';
		return $this->db->query($sql)->result_array();
	}
	/**
	 * 数据分析-集团主页-集团下门店排行
	 * 日期:2017.04.25  Add by hjm
	 */
	public function getStoreRankData($group_id,$model,$s_month,$b_month,$sort){
		$sql="SELECT    C.merchantId,
									E.name,
									ROUND(IFNULL(SUM(CASE WHEN  DATE_FORMAT(C.operationTime,'%m')='".$b_month."' THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
			                                 SUM(CASE WHEN DATE_FORMAT(C.operationTime,'%m')='".$b_month."'  THEN 1 ELSE 0 END),0),2) * 100          AS bscore,
									ROUND(IFNULL(SUM(CASE WHEN  DATE_FORMAT(C.operationTime,'%m')='".$s_month."'  THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
											SUM(CASE WHEN DATE_FORMAT(C.operationTime,'%m')='".$s_month."' THEN 1 ELSE 0 END),0),2) * 100            AS sscore,
									(ROUND(IFNULL(SUM(CASE WHEN  DATE_FORMAT(C.operationTime,'%m')='".$b_month."'  THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
			                                SUM(CASE WHEN DATE_FORMAT(C.operationTime,'%m')='".$b_month."'   THEN 1 ELSE 0 END),0),2) * 100)-
									(ROUND(IFNULL(SUM(CASE WHEN  DATE_FORMAT(C.operationTime,'%m')='".$s_month."' THEN IFNULL(C.alreadyWeight,0)/IFNULL(C.primitive,0) ELSE 0 END)/
											SUM(CASE WHEN DATE_FORMAT(C.operationTime,'%m')='".$s_month."'  THEN 1 ELSE 0 END),0),2) * 100)          AS cscore 
						 FROM cada_model A LEFT JOIN cada_module B
									ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
									ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
									LEFT JOIN	cada_car_info    AS D  ON D.id=C.brandId LEFT JOIN
									cada_merchant_info	       AS E  ON E.id=C.merchantId
					 WHERE  A.status=B.status=C.status=D.status  AND A.status='1'  AND C.groupId=".$group_id." AND  A.id=".$model."  AND DATE_FORMAT(C.operationTime,'%Y')=DATE_FORMAT(NOW(),'%Y') 
				 GROUP BY   C.merchantId
			     ORDER BY    bscore   ".$sort." , sscore ".$sort." 
     LIMIT  0,10	 ";
		return $this->db->query($sql)->result_array();
	}
	/**
	 * 数据分析-集团主页-地图得分
	 * 日期:2017.04.25  Add by hjm
	 */
	public function getMapScoreData($group_id,$model){
		$sql="
				SELECT  SUM(E.河南)  '河南', SUM(E.北京)  '北京', SUM(E.上海)  '上海', SUM(E.广东)  '广东', SUM(E.陕西)  '陕西', SUM(E.四川)  '四川', SUM(E.南京)  '南京', SUM(E.河北)  '河北', (E.甘肃)  '甘肃'
 FROM(SELECT C.groupId,
						 CASE WHEN C.areaId='10'  OR C.areaId='12' THEN ROUND((SUM((IFNULL(C.alreadyWeight,0))/(IFNULL(C.primitive,0)))/SUM(1))*100,2) ELSE 0 END     '河南',	
						 CASE WHEN C.areaId='1' OR C.areaId='2' THEN ROUND((SUM((IFNULL(C.alreadyWeight,0))/(IFNULL(C.primitive,0)))/SUM(1))*100,2) ELSE 0 END     '北京',
						 CASE WHEN C.areaId='3'  THEN ROUND((SUM((IFNULL(C.alreadyWeight,0))/(IFNULL(C.primitive,0)))/SUM(1))*100,2)  ELSE 0 END     '上海',
						 CASE WHEN C.areaId='4' OR C.areaId='9'  THEN ROUND((SUM((IFNULL(C.alreadyWeight,0))/(IFNULL(C.primitive,0)))/SUM(1))*100,2) ELSE 0 END     '广东',
					   	 CASE WHEN C.areaId='5' OR C.areaId='11'  THEN ROUND((SUM((IFNULL(C.alreadyWeight,0))/(IFNULL(C.primitive,0)))/SUM(1))*100,2) ELSE 0 END     '陕西',
						 CASE WHEN C.areaId='6'  THEN ROUND((SUM((IFNULL(C.alreadyWeight,0))/(IFNULL(C.primitive,0)))/SUM(1))*100,2) ELSE 0 END     '四川',
						 CASE WHEN C.areaId='7'  THEN ROUND((SUM((IFNULL(C.alreadyWeight,0))/(IFNULL(C.primitive,0)))/SUM(1))*100,2) ELSE 0 END     '南京',
						 CASE WHEN C.areaId='8'  THEN ROUND((SUM((IFNULL(C.alreadyWeight,0))/(IFNULL(C.primitive,0)))/SUM(1))*100,2) ELSE 0 END     '河北',
						 CASE WHEN C.areaId='13' THEN ROUND((SUM((IFNULL(C.alreadyWeight,0))/(IFNULL(C.primitive,0)))/SUM(1))*100,2) ELSE 0 END     '甘肃'
			  FROM cada_model A LEFT JOIN cada_module B
						 ON A.id=B.modelId LEFT JOIN cada_results_questionnaire C
						 ON C.questionnaireId=B.questionnaireId AND C.primitivemoduleId=B.id AND C.primitiveModelId=A.id 
						 LEFT JOIN	cada_area    AS D  ON D.id=C.areaId
			WHERE  A.status=B.status=C.status=D.status  AND A.status='1'	AND C.groupId=".$group_id." AND A.id=".$model." AND 	 DATE_FORMAT(C.operationTime,'%Y')=DATE_FORMAT(NOW(),'%Y') 
	 GROUP BY  C.areaId)           AS E
GROUP BY E.groupId";
		return $this->db->query($sql)->result_array();
	}
	/**
	 * 数据分析-集团主页-地图样本量
	 * 日期:2017.04.25  Add by hjm
	 */
	public function getMapSizeData($group_id,$model){
		$model=$this->getQueData($model);
		$sql="SELECT  IFNULL((SELECT SUM(X.size)  AS g_num  FROM (SELECT 1  AS size,groupId FROM cada_results_questionnaire   WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) 		AND status=1   AND  (areaId='10'  OR areaId='12')  AND status=1   AND   groupId=".$group_id."  AND questionnaireId IN (".$model[0]['questionnaireId'].",".$model[1]['questionnaireId'].",".$model[2]['questionnaireId'].",".$model[3]['questionnaireId'].",".$model[4]['questionnaireId']." )  GROUP  BY personsId) X GROUP BY X.groupId),0) AS '河南',
								 IFNULL((SELECT SUM(X.size)  AS g_num  FROM (SELECT 1  AS size,groupId FROM cada_results_questionnaire   WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) 		AND status=1   AND  (areaId='1'  OR areaId='2')  AND status=1   AND   groupId=".$group_id."  AND questionnaireId IN (".$model[0]['questionnaireId'].",".$model[1]['questionnaireId'].",".$model[2]['questionnaireId'].",".$model[3]['questionnaireId'].",".$model[4]['questionnaireId']." )  GROUP  BY personsId) X GROUP BY X.groupId),0) AS '北京',
								 IFNULL((SELECT SUM(X.size)  AS g_num  FROM (SELECT 1  AS size,groupId FROM cada_results_questionnaire   WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) 		AND status=1   AND  (areaId='3')  AND status=1   AND   groupId=".$group_id."  AND questionnaireId IN (".$model[0]['questionnaireId'].",".$model[1]['questionnaireId'].",".$model[2]['questionnaireId'].",".$model[3]['questionnaireId'].",".$model[4]['questionnaireId']." )  GROUP  BY personsId) X GROUP BY X.groupId),0) AS '上海',
								 IFNULL((SELECT SUM(X.size)  AS g_num  FROM (SELECT 1  AS size,groupId FROM cada_results_questionnaire   WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) 		AND status=1   AND  (areaId='4'  OR areaId='9') AND status=1   AND   groupId=".$group_id."  AND questionnaireId IN (".$model[0]['questionnaireId'].",".$model[1]['questionnaireId'].",".$model[2]['questionnaireId'].",".$model[3]['questionnaireId'].",".$model[4]['questionnaireId']." )  GROUP  BY personsId) X GROUP BY X.groupId),0) AS '广东',
								 IFNULL((SELECT SUM(X.size)  AS g_num  FROM (SELECT 1  AS size,groupId FROM cada_results_questionnaire   WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) 		AND status=1   AND  (areaId='5'  OR areaId='11') AND status=1   AND   groupId=".$group_id."  AND questionnaireId IN (".$model[0]['questionnaireId'].",".$model[1]['questionnaireId'].",".$model[2]['questionnaireId'].",".$model[3]['questionnaireId'].",".$model[4]['questionnaireId']." )  GROUP  BY personsId) X GROUP BY X.groupId),0) AS '陕西',
								 IFNULL((SELECT SUM(X.size)  AS g_num  FROM (SELECT 1  AS size,groupId FROM cada_results_questionnaire   WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) 		AND status=1   AND  (areaId='6') AND status=1   AND   groupId=".$group_id."  AND questionnaireId IN (".$model[0]['questionnaireId'].",".$model[1]['questionnaireId'].",".$model[2]['questionnaireId'].",".$model[3]['questionnaireId'].",".$model[4]['questionnaireId']." )  GROUP  BY personsId) X GROUP BY X.groupId),0) AS '四川',
								 IFNULL((SELECT SUM(X.size)  AS g_num  FROM (SELECT 1  AS size,groupId FROM cada_results_questionnaire   WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) 		AND status=1   AND  (areaId='7') AND status=1   AND   groupId=".$group_id."  AND questionnaireId IN (".$model[0]['questionnaireId'].",".$model[1]['questionnaireId'].",".$model[2]['questionnaireId'].",".$model[3]['questionnaireId'].",".$model[4]['questionnaireId']." )  GROUP  BY personsId) X GROUP BY X.groupId),0) AS '南京',
								 IFNULL((SELECT SUM(X.size)  AS g_num  FROM (SELECT 1  AS size,groupId FROM cada_results_questionnaire   WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) 		AND status=1   AND  (areaId='8') AND status=1   AND   groupId=".$group_id."  AND questionnaireId IN (".$model[0]['questionnaireId'].",".$model[1]['questionnaireId'].",".$model[2]['questionnaireId'].",".$model[3]['questionnaireId'].",".$model[4]['questionnaireId']." )  GROUP  BY personsId) X GROUP BY X.groupId),0) AS '河北',
								 IFNULL((SELECT SUM(X.size)  AS g_num  FROM (SELECT 1  AS size,groupId FROM cada_results_questionnaire   WHERE  YEAR(operationTime)=YEAR(CURDATE()) AND MONTH(operationTime)=MONTH(CURDATE()) 		AND status=1   AND  (areaId='13') AND status=1   AND   groupId=".$group_id."  AND questionnaireId IN (".$model[0]['questionnaireId'].",".$model[1]['questionnaireId'].",".$model[2]['questionnaireId'].",".$model[3]['questionnaireId'].",".$model[4]['questionnaireId']." )  GROUP  BY personsId) X GROUP BY X.groupId),0) AS '甘肃' ";
		return $this->db->query($sql)->result_array();
	}



	
}