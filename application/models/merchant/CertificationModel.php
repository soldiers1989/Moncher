<?php
/*****************************************************
**作者：张文晓
**创始时间：2017-03-03
**描述：商户端认证Model类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/system/core/Model.php");
	/**
	public function getCertificationList($type=1,$isCompany,$id,$open=0,$last=20,$order="id",$desc="DESC"){
		switch ($isCompany){
			#.获取集团认证列表
			case 0:
				if($type==1){
					$query=$this->db->query("SELECT 			A.*,
																							C.isCompany										    AS company,
																							B.name 												    AS parentName,
																							C.name 													AS providerName
																	 FROM   			cada_provider_certification 					AS  A
																							LEFT JOIN cada_merchant_info   	    AS  B   ON B.id=A.pId
																							LEFT JOIN cada_merchant_info			AS  C   ON C.id=A.providerId
																	 WHERE      	A.status=1  											AND
																							A.pId=".$id."
																	 ORDER  BY    A.".$order."  ".$desc."
																	 LIMIT				 ".$open.",".$last);
					return $query->result_array();
				}else{
					$query=$this->db->query("SELECT * FROM  cada_provider_certification  WHERE status=1 AND pId=".$id);
					return $query->num_rows();
				}
				break;
			#.获取门店认证列表
			case 1:
				if($type==1){
					$query=$this->db->query("SELECT 			A.*,
																							B.name 												    AS parentName,
																							B.isCompany										    AS company,
																							C.name 													AS providerName
																	 FROM   			cada_provider_certification 					AS  A
																							LEFT JOIN cada_merchant_info   	    AS  B   ON B.id=A.pId
																							LEFT JOIN cada_merchant_info			AS  C   ON C.id=A.providerId
																	 WHERE      	A.status=1  											AND
																							A.providerId=".$id." 
																	 ORDER  BY    A.".$order."  ".$desc."
																	 LIMIT				 ".$open.",".$last);
					return $query->result_array();
				}else{
					$query=$this->db->query("SELECT * FROM  cada_provider_certification  WHERE status=1 AND pId=".$id);
					return $query->num_rows();
				}
				break;
			#.获取厂家认证列表
			case 3:
				if($type==1){
					$query=$this->db->query("SELECT 			A.*,
																							B.name 												    AS parentName,
																							B.isCompany										    AS company,
																							C.name 													AS providerName
																	 FROM   			cada_provider_certification 					AS  A
																							LEFT JOIN cada_merchant_info   	    AS  B   ON B.id=A.pId
																							LEFT JOIN cada_merchant_info			AS  C   ON C.id=A.providerId
																	 WHERE      	A.status=1  											AND
																							A.pId=".$id."
																	 ORDER  BY    A.".$order."  ".$desc."
																	 LIMIT				 ".$open.",".$last);
					return $query->result_array();
				}else{
					$query=$this->db->query("SELECT * FROM  cada_provider_certification  WHERE status=1 AND pId=".$id);
					return $query->num_rows();
				}
				break;
		}
	/**检测商户名称*/
	public function getCertification($title,$id){
		$query=$this->db->query("SELECT 			A.id,
																				A.pId,
																				A.providerId
														 FROM   			cada_provider_certification 					AS  A
																				LEFT JOIN cada_merchant_info   	    AS  B   ON B.id=A.pId
																				LEFT JOIN cada_merchant_info			AS  C   ON C.id=A.providerId
														 WHERE      	A.status=1  											AND
																				B.status=1												AND 
																				C.status=1												AND 
																				B.name='".$title."'								    AND  
																				A.providerId=".$id);
		return $query->result_array();
	}
	/**检测商户是否有认证*/
	public function getCertificationProvider($id,$iscompany){
		$query=$this->db->query("SELECT 			A.id,
																				A.pId,
																				A.providerId
														 FROM   			cada_provider_certification 					AS  A
																				LEFT JOIN cada_merchant_info   	    AS  B   ON B.id=A.pId
																				LEFT JOIN cada_merchant_info			AS  C   ON C.id=A.providerId
														 WHERE      	A.status=1  											AND
																				B.status=1												AND
																				C.status=1												AND
																				A.certificationStatus<>2                      AND 
																				A.providerId=".$id."                               AND
																				B.isCompany=".$iscompany);
		return $query->result_array();
	}
	/**检测商户是否有认证*/
	public function getProvider($name){
		$query=$this->db->query("SELECT id,name,isCompany  FROM cada_merchant_info WHERE name='".$name."'");
		$list=$query->result_array();
		return $list[0];
	}
	/**搜索门店认证列表*/
	public function getSearch($type=1,$isCompany,$title,$id){
		switch ($isCompany){
			#.获取集团认证列表
			case 0:
					$query=$this->db->query("SELECT 			A.*,
																							C.isCompany										    AS company,
																							B.name 												    AS parentName,
																							C.name 													AS providerName
																	 FROM   			cada_provider_certification 					AS  A
																							LEFT JOIN cada_merchant_info   	    AS  B   ON B.id=A.pId
																							LEFT JOIN cada_merchant_info			AS  C   ON C.id=A.providerId
																	 WHERE      	A.status=1  											AND
																							A.pId=".$id."											AND ".(!empty($title)?" 	C.name='".$title."'":" A.id<>0"));
					return $type==1?$query->result_array():$query->num_rows();
				break;
				#.获取门店认证列表
			case 1:
					$query=$this->db->query("SELECT 			A.*,
																							B.name 												    AS parentName,
																							B.isCompany										    AS company,
																							C.name 													AS providerName
																	 FROM   			cada_provider_certification 					AS  A
																							LEFT JOIN cada_merchant_info   	    AS  B   ON B.id=A.pId
																							LEFT JOIN cada_merchant_info			AS  C   ON C.id=A.providerId
																	 WHERE      	A.status=1  											AND
																							A.providerId=".$id."								AND ".(!empty($title)?" 	B.name='".$title."'":" A.id<>0"));
					return $type==1?$query->result_array():$query->num_rows();
				break;
				#.获取厂家认证列表
			case 3:
					$query=$this->db->query("SELECT 			A.*,
																							B.name 												    AS parentName,
																							B.isCompany										    AS company,
																							C.name 													AS providerName
																	 FROM   			cada_provider_certification 					AS  A
																							LEFT JOIN cada_merchant_info   	    AS  B   ON B.id=A.pId
																							LEFT JOIN cada_merchant_info			AS  C   ON C.id=A.providerId
																	 WHERE      	A.status=1  											AND
																							A.pId=".$id."											AND ".(!empty($title)?" 	C.name='".$title."'":" A.id<>0"));
			    return $type==1?$query->result_array():$query->num_rows();
				break;
		}
	}
	/**暂无更改*/
}