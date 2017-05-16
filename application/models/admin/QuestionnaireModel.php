<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class QuestionnaireModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::QuestionnaireModel::__construct
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
	 * 日期:2017.02.10  Add by hjm
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**
	 ***********************************************************
	 *方法::QuestionnaireModel::getprovider
	 * ----------------------------------------------------------
	 * 描述::问卷管理-问卷管理-修改
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : $id 问卷id
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2017.02.10  Add by hjm
	 ************************************************************
	 */
	public function getquestionList($id){
		$list=$this->db->query("
				SELECT A.questionId,
							 B.title,
				 		     B.type,
							 B.ico,
							 A.operatorName,
							 A.operationTime,
							 A.id
				FROM  cada_questionnaire_info               AS 	A
							LEFT  JOIN cada_question_bank    AS B    ON A.questionId =B.id
			WHERE   A.questionnaireId=".$id."  AND A.status<>2 
			ORDER BY A.id  ASC  
				")->result_array();
		return $list;	
	}
	/**
	 * 问卷管理-问卷-所有试题
	 * 参数：
	 *parm1:in--
	 * 日期:2017.02.17  Add by hjm
	 */
	public function getAllquestionList($id,$page=NULL){
		$sql='';
		!empty($page) && $sql.=" 		LIMIT  ".(($page-1)*50).",50";
		$list=$this->db->query("SELECT	 *
												FROM       cada_question_bank
												WHERE  	 id NOT IN (SELECT questionId FROM cada_questionnaire_info WHERE questionnaireId=".$id." AND status=1) AND 
																 status=1
			   								    ORDER     BY id  DESC".$sql)->result_array();
		return $list;
	}
	/**
 	 * 问卷管理-问卷-修改(获取问卷答案)
 	 * 参数：
  	 *parm1:in--   String : $id获取问卷id
 	 * 日期:2017.02.10  Add by hjm
 	 */
	public function getQsAns($id){
		$query=$this->db->query(
			  "SELECT   B.*,
							   A.id AS wid
				  FROM	  cada_questionnaire_info          AS A   
							  LEFT JOIN  cada_question_bank_answer    AS B   ON A.questionId=B.questionId
			   WHERE  A.status<>2   AND
							 B.status<>2    AND
							 A.questionnaireId=".$id."
				ORDER   BY  A.id ASC");
	return $query->result_array();
	}
	/**获取所有选项结果*/
	public function getAllAnswer(){
		$query=$this->db->query("SELECT * FROM cada_question_bank_answer WHERE status=1");
		return  $query->result_array();
	}
	/**
	 * 问卷管理-问卷-修改完成
	 * 参数：
	 *parm1:in--   String : $id获取问卷id
	 * 日期:2017.02.10  Add by hjm
	 */
	function getQuestionAll($id){
		$query=$this->db->query(
				"SELECT  A.questionId,
								B.name,
								A.id
				    FROM                      cada_questionnaire_info          AS A
				                 LEFT JOIN  cada_questionnaire                  AS B    ON A.questionId = B.id
				 WHERE    A.questionnaireId=".$id."
				 ORDER    BY  A.id  ASC"
				);
		return $query->result_array();
	}
	
	/**
	 * 问卷管理-问卷-列表查询
	 * 参数：
	 *parm1:in--   String : $select 所要查询的sql语句
	 * 日期:2017.02.14  Add by hjm
	 */
	function getQuestionnaireSearch($select){
	$query=$this->db->query($select);
	return $query->result_array();
	}
		/**
	 * 问卷管理-问卷-接口获取答案
	 * 参数：
	 *parm1:in--   String : $id 试题id
	 * 日期:2017.02.22  Add by hjm
	 */
	function ansData($id){
		$query=$this->db->query("SELECT id,title,questionId FROM cada_question_bank_answer WHERE questionId=".$id);
		return $query->result_array();
	}
	/**
	 * 问卷管理-问卷列表-获取数据&分页
	 * 参数：
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束 
	 *parm4:in--    String :: order :: 排序字段
	 *parm4:in--    String :: desc   ::正序 OR 倒序
	 * 日期:2017.03.07  Add by hjm
	 */
	public function getQuestionnaireData($type=1,$open=0,$last=20,$order='id',$desc='DESC'){
		if($type==1){
			$query=$this->db->query("SELECT 			*
															 FROM   			cada_questionnaire
															 WHERE      	status<>2
															 ORDER  BY    ".$order."  ".$desc."
															 LIMIT				".$open.",".$last);
			return $query->result_array();
		}else{
			$query=$this->db->query('SELECT * FROM cada_questionnaire WHERE status=1');
			return $query->num_rows();
		}
	}
	/**
	 * 问卷管理-问卷-获取试题
	 * 参数：
	 *parm1:in--   String : $id 试题id
	 * 日期:2017.02.22  Add by hjm
	 */
	public function getques(){
		$sql.="
			SELECT   id,title,type,description,operatorName,operationTime
			  FROM    cada_question_bank
			 WHERE  status='1'
	     ORDER BY id DESC
			 LIMIT 1,50  "; 
		
	return $this->db->query($sql)->result_array();
	}
	/**
	 * 问卷管理-问卷-获取试题总数
	 * 参数：
	 *parm1:in--   String : $id 试题id
	 * 日期:2017.02.22  Add by hjm
	 */
	public function getcon(){
		$sql="
				SELECT COUNT(1) AS num 
				 FROM    cada_question_bank  WHERE status='1'";
		return $this->db->query($sql)->result_array();
	}
	/**
	 * 问卷管理-问卷-获取试题接口
	 * 参数：
	 *parm1:in--   String : $id 试题id
	 * 日期:2017.02.22  Add by hjm
	 */
	public function getquejk($name,$page=NULL){
		!empty($name) &&
		$sql="SELECT id,title,type,description,operatorName,operationTime
				  FROM 	cada_question_bank
				 WHERE 	status='1' AND title LIKE '%".$name."%'
				 ORDER 	BY id DESC";
		empty($name) && !empty($page) && 
		 $sql="SELECT   id,title,type,description,operatorName,operationTime
				   FROM      cada_question_bank
				   WHERE   status='1'
		     	   ORDER   BY id DESC
				 	LIMIT 	 ".(($page-1)*50).",50" ;
		return $this->db->query($sql)->result_array();
	}
	/**试题维护搜索*/
	public function findQuestionsOne($id,$name){
		$sql="SELECT	 	 *
				   FROM        cada_question_bank
				  WHERE  	 id NOT IN (SELECT questionId FROM cada_questionnaire_info WHERE questionnaireId=".$id." AND status=1) AND
									 status=1 AND title LIKE '%".$name."%'
   				  ORDER        BY id  DESC";
		return $this->db->query($sql)->result_array();
	}
}














