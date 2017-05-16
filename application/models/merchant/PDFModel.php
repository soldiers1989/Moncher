<?php
	/*****************************************************
	**作者：张文晓
	**创始时间：2017-04-12
	**描述：门店报告下载Model类
	*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/system/core/Model.php");
class PDFModel extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->load->database();
		}
  /**获取满足条件的月份PDF*/
	public function  findList($providerid,$modelid,$size,$startDate,$endDate){
		$model=$this->getModels($modelid);
		$query=$this->db->query("SELECT  SUM(X.A1)+SUM(X.A2)+SUM(X.A3)+SUM(X.A4)+SUM(X.A5) AS PDF,
																		X.yeari,
																		CASE WHEN LENGTH(X.monthxii)=2 THEN X.monthxii ELSE CONCAT('0',X.monthxii) END AS monthxii
															FROM   (SELECT CASE WHEN E.questionnaireId=".$model[0]['id']." 	THEN 1 ELSE 0 END AS A1,
																						 CASE WHEN E.questionnaireId=".$model[1]['id']." 	THEN 1 ELSE 0 END AS A2,
																						 CASE WHEN E.questionnaireId=".$model[2]['id']."  THEN 1 ELSE 0 END AS A3,
																						 CASE WHEN E.questionnaireId=".$model[3]['id']."  THEN 1 ELSE 0 END AS A4,
																						 CASE WHEN E.questionnaireId=".$model[4]['id']."  THEN 1 ELSE 0 END AS A5,
																						 E.yeari,
																						 E.monthxii
																			FROM (SELECT D.merchantId,
																									   D.questionnaireId,
																									   COUNT(1) AS size,
																									   MONTH(D.operationTime) AS monthxii,
																									  YEAR(D.operationTime) AS  yeari
																						FROM   cada_results_questionnaire  AS  D
																						WHERE  D.merchantId=".$providerid." AND D.status=1	AND  
																									   D.questionnaireId IN (".$model[0]['id'].",".$model[1]['id'].",".$model[2]['id'].",".$model[3]['id'].",".$model[4]['id']." )	 AND 
																									   (DATE_FORMAT(D.operationTime,'%Y-%m')>='".$startDate."' AND DATE_FORMAT(D.operationTime,'%Y-%m')<='".$endDate."')				 							
																						GROUP  BY D.questionnaireId,monthxii,yeari
																						HAVING size>=".$size."
																						ORDER BY yeari DESC,monthxii DESC ) AS E) AS X
															GROUP BY X.yeari,X.monthxii
															HAVING PDF=5
															ORDER BY X.yeari DESC,X.monthxii DESC ");
		return $query->result_array();
	}
	/**获取车主总数量*/
	public function getPerson($providerid,$y,$m){
		$query=$this->db->query("SELECT   SUM(C.A34)					    			AS size,
																		 SUM(C.A1)/SUM(C.A34)	  	    	AS '男',
																		 SUM(C.A2)/SUM(C.A34)				AS '女',
																		 SUM(C.A3)/SUM(C.A34)				AS '60+岁',
																		 SUM(C.A4)/SUM(C.A34)				AS '50-59岁',
																		 SUM(C.A5)/SUM(C.A34)				AS '40-49岁',
																		 SUM(C.A6)/SUM(C.A34)				AS '30-39岁',
																		 SUM(C.A7)/SUM(C.A34)				AS '18-29岁',
																		 SUM(C.A8)/SUM(C.A34)			    AS '硕士及以上',
																		 SUM(C.A9)/SUM(C.A34)			    AS '本科',
																		 SUM(C.A10)/SUM(C.A34)			AS '大专',
																		 SUM(C.A11)/SUM(C.A34)			AS '高中',
																		 SUM(C.A12)/SUM(C.A34)			AS '初中及以下',
																		 SUM(C.A13)/SUM(C.A34)			AS '>=30万',
																		 SUM(C.A14)/SUM(C.A34)			AS '20-30万',
																		 SUM(C.A15)/SUM(C.A34)			AS '10-20万',
																		 SUM(C.A16)/SUM(C.A34)			AS '5-10万',
																		 SUM(C.A17)/SUM(C.A34)			AS '<=5万',
																		 SUM(C.A18)/SUM(C.A34)			AS '高层管理人员',
																		 SUM(C.A19)/SUM(C.A34)			AS '中层管理人员',
																		 SUM(C.A20)/SUM(C.A34)			AS '普通职员',
																		 SUM(C.A21)/SUM(C.A34)			AS '教育界人员',
																		 SUM(C.A22)/SUM(C.A34)			AS '律师、会计师...',
																		 SUM(C.A23)/SUM(C.A34)			AS '私营公司老板',
																		 SUM(C.A24)/SUM(C.A34)			AS '科技、体育...',
																		 SUM(C.A25)/SUM(C.A34)			AS '个体工商业者',
																		 SUM(C.A26)/SUM(C.A34)			AS '自由职业者',
																		 SUM(C.A27)/SUM(C.A34)			AS '其他',
																		SUM(C.A28)/SUM(C.A34)			AS '无业',
																		 SUM(C.A29)/SUM(C.A34)			AS '拒绝回答',
																		 SUM(C.A30)/SUM(C.A34)			AS '5年以上',
																		 SUM(C.A31)/SUM(C.A34)			AS '3-5年',
																		 SUM(C.A32)/SUM(C.A34)			AS '1-3年',
																		 SUM(C.A33)/SUM(C.A34)			AS '1年以内'
														FROM     (SELECT    		CASE  WHEN A.sex=1 																					   THEN 1 ELSE 0 END AS A1,
																								CASE  WHEN A.sex=2 																				       THEN 1 ELSE 0 END AS A2 ,
																								CASE  WHEN A.age='60岁及以上' 															   THEN 1 ELSE 0 END AS A3,
																								CASE  WHEN A.age='50-59岁' 																	   THEN 1 ELSE 0 END AS A4,
																								CASE  WHEN A.age='40-49岁' 																	   THEN 1 ELSE 0 END AS A5,
																								CASE  WHEN A.age='30-39岁' 																	   THEN 1 ELSE 0 END AS A6,
																								CASE  WHEN A.age='18-29岁' 																	   THEN 1 ELSE 0 END AS A7,
																								CASE  WHEN A.qualifications='硕士及以上' 														THEN 1 ELSE 0 END AS A8,
																								CASE  WHEN A.qualifications='本科' 																	THEN 1 ELSE 0 END AS A9,
																								CASE  WHEN A.qualifications='大专' 																	THEN 1 ELSE 0 END AS A10,
																								CASE  WHEN A.qualifications='高中(含高职，技校等)' 										THEN 1 ELSE 0 END AS A11,
																								CASE  WHEN A.qualifications='初中及以下' 												  		THEN 1 ELSE 0 END AS A12,
																								CASE  WHEN A.income='30万元以上'    														THEN 1 ELSE 0 END AS A13,
																								CASE  WHEN A.income='20-30万元之间'   													THEN 1 ELSE 0 END AS A14, 
																								CASE  WHEN A.income='10-20万元之间'    													THEN 1 ELSE 0 END AS A15,
																								CASE  WHEN A.income='5-10万元之间'    													THEN 1 ELSE 0 END AS A16,
																								CASE  WHEN A.income='5万元以下'    															THEN 1 ELSE 0 END AS A17,
																								CASE  WHEN A.occupation='高层管理人员（含单位、公司高层领导）' 			THEN 1 ELSE 0 END AS A18,
																								CASE  WHEN A.occupation='中层管理人员（含单位、公司环节干部）' 			THEN 1 ELSE 0 END AS A19,
																								CASE  WHEN A.occupation='普通职员' 															THEN 1 ELSE 0 END AS A20,
																								CASE  WHEN A.occupation='教育界人员' 														THEN 1 ELSE 0 END AS A21,
																								CASE  WHEN A.occupation='律师、会计师、文艺工作者' 								THEN 1 ELSE 0 END AS A22,
																								CASE  WHEN A.occupation='私营公司老板' 													THEN 1 ELSE 0 END AS A23,
																								CASE  WHEN A.occupation='科技、体育、卫生行业普通人员' 						THEN 1 ELSE 0 END AS A24,
																								CASE  WHEN A.occupation='个体工商业者' 													THEN 1 ELSE 0 END AS A25,
																								CASE  WHEN A.occupation='自由职业者' 														THEN 1 ELSE 0 END AS A26,
																								CASE  WHEN A.occupation='其他' 																	THEN 1 ELSE 0 END AS A27,
																								CASE  WHEN A.occupation='无业' 																	THEN 1 ELSE 0 END AS A28,
																								CASE  WHEN A.occupation='拒绝回答' 															THEN 1 ELSE 0 END AS A29, 
																								CASE  WHEN A.carPeriod='5年以上' 																THEN 1 ELSE 0 END AS A30,
																								CASE  WHEN A.carPeriod='3-5年之间' 															THEN 1 ELSE 0 END AS A31,
																								CASE  WHEN A.carPeriod='1-3年之间' 															THEN 1 ELSE 0 END AS A32,
																								CASE  WHEN A.carPeriod='1年以内' 																THEN 1 ELSE 0 END AS A33,
																								CASE  WHEN A.id>0           																			THEN 1 ELSE 0 END AS A34 
																			FROM      	cada_persons	    A
																			WHERE     	YEAR(A.createtime) =".$y."											 			AND
																							 	 MONTH(A.createtime)=".$m."		    								    AND
																							     A.merchantId=".$providerid.")											    AS  C
														GROUP BY  C.A34");
		return $query->result_array();
	}
	/**获取车主五大纬度答题数量*/
	public function getResult($modelid,$providerid,$y,$m){
		$model=$this->getModels($modelid);
		$query=$this->db->query("SELECT 		 IFNULL(SUM(C.A2),0)                        								AS  size,
																			 IFNULL(SUM(C.A4),0)                        								AS '服务顾问',
																	         IFNULL(SUM(C.A5),0)                        								AS '服务设施',
																	         IFNULL(SUM(C.A6),0)                        								AS '维修质量',
																			 IFNULL(SUM(C.A7),0)                        								AS '维修时间',
																			 IFNULL(SUM(C.A8),0)                        								AS '维修价格',
																			 IFNULL(ROUND(SUM(C.A1)/SUM(C.A2)*100,2),0) 		AS '总平均分',
																			 IFNULL(ROUND(SUM(C.A9)/SUM(C.A4)*100,2),0) 	    AS '服务顾问 ',
																			 IFNULL(ROUND(SUM(C.A10)/SUM(C.A5)*100,2),0)   AS '服务设施 ',
																			 IFNULL(ROUND(SUM(C.A11)/SUM(C.A6)*100,2),0)   AS '维修质量 ',
																			 IFNULL(ROUND(SUM(C.A12)/SUM(C.A7)*100,2),0)   AS '维修时间 ',
																			 IFNULL(ROUND(SUM(C.A13)/SUM(C.A8)*100,2),0)   AS '维修价格 '
														FROM (SELECT   id,
																				 CASE  WHEN merchantId=".$providerid." 		THEN  (alreadyWeight/primitive)  			    ELSE 0 END AS A1,
																				 CASE  WHEN merchantId=".$providerid." 		THEN  1                          			 	  				ELSE 0 END AS A2,
																				 CASE  WHEN id>0                                               THEN  1                                                          ELSE 0  END AS A3, 
																				 CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[0]['id']."  		THEN 1 ELSE 0 END AS A4,
																				 CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[1]['id']."  		THEN 1 ELSE 0 END AS A5,
																				 CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[2]['id']."   		THEN 1 ELSE 0 END AS A6,
																				 CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[3]['id']."    	    THEN 1 ELSE 0 END AS A7,
																				 CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[4]['id']."    	    THEN 1 ELSE 0 END AS A8,
																				 CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[0]['id']."  		THEN (alreadyWeight/primitive) ELSE 0 END AS A9,
																				 CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[1]['id']."  		THEN (alreadyWeight/primitive) ELSE 0 END AS A10,
																				 CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[2]['id']."    		THEN (alreadyWeight/primitive) ELSE 0 END AS A11,
																				 CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[3]['id']."    		THEN (alreadyWeight/primitive) ELSE 0 END AS A12,
																				 CASE  WHEN merchantId=".$providerid." AND questionnaireId=".$model[4]['id']."    		THEN (alreadyWeight/primitive) ELSE 0 END AS A13
																	FROM   cada_results_questionnaire
																	WHERE  status=1 			 																																											 AND
																				  questionnaireId IN (".$model[0]['id'].",".$model[1]['id'].",".$model[2]['id'].",".$model[3]['id'].",".$model[4]['id']." )   		 AND
																				  YEAR(operationTime)= ".$y."  AND MONTH(operationTime) = ".$m." AND merchantId=".$providerid."
																	ORDER  BY id DESC ) AS C
														GROUP BY C.A3");
		return $query->result_array();
	}
	/**获取门店单一纬度的所有答题的平均分*/
	public function getQuestionAvg($modelid,$providerid,$y,$m){
		$model=$this->getModels($modelid);
		$query=$this->db->query("SELECT  1 AS F, 
																		CASE WHEN SUM(H.F1)>0  THEN SUM(H.F1) 		ELSE 0 END '是否主动接待',
																		CASE WHEN SUM(H.F2)>0  THEN SUM(H.F2)  	ELSE 0 END '是否询问需求',
																		CASE WHEN SUM(H.F3)>0  THEN SUM(H.F3)  	ELSE 0 END '顾问服务态度',
																		CASE WHEN SUM(H.F4)>0  THEN SUM(H.F4)  	ELSE 0 END '环车检查高效',
																		CASE WHEN SUM(H.F6)>0  THEN SUM(H.F6)  	ELSE 0 END '需求是否理解',
																		CASE WHEN SUM(H.F7)>0  THEN SUM(H.F7)  	ELSE 0 END '维修保养建议',
																		CASE WHEN SUM(H.F8)>0  THEN SUM(H.F8)  	ELSE 0 END '建议能否接受',
																		CASE WHEN SUM(H.F8)>0  THEN SUM(H.F8)  	ELSE 0 END '主动给出建议',
																		CASE WHEN SUM(H.F9)>0  THEN SUM(H.F9)   	ELSE 0 END '费用结算签字',
																		CASE WHEN SUM(H.F11)>0 THEN SUM(H.F11) 	ELSE 0 END '提醒保管财物',
																		2 AS S,
																		CASE WHEN SUM(H.S1)>0  THEN SUM(H.S1)  	ELSE 0 END '位置是否便利',
																		CASE WHEN SUM(H.S3)>0  THEN SUM(H.S3)  	ELSE 0 END '车位是否充足',
																		CASE WHEN SUM(H.S5)>0  THEN SUM(H.S5)  	ELSE 0 END '专人引导停车',
																		CASE WHEN SUM(H.S6)>0  THEN SUM(H.S6)  	ELSE 0 END '停车位置便利',
																		CASE WHEN SUM(H.S7)>0  THEN SUM(H.S7)  	ELSE 0 END '人员主动服务',
																		CASE WHEN SUM(H.S9)>0  THEN SUM(H.S9)  	ELSE 0 END '座位是否充足',
																		CASE WHEN SUM(H.S10)>0 THEN SUM(H.S10) 	ELSE 0 END '休息区舒适性',
																		CASE WHEN SUM(H.S11)>0 THEN SUM(H.S11) 	ELSE 0 END '饮品种类质量',
																		CASE WHEN SUM(H.S12)>0 THEN SUM(H.S12) 	ELSE 0 END '简餐种类质量',
																		3 AS Z,
																		CASE WHEN SUM(H.Z3)>0  THEN SUM(H.Z3)  	ELSE 0 END '解释直接沟通',
																		CASE WHEN SUM(H.Z5)>0  THEN SUM(H.Z5)  	ELSE 0 END '过程是否透明',
																		CASE WHEN SUM(H.Z6)>0  THEN SUM(H.Z6)  	ELSE 0 END '三包描述相符',
																		CASE WHEN SUM(H.Z8)>0  THEN SUM(H.Z8)  	ELSE 0 END '交车车辆清洁',
																		CASE WHEN SUM(H.Z9)>0  THEN SUM(H.Z9)  	ELSE 0 END '服务设置一致',
																		CASE WHEN SUM(H.Z10)>0 THEN SUM(H.Z10) ELSE 0 END '服务符合情况',
																		CASE WHEN SUM(H.Z12)>0 THEN SUM(H.Z12) ELSE 0 END '是否有过投诉',
																		4 AS T,
																		CASE WHEN SUM(H.T2)>0  THEN SUM(H.T2)  	ELSE 0 END '预约有无优惠',
																		CASE WHEN SUM(H.T4)>0  THEN SUM(H.T4)  	ELSE 0 END '是否需要等待',
																		CASE WHEN SUM(H.T5)>0  THEN SUM(H.T5)  	ELSE 0 END '提前告知时长',
																		CASE WHEN SUM(H.T6)>0  THEN SUM(H.T6)  	ELSE 0 END '工位是否等待',
																		CASE WHEN SUM(H.T7)>0  THEN SUM(H.T7)  	ELSE 0 END '满意等待时长',
																		CASE WHEN SUM(H.T8)>0  THEN SUM(H.T8)  	ELSE 0 END '约定时间交车',
																		CASE WHEN SUM(H.T11)>0 THEN SUM(H.T11)  ELSE 0 END '交车是否等待',
																		CASE WHEN SUM(H.T12)>0 THEN SUM(H.T12)  ELSE 0 END '结算是否等待',
																		5 AS P,
																		CASE WHEN SUM(H.P1)>0  THEN SUM(H.P1)  	ELSE 0 END '价格是否透明',
																		CASE WHEN SUM(H.P2)>0  THEN SUM(H.P2)  	ELSE 0 END '定价是否合理',
																		CASE WHEN SUM(H.P3)>0  THEN SUM(H.P3)  	ELSE 0 END '工时定价合理',
																		CASE WHEN SUM(H.P4)>0  THEN SUM(H.P4)  	ELSE 0 END '配件多种选择'
											FROM  (SELECT   		CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='F1'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END F1,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='F2'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END F2,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='F3'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END F3,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='F4'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END F4,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='F6'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END F6,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='F7'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END F7,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='F8'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END F8,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='F9'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END F9,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='F10' THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END F10,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='F11' THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END F11,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='S1'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END S1,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='S3'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END S3,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='S5'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END S5,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='S6'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END S6,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='S7'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END S7,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='S9'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END S9,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='S10' THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END S10,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='S11' THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END S11,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='S12' THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END S12,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='Z3'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END Z3,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='Z5'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END Z5,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='Z6'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END Z6,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='Z8'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END Z8,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='Z9'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END Z9,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='Z10' THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END Z10,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='Z12' THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END Z12,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='T2'   THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END T2,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='T4'   THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END T4,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='T5'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END T5,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='T6'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END T6,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='T7'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END T7,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='T8'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END T8,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='T11' THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END T11,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='T12' THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END T12,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='P1'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END P1,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='P2'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END P2,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='P3'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END P3,
																				CASE WHEN SUBSTRING_INDEX(G.name,'、',1)='P4'  THEN ROUND(SUM(G.size)/COUNT(1),2) ELSE 0 END P4,
																				CASE WHEN G.questionnaireId>0								  	  THEN 1													ELSE 0 END A1								
														 FROM   		    (SELECT 	    A.questionnaireId,
																								    B.primitiveQuestionId AS questionid,
																								    B.primitiveTitle 													AS name,
																								   (D.primitiveWeight/B.primitiveWeight)*100 	AS size
																				 FROM       cada_results_questionnaire                  	    		AS A
																								   LEFT JOIN cada_results_question_bank   		AS B  ON  B.resultsQuestionnaireId=A.id
																								   LEFT JOIN cada_results_answer        	    		AS D  ON  D.resultsQuestionId=B.id 
																				WHERE      A.merchantId=".$providerid." 			 AND 
																								   YEAR(A.operationTime)= ".$y."  		 AND 
																								   MONTH(A.operationTime) = ".$m."  AND 
																								   A.status=B.status=D.status=1           AND 
																								   A.questionnaireId IN (".$model[0]['id'].",".$model[1]['id'].",".$model[2]['id'].",".$model[3]['id'].",".$model[4]['id']." ) 	) AS G
														WHERE 		   SUBSTRING_INDEX(G.name,'、',1) <> 'Z1'
														GROUP  BY   G.questionid
														ORDER  BY   G.questionnaireId,G.questionid ASC)							                     AS H
											GROUP BY H.A1");
		return $query->result_array();
	}
	/**获取某一试题判断题回答比例*/
	public function getQuestioni($providerid,$y,$m,$questionnaireid,$str){
		$query=$this->db->query('SELECT  	G.name,
																	CASE WHEN SUM(G.A1)/SUM(G.A3)>0 THEN ROUND(SUM(G.A1)/SUM(G.A3)*100,2) ELSE 0 END   AS "是",
																	CASE WHEN SUM(G.A2)/SUM(G.A3)>0 THEN ROUND(SUM(G.A2)/SUM(G.A3)*100,2) ELSE 0 END   AS "否"
													FROM (SELECT   B.primitiveQuestionId AS questionid,
																				 B.primitiveTitle 																				AS name,
																				 CASE WHEN D.primitiveTitle="是" THEN 1 ELSE 0	END			AS A1,
																				 CASE WHEN D.primitiveTitle="否" THEN 1 ELSE 0 END        AS A2,
																				 1																								        AS A3
																 FROM     cada_results_questionnaire                  	        AS A
																				 LEFT JOIN cada_results_question_bank   		AS B  ON  B.resultsQuestionnaireId=A.id
																				 LEFT JOIN cada_results_answer        	    		AS D  ON  D.resultsQuestionId=B.id 
																WHERE    A.status=B.status=D.status=1           				AND
																				 A.merchantId='.$providerid.' 						   				AND
																				 YEAR(A.operationTime)= '.$y.'  		   				AND 
																				 MONTH(A.operationTime) = '.$m.'  				AND 
																				 B.primitiveType=1       					    				AND
																				 A.questionnaireId= '.$questionnaireid.')   									AS G
													WHERE  SUBSTRING_INDEX(G.name,"、",1)="'.$str.'"
													GROUP BY G.name');
		return $query->result_array();
	}
	/**获取门店某一试题的回答比例*/
	public function getQuestionAnswer($providerid,$y,$m,$questionnaireid,$str){
		$query=$this->db->query("SELECT   	G.questionid,
																			G.name,
																			G.content,
																			COUNT(1) AS size
														FROM (SELECT   B.primitiveQuestionId AS questionid,
																					 B.primitiveTitle 										            AS name,
																					 D.primitiveTitle												    AS content ,
																					 D.primitiveAnswerId
																 FROM     	cada_results_questionnaire                  	        AS A
																				 	LEFT JOIN cada_results_question_bank   		AS B  ON  B.resultsQuestionnaireId=A.id
																				 	LEFT JOIN cada_results_answer        	    		AS D  ON  D.resultsQuestionId=B.id 
																WHERE      A.status=B.status=D.status=1           				AND
																				   A.merchantId=".$providerid." 						   	AND
																				  YEAR(A.operationTime)= ".$y."  		   				AND 
																				  MONTH(A.operationTime) = ".$m."  				AND 
																				  B.primitiveType=1       					    				AND
																				  A.questionnaireId= ".$questionnaireid.")   				AS G
													WHERE   SUBSTRING_INDEX(G.name,'、',1)='".$str."'
													GROUP BY G.content");
		return $query->result_array();
	}
	/**获取服务顾问的模块化得分*/
	public function getQi($modelid,$providerid,$y,$m,$questionnaireid){
		$model=$this->getModels($modelid);
		$sql="SELECT ";
		$sqlStr=array(
				$model[0][id]=>" CASE
										    	WHEN SUBSTRING_INDEX(G.name,'、',1)='F4'  OR SUBSTRING_INDEX(G.name,'、',1)='F1' 										    											THEN '服务态度'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='F2'																																									THEN '着装仪表'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='F6'  OR SUBSTRING_INDEX(G.name,'、',1)='F7'   OR SUBSTRING_INDEX(G.name,'、',1)='F8' 		THEN '经验能力'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='F9'  OR SUBSTRING_INDEX(G.name,'、',1)='F10' OR SUBSTRING_INDEX(G.name,'、',1)='F11' OR SUBSTRING_INDEX(G.name,'、',1)='F3'  THEN  '操作规范'
							       				END AS title,",
				$model[1]['id']=>"CASE
										    	WHEN SUBSTRING_INDEX(G.name,'、',1)='S1'     OR SUBSTRING_INDEX(G.name,'、',1)='S3' OR SUBSTRING_INDEX(G.name,'、',1)='S5' OR SUBSTRING_INDEX(G.name,'、',1)='S6'	 THEN '门店便利性'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='S11'   OR   SUBSTRING_INDEX(G.name,'、',1)='S12'  									        THEN '餐饮品质'
				       							END AS title,",
				$model[2]['id']=>" CASE
												WHEN SUBSTRING_INDEX(G.name,'、',1)='Z3'  OR SUBSTRING_INDEX(G.name,'、',1)='Z5'   OR SUBSTRING_INDEX(G.name,'、',1)='Z12' 		THEN '维修保养透明度'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='Z1'  OR SUBSTRING_INDEX(G.name,'、',1)='Z8' OR SUBSTRING_INDEX(G.name,'、',1)='Z9' OR SUBSTRING_INDEX(G.name,'、',1)='Z10'  THEN  '维修保养结果'
							       				END AS title,",
				$model[3]['id']=>"CASE
											    WHEN SUBSTRING_INDEX(G.name,'、',1)='T2'     THEN '预约服务提供'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='T4'     OR   
															SUBSTRING_INDEX(G.name,'、',1)='T5'     OR  
															SUBSTRING_INDEX(G.name,'、',1)='T6'     OR 
															SUBSTRING_INDEX(G.name,'、',1)='T7'     OR 
										                    SUBSTRING_INDEX(G.name,'、',1)='T8'     OR  
															SUBSTRING_INDEX(G.name,'、',1)='T11'   OR   
															SUBSTRING_INDEX(G.name,'、',1)='T12'   THEN '维修保养服务时长'
								       			END AS title,",
				$model[4]['id']=>"CASE
											    WHEN SUBSTRING_INDEX(G.name,'、',1)='P1'																																								THEN '价格透明度'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='P2' OR SUBSTRING_INDEX(G.name,'、',1)='P3'	OR SUBSTRING_INDEX(G.name,'、',1)='P4' 	THEN '定价合理性'
								       			END AS title,"
		);
		$sql.=$sqlStr[$questionnaireid];
		$sql.="		 ROUND((SUM(G.size)/COUNT(1)),2) AS score
				FROM  (SELECT 	    A.questionnaireId,
												    B.primitiveQuestionId AS questionid,
												    B.primitiveTitle 													AS name,
												   (D.primitiveWeight/B.primitiveWeight)*100 	AS size
								 FROM       cada_results_questionnaire                  	    		AS A
												   LEFT JOIN cada_results_question_bank   		AS B  ON  B.resultsQuestionnaireId=A.id
												   LEFT JOIN cada_results_answer        	    		AS D  ON  D.resultsQuestionId=B.id 
								WHERE      A.merchantId=".$providerid." 			 AND 
												   YEAR(A.operationTime)= ".$y."  		 AND 
												   MONTH(A.operationTime) = ".$m."  AND 
												   A.status=B.status=D.status=1           AND 
												   A.questionnaireId=".$questionnaireid." ) 	AS G
				GROUP  BY title
				HAVING title IS NOT  NULL ";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	/**查询一个商户的详情*/
	public function getProvider($id){
		$query=$this->db->query("SELECT id,name AS provider_name  FROM cada_merchant_info WHERE id=".$id);
		return $query->result_array();
	} 
	/**获取模型列表*/
	public function getModels($modelid){
		$query=$this->db->query("SELECT     B.questionnaireId AS id,
																		   B.title
															 FROM   cada_model A LEFT JOIN cada_module B ON A.id=B.modelId
															 WHERE  A.status=1 AND B.status=1 AND A.id=".$modelid."  ORDER BY B.sorting ASC ");
		return $query->result_array();
	}
	}