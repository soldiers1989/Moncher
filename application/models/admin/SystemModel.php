<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：系统日志管理MODEL类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class SystemModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::SystemModel::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**
	 ***********************************************************
	 *方法::SystemModel::getSystemList
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束 
	 *parm4:in--    String :: order :: 排序字段
	 *parm4:in--    String :: desc   ::正序 OR 倒序
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function getSystemList($type=1,$open=0,$last=100,$order='id',$desc='DESC'){
		if($type==1){
			$query=$this->db->query("SELECT 			*
															 FROM   			cada_system_log
															 WHERE      	status=1
															 ORDER  BY    ".$order."  ".$desc."
															 LIMIT				".$open.",".$last);
			return $query->result_array();
		}else{
			$query=$this->db->query('SELECT * FROM cada_system_log WHERE status=1');
			return $query->num_rows();
		}
	}
	/**
	 ***********************************************************
	 *方法::SystemModel::getSearch
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: logType :: 分页起始
	 *parm3:in--    String :: operationType :: 分页结束
	 *parm4:in--    String :: operatorName  :: 排序字段
	 *parm4:in--    String :: startDate   ::开始时间
	 *parm5:in--    String :: lastDate     ::结束时间
	 *parm6:in--    String :: open 		  :: 分页起始
	 *parm7:in--    String :: last    	      :: 分页结束
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function getSearch($type,$logType,$operationType,$operatorName,$startDate,$lastDate,$open=0,$last=100){
		date_default_timezone_set('PRC');
		$sql="SELECT 			*
				    FROM				cada_system_log
					WHERE			status=1			 ";
		!empty($logType) 				&& $sql.=" 	AND 	type=".$logType;
		!empty($operationType)		&& $sql.=" 	AND 	operationType=".$operationType ;
		!empty($operationName) 	&& $sql.=" 	AND 	operatorName='".$operatorName."'";
		if((!empty($startDate) && !empty($lastDate))){
			strtotime($startDate)<=strtotime($lastDate) ? $sql.=" AND   operationTime   BETWEEN  '".$startDate." 00:00:00' AND '".$lastDate."  23:59:59'":
																						    $sql.=" AND   operationTime   BETWEEN  '".$lastDate." 00:00:00' AND '".$startDate."  23:59:59'";
		}
		if($type==1){
			$sql.="	ORDER BY id DESC  ";
			$sql.="    LIMIT	".$open.",".$last;
			$query=$this->db->query($sql);
			return $query->result_array();
		}else{
			$query=$this->db->query($sql);
			return $query->num_rows();
		}
	}
}