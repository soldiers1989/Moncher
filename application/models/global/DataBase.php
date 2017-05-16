<?php
require_once (dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class DataBase extends CI_Model {
	/*****************************************************
     **作者：张文晓
	 **创始时间：2017-01-05
	 **描述：数据库基础类，包含常规的插入，删除
	 *				修改，获取一条记录操作。
	*****************************************************/
	#.数据表结构数组
	private $tableArray=array(NULL,
													'cada_admin', #.1-管理员表
													'cada_admin_roles',#.2.权限角色表
													'cada_admin_roles2',#.3.权限角色明细表
													'cada_admin_navs',#.4.导航表
													'cada_hover_log',#.5.操作日志表
													'cada_system_log',#.6.系统日志表
													'cada_message',#.7.系统消息表
													'cada_provider_feedback',#.8.商户反馈表
													'cada_car_info',#.9.汽车品牌表
													'cada_area',#.10.平台区域表
													'cada_parameter',#.11.系统参数表
													'cada_dictioncry',#.12.字典表
													'cada_merchant_info',#.13.商户信息表
													'cada_question_bank',#.14.题库表
													'cada_question_bank_answer',#.15.题库答案表
													'cada_questionnaire',#.16.问卷表
													'cada_questionnaire_info',#.17.问卷明细表
													'cada_results_question_bank',#.18.结果题库表
													'cada_results_answer',#.19.结果答案表
													'cada_results_questionnaire',#.20结果.问卷表
													'cada_provider_admin', #.21-商户管理员表
													'cada_provider_admin_roles',#.22.商户权限角色表
													'cada_provider_admin_roles2',#.23.商户权限角色明细表
													'cada_provider_admin_navs',#.24.商户导航表
													'cada_provider_report_download',#.25.商户报告下载表
													'cada_provider_certification',#.26.商户认证表
													'cada_model',#.27.调研模型表
													'cada_module',#.28.调研模块表
													'cada_persons',#.29.车主信息表
													'cada_skin',#.30.多媒体皮肤表
													'cada_strategy',#.31.调研策略表
													'cada_activities',#.32.调研活动表
											);
		/**
	 ***********************************************************
	 *方法::DataBase::__construct
	 * ----------------------------------------------------------
	 * 描述::数据基础类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm:in--   无
	 *----------------------------------------------------------
	 *返回：
	 *return:out-- 无
	 * ----------------------------------------------------------
	 * 日期:2017.01.05  Add by zwx
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**
	 ***********************************************************
	 *方法::DataBase::insert
	 * ----------------------------------------------------------
	 * 描述::数据表插入数据方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : index :: 数据表编号
	 *parm2:in--   Array  : data   :: 插入的数据数组
	 *----------------------------------------------------------
	 *返回：
	 *return:out-- int : id             ::插入数据的id
	 * ----------------------------------------------------------
	 *示例:
	 *case1:use--  insert(1,array("token"=>"ASDFGHJKL"))
	 *----------------------------------------------------------
	 * 日期:2017.01.05  Add by zwx
	 ************************************************************
	 */
	function insert($index=0,$data=array()){
		try{
			$this->db->insert($this->tableArray[$index],$data);
			return $this->db->insert_id();
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	/**
	 ***********************************************************
	 *方法::DataBase::delete
	 * ----------------------------------------------------------
	 * 描述::数据表删除数据方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : index  :: 数据表编号
	 *parm2:in--   Array  : where :: 需要删除的条件
	 *----------------------------------------------------------
	 *返回：
	 *return:out-- int : rows :: 处理的结果条数
	 * ----------------------------------------------------------	 
	 *示例:
	 *case1:use--   delete(1,12)  
	 *case2:use--   delete(1,array("token"=>"ASDFGHJKL")) 
	 *----------------------------------------------------------
	 * 日期:2017.01.05  Add by zwx
	 ************************************************************
	 */
	/*
	 * 
	 * 
	 * 
	 * */
	function delete($index=0,$where=array()){
		try{
			$this->db->where(is_array($where)?$where:array("id"=>$where));
			$this->db->update($this->tableArray[$index],array("status"=>2));
			return $this->db->affected_rows();
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	} 	
	/**
	 ***********************************************************
	 *方法::DataBase::update
	 * ----------------------------------------------------------
	 * 描述::数据表更新方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : index  :: 数据表编号
	 *parm2:in--   Array  : where :: 更新条件
	 *parm3:in--   Array  : data    :: 需要更新的数据数组
	 *----------------------------------------------------------
	 *返回：
	 *return:out-- int : rows :: 处理结果行
	 * ----------------------------------------------------------
	 *示例:
	 *case1:use--   update(1,12,array("name"=>"zwx"))  
	 *case2:use--   update(1,array("token"=>"ASDFGHJKL"),array("name"=>"zwx")) 
	 *----------------------------------------------------------
	 * 日期:2017.01.05  Add by zwx
	 ************************************************************
	 */
	function update($index=0,$where=array(),$data=array()){
		try{
			$this->db->where(is_array($where)?$where:array("id"=>$where));
			$this->db->update($this->tableArray[$index],$data);
			return  $this->db->affected_rows();
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	/**
	 ***********************************************************
	 *方法::DataBase::select
	 * ----------------------------------------------------------
	 * 描述::数据表查找获取数据的方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : index  :: 数据表编号
	 *parm2:in--   Array  : where :: 需要查询的条件
	 *----------------------------------------------------------
	 *返回：
	 *return:out-- Array : result  :: 查询处理的结果集
	 *----------------------------------------------------------
	 *示例:
	 *case1:use--   selete(1,12)  
	 *case2:use--   selete(1,array("token"=>"ASDFGHJKL")) 
	 *----------------------------------------------------------
	 * 日期:2017.01.05  Add by zwx
	 ************************************************************
	 */
	function select($index=0,$where=array()){
		try{
			$result=$this->db->get_where($this->tableArray[$index],is_array($where)?$where:array("id"=>$where));
			return $result->result_array();
		}catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	/**
	 ***********************************************************
	 *方法::DataBase::getColumn
	 * ----------------------------------------------------------
	 * 描述::数据表获取一个表的所有字段名称
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : index  :: 数据表编号
	 *----------------------------------------------------------
	 *返回：
	 *return:out-- Array : result  :: 查询处理的结果集
	 *----------------------------------------------------------
	 *示例:
	 *case1:use--   getColumn(1)
	 *----------------------------------------------------------
	 * 日期:2017.01.06  Add by zwx
	 ************************************************************
	 */
    function getColumn($index=0){
    	try{
    		$result=$this->db->query("SEELCT  column_name AS column
	    												    FROM    information_schema.columns
	    											       WHERE   table_name='".$this->tableArray[$index]."'");
    		return $result->result_array();
    	}catch(Exception $e) {
    		echo $e->getMessage();
    	}
    }
}