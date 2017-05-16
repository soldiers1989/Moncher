<?php
/*****************************************************
**作者：张文晓
**创始时间：2017-03-03
**描述：集团数据监控
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/system/core/Model.php");
class ConceptualModel extends CI_Model {

	/**
	 ***********************************************************
	 *方法::CertificationModel::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.03.03   Add by wjr
	 ************************************************************
	 */

	function __construct(){
	    parent::__construct();
	    $this->load->database();
	    
	}
	// 集团总样本量
	public function getSizeData($pro_id){
		
		$query=$this->db->query("SELECT COUNT(1)   AS B
			                       FROM cada_results_questionnaire  
			                      WHERE groupId=".$pro_id);
		
		return $query->result_array();

	}
	//集团总得分
	public function getAllSizeData($fid){
		$query="SELECT A.groupId,ROUND(SUM(A.alreadyWeight/B.weight)*100/COUNT(1),2) AS score
		             FROM cada_results_questionnaire                                 AS A        LEFT JOIN 
		                  cada_questionnaire                                         AS B ON B.id=A.questionnaireId
		             WHERE groupId=".$fid."
		             GROUP BY groupId";
		 return $this->db->query($query)->result_array();
		                 
	}
	// 各模块平均分
	public function getMeanData($pid){
		$query="SELECT A.groupId,B.name                                                                    AS name,
		                        ROUND(SUM((A.alreadyWeight/B.weight)*100)/COUNT(1),2)                      AS score
					  FROM      cada_results_questionnaire                                                 AS A 
					            LEFT JOIN cada_questionnaire                                               AS B 
					            ON B.id=A.questionnaireId
					  WHERE groupId=".$pid."
					  GROUP BY A.questionnaireId";
		 return $this->db->query($query)->result_array();
	}
	// 各模块数量
	public function getCountData($sid){
		$query="SELECT A.groupId,B.name,COUNT(1)        AS size 
		          FROM cada_results_questionnaire       AS A
		          	   LEFT JOIN cada_questionnaire     AS B ON B.id=A.questionnaireId
		          WHERE  groupId=".$sid."
		          GROUP BY A.questionnaireId";
		 return $this->db->query($query)->result_array();
	}
	//本日总样本量
	public function getDayData($did){
		$query="SELECT   A.groupId,
			             B.name                                 AS N,
			             DAYOFYEAR(A.operationTime) 		    AS day,
		 	             COUNT(1) 								AS size
                  FROM   cada_results_questionnaire   	        AS A
			             LEFT JOIN cada_questionnaire           AS B ON B.id=A.questionnaireId	 
                  WHERE  groupId=".$did."					    AND
			             DAYOFYEAR(A.operationTime)=DAYOFYEAR(CURDATE())";
			 return $this->db->query($query)->result_array();
	}
	//本日总平均分
	public function getDaysData($rid){
		$query="SELECT   A.groupId,
			             B.name                                                 AS N,									
			             DAYOFYEAR(A.operationTime) 			                AS QUAR,
			             ROUND(SUM((A.alreadyWeight/B.weight)* 100)/COUNT(1),2) AS score
                  FROM   cada_results_questionnaire   	                        AS A
			             LEFT JOIN cada_questionnaire                           AS B ON B.id=A.questionnaireId	 
                  WHERE  groupId=".$rid."									    AND
			             DAYOFYEAR(A.operationTime)=DAYOFYEAR(CURDATE())
             	         GROUP  BY DAYOFYEAR(A.operationTime)";
             	  return $this->db->query($query)->result_array();
	}
	//本日样本数量
	public function getDayyData($y_id){
		$query="SELECT     A.groupId,
	 		               B.name,
	 		               DAYOFYEAR(A.operationTime) 			       AS QUAR,
	 		               COUNT(1) 							       AS size
                    FROM   cada_results_questionnaire   	           AS A
	 		               LEFT JOIN cada_questionnaire                AS B ON B.id=A.questionnaireId	 
                    WHERE  groupId=".$y_id."			               AND
	 		               DAYOFYEAR(A.operationTime)=DAYOFYEAR(CURDATE())
                           GROUP  BY A.questionnaireId";
                    return $this->db->query($query)->result_array();
	}
	//本日各模块测评得分
	public function getDayfData($d_id){
		$query="SELECT  A.groupId,     
                        B.name                                                               AS name,
                        DAYOFYEAR(A.operationTime) 			                                 AS QUAR,
		                ROUND(SUM((A.alreadyWeight/B.weight)*100)/COUNT(1),2)                AS score
			      FROM  cada_results_questionnaire                                           AS A 
					    LEFT JOIN cada_questionnaire                                         AS B 
					    ON B.id=A.questionnaireId
					  WHERE groupId=".$d_id."                                                AND
							DAYOFYEAR(A.operationTime)=DAYOFYEAR(CURDATE())
					  GROUP BY A.questionnaireId";
					  return $this->db->query($query)->result_array();
	}
	//年份总样本量
	public function getYeardata($nid){
		$query="SELECT A.groupId,
			           B.name,
			           YEAR(A.operationTime) 			                    AS QUAR,
			           COUNT(1) 											AS size
                   FROM   cada_results_questionnaire   	                    AS A
			              LEFT JOIN cada_questionnaire                      AS B ON B.id=A.questionnaireId	 
                   WHERE  groupId=".$nid."									AND
			           YEAR(A.operationTime)=YEAR(CURDATE())
                       GROUP  BY YEAR(A.operationTime);";
                   return $this->db->query($query)->result_array();

	}
	//月份总数量
	public function getMonthData($msid){
		$query="SELECT   A.groupId,
			             B.name                                 AS N,
			             MONTH(A.operationTime) 		        AS day,
		 	             COUNT(1) 								AS size
                  FROM   cada_results_questionnaire   	        AS A
			             LEFT JOIN cada_questionnaire           AS B ON B.id=A.questionnaireId	 
                  WHERE  groupId=".$msid."				    AND
			             MONTH(A.operationTime)=MONTH(CURDATE())";
			      return $this->db->query($query)->result_array();
	}
	//月份总得分
	public function getMonthaData($yfid){
		$query="SELECT   A.groupId,
			             B.name                                                 AS N,									
			             MONTH(A.operationTime) 			                    AS QUAR,
			             ROUND(SUM((A.alreadyWeight/B.weight)* 100)/COUNT(1),2) AS score
                  FROM   cada_results_questionnaire   	                        AS A
			             LEFT JOIN cada_questionnaire                           AS B ON B.id=A.questionnaireId	 
                  WHERE  groupId=".$yfid."									    AND
			             MONTH(A.operationTime)=MONTH(CURDATE())
             	         GROUP  BY MONTH(A.operationTime)";
             	 return $this->db->query($query)->result_array();
	}
	// 月份各模块数量
	public function getMonthsData($m_id){
		$query="SELECT   A.groupId,
	 		             B.name,
	 		             MONTH(A.operationTime) 			       AS MONTH,
	 		             COUNT(1) 							       AS size
                   FROM  cada_results_questionnaire   	           AS A
	 		             LEFT JOIN cada_questionnaire              AS B ON B.id=A.questionnaireId	 
                   WHERE groupId=".$m_id."			               AND
	 		             MONTH(A.operationTime)=MONTH(CURDATE())
                   GROUP  BY A.questionnaireId";
                   return $this->db->query($query)->result_array();
	}
	//月份各模块得分
	public function getMonthbData($b_id){
		$query="SELECT  A.groupId,     
                        B.name                                                               AS name,
                        MONTH(A.operationTime) 			                                     AS QUAR,
		                ROUND(SUM((A.alreadyWeight/B.weight)*100)/COUNT(1),2)                AS score
			       FROM cada_results_questionnaire                                           AS A 
					            LEFT JOIN cada_questionnaire                                 AS B 
					            ON B.id=A.questionnaireId
				   WHERE groupId=".$b_id."                                                   AND
						 MONTH(A.operationTime)=MONTH(CURDATE())
				   GROUP BY A.questionnaireId";
				   return $this->db->query($query)->result_array();
	}
	//当月每一天的测评得分
	// public function getMonthdayData($mdid){
	// 	$query="SELECT   A.groupId,     
 //                         B.name                                                    AS name,
 //                         DAYOFMONTH(A.operationTime) 			                   AS day,
	// 	                 ROUND(SUM((A.alreadyWeight/B.weight)*100)/COUNT(1),2)     AS score
	// 		       FROM  cada_results_questionnaire                                AS A 
	// 				     LEFT JOIN cada_questionnaire                              AS B 
	// 				     ON B.id=A.questionnaireId
	// 			   WHERE groupId=".$mdid."                                         AND
	// 				     MONTH(A.operationTime)=MONTH(CURDATE())
	// 			   GROUP BY A.questionnaireId";
	// 			   return $this->db->query($query)->result_array();
	// }
	// //条形统计图数据
	// public function getLeafData($lid,$time){
	// 	$query="SELECT     CASE questionnaireId
	// 					   WHEN 11 THEN '服务顾问'
	// 					   WHEN 10 THEN '服务设施'
	// 					   WHEN 9 THEN '维修质量'
	// 					   WHEN 7 THEN '维修价格'
	// 					   WHEN 8 THEN '维修时间'
	// 					   END  																	  AS  name,
	// 					   MONTH(A.operationTime)									                  AS month,
	// 					   CASE WHEN  ROUND(SUM((A.alreadyWeight/B.weight)* 100)/COUNT(1),0)>0   
	// 					   THEN   ROUND(SUM((A.alreadyWeight/B.weight)* 100)/COUNT(1),0) ELSE 0 END   AS score
	// 			    FROM   cada_results_questionnaire   	                                          AS A
	// 					   LEFT JOIN cada_questionnaire                                               AS B ON B.id=A.questionnaireId   
	// 					   LEFT JOIN cada_car_info                                                    AS C ON C.id=A.brandId
	// 		        WHERE  A.status<>2  AND B.status<>2  AND B.id IN(7,8,9,10,11)  AND C.rank=1
	// 				         AND  YEAR(A.operationTime)=YEAR(CURDATE()) 
	// 						 AND   A.groupId=".$lid." 
	// 	            GROUP  BY  A.questionnaireId ";
	// 	            return $this->db->query($query)->result_array();
	// }

	//集团各月份得分
	// public function getMonthData($mfid){
	// 	$query="SELECT A.groupId,
	// 		           B.name,
	// 		           MONTH(A.operationTime) 				       AS MON,
	// 		           COUNT(1) 								   AS size
 //                  FROM     cada_results_questionnaire   	       AS A
	// 		      LEFT JOIN cada_questionnaire                     AS B ON B.id=A.questionnaireId	 
 //                  WHERE  groupId=".$mfid."						   AND
	// 		             YEAR(A.operationTime)=YEAR(CURDATE())
 //                         GROUP  BY MONTH(A.operationTime)"
	// 	 return $this->db->query($query)->result_array();
	// }
	// 当前季度总样本数量
	public function getQuarterData($jyid){
		$quarter="SELECT A.groupId,
			             B.name,
			             QUARTER(A.operationTime) 			AS QUAR,
			             COUNT(1) 							AS size
                    FROM   cada_results_questionnaire   	AS A
			        LEFT JOIN cada_questionnaire            AS B ON B.id=A.questionnaireId	 
                    WHERE  groupId=".$jyid."			    AND
			        YEAR(A.operationTime)=YEAR(CURDATE())
                    GROUP  BY QUARTER(A.operationTime)";
		 return $this->db->query($quarter)->result_array();
	}
	//当前季度总测评得分
	public function getQuarterfData($qyid){
		$query="SELECT   A.groupId,
			             B.name                                                 AS N,									
			             QUARTER(A.operationTime) 			                    AS QUAR,
			             ROUND(SUM((A.alreadyWeight/B.weight)* 100)/COUNT(1),2) AS score
                  FROM   cada_results_questionnaire   	                        AS A
			             LEFT JOIN cada_questionnaire                           AS B ON B.id=A.questionnaireId	 
                  WHERE  groupId=".$qyid."									            AND
			             QUARTER(A.operationTime)=QUARTER(CURDATE())
             	         GROUP  BY QUARTER(A.operationTime)";
             	         return $this->db->query($query)->result_array();
	}
	//当前季度各模块样本数量
	public function getQuartersData($qsid){
		$query="SELECT     A.groupId,								  
	 		               B.name									   AS name,
	 		               QUARTER(A.operationTime) 			       AS QUAR,
	 		               COUNT(1) 							       AS size
                    FROM   cada_results_questionnaire   	           AS A
	 		               LEFT JOIN cada_questionnaire                AS B ON B.id=A.questionnaireId	 
                    WHERE  groupId=".$qsid."			               AND
	 		               QUARTER(A.operationTime)=QUARTER(CURDATE())
                           GROUP  BY A.questionnaireId";
                    return $this->db->query($query)->result_array();
	}
	//当前季度各模块测评得分
	public function getQuartaData($a_id){
		$query="SELECT   A.groupId,     
                         B.name                                                               AS name,
                         QUARTER(A.operationTime) 			                                  AS QUAR,
		                 ROUND(SUM((A.alreadyWeight/B.weight)*100)/COUNT(1),2)                AS score
			       FROM  cada_results_questionnaire                                           AS A 
					     LEFT JOIN cada_questionnaire                                         AS B 
					     ON B.id=A.questionnaireId
				   WHERE groupId=".$a_id."                                                    AND
				         QUARTER(A.operationTime)=QUARTER(CURDATE())
				         GROUP BY A.questionnaireId";
				   return $this->db->query($query)->result_array();
	}
	//本年度总样本量
	public function getYearaData($yid){
		$query="SELECT A.groupId,
			             B.name,
			             YEAR(A.operationTime) 			AS QUAR,
			             COUNT(1) 							AS size
                    FROM   cada_results_questionnaire   	AS A
			        LEFT JOIN cada_questionnaire            AS B ON B.id=A.questionnaireId	 
                    WHERE  groupId=".$yid."			    AND
			        YEAR(A.operationTime)=YEAR(CURDATE())
                    GROUP  BY YEAR(A.operationTime)";
                    return $this->db->query($query)->result_array();
	}
	//本年度下各模块测评得分
	public function getYearsData($ysid){
		$query="SELECT   A.groupId,     
                         B.name                                                                AS name,
                         YEAR(A.operationTime) 			                                       AS QUAR,
		                 ROUND(SUM((A.alreadyWeight/B.weight)*100)/COUNT(1),2)                 AS score
	               FROM  cada_results_questionnaire                                            AS A 
				         LEFT JOIN cada_questionnaire                                          AS B 
				         ON B.id=A.questionnaireId
	               WHERE groupId=".$ysid."                                                     AND
				         YEAR(A.operationTime)=YEAR(CURDATE())
				   GROUP BY A.questionnaireId";
				   return $this->db->query($query)->result_array();
	}
	//本年度各模块样本数量
	public function getYearcData($cid){
		$query="SELECT     A.groupId,								  
	 		               B.name									   AS name,
	 		               YEAR(A.operationTime) 			           AS QUAR,
	 		               COUNT(1) 							       AS size
                    FROM   cada_results_questionnaire   	           AS A
	 		               LEFT JOIN cada_questionnaire                AS B ON B.id=A.questionnaireId	 
                    WHERE  groupId=".$cid."			                       AND
	 		               YEAR(A.operationTime)=YEAR(CURDATE())
                           GROUP  BY A.questionnaireId";
                    return $this->db->query($query)->result_array();
	}
}