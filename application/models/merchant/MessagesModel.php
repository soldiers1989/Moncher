<?php
/*****************************************************
**作者：张文晓
**创始时间：2017-02-28
**描述：商户端系统消息Model类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/system/core/Model.php");class MessagesModel extends CI_Model {	/**	 ***********************************************************	 *方法::MessagesModel::__construct	 * ----------------------------------------------------------	 * 描述::初始化方法	 *----------------------------------------------------------	 *参数:	 *parm2:in--    无	 *----------------------------------------------------------	 *返回：	 *return:out--  无	 * ----------------------------------------------------------	 * 日期:2017.02.28   Add by zwx	 ************************************************************	 */	function __construct(){		parent::__construct();		$this->load->database();	}
	/**	 ***********************************************************	 *方法::MessagesModel::getAreaList	 * ----------------------------------------------------------	 * 描述::获取列表分页及数量方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    String :: type ::获取数量 OR 结果	 *parm2:in--    String :: open :: 分页起始	 *parm3:in--    String :: last    :: 分页结束 	 *parm4:in--    String :: order :: 排序字段	 *parm4:in--    String :: desc   ::正序 OR 倒序	 *----------------------------------------------------------	 *返回：	 *return:out1--  Int :: rows      :: 获取数量	 *return:out2--  Array::query  :: 获取结果数组	 * ----------------------------------------------------------	 * 日期:2017.02.28  Add by zwx	 ************************************************************	 */
	public function getMessagesList($type=1,$providerId,$open=0,$last=20,$order="id",$desc="DESC"){
		$sql="SELECT X.*
						FROM (SELECT  A.id,
										A.title,
										A.publicDate,
										A.pushTime,
									  A.notes,
										A.areaId,
										CASE A.mark 
												 WHEN 1   							THEN  '未读'
												 WHEN 2							    THEN  '已读'
												 ELSE    '未知'					END     	      AS  mark,
										CASE A.type	
												 WHEN 1								  THEN '系统消息'
												 WHEN 2								  THEN  '公告' 
												 WHEN 3                                   THEN  '平台消息'					
												 ELSE    '未知'					END							AS type
						FROM    cada_message 									  						AS						A 
						WHERE   A.status=1 AND A.areaId=0 AND A.brandId=0 AND A.groupId=0
						UNION 	ALL 
						SELECT  A.id,
										A.title,
										A.publicDate,
										A.pushTime,
									  A.notes,
										A.areaId,
										CASE A.mark 
												 WHEN 1   							THEN  '未读'
												 WHEN 2							    THEN  '已读'
												 ELSE    '未知'					END     	      	AS  mark,
										CASE A.type	
												 WHEN 1								  THEN '系统消息'
												 WHEN 2								  THEN  '公告' 
												 WHEN 3                                   THEN  '平台消息'					
												 ELSE    '未知'							   END				AS type
						FROM    cada_message 									  							AS						A 
						WHERE   A.status=1 AND A.areaId IN (SELECT areaId FROM cada_merchant_info WHERE id=".$providerId.")
						UNION 	ALL 
						SELECT  A.id,
										A.title,
										A.publicDate,
										A.pushTime,
									  A.notes,
										A.areaId,
										CASE A.mark 
												 WHEN 1   							THEN  '未读'
												 WHEN 2							    THEN  '已读'
												 ELSE    '未知'					END     	      	AS  mark,
										CASE A.type	
												 WHEN 1								  THEN '系统消息'
												 WHEN 2								  THEN  '公告' 
												 WHEN 3                                   THEN  '平台消息'					
												 ELSE    '未知'							   END				AS type
						FROM    cada_message 									  							AS						A 
						WHERE   A.status=1 AND A.groupId=2
						UNION 	ALL 
						SELECT  A.id,
										A.title,
										A.publicDate,
										A.pushTime,
									  A.notes,
										A.areaId,
										CASE A.mark 
												 WHEN 1   							THEN  '未读'
												 WHEN 2							    THEN  '已读'
												 ELSE    '未知'					END     	      	AS  mark,
										CASE A.type	
												 WHEN 1								  THEN '系统消息'
												 WHEN 2								  THEN  '公告' 
												 WHEN 3                                   THEN  '平台消息'					
												 ELSE    '未知'							   END				AS type
						FROM    cada_message 									  							AS						A 
						WHERE   A.status=1 AND A.brandId IN (SELECT brandId1 FROM cada_merchant_info WHERE id=".$providerId.")
						UNION 	ALL 
						SELECT  A.id,
										A.title,
										A.publicDate,
										A.pushTime,
									  A.notes,
										A.areaId,
										CASE A.mark 
												 WHEN 1   							THEN  '未读'
												 WHEN 2							    THEN  '已读'
												 ELSE    '未知'					END     	      	AS  mark,
										CASE A.type	
												 WHEN 1								  THEN '系统消息'
												 WHEN 2								  THEN  '公告' 
												 WHEN 3                                   THEN  '平台消息'					
												 ELSE    '未知'							   END				AS type
						FROM   cada_message 									  							AS						A 
						WHERE  A.status=1 AND A.brandId IN (SELECT R.parentId FROM cada_merchant_info M LEFT JOIN cada_area R ON R.id=M.areaId WHERE M.id=".$providerId." AND R.parentId<>0)) X ";		if($type==1){			$sql.=" ORDER  BY    X.".$order."  ".$desc."	LIMIT	 ".$open.",".$last;
			$query=$this->db->query($sql);			return $query->result_array();		}else{			$query=$this->db->query($sql);			return $query->num_rows();		}	}
		/**
	 ***********************************************************
	 *方法::MessagesModel::getSearch
	 * ----------------------------------------------------------
	 * 描述::获取系统消息搜索方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.28  Add by zwx
	 ************************************************************
	 */
	public function getSearch($type=1,$providerId,$types,$mark,$startPublicDate,$lastPublicDate,$startPushDate,$lastPushDate,$open=0,$last=20){
		$sql="SELECT A.id,
								  A.title,
								  A.publicDate,
								  A.pushTime,
								  CASE  A.mark 
											 WHEN 1   							    THEN  '未读'
											 WHEN 2							    THEN  '已读'
											 ELSE    '未知'							END     	      AS  mark,
								  CASE   A.type	
											 WHEN 1								   THEN '系统消息'
											 WHEN 2								   THEN  '公告' 
											 WHEN 3                                   THEN  '平台消息'					
											 ELSE    '未知'							   END				AS type
					FROM   cada_message 									AS				A 
								  LEFT JOIN cada_merchant_info			AS               B 		ON B.id=A.groupId
								  LEFT JOIN cada_area							AS               C      ON C.id=B.areaId
					WHERE  (A.groupId=".$providerId."			    OR 
								   A.brandId=B.brandId1			OR
								   C.parentId=A.areaId							OR 
								   (A.areaId=0	   AND		A.groupId=0 AND		A.brandId=0)) 	AND
								   A.status=1";
		!empty($types) && $sql.="		AND	A.type=".$types;
		!empty($mark) && $sql.="		AND    A.mark=".$mark;
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