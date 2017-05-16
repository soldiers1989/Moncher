<?php
	/*****************************************************
	**作者：张文晓
	**创始时间：2017-04-12
	**描述：门店报告下载Model类
	*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/system/core/Model.php");
class PDFOModel extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->load->database();
		}
	/**获取车主总数量*/
	public function getPersonSize($id,$y,$m){
		$query=$this->db->query("SELECT 		 merchantId  AS providerid,
																			 COUNT(1)	AS size
														   FROM       cada_persons
														   WHERE     merchantId=".$id." 													AND
																			 YEAR(createtime) =".$y." 	    	AND 
																			 MONTH(createtime)=".$m."
					                                       GROUP     BY merchantId  ");
		$list=$query->result_array();
		return empty($list)?0:$list[0]['size'];
	}
	/**获取车主男女比例*/
	public function getPersonSexSize($id,$y,$m){
		$query=$this->db->query("SELECT  CASE sex
																			  WHEN  1   THEN  '男'
																			  WHEN   2  THEN  '女'
																	  END                AS  sex,
																	  COUNT(1)      AS size
														FROM    cada_persons
														WHERE  merchantId=".$id."   AND
																	  YEAR(createtime) =".$y." 	AND
																	  MONTH(createtime)=".$m."
														GROUP  BY sex ");
		return $query->result_array();
	}
	/**获取车主年龄比例*/
	public function getPersonAgeSize($id,$y,$m){
		$query=$this->db->query("SELECT  CASE age
																			  WHEN  '60岁及以上'   THEN  '60+岁'
																			  WHEN   '50-59岁'  	   THEN  '50-59岁'
																			  WHEN  '40-49岁'         THEN  '40-49岁'
																			  WHEN   '30-39岁'        THEN  '30-39岁'
																			  WHEN  '18-29岁'         THEN  '18-29岁'
																	  END                AS  age,
																	  COUNT(1)      AS  size
														FROM    cada_persons
														WHERE  merchantId=".$id."   AND
																	  YEAR(createtime) =".$y." 	AND
																	  MONTH(createtime)=".$m."
														GROUP  BY age ");
		
		return $query->result_array();
	}
	/**获取车主学历比例*/
	public function getPersonEducationSize($id,$y,$m){
		$query=$this->db->query("SELECT  CASE qualifications
																		  WHEN  '硕士及以上'   					THEN  '硕士及以上'
																		  WHEN  '本科'  									THEN  '本科'
																		  WHEN  '大专'   								THEN  '大专'
																		  WHEN  '高中(含高职，技校等)'  	THEN  '高中'
																		  WHEN  '初中及以下'   					THEN  '初中及以下'
																	  END                AS  education,
																	  COUNT(1)      AS size
														FROM    cada_persons
														WHERE  merchantId=".$id."   AND
																	  YEAR(createtime) =".$y." 	AND
																	  MONTH(createtime)=".$m."
														GROUP  BY qualifications ");
		
		return $query->result_array();
	}
	/**获取车主收入比例*/
	public function getPersonMoneySize($id,$y,$m){
		$query=$this->db->query("SELECT  CASE income
																			  WHEN  '30万元以上'   	   THEN  '>=30万'
																			  WHEN  '20-30万元之间'   THEN  '20-30万'
																			  WHEN  '10-20万元之间'   THEN  '10-20万'
																			  WHEN  '5-10万元之间'  	   THEN  '5-10万'
																			  WHEN  '5万元以下'   		   THEN  '<=5万'
																	  END                AS  money,
																	  COUNT(1)      AS size
														FROM    cada_persons
														WHERE  merchantId=".$id."   AND
																	  YEAR(createtime) =".$y." 	AND
																	  MONTH(createtime)=".$m."
														GROUP  BY income ");
		return $query->result_array();
	}
	/**获取车主职业比例*/
	public function getPersonVocationSize($id,$y,$m){
		$query=$this->db->query("SELECT  CASE occupation
																			  WHEN  '高层管理人员（含单位、公司高层领导）'   THEN  '高层管理人员'
																			  WHEN  '中层管理人员（含单位、公司环节干部）'  THEN  '中层管理人员'
																			  WHEN  '普通职员'   														THEN  '普通职员'
																			  WHEN  '教育界人员'   													THEN  '教育界人员'
																			  WHEN  '律师、会计师、文艺工作者'   						THEN  '律师、会计师...'
																			  WHEN  '私营公司老板'  													THEN  '私营公司老板'
																			  WHEN  '科技、体育、卫生行业普通人员'   				THEN  '科技、体育...'
																			  WHEN  '个体工商业者'  													THEN  '个体工商业者'
																			  WHEN  '自由职业者'   													THEN  '自由职业者'
																			  WHEN  '其他'  																	THEN  '其他'
																			  WHEN  '无业'   																THEN  '无业'
																			  WHEN  '拒绝回答'  															THEN  '拒绝回答'
																	  END                AS  vocation,
																	  COUNT(1)      AS size
														FROM    cada_persons
														WHERE  merchantId=".$id."   AND
																	   YEAR(createtime) =".$y." 	AND
																	   MONTH(createtime)=".$m."
														GROUP  BY occupation ");
		
		return $query->result_array();
	}
	/**获取车主年限比例*/
	public function getPersonYearSize($id,$y,$m){
		$query=$this->db->query("SELECT   CASE carPeriod
																			  WHEN  '5年以上'     	THEN  '5年以上'
																			  WHEN  '3-5年之间'  	THEN  '3-5年'
																			  WHEN  '1-3年之间'   	THEN  '1-3年'
																			  WHEN  '1年以内'  		THEN  '1年以内'
																	   END                AS  buytime,
																	   COUNT(1)      AS size
														FROM    cada_persons
														WHERE  merchantId=".$id."   AND
																	   YEAR(createtime) =".$y." 	AND
																	   MONTH(createtime)=".$m."
														GROUP  BY carPeriod ");
		return $query->result_array();
	}
	/**获取车主五大纬度比例*/
	public function getResultSize($id,$modelid,$y,$m){
		$model=$this->getModels($modelid);
		$query=$this->db->query("SELECT  CASE questionnaireId
																			WHEN   ".$model[0]['id']." THEN  '服务顾问'
																			WHEN   ".$model[1]['id']." THEN  '服务设施'
																			WHEN   ".$model[2]['id']." THEN  '维修质量'
																			WHEN   ".$model[3]['id']." THEN  '维修时间'
																			WHEN   ".$model[4]['id']." THEN  '维修价格'
																		END    AS  model,
																		COUNT(1) AS size
														FROM     cada_results_questionnaire
														WHERE   merchantId=".$id."	AND
																		YEAR(operationTime) =".$y." 	AND
																		MONTH(operationTime)=".$m."
														GROUP   BY model ");
		
		return $query->result_array();
	}
	/**获取门店的五个维度当月得分*/
	public function getResultMonthScore($id,$modelid,$y,$m){
		$model=$this->getModels($modelid);
		$query=$this->db->query("SELECT   D.providerid,
																	   CASE  D.questionnaireid
																		    WHEN   ".$model[0]['id']." THEN   '服务顾问'
																			WHEN   ".$model[1]['id']." THEN   '服务设施'
																			WHEN   ".$model[2]['id']." THEN   '维修质量'
																			WHEN   ".$model[3]['id']." THEN   '维修时间'
																			WHEN   ".$model[4]['id']." THEN   '维修价格'
				  													   END AS model,
																	   ROUND(SUM(D.score)/COUNT(1),6) AS size
														FROM    (SELECT   id,
																					    merchantId AS providerid,
																					    questionnaireId AS questionnaireid,
																					    MONTH(operationTime) AS monthxii,
																					    (alreadyWeight/primitive)*100  AS  score
																		FROM     cada_results_questionnaire
																		WHERE   merchantId=".$id."	AND
																						YEAR(operationTime) =".$y." 	AND
																						MONTH(operationTime)=".$m." )     AS   D
														WHERE   D.monthxii= ".$m."  
														GROUP   	BY D.questionnaireid");
		return $query->result_array();
	}
	/**获取门店单一纬度的所有答题的平均分*/
	public function getQuestionAvg($questionnaireId,$providerid,$y,$m){
		$query=$this->db->query("SELECT   B.primitiveQuestionId AS questionid,
																		 B.primitiveTitle  AS name,
																		 IFNULL(ROUND(AVG(B.alreadyWeight/B.primitiveWeight),2)*100,0)  AS score
														 FROM   cada_results_questionnaire   A  LEFT JOIN
																	    cada_results_question_bank  B   ON A.id=B.resultsQuestionnaireId
														 WHERE  B.status=1 																				AND
																	   A.status=1 																				AND
																	   B.primitiveWeight>0 															AND
																	   A.merchantId=".$providerid."											    AND
															           A.questionnaireId=".$questionnaireId."								AND 
																	   YEAR(A.operationTime) =".$y." 					AND
																	   MONTH(A.operationTime)=".$m."
														 GROUP BY B.primitiveQuestionId
														 ORDER  BY questionid  ASC");
		return  $query->result_array();
	}
	/**获取门店某一问卷的的MAXMIN排序*/
	public function getQuestionMaxMin($questionnaireId,$providerid,$y,$m){
		$query=$this->db->query("SELECT   B.primitiveQuestionId AS questionid,
																		 B.primitiveTitle  AS name,
																		 IFNULL(ROUND(SUM(B.alreadyWeight/B.primitiveWeight)/COUNT(1)*100,2),0) score
														 FROM   cada_results_questionnaire   A  LEFT JOIN
																	    cada_results_question_bank  B   ON A.id=B.resultsQuestionnaireId
														 WHERE  B.status=1 																				AND
																	   A.status=1 																				AND
																	   B.primitiveWeight>0 															AND
																	   A.merchantId=".$providerid."											    AND
															           A.questionnaireId=".$questionnaireId."								AND
																	   YEAR(A.operationTime) =".$y." 					AND
																	   MONTH(A.operationTime)=".$m."
														 GROUP  BY B.primitiveQuestionId
														 ORDER  BY score  DESC");
		return  $query->result_array();
	}
	/**获取门店某一试题的回答比例*/
	public function getQuestionAnswer($providerid,$y,$m,$questionnaireid,$str){
		$query=$this->db->query("SELECT   	G.questionid,
																			G.name,
																			G.content,
																			AVG(G.answerWeight/G.questionWeight)*100 AS score,
																			COUNT(1) AS size
														FROM (SELECT   B.primitiveQuestionId AS questionid,
																					 B.primitiveTitle 										            AS name,
																					 D.primitiveTitle												    AS content ,
																					 B.primitiveWeight											AS questionWeight,
																					 D.primitiveWeight										    AS answerWeight,
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
												WHEN SUBSTRING_INDEX(G.name,'、',1)='S7'     OR SUBSTRING_INDEX(G.name,'、',1)='S8' OR SUBSTRING_INDEX(G.name,'、',1)='S9' OR SUBSTRING_INDEX(G.name,'、',1)='S10'	OR SUBSTRING_INDEX(G.name,'、',1)='S13'      THEN '客休区服务及设施'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='S11'   OR   SUBSTRING_INDEX(G.name,'、',1)='S12'  									        THEN '餐饮品质'
				       							END AS title,",
				$model[2]['id']=>" CASE
												WHEN SUBSTRING_INDEX(G.name,'、',1)='Z1'  OR SUBSTRING_INDEX(G.name,'、',1)='Z8'   OR SUBSTRING_INDEX(G.name,'、',1)='Z9' OR SUBSTRING_INDEX(G.name,'、',1)='Z10'  THEN  '维修保养结果'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='Z3'  OR SUBSTRING_INDEX(G.name,'、',1)='Z5'   OR SUBSTRING_INDEX(G.name,'、',1)='Z12' 		THEN '维修保养透明度'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='Z4'  OR SUBSTRING_INDEX(G.name,'、',1)='Z6'   OR  SUBSTRING_INDEX(G.name,'、',1)='Z14' OR SUBSTRING_INDEX(G.name,'、',1)='Z15'  THEN  '投诉与处理'
							       				END AS title,",
				$model[3]['id']=>"CASE
											    WHEN SUBSTRING_INDEX(G.name,'、',1)='T2'     THEN '预约服务提供'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='T4'     OR
															SUBSTRING_INDEX(G.name,'、',1)='T5'     OR
															SUBSTRING_INDEX(G.name,'、',1)='T6'     OR
															SUBSTRING_INDEX(G.name,'、',1)='T7'     OR
										                    SUBSTRING_INDEX(G.name,'、',1)='T8'     OR
															SUBSTRING_INDEX(G.name,'、',1)='T11'   OR
															SUBSTRING_INDEX(G.name,'、',1)='T12'    THEN '维修保养服务时长'
												WHEN SUBSTRING_INDEX(G.name,'、',1)='T15'    THEN '营业时间便利'
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
	/**获取模型列表*/
	public function getModels($modelid){
		$query=$this->db->query("SELECT      B.questionnaireId AS id,
																		    B.title
															 FROM    cada_model A LEFT JOIN cada_module B ON A.id=B.modelId
															 WHERE  A.status=1 AND B.status=1 AND A.id=".$modelid."  ORDER BY B.sorting ASC ");
		return $query->result_array();
	}
	/**查询一个商户的详情*/
	public function getProvider($id){
		$query=$this->db->query("SELECT id,name AS provider_name  FROM cada_merchant_info WHERE id=".$id);
		return $query->result_array();
	}
}