<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class QuestionModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::QuestionModel::__construct
	 * ----------------------------------------------------------
	 * 描述::数据库基础类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.02.03  Add by hjm
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**
	 ***********************************************************
	 *方法::QuestionModel::getprovider
	 * ----------------------------------------------------------
	 * 描述::问卷管理-题库管理-列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.02.07  Add by hjm
	 ************************************************************
	 */
	public function getProviderNum(){
		$list=$this->db->query("SELECT  COUNT(1)  AS num  FROM cada_merchant_info")->result_array();
		return $list;	
	}
	/**
	 * 问卷管理-试题-查询
	 * 参数：
	 *parm1:in--   String : $select所要查询的条件语句
	 * 日期:2017.02.13  Add by hjm
	 */
	public function getQuestionSearch($select){
		$list=$this->db->query($select)->result_array();
		return $list;
	}
	/**
	 * 问卷管理-试题-查询
	 * 参数：
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束 
	 *parm4:in--    String :: order :: 排序字段
	 *parm4:in--    String :: desc   ::正序 OR 倒序
	 * 日期:2017.02.13  Add by hjm
	 */
	public function getQuestionList($type=1,$open=0,$last=10,$order='ID',$desc='DESC'){
		if($type==1){
			$query=$this->db->query("SELECT 			*
															 FROM   			cada_question_bank
															 WHERE      	status<>2
															 ORDER  BY    ".$order."  ".$desc."
															 LIMIT				".$open.",".$last);
			return $query->result_array();
		}else{
			$query=$this->db->query('SELECT * FROM cada_question_bank WHERE status=1');
			return $query->num_rows();
		}
	}
	/**获取一个试题的权重*/
	public function findQuestionWeight($type,$id){
		$sql="";
		if($type==1||$type==4){
			$sql="SELECT IFNULL(MAX(weight),0) AS weight FROM cada_question_bank_answer  WHERE status=1 AND questionId=".$id."  GROUP BY questionId";
		}else if($type==2){
			$sql="SELECT IFNULL(SUM(weight),0) AS weight FROM cada_question_bank_answer  WHERE status=1 AND questionId=".$id."  GROUP BY questionId";
		}else{
			return 0;
		}
		$query=$this->db->query($sql);
		$list=$query->result_array();
		return count($list)>0?$list[0]['weight']:0;
	}
}