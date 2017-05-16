<?php 
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：菜单管理MODEL类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class MenuModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::MenuModel::__construct
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
	 *方法::MenuModel::getMenuList
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束 
	 *parm4:in--    String :: order :: 排序字段
	 *parm5:in--    String :: desc   ::正序 OR 倒序
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function getMenuList($type=1,$Pid=0,$open=0,$last=20,$order='id',$desc='DESC'){
		if($type==1){
			$query=$this->db->query("SELECT 			*
															 FROM   			cada_admin_navs
															 WHERE      	status=1 	   AND 
																					pId=".$Pid."			
															 ORDER  BY    ".$order."  ".$desc."
															 LIMIT				".$open.",".$last);
			return $query->result_array();
		}else{
			$query=$this->db->query('SELECT * FROM cada_admin_navs WHERE status=1 AND pId='.$Pid);
			return $query->num_rows();
		}
	}
	/**
	 ***********************************************************
	 *方法::MenuModel::getSearchList
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束
	 *parm4:in--    String :: Pid    :: 父级id
	 *parm5:in--    String :: navTitle   ::导航标题
	 *parm6:in--    String :: startDate ::起始时间
	 *parm7:in--    String :: lastDate   ::结束时间
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function getSearch($type=1,$Pid,$navTitle,$startDate,$lastDate,$open=0,$last=20){
		date_default_timezone_set('PRC');
		$sql="SELECT 			*
				    FROM				cada_admin_navs
					WHERE			status=1			 ";
		$sql.=" 	AND  ".(empty($Pid)?" pId>0 	":"	pId=".($Pid!=1?$Pid:0));
		!empty($navTitle)		&& $sql.=" 	AND 	navTitle='".$navTitle."'";
		if((!empty($startDate) && !empty($lastDate))){
			strtotime($startDate)<=strtotime($lastDate) ? $sql.=" AND   operationTime   BETWEEN  '".$startDate." 00:00:00' AND '".$lastDate."  23:59:59'":
			$sql.=" AND   operationTime   BETWEEN  '".$lastDate." 00:00:00' AND '".$startDate."  23:59:59'";
		}
		if($type==1){
			$sql.="	ORDER BY id DESC ";
			$sql.="    LIMIT	".$open.",".$last;
			$query=$this->db->query($sql);
			return $query->result_array();
		}else{
			$query=$this->db->query($sql);
			return $query->num_rows();
		}
	}
}