<?php
/*****************************************************
**作者：张文晓
**创始时间：2017-03-03
**描述：商户端基础信息Model类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/system/core/Model.php");class InformationModel extends CI_Model {/** *********************************************************** *方法::InformationModel::__construct * ---------------------------------------------------------- * 描述::初始化方法 *---------------------------------------------------------- *参数: *parm2:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- * 日期:2017.03.03   Add by zwx ************************************************************ */function __construct(){    parent::__construct();    $this->load->database();}
/** *********************************************************** *方法::InformationModel::getAreaList * ---------------------------------------------------------- * 描述::获取列表分页及数量方法 *---------------------------------------------------------- *参数: *parm1:in--    String :: type ::获取数量 OR 结果 *parm2:in--    String :: open :: 分页起始 *parm3:in--    String :: last    :: 分页结束  *parm4:in--    String :: order :: 排序字段 *parm4:in--    String :: desc   ::正序 OR 倒序 *---------------------------------------------------------- *返回： *return:out1--  Int :: rows      :: 获取数量 *return:out2--  Array::query  :: 获取结果数组 * ---------------------------------------------------------- * 日期:2017.03.03  Add by zwx ************************************************************ */
public function getInformation($isCompany,$id){	if($isCompany==1){#.门店基础信息查询		$query=$this->db->query("SELECT 			A.*,
																				E.name 																				AS area,
																				F.name 																	   		     AS  brand,
																				F.rank,
																				G.groupName														 FROM   			cada_merchant_info 												   		     AS  A
																				LEFT JOIN  cada_area                                                         AS   E ON E.id=A.areaId
																				LEFT JOIN  cada_car_info													  AS   F  ON F.id=A.brandId1
																				LEFT JOIN  (SELECT   I.providerId,
																													H.name											  AS	 groupName			
																									 FROM    cada_provider_certification	 		  AS 	  I 
																													LEFT JOIN cada_merchant_info  	  AS   H   ON H.id=I.pId
																									 WHERE  I.certificationStatus=1					  AND 
																													H.isCompany=0)							  AS   G   ON G.providerId=A.id														 WHERE      	A.status=1  AND
																			    A.id=".$id);		return $query->result_array();	}else if($isCompany==0){#.集团基础信息查询
		$query=$this->db->query("SELECT 			A.*,
																				D.size,
																				C.brandSize,
																				E.name  AS area
														 FROM   			cada_merchant_info 												   		     AS  A
																				LEFT JOIN cada_area                                                          AS  E ON E.id=A.areaId
																		 		LEFT JOIN (SELECT COUNT(1) AS size ,
																												   pId
																								    FROM   cada_provider_certification 
				                                                                                    WHERE  status=1 AND certificationStatus=1 
																									GROUP BY pId) 												 AS  D  ON D.pId=A.id
																				LEFT  JOIN ( SELECT COUNT(1) AS brandSize,groupId
																									FROM (SELECT brandId, groupId 
																									FROM 	 cada_results_questionnaire
																									WHERE  status=1 
																									GROUP  BY brandId,groupId 
																									HAVING groupId IS NOT NULL ) AS A 
																									GROUP BY groupId ) AS C ON C.groupId=A.id
														 WHERE      	A.status=1  AND
																			    A.id=".$id);
		return $query->result_array();	}else if($isCompany==3){#.厂家基础信息查询
		$query=$this->db->query("SELECT 			A.*,
																				E.name AS area,
																				F.name 																	   		     AS  brand,
																				F.rank
														 FROM   			cada_merchant_info 												   		       AS  A
																				LEFT JOIN  cada_area														   AS  E ON E.id=A.areaId
																				LEFT JOIN  cada_car_info													  AS   F   ON F.id=A.brandId1
														 WHERE      	A.status=1  AND
																			    A.id=".$id);
		return $query->result_array();
	}}
}