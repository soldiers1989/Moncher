<?php
/*****************************************************
**作者：张文晓
**创始时间：2017-03-01
**描述：平台系统消息Model类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/system/core/Model.php");class MessagesModel extends CI_Model {/** *********************************************************** *方法::MessagesModel::__construct * ---------------------------------------------------------- * 描述::初始化方法 *---------------------------------------------------------- *参数: *parm2:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- * 日期:2017.03.01   Add by zwx ************************************************************ */function __construct(){    parent::__construct();    $this->load->database();}
/** *********************************************************** *方法::MessagesModel::getAreaList * ---------------------------------------------------------- * 描述::获取列表分页及数量方法 *---------------------------------------------------------- *参数: *parm1:in--    String :: type ::获取数量 OR 结果 *parm2:in--    String :: open :: 分页起始 *parm3:in--    String :: last    :: 分页结束  *parm4:in--    String :: order :: 排序字段 *parm4:in--    String :: desc   ::正序 OR 倒序 *---------------------------------------------------------- *返回： *return:out1--  Int :: rows      :: 获取数量 *return:out2--  Array::query  :: 获取结果数组 * ---------------------------------------------------------- * 日期:2017.03.01  Add by zwx ************************************************************ */
public function getMessagesList($type=1,$open=0,$last=20,$order="id",$desc="DESC"){	if($type==1){		$query=$this->db->query("SELECT        A.id,
																			  A.title,
																			  CASE  WHEN  LENGTH(B.name)>0   THEN   B.name ELSE '全部区域'  END AS area,
																			  CASE  WHEN  LENGTH(C.name)>0   THEN   C.name ELSE '全部品牌'  END AS brand,
																			  CASE  WHEN  LENGTH(D.name)>0   THEN   D.name ELSE '全体商户'  END AS provider,
																			  CASE  A.mark 
																						 WHEN 1   									THEN  '未读'
																						 WHEN 2										THEN  '已读'
																						 ELSE    '未知'							END     														 AS  mark,
																			  CASE   A.type	
																						 WHEN 1										THEN '系统消息'
																						 WHEN 2										THEN  '公告' 
																						 WHEN 3                                     THEN  '平台消息'					
																						 ELSE    '未知'							 END														     AS type,
																		     A.publicDate,
																			 A.pushTime,
																			 A.operatorName,
																			 A.operationTime
															FROM     cada_message 																											 AS A 
																			LEFT JOIN cada_area              																					 AS B   ON B.id=A.areaId
																			LEFT JOIN cada_car_info         																				     AS C   ON C.id=A.brandId
																			LEFT JOIN cada_merchant_info  																			      AS D  ON D.id=A.groupId
														  WHERE      A.status=1  														 ORDER  BY    ".$order."  ".$desc."															 LIMIT				".$open.",".$last);		return $query->result_array();	}else{		$query=$this->db->query("SELECT * FROM  cada_message  WHERE status=1");		return $query->num_rows();	}}
/**系统消息搜索方法*/
public function getSearch($type=1,$name,$types,$mark,$startPublicDate,$lastPublicDate,$startPushDate,$lastPushDate,$areaId,$brandId,$operatorName,$open=0,$last=20){
	$sql="SELECT  A.id,
							  A.title,
							  CASE  WHEN  LENGTH(B.name)>0   THEN   B.name ELSE '全部区域'  END AS area,
							  CASE  WHEN  LENGTH(C.name)>0   THEN   C.name ELSE '全部品牌'  END AS brand,
							  CASE  WHEN  LENGTH(D.name)>0   THEN   D.name ELSE '全体商户'  END AS provider,
							  CASE  A.mark 
										 WHEN 1   									THEN  '未读'
										 WHEN 2										THEN  '已读'
										 ELSE    '未知'							END     														 AS  mark,
							  CASE   A.type	
										 WHEN 1										THEN '系统消息'
										 WHEN 2										THEN  '公告' 
										 WHEN 3                                     THEN  '平台消息'					
										 ELSE    '未知'							 END														     AS type,
						     A.publicDate,
							 A.pushTime,
							 A.operatorName,
							 A.operationTime
			FROM     cada_message 																											 AS A 
							LEFT JOIN cada_area              																					 AS B   ON B.id=A.areaId
							LEFT JOIN cada_car_info         																				     AS C   ON C.id=A.brandId
							LEFT JOIN cada_merchant_info  																			      AS D  ON D.id=A.groupId
		  WHERE    A.status=1		";
	!empty($name) && $sql.="	AND	D.name='".$name."'";
	!empty($types) && $sql.="	AND    A.type=".$types;
	!empty($mark) && $sql.="	AND    A.mark=".$mark;
	!empty($areaId) && $sql.="	 AND   A.areaId=".$areaId;
	!empty($brandId) && $sql.="  AND A.brandId=".$brandId;
	!empty($operatorName) && $sql.=" AND A.operatorName='".$operatorName."'";
	date_default_timezone_set('PRC');
	if((!empty($startPublicDate) && !empty($lastPublicDate))){
		strtotime($startDate)<=strtotime($lastDate) ? $sql.=" AND   publicDate   BETWEEN  '".$startPublicDate." 00:00:00' AND '".$lastPublicDate."  23:59:59'":
		$sql.=" AND   publicDate   BETWEEN  '".$lastPublicDate." 00:00:00' AND '".$startPublicDate."  23:59:59'";
	}
	if((!empty($startPushDate) && !empty($lastPushDate))){
		strtotime($startDate)<=strtotime($lastDate) ? $sql.=" AND   pushTime   BETWEEN  '".$startPushDate." 00:00:00' AND '".$lastPushDate."  23:59:59'":
		$sql.=" AND   pushTime   BETWEEN  '".$lastPushDate." 00:00:00' AND '".$startPushDate."  23:59:59'";
	}
	
	#.请求数据或者获取数量
   if($type==1){
		$sql.="	ORDER BY A.id DESC  ";
		$sql.="    LIMIT	".$open.",".$last;
		$query=$this->db->query($sql);
		return $query->result_array();
	}else{
		$query=$this->db->query($sql);
		return $query->num_rows();
	}
}
}