<?php 
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：系统参数管理MODEL类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class ParameterModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::ParameterModel::__construct
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
	 *方法::ParamModel::getParamList
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
	public function getParamList($type=1,$open=0,$last=20,$order='id',$desc='DESC'){
		if($type==1){
			$query=$this->db->query("SELECT 			*
															 FROM   			cada_parameter
															 WHERE      	status=1
															 ORDER  BY    ".$order."  ".$desc."
															 LIMIT				".$open.",".$last);
			return $query->result_array();
		}else{
			$query=$this->db->query('SELECT * FROM cada_parameter WHERE status=1');
			return $query->num_rows();
		}
	}
	public function getSearch(){
		
	}
}