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
	public function getMonitorList($type=1,$groupid,$modelid,$brandid,$areaid,$providerid,$startDate,$endDate){
		$model=$this->getModels($modelid);
		$where=' ';
	    $brandid!=0     && $where.=' 	AND  brandId='.$brandid;
		$areaid!=0       &&  $where.=' 	AND  areaId='.$areaid;
		$providerid!=0 && $where.=' 	AND  merchantId='.$providerid;
		if((!empty($startDate) && !empty($endDate))){
			strtotime($startDate)<=strtotime($endDate) ? $where.=" 	AND   operationTime   BETWEEN  '".$startDate." 00:00:00' AND '".$endDate."  23:59:59'":
			$where.=" 	AND   operationTime   BETWEEN  '".$endDate." 00:00:00' AND '".$startDate."  23:59:59'";
		}
		$query=$this->db->query('SELECT  		C.merchantId,
																			 D.name,
																			 E.name AS groupName,
																			 IFNULL(ROUND(SUM(C.A1)/SUM(C.A2)*100,2),0) 	 AS F1,
																			 IFNULL(SUM(C.A2),0)                        	 						AS F2,
																			 IFNULL(SUM(C.A4),0)                        	 						AS F3,
																			 IFNULL(SUM(C.A5),0)                        	 						AS F4,
																			 IFNULL(SUM(C.A6),0)                        	 						AS F5,
																			 IFNULL(SUM(C.A7),0)                        	 						AS F6,
																			 IFNULL(SUM(C.A8),0)                        	 						AS F7,
																			 IFNULL(ROUND(SUM(C.A9)/SUM(C.A4)*100,2),0) 	 	AS F8,
																			 IFNULL(ROUND(SUM(C.A10)/SUM(C.A5)*100,2),0)   AS F9,
																			 IFNULL(ROUND(SUM(C.A11)/SUM(C.A6)*100,2),0)   AS F10,
																			 IFNULL(ROUND(SUM(C.A12)/SUM(C.A7)*100,2),0)   AS F11,
																			 IFNULL(ROUND(SUM(C.A13)/SUM(C.A8)*100,2),0)   AS F12
																FROM (SELECT id,
																						 merchantId,
																						 groupId,
																						 CASE  WHEN id>0 		  					THEN (alreadyWeight/primitive)   ELSE 0 END AS A1,
																						 CASE  WHEN id>0 		  				    THEN 1               ELSE 0 END AS A2,
																						 CASE  WHEN questionnaireId='.$model[0]['id'].' 	THEN 1 ELSE 0 END AS A4,
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
																						 groupId='.$groupid.$where.' 
																			ORDER  BY id DESC ) 					AS C
																			LEFT JOIN cada_merchant_info  AS D ON D.id=C.merchantId
																			LEFT JOIN cada_merchant_info  AS E ON  E.id=C.groupId
																GROUP BY C.merchantId
																HAVING C.merchantId IS NOT NULL');
		return $type==2?$query->num_rows():$query->result_array();
	}
	/**获取集团的调研区域*/
	public function getAreaList($groupid){
		$query=$this->db->query("SELECT   A.areaId,
																	  	 B.name
														FROM     cada_results_questionnaire A LEFT JOIN
																        cada_area           		       	    B ON B.id=A.areaId
														WHERE 	A.groupId=".$groupid."
														GROUP 	BY A.areaId");
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