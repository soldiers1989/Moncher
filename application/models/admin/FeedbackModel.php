<?php
/*****************************************************
**作者：张文晓
**创始时间：2017-03-01
**描述：平台意见反馈Model类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/system/core/Model.php");class FeedbackModel extends CI_Model {/** *********************************************************** *方法::FeedbackModel::__construct * ---------------------------------------------------------- * 描述::初始化方法 *---------------------------------------------------------- *参数: *parm2:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- * 日期:2017.03.01   Add by zwx ************************************************************ */function __construct(){    parent::__construct();    $this->load->database();}
/** *********************************************************** *方法::FeedbackModel::getAreaList * ---------------------------------------------------------- * 描述::获取列表分页及数量方法 *---------------------------------------------------------- *参数: *parm1:in--    String :: type ::获取数量 OR 结果 *parm2:in--    String :: open :: 分页起始 *parm3:in--    String :: last    :: 分页结束  *parm4:in--    String :: order :: 排序字段 *parm4:in--    String :: desc   ::正序 OR 倒序 *---------------------------------------------------------- *返回： *return:out1--  Int :: rows      :: 获取数量 *return:out2--  Array::query  :: 获取结果数组 * ---------------------------------------------------------- * 日期:2017.03.01  Add by zwx ************************************************************ */
public function getFeedbackList($type=1,$open=0,$last=20,$order="id",$desc="DESC"){	if($type==1){		$query=$this->db->query("SELECT 			A.id,
																				A.title,
																				A.tel,
																				A.feedbackTime,
																				A.replyTime,
																				A.operatorName,
																				A.operationTime,
																				CASE A.feedbackType 
																						  WHEN	  1 	THEN 		 '平台操作'
																						  WHEN     2    THEN       '分析类别'
																						   ELSE  '其他' END					AS   feedbackType,
																				CASE A.satisfaction
																						  WHEN     1     THEN       '满意'
																						  WHEN     2     THEN        '非常满意'
																						  WHEN     3     THEN		    '不满意'
																						   ELSE   '其他' END                   AS    satisfaction,
																				CASE A.ProcessingStatus
																						  WHEN      1    THEN       '待处理'
																						  WHEN      2    THEN       '处理中'
																						  WHEN      3    THEN       '已处理'
																						  WHEN      4    THEN       '已忽略'
																						  ELSE    '其他'  END                    AS  status,
																				CASE A.type
																						  WHEN		1    THEN		'商户端'
																						  WHEN       2    THEN        '采集端'
																						  ELSE     '其他' END                     AS type,
																			    CASE  WHEN LENGTH(B.name)>0    THEN B.name	ELSE '商户' END	AS provider															 FROM   			cada_provider_feedback   					AS A
																				LEFT JOIN cada_merchant_info           AS B  ON B.id=A.providerId  														 WHERE      	A.status=1  														 ORDER  BY    ".$order."  ".$desc."															 LIMIT				".$open.",".$last);		return $query->result_array();	}else{		$query=$this->db->query("SELECT * FROM  cada_provider_feedback  WHERE status=1");		return $query->num_rows();	}}
/**商户搜索方法*/
public function getSearch($type=1,$name,$status,$types,$startFeedDate,$lastFeedDate,$startReplyDate,$lastReplyDate,$baseType,$satisfaction,$operatorName,$open=0,$last=20){
	$sql="SELECT 			A.id,
										A.title,
										A.tel,
										A.feedbackTime,
										A.replyTime,
										A.operatorName,
										A.operationTime,
										CASE A.feedbackType 
												  WHEN	  1 	THEN 		 '平台操作'
												  WHEN     2    THEN       '分析类别'
												   ELSE  '其他' END					AS   feedbackType,
										CASE A.satisfaction
												  WHEN     1     THEN       '满意'
												  WHEN     2     THEN        '非常满意'
												  WHEN     3     THEN		    '不满意'
												   ELSE   '其他' END                   AS    satisfaction,
										CASE A.ProcessingStatus
												  WHEN      1    THEN       '待处理'
												  WHEN      2    THEN       '处理中'
												  WHEN      3    THEN       '已处理'
												  WHEN      4    THEN       '已忽略'
												  ELSE    '其他'  END                    AS  status,
										CASE A.type
												  WHEN		1    THEN		'商户端'
												  WHEN       2    THEN        '采集端'
												  ELSE     '其他' END                     AS type,
									    CASE  WHEN LENGTH(B.name)>0    THEN B.name	ELSE '商户' END	AS provider	
				 FROM   			cada_provider_feedback   					AS A
										LEFT JOIN cada_merchant_info           AS B  ON B.id=A.providerId  
				 WHERE      	A.status=1  ";
	!empty($name) && $sql.=" 	AND  B.name='".$name."'";
	!empty($status) && $sql.="	AND  A.ProcessingStatus=".$status;
	!empty($types)  && $sql.="	AND 	A.feedbackType=".$types;
	!empty($baseType) && $sql.="		AND  A.type=".$baseType;
	!empty($satisfaction) && $sql.="		AND A.satisfaction=".$satisfaction;
	!empty($operatorName) && $sql.="		AND  A.operatorName='".$operatorName."'";
	if((!empty($startFeedDate) && !empty($lastFeedDate))){
		strtotime($startDate)<=strtotime($lastDate) ? $sql.=" AND   feedbackTime IS NOT NULL    AND  feedbackTime     BETWEEN  '".$startFeedDate." 00:00:00' AND '".$lastFeedDate."  23:59:59'":
		$sql.=" AND   feedbackTime IS NOT NULL    AND  feedbackTime   BETWEEN  '".$lastPublicDate." 00:00:00' AND '".$startPublicDate."  23:59:59'";
	}
	if((!empty($startReplyDate) && !empty($lastReplyDate))){
		strtotime($startDate)<=strtotime($lastDate) ? $sql.=" AND   replyTime IS NOT NULL AND    replyTime    BETWEEN  '".$startPushDate." 00:00:00' AND '".$lastPushDate."  23:59:59'":
		$sql.=" AND   replyTime IS NOT NULL         AND   replyTime    BETWEEN  '".$lastPushDate." 00:00:00' AND '".$startPushDate."  23:59:59'";
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