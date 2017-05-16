<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class ReportModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::ReportModel::__construct
	 * ----------------------------------------------------------
	 * 描述::数据库基础类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.03.02  Add by zwx
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**
	 ***********************************************************
	 *方法::ReportModel::getProData
	 * ----------------------------------------------------------
	 * 描述::生成报告-查询-获取商户名称
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.03.02  Add by zwx
	 ************************************************************
	 */
	public function getReportList($type=1,$modelid,$groupid,$providerid,$startDate,$endDate,$size=24){
		$model=$this->getModels($modelid);
		$where=' ';
		!empty($groupid) && $where.="			AND D.groupId=".$groupid;
		!empty($providerid) && $where.="		AND D.merchantId=".$providerid;
	    if((!empty($startDate) && !empty($endDate))){
			strtotime($startDate)<=strtotime($endDate) ? $where.="		AND	(DATE_FORMAT(D.operationTime,'%Y-%m')>='".$startDate."' 	AND 		DATE_FORMAT(D.operationTime,'%Y-%m')<='".$endDate."')":
																							 $where.="		AND	(DATE_FORMAT(D.operationTime,'%Y-%m')>='".$endDate."' 	AND 		DATE_FORMAT(D.operationTime,'%Y-%m')<='".$startDate."')";
		}
		$query=$this->db->query("SELECT  X.merchantId,
																		Y.name   provider,
																		X.yeari,
																	  	CASE WHEN LENGTH(X.monthxii)=2 THEN X.monthxii ELSE CONCAT('0',X.monthxii) END AS monthxii
														FROM     (SELECT 	 D.merchantId,
																						 D.questionnaireId,
																						 COUNT(1) AS SIZE,
																						 CASE WHEN D.questionnaireId=".$model[0]['id']." 	AND COUNT(1)>=".$size."	THEN 1 ELSE 0 END AS A1,
																						 CASE WHEN D.questionnaireId=".$model[1]['id']." 	AND COUNT(1)>=".$size."	THEN 1 ELSE 0 END AS A2,
																						 CASE WHEN D.questionnaireId=".$model[2]['id']."  	AND COUNT(1)>=".$size."	THEN 1 ELSE 0 END AS A3,
																						 CASE WHEN D.questionnaireId=".$model[3]['id']."  	AND COUNT(1)>=".$size."	THEN 1 ELSE 0 END AS A4,
																						 CASE WHEN D.questionnaireId=".$model[4]['id']."  	AND COUNT(1)>=".$size."	THEN 1 ELSE 0 END AS A5,
																						 MONTH(D.operationTime) AS monthxii,
																						 YEAR(D.operationTime) AS  yeari
																			FROM   cada_results_questionnaire  AS  D
																			WHERE  D.status=1	AND
																						   D.questionnaireId IN (".$model[0]['id'].",".$model[1]['id'].",".$model[2]['id'].",".$model[3]['id'].",".$model[4]['id'].")".$where."	 							
																			GROUP  BY  monthxii,yeari,D.merchantId,D.questionnaireId
																			HAVING COUNT(1)>=".$size."  AND D.merchantId IS NOT NULL 
																			ORDER  BY yeari DESC,monthxii DESC) AS X LEFT JOIN cada_merchant_info  AS Y  ON Y.id=X.merchantId	
																			GROUP BY X.yeari,X.monthxii,X.merchantId
															HAVING 	 SUM(X.A1)+SUM(X.A2)+SUM(X.A3)+SUM(X.A4)+SUM(X.A5)>=5
															ORDER BY X.yeari DESC,X.monthxii DESC");
		return $type==1?$query->result_array():$query->num_rows();
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
	/**获取模型列表*/
	public function getModels($modelid){
		$query=$this->db->query("SELECT  B.questionnaireId AS id,
														 				B.title
													 FROM   cada_model A LEFT JOIN cada_module B ON A.id=B.modelId
													 WHERE  A.status=1 AND B.status=1 AND A.id=".$modelid."  ORDER BY B.sorting ASC ");
		return $query->result_array();
	}
	public function getGroupList($modelid){
		$model=$this->getModels($modelid);
		$query=$this->db->query('SELECT  A.groupId,
																	    B.name
															FROM   cada_results_questionnaire A LEFT JOIN
																	   	  cada_merchant_info           	  B ON B.id=A.groupId
															WHERE questionnaireId IN ('.$model[0]['id'].','.$model[1]['id'].','.$model[2]['id'].','.$model[3]['id'].','.$model[4]['id'].')   	 AND
																		  A.status=1 AND B.status=1
															GROUP BY A.groupId');
		return $query->result_array();
	}
}