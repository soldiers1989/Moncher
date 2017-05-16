<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-04-17
**描述：集团监控MODEL类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class MonitorModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::MonitorModel::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**
	 ***********************************************************
	 *方法::MonitorModel::getMonitorList
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束 
	 *parm4:in--    String :: order :: 排序字段
	 *parm5:in--    String :: desc   ::正序 OR 倒序
	 *parm6:in--    String :: desc   ::商户id
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function getMonitorList($type=1,$groupid,$modelid,$brandid,$areaid,$providerid){
		$model=$this->getModels($modelid);
		$where=' ';
	    $brandid!=0     && $where.=' AND C.brandId='.$brandid;
		$areaId!=0       &&  $where.=' AND C.areaId='.$areaid;
		$providerid!=0 && $where.=' AND C.merchantId='.$providerid;
		$query=$this->db->query('SELECT  X.merchantId,Y.name,
																   X.S1,X.S2,X.S3,X.S4,X.S5,X.S6,X.S7,
															       Y.F3,Y.F4,Y.F5,Y.F6,Y.F7,Y.F8,Y.F9,Y.F10,Y.F11,Y.F12,Y.F1
												FROM (SELECT       C.merchantId,
																			IFNULL(ROUND(SUM(CASE WHEN (F.code="S101") THEN 1 ELSE 0 END) / 
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
															WHERE 	A.status=B.status=C.status AND A.status="1"            AND
																			YEAR(C.operationTime)=YEAR(CURDATE())				 AND
																			A.id='.$modelid.' AND C.groupId='.$groupid.' 		 AND 
																			F.code IN("S101","S102","S103","S201","S202","S301","S302") '.$where.'
															GROUP BY C.merchantId
															) AS X LEFT JOIN
													  (SELECT  C.merchantId,
																			 D.name,
																			 IFNULL(ROUND(SUM(C.A1)/SUM(C.A2)*100,2),0) 	 AS F1,
																			 IFNULL(SUM(C.A2),0)                        	 AS F2,
																			 IFNULL(SUM(C.A4),0)                        	 AS F3,
																			 IFNULL(SUM(C.A5),0)                        	 AS F4,
																			 IFNULL(SUM(C.A6),0)                        	 AS F5,
																			 IFNULL(SUM(C.A7),0)                        	 AS F6,
																			 IFNULL(SUM(C.A8),0)                        	 AS F7,
																			 IFNULL(ROUND(SUM(C.A9)/SUM(C.A4)*100,2),0) 	 AS F8,
																			 IFNULL(ROUND(SUM(C.A10)/SUM(C.A5)*100,2),0)   AS F9,
																			 IFNULL(ROUND(SUM(C.A11)/SUM(C.A6)*100,2),0)   AS F10,
																			 IFNULL(ROUND(SUM(C.A12)/SUM(C.A7)*100,2),0)   AS F11,
																			 IFNULL(ROUND(SUM(C.A13)/SUM(C.A8)*100,2),0)   AS F12
																FROM (SELECT id,
																						 merchantId,
																						 CASE  WHEN id>0 		  					THEN (alreadyWeight/primitive)   ELSE 0 END AS A1,
																						 CASE  WHEN id>0 		  				    THEN 1                          			 ELSE 0 END AS A2,
																						 CASE  WHEN questionnaireId='.$model[0]['id'].' 	    THEN 1 ELSE 0 END AS A4,
																						 CASE  WHEN questionnaireId='.$model[1]['id'].'  	THEN 1 ELSE 0 END AS A5,
																						 CASE  WHEN questionnaireId='.$model[2]['id'].'   	THEN 1 ELSE 0 END AS A6,
																						 CASE  WHEN questionnaireId='.$model[3]['id'].'    	THEN 1 ELSE 0 END AS A7,
																						 CASE  WHEN questionnaireId='.$model[4]['id'].'   	THEN 1 ELSE 0 END AS A8,
																						 CASE  WHEN questionnaireId='.$model[0]['id'].'  	THEN (alreadyWeight/primitive) ELSE 0 END AS A9,
																						 CASE  WHEN questionnaireId='.$model[1]['id'].'  	THEN (alreadyWeight/primitive) ELSE 0 END AS A10,
																						 CASE  WHEN questionnaireId='.$model[2]['id'].'   	THEN (alreadyWeight/primitive) ELSE 0 END AS A11,
																						 CASE  WHEN questionnaireId='.$model[3]['id'].'   	THEN (alreadyWeight/primitive) ELSE 0 END AS A12,
																						 CASE  WHEN questionnaireId='.$model[4]['id'].'    	THEN (alreadyWeight/primitive) ELSE 0 END AS A13
																			FROM   cada_results_questionnaire  
																			WHERE  status=1 			 																																         AND 
																						 questionnaireId IN ('.$model[0]['id'].','.$model[1]['id'].','.$model[2]['id'].','.$model[3]['id'].','.$model[4]['id'].')   	 AND 
																						 YEAR(operationTime)= YEAR(CURDATE()) 																				 	                 AND 
																						 groupId='.$groupid.'
																			ORDER  BY id DESC ) 					AS C
																			LEFT JOIN cada_merchant_info  AS D ON D.id=C.merchantId
																GROUP BY C.merchantId
																HAVING C.merchantId IS NOT NULL 
															) AS Y  ON Y.merchantId=X.merchantId');
		return $type==2?$query->num_rows():$query->result_array();
	}
	/**获取模型列表*/
	public function getModels($modelid){
	$query=$this->db->query("SELECT  B.questionnaireId AS id,
														 			B.title  
													 FROM   cada_model A LEFT JOIN cada_module B ON A.id=B.modelId  
													 WHERE  A.status=1 AND B.status=1 AND A.id=".$modelid."  ORDER BY B.sorting ASC ");
	return $query->result_array();
	}
	/**获取集团日月季度年数据分析*/
	public function getGroupScore($type='All',$groupid,$modelid,$rank,$areaid,$brandid){
		$model=$this->getModels($modelid);
		$keys=array();
	    /*时间条件数据*/
		$where=array("All"        =>" AND id<>0 ",
								 "Year"       =>" AND  YEAR(operationTime)= YEAR(CURDATE()) " ,
								 "Quar"      =>" AND  QUARTER(operationTime)=QUARTER(CURDATE()) AND YEAR(operationTime)= YEAR(CURDATE())  ",
								 "Month"   =>" AND  MONTH(operationTime)=MONTH(CURDATE()) AND YEAR(operationTime)= YEAR(CURDATE())  ",
								 "Day"        =>" AND  DAYOFYEAR(operationTime)=DAYOFYEAR(CURDATE()) AND YEAR(operationTime)= YEAR(CURDATE()) ");
		$sex='';
		$rank != 0      &&  $sex.=" 	AND rank=".$rank;
		$areaid !=0    &&  $sex.=" 	AND areaId=".$areaid;
		$brandid !=0  && $sex.= " 	AND brandId=".$brandid;
		$sql=" SELECT IFNULL(ROUND(SUM(C.A1)/SUM(C.A2)*100,2),0) AS F1,
				    			  IFNULL((SELECT SUM(X.size) FROM (SELECT  1  AS size,groupId  FROM cada_results_questionnaire WHERE  status=1 AND groupId=".$groupid."  AND questionnaireId IN (".$model[0]['id'].",".$model[1]['id'].",".$model[2]['id'].",".$model[3]['id'].",".$model[4]['id']."  )  ".$where[$type]."  ".$sex."  GROUP  BY personsId) X GROUP BY X.groupId),0)  AS F2,";
		/**各种CASE的集合修改前请打印SQL语句*/
		for($i=1;$i<=count($model);$i++){
			$sql.="		IFNULL((SELECT SUM(X.size) FROM (SELECT   1  AS size,groupId FROM cada_results_questionnaire WHERE  status=1 AND groupId=".$groupid."  AND questionnaireId=".$model[($i-1)]['id']."  ".$where[$type]."   ".$sex."   GROUP  BY personsId) X GROUP BY X.groupId ),0)  AS F".($i+2).",";
		}
		/**各种CASE的集合修改前请打印SQL语句*/
		for($i=1;$i<=count($model);$i++){
			$i==count($model)?$sql.="IFNULL(ROUND(SUM(C.A".($i+7).")/SUM(C.A".($i+2).")*100,2),0)  AS F".($i+7) :
											  $sql.="IFNULL(ROUND(SUM(C.A".($i+7).")/SUM(C.A".($i+2).")*100,2),0)  AS F".($i+7).",";
		}
		$sql.="	FROM ( SELECT  CASE  WHEN groupId=".$groupid."  THEN  (alreadyWeight/primitive)   ELSE 0 END AS A1, CASE  WHEN groupId=".$groupid."  THEN 1  ELSE 0 END AS A2," ;
		/**各种CASE的集合修改前请打印SQL语句*/
		for($i=0;$i<count($model);$i++){
			$sql.="CASE  WHEN groupId=".$groupid." AND questionnaireId=".$model[$i]['id']."   THEN 1 ELSE 0 END AS A".($i+3).",";
			$keys[]=$model[$i]['id'];
		}
		/**各种CASE的集合修改前请打印SQL语句*/
		for($i=0;$i<count($model);$i++){
			$sql.=" CASE  WHEN groupId=".$groupid." AND questionnaireId=".$model[$i]['id']."   THEN (alreadyWeight/primitive) ELSE 0 END AS A".($i+8).",";
		}
		$sql.="	CASE  WHEN id>0 THEN  1  ELSE 1 END AS A0	FROM   cada_results_questionnaire  ";
		$sql.="	WHERE  status=1   AND questionnaireId IN (".(implode(',',$keys)).")  AND  groupId=".$groupid;
		$sql.=$where[$type];
		$rank != 0 && $sql.=" 	AND rank=".$rank;
		$areaid !=0 && $sql.=" 	AND areaId=".$areaid;
		$brandid !=0 && $sql.= " 	AND brandId=".$brandid; 
		$sql.="	ORDER  BY id DESC ) AS C GROUP BY C.A0";
		$query=$this->db->query($sql);
		return  $query->result_array();
	}

	/**获取集团季度得分*/
	public function getQuarScore($groupid,$questionnaireId,$rank,$areaid,$brandid){
		$sql=" SELECT  ";
		$sex='';
		$rank != 0      &&  $sex.=" 	AND rank=".$rank;
		$areaid !=0    &&  $sex.=" 	AND areaId=".$areaid;
		$brandid !=0  && $sex.= " 	AND brandId=".$brandid;
		/**各种CASE的集合修改前请打印SQL语句*/
	    for($i=1;$i<=4;$i++){
			$sql.="		IFNULL((SELECT SUM(X.size) FROM (SELECT  1  AS size,groupId  FROM cada_results_questionnaire WHERE  status=1 AND groupId=".$groupid."  AND questionnaireId=".$questionnaireId."  AND YEAR(operationTime)= YEAR(CURDATE()) AND QUARTER(operationTime)=".$i."  ".$sex."  GROUP  BY personsId) X GROUP BY X.groupId ),0)  AS F".$i.",";
		}
		/**各种CASE的集合修改前请打印SQL语句*/
		for($i=1;$i<=4;$i++){
			$i==4?$sql.="IFNULL(ROUND(SUM(C.A".($i+4).")/SUM(C.A".$i.")*100,2),0)  AS F".($i+4)	:
			$sql.="IFNULL(ROUND(SUM(C.A".($i+4).")/SUM(C.A".$i.")*100,2),0)   AS F".($i+4).",";
		}
		/**各种CASE的集合修改前请打印SQL语句*/
		$sql.="	FROM ( SELECT  " ;
		for($i=1;$i<=4;$i++){
			$sql.="CASE  WHEN groupId=".$groupid." AND QUARTER(operationTime)=".$i."  THEN 1 ELSE 0 END AS A".$i.",";
		}
		/**各种CASE的集合修改前请打印SQL语句*/
		for($i=1;$i<=4;$i++){
			$sql.="CASE  WHEN groupId=".$groupid." AND QUARTER(operationTime)=".$i."  THEN (alreadyWeight/primitive) ELSE 0 END AS A".($i+4).",";
		}
		$sql.="	CASE  WHEN id>0 THEN  1  ELSE 1 END AS A0	FROM   cada_results_questionnaire  ";
		$sql.="  	WHERE status=1 AND YEAR(operationTime)= YEAR(CURDATE())   AND questionnaireId=".$questionnaireId."  AND groupId=".$groupid;
		$rank != 0 && $sql.=" 	AND rank=".$rank;
		$areaid !=0 && $sql.=" 	AND areaId=".$areaid;
		$brandid !=0 && $sql.= " 	AND brandId=".$brandid;
		$sql.="  ORDER  BY id DESC )  AS C  GROUP BY C.A0" ;
		$query=$this->db->query($sql);
		return  $query->result_array();
	}
	/**获取集团年度得分*/
	public function getYearScore($groupid,$questionnaireId,$rank,$areaid,$brandid){
		$sex='';
		$rank != 0      &&  $sex.=" 	AND rank=".$rank;
		$areaid !=0    &&  $sex.=" 	AND areaId=".$areaid;
		$brandid !=0  && $sex.= " 	AND brandId=".$brandid;
		$sql=" SELECT  ";
		/**各种CASE的集合修改前请打印SQL语句*/
		for($i=1;$i<=12;$i++){
			$sql.="		IFNULL((SELECT SUM(X.size) FROM (SELECT  1  AS size,groupId  FROM cada_results_questionnaire WHERE  status=1 AND groupId=".$groupid."  AND questionnaireId=".$questionnaireId."  AND YEAR(operationTime)= YEAR(CURDATE()) AND MONTH(operationTime)=".$i."  ".$sex."  GROUP  BY personsId) X GROUP BY X.groupId),0)  AS F".$i.",";
		}
		/**各种CASE的集合修改前请打印SQL语句*/
		for($i=1;$i<=12;$i++){
			$i==12?$sql.="IFNULL(ROUND(SUM(C.A".($i+12).")/SUM(C.A".$i.")*100,2),0)  AS F".($i+12)	:
			$sql.="IFNULL(ROUND(SUM(C.A".($i+12).")/SUM(C.A".$i.")*100,2),0)   AS F".($i+12).",";
		}
		/**各种CASE的集合修改前请打印SQL语句*/
		$sql.="	FROM ( SELECT  " ;
		for($i=1;$i<=12;$i++){
			$sql.="CASE  WHEN groupId=".$groupid." AND MONTH(operationTime)=".$i."  THEN 1 ELSE 0 END AS A".$i.",";
		}
		/**各种CASE的集合修改前请打印SQL语句*/
		for($i=1;$i<=12;$i++){
			$sql.="CASE  WHEN groupId=".$groupid." AND MONTH(operationTime)=".$i."  THEN (alreadyWeight/primitive) ELSE 0 END AS A".($i+12).",";
		}
		$sql.="	CASE  WHEN id>0 THEN  1  ELSE 1 END AS A0	FROM   cada_results_questionnaire  ";
		$sql.="  WHERE status=1 AND YEAR(operationTime)= YEAR(CURDATE())   AND questionnaireId=".$questionnaireId."  AND groupId=".$groupid;
		$rank != 0 && $sql.=" 	AND rank=".$rank;
		$areaid !=0 && $sql.=" 	AND areaId=".$areaid;
		$brandid !=0 && $sql.= " 	AND brandId=".$brandid;
		$sql.="  ORDER  BY id DESC )  AS C  GROUP BY C.A0" ;
		$query=$this->db->query($sql);
		return  $query->result_array();
	}
	/**获取集团月份得分*/
	public function getMonthScore($groupid,$questionnaireId,$time,$rank,$areaid,$brandid){
		$mon=date('t',$time);
		$sex='';
		$rank != 0      &&  $sex.=" 	AND rank=".$rank;
		$areaid !=0    &&  $sex.=" 	AND areaId=".$areaid;
		$brandid !=0  && $sex.= " 	AND brandId=".$brandid;
		$sql="SELECT ";
		/**各种CASE的集合修改前请打印SQL语句*/
	    for($i=1;$i<=$mon;$i++){
			$sql.="		IFNULL((SELECT SUM(X.size) FROM (SELECT  1  AS size,groupId  FROM cada_results_questionnaire WHERE  status=1 AND groupId=".$groupid."  AND questionnaireId=".$questionnaireId."  AND YEAR(operationTime)= YEAR('".$time."')  AND  MONTH(operationTime)=MONTH('".$time."')   AND   DAYOFMONTH(operationTime)=".$i."  ".$sex." GROUP  BY personsId) X GROUP BY X.groupId ),0)  AS F".$i.",";
		}
		/**各种CASE的集合修改前请打印SQL语句*/
		for($i=1;$i<=$mon;$i++){
			$i ==$mon ? $sql.="	IFNULL(ROUND(SUM(C.A".($i+$mon).")/SUM(C.A".$i.")*100,2),0) 	  		AS F".($i+$mon) :
			$sql.="	IFNULL(ROUND(SUM(C.A".($i+$mon).")/SUM(C.A".$i.")*100,2),0) 	  		AS F".($i+$mon).",";
		}
		/**各种CASE的集合修改前请打印SQL语句*/
		$sql.="	FROM ( SELECT  " ;
		for($i=1;$i<=$mon;$i++){
			$sql.="CASE  WHEN groupId=".$groupid." AND DAYOFMONTH(operationTime)=".$i."   THEN 1 ELSE 0 END AS A".$i.",";
		}
		/**各种CASE的集合修改前请打印SQL语句*/
		for($i=1;$i<=$mon;$i++){
			$sql.="CASE  WHEN groupId=".$groupid." AND DAYOFMONTH(operationTime)=".$i."   THEN (alreadyWeight/primitive) ELSE 0 END AS A".($i+$mon).",";
		}
		$sql.="    CASE  WHEN id>0 THEN  1  ELSE 1 END AS A0	FROM   cada_results_questionnaire  ";
		$sql.="    WHERE status=1 AND YEAR(operationTime)= YEAR('".$time."') AND MONTH(operationTime)=MONTH('".$time."') AND questionnaireId=".$questionnaireId." AND groupId=".$groupid;
		$rank != 0 && $sql.=" 	AND rank=".$rank;
		$areaid !=0 && $sql.=" 	AND areaId=".$areaid;
		$brandid !=0 && $sql.= " 	AND brandId=".$brandid;
		$sql.=" 	ORDER  BY id DESC ) AS C GROUP BY C.A0" ;
		$query=$this->db->query($sql);
		return  $query->result_array();
	}
}