<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class MouldModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::MouldModel::__construct
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
	 * 日期:2017.02.04  Add by hjm
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * 模型管理-添加模型-search
	 * 参数：
	 *parm1:in--   String : $select所要查询的条件语句
	 * 日期:2017.02.24  Add by hjm
	 */
	public function getMouldSearch($select){
		$list=$this->db->query($select)->result_array();
		return $list;
	}
	/**
	 * 模型管理-模型列表-data&分页
	 * 参数：
	  *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束 
	 *parm4:in--    String :: order :: 排序字段
	 *parm4:in--    String :: desc   ::正序 OR 倒序
	 * 日期:2017.03.15  Add by hjm
	 */
	public function getModelList($type=1,$open=0,$last=10,$order='id',$desc='DESC'){
		if($type==1){
			$query=$this->db->query(
					"SELECT   *  FROM  cada_model  
					WHERE    status<>2
				ORDER BY  ".$order." ".$desc."
					LIMIT     ".$open.",".$last
					);
			//echo $this->db->last_query();
			return $query->result_array();
		}else{
			
			return $query->result_array();
		}
	}
	/**
	 * 模型管理-模块列表
	 * 参数：
	 * 日期:2017.02.24  Add by hjm
	 */
	public function getModelblockList($type=1,$open=0,$last=10,$order='id',$desc='DESC'){
		if($type==1){
			$query=$this->db->query(
					"SELECT   *  FROM  cada_module
					WHERE    status<>2
				ORDER BY  ".$order." ".$desc."
					LIMIT     ".$open.",".$last
			);
			//echo $this->db->last_query();
			return $query->result_array();
		}else{
				
			return $query->result_array();
		}
	}
	/**
	 * 模型管理-添加模块-search
	 * 参数：
	 *parm1:in--   String : $select所要查询的条件语句
	 * 日期:2017.02.24  Add by hjm
	 */
	public function getBlockSearch($select){
		$list=$this->db->query($select)->result_array();
		return $list;
	}
}






