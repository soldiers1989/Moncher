<?php
/*****************************************************
**作者：张文晓
**创始时间：2017-03-03
**描述：商户端基础信息Model类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/system/core/Model.php");
/**
public function getInformation($isCompany,$id){
																				E.name 																				AS area,
																				F.name 																	   		     AS  brand,
																				F.rank,
																				G.groupName
																				LEFT JOIN  cada_area                                                         AS   E ON E.id=A.areaId
																				LEFT JOIN  cada_car_info													  AS   F  ON F.id=A.brandId1
																				LEFT JOIN  (SELECT   I.providerId,
																													H.name											  AS	 groupName			
																									 FROM    cada_provider_certification	 		  AS 	  I 
																													LEFT JOIN cada_merchant_info  	  AS   H   ON H.id=I.pId
																									 WHERE  I.certificationStatus=1					  AND 
																													H.isCompany=0)							  AS   G   ON G.providerId=A.id
																			    A.id=".$id);
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
		return $query->result_array();
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
	}
}