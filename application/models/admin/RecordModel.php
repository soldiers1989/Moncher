<?php
	/*****************************************************
	**作者：张文晓
	**创始时间：2017-04-12
	**描述：样本查询Model类
	*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/system/core/Model.php");class RecordModel extends CI_Model {		/**		 ***********************************************************		 *方法::RecordModel::__construct		 * ----------------------------------------------------------		 * 描述::初始化方法		 *----------------------------------------------------------		 *参数:		 *parm2:in--    无		 *----------------------------------------------------------		 *返回：		 *return:out--  无		 * ----------------------------------------------------------		 * 日期:2017.04.12   Add by zwx		 ************************************************************		 */		function __construct(){			parent::__construct();			$this->load->database();		}
	/**	 ***********************************************************	 *方法::RecordModel::getRecordList	 * ----------------------------------------------------------	 * 描述::获取列表分页及数量方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    String :: type ::获取数量 OR 结果	 *parm2:in--    String :: open :: 分页起始	 *parm3:in--    String :: last    :: 分页结束 	 *parm4:in--    String :: order :: 排序字段	 *parm4:in--    String :: desc   ::正序 OR 倒序	 *----------------------------------------------------------	 *返回：	 *return:out1--  Int :: rows      :: 获取数量	 *return:out2--  Array::query  :: 获取结果数组	 * ----------------------------------------------------------	 * 日期:2017.04.12  Add by zwx	 ************************************************************	 */
	public function getRecordList($type,$questionnaireId=11,$providerId=NULL,$groupId=NULL,$brandId=NULL,$areaId=NULL,$startTime=NULL,$endTime=NULL,$open=0,$last=20){
				$findStr=array(
				"2"=>" CASE WHEN MAX(C.F1)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F1))   ELSE ''  END F1,
							 CASE WHEN MAX(C.F2)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F2))   ELSE ''  END F2,
							 CASE WHEN MAX(C.F3)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F3))   ELSE ''  END F3,
							 CASE WHEN MAX(C.F4)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F4))   ELSE ''  END F4,
							 CASE WHEN MAX(C.F5)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F5))   ELSE ''  END F5,
							 CASE WHEN MAX(C.F6)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F6))   ELSE ''  END F6,
							 CASE WHEN MAX(C.F7)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F7))   ELSE ''  END F7,
							 CASE WHEN MAX(C.F8)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F8))   ELSE ''  END F8,
							 CASE WHEN MAX(C.F9)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F9))   ELSE ''  END F9,
							 CASE WHEN MAX(C.F10)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F10))  ELSE '' END F10,
							 CASE WHEN MAX(C.F11)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F11))  ELSE '' END F11,
							 CASE WHEN MAX(C.F12)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F12))  ELSE '' END F12,
							 CASE WHEN MAX(C.F13)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F13))  ELSE '' END F13,
							 CASE WHEN MAX(C.F14)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F14))  ELSE '' END F14",
				"3"=>" CASE WHEN MAX(C.F1)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F1))   ELSE '' END F1,
							 CASE WHEN MAX(C.F2)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F2))   ELSE '' END F2,
							 CASE WHEN MAX(C.F3)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F3))   ELSE '' END F3,
							 CASE WHEN MAX(C.F4)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F4))   ELSE '' END F4,
							 CASE WHEN MAX(C.F5)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F5))   ELSE '' END F5,
							 CASE WHEN MAX(C.F6)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F6))   ELSE '' END F6,
							 CASE WHEN MAX(C.F7)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F7))   ELSE '' END F7,
							 CASE WHEN MAX(C.F8)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F8))   ELSE '' END F8,
							 CASE WHEN MAX(C.F9)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F9))   ELSE '' END F9,
							 CASE WHEN MAX(C.F10)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F10))  ELSE '' END F10,
							 CASE WHEN MAX(C.F11)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F11))  ELSE '' END F11,
							 CASE WHEN MAX(C.F12)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F12))  ELSE '' END F12,
							 CASE WHEN MAX(C.F13)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F13))  ELSE '' END F13,
							 CASE WHEN MAX(C.F14)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F14))  ELSE '' END F14,
							 CASE WHEN MAX(C.F15)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F15))  ELSE '' END F15,
							 CASE WHEN MAX(C.F16)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F16))  ELSE '' END F16,
							 CASE WHEN MAX(C.F17)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F17))  ELSE '' END F17,
							 CASE WHEN MAX(C.F18)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F18))  ELSE '' END F18",
				"4"=>"CASE WHEN MAX(C.F1)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F1))   ELSE '' END F1,
							 CASE WHEN MAX(C.F2)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F2))   ELSE '' END F2,
							 CASE WHEN MAX(C.F3)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F3))   ELSE '' END F3,
							 CASE WHEN MAX(C.F4)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F4))   ELSE '' END F4,
							 CASE WHEN MAX(C.F5)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F5))   ELSE '' END F5,
							 CASE WHEN MAX(C.F6)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F6))   ELSE '' END F6,
							 CASE WHEN MAX(C.F7)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F7))   ELSE '' END F7,
							 CASE WHEN MAX(C.F8)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F8))   ELSE '' END F8,
							 CASE WHEN MAX(C.F9)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F9))   ELSE '' END F9,
							 CASE WHEN MAX(C.F10)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F10))  ELSE '' END F10,
							 CASE WHEN MAX(C.F11)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F11))  ELSE '' END F11,
							 CASE WHEN MAX(C.F12)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F12))  ELSE '' END F12,
							 CASE WHEN MAX(C.F13)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F13))  ELSE '' END F13,
							 CASE WHEN MAX(C.F14)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F14))  ELSE '' END F14,
							 CASE WHEN MAX(C.F15)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F15))  ELSE '' END F15,
							 CASE WHEN MAX(C.F16)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F16))  ELSE '' END F16,
							 CASE WHEN MAX(C.F17)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F17))  ELSE '' END F17",
				"5"=>" CASE WHEN MAX(C.F1)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F1))   ELSE '' END F1,
							 CASE WHEN MAX(C.F2)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F2))   ELSE '' END F2,
							 CASE WHEN MAX(C.F3)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F3))   ELSE '' END F3,
							 CASE WHEN MAX(C.F4)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F4))   ELSE '' END F4,
							 CASE WHEN MAX(C.F5)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F5))   ELSE '' END F5,
							 CASE WHEN MAX(C.F6)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F6))   ELSE '' END F6,
							 CASE WHEN MAX(C.F7)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F7))   ELSE '' END F7,
							 CASE WHEN MAX(C.F8)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F8))   ELSE '' END F8,
							 CASE WHEN MAX(C.F9)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F9))   ELSE '' END F9,
							 CASE WHEN MAX(C.F10)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F10))  ELSE '' END F10,
							 CASE WHEN MAX(C.F11)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F11))  ELSE '' END F11,
							 CASE WHEN MAX(C.F12)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F12))  ELSE '' END F12,
							 CASE WHEN MAX(C.F13)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F13))  ELSE '' END F13,
							 CASE WHEN MAX(C.F14)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F14))  ELSE '' END F14,
							 CASE WHEN MAX(C.F15)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F15))  ELSE '' END F15,
							 CASE WHEN MAX(C.F16)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F16))  ELSE '' END F16,
							 CASE WHEN MAX(C.F17)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F17))  ELSE '' END F17",
				"6"=>"CASE WHEN MAX(C.F1)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F1))   ELSE '' END F1,
							CASE WHEN MAX(C.F2)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F2))   ELSE '' END F2,
							CASE WHEN MAX(C.F3)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F3))   ELSE '' END F3,
							CASE WHEN MAX(C.F4)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F4))   ELSE '' END F4,
							CASE WHEN MAX(C.F5)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F5))   ELSE '' END F5,
							CASE WHEN MAX(C.F6)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F6))   ELSE '' END F6,
							CASE WHEN MAX(C.F7)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F7))   ELSE '' END F7,
							CASE WHEN MAX(C.F8)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F8))   ELSE '' END F8,
							CASE WHEN MAX(C.F9)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F9))     ELSE '' END F9,
							CASE WHEN MAX(C.F10)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F10))   ELSE '' END F10",
				"7"=>" CASE WHEN MAX(C.F1)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F1))   ELSE '' END F1,
							 CASE WHEN MAX(C.F2)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F2))   ELSE '' END F2,
							 CASE WHEN MAX(C.F3)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F3))   ELSE '' END F3,
							 CASE WHEN MAX(C.F4)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F4))   ELSE '' END F4,
							 CASE WHEN MAX(C.F5)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F5))   ELSE '' END F5,
							 CASE WHEN MAX(C.F6)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F6))   ELSE '' END F6,
							 CASE WHEN MAX(C.F7)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F7))   ELSE '' END F7,
							 CASE WHEN MAX(C.F8)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F8))   ELSE '' END F8,
							 CASE WHEN MAX(C.F9)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F9))   ELSE '' END F9,
							CASE WHEN MAX(C.F10A)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F10A))  ELSE '' END F10A,
							CASE WHEN MAX(C.F10B)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F10B))  ELSE '' END F10B,
							CASE WHEN MAX(C.F11)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F11))  ELSE '' END F11,
							CASE WHEN MAX(C.F12A)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F12A))  ELSE '' END F12A,
							CASE WHEN MAX(C.F12B)>0 THEN (SELECT answerValue  FROM cada_results_answer WHERE id=MAX(C.F12B))  ELSE '' END F12B",
				"8"=>" CASE WHEN MAX(C.F1)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F1))   ELSE '' END F1,
							 CASE WHEN MAX(C.F2)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F2))   ELSE '' END F2,
							 CASE WHEN MAX(C.F3)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F3))   ELSE '' END F3,
							 CASE WHEN MAX(C.F4)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F4))   ELSE '' END F4,
							 CASE WHEN MAX(C.F5)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F5))   ELSE '' END F5,
							 CASE WHEN MAX(C.F6)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F6))   ELSE '' END F6,
							 CASE WHEN MAX(C.F7)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F7))   ELSE '' END F7,
							 CASE WHEN MAX(C.F8)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F8))   ELSE '' END F8,
							 CASE WHEN MAX(C.F9)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F9))   ELSE '' END F9,
							 CASE WHEN MAX(C.F10)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F10))  ELSE '' END F10,
							 CASE WHEN MAX(C.F11)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F11))  ELSE '' END F11,
							 CASE WHEN MAX(C.F12)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F12))  ELSE '' END F12,
							 CASE WHEN MAX(C.F13)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F13))  ELSE '' END F13,
							 CASE WHEN MAX(C.F14)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F14))  ELSE '' END F14,
							 CASE WHEN MAX(C.F15)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F15))  ELSE '' END F15,
							 CASE WHEN MAX(C.F16)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F16))  ELSE '' END F16,
							 CASE WHEN MAX(C.F17A)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F17A))  ELSE '' END F17A,
							 CASE WHEN MAX(C.F17B)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F17B))  ELSE '' END F17B,
							 CASE WHEN MAX(C.F18)>0 THEN   (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F18))  ELSE '' END F18,
							 CASE WHEN MAX(C.F19A)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F19A))  ELSE '' END F19A,
							 CASE WHEN MAX(C.F19B)>0 THEN (SELECT answerValue  FROM cada_results_answer WHERE id=MAX(C.F19B))  ELSE '' END F19B",
				"9"=>"CASE WHEN MAX(C.F1)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F1))   ELSE '' END F1,
							 CASE WHEN MAX(C.F2)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F2))   ELSE '' END F2,
							 CASE WHEN MAX(C.F3)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F3))   ELSE '' END F3,
							 CASE WHEN MAX(C.F4)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F4))   ELSE '' END F4,
							 CASE WHEN MAX(C.F5)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F5))   ELSE '' END F5,
							 CASE WHEN MAX(C.F6)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F6))   ELSE '' END F6,
							 CASE WHEN MAX(C.F7)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F7))   ELSE '' END F7,
							 CASE WHEN MAX(C.F8)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F8))   ELSE '' END F8,
							 CASE WHEN MAX(C.F9)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F9))   ELSE '' END F9,
							 CASE WHEN MAX(C.F10)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F10))  ELSE '' END F10,
							 CASE WHEN MAX(C.F11)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F11))  ELSE '' END F11,
							 CASE WHEN MAX(C.F12)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F12))  ELSE '' END F12,
							 CASE WHEN MAX(C.F13)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F13))  ELSE '' END F13,
							 CASE WHEN MAX(C.F14)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F14))  ELSE '' END F14,
							 CASE WHEN MAX(C.F15)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F15))  ELSE '' END F15,
							CASE WHEN MAX(C.F16A)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F16A))  ELSE '' END F17A,
							CASE WHEN MAX(C.F16B)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F16B))  ELSE '' END F17B,
							CASE WHEN MAX(C.F17)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F17))  ELSE '' END F17,
							CASE WHEN MAX(C.F18A)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F18A))  ELSE '' END F18A,
							CASE WHEN MAX(C.F18B)>0 THEN (SELECT answerValue  FROM cada_results_answer WHERE id=MAX(C.F18B))  ELSE '' END F18B",
				"10"=>"CASE WHEN MAX(C.F1)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F1))   ELSE '' END F1,
							 CASE WHEN MAX(C.F2)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F2))   ELSE '' END F2,
							 CASE WHEN MAX(C.F3)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F3))   ELSE '' END F3,
							 CASE WHEN MAX(C.F4)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F4))   ELSE '' END F4,
							 CASE WHEN MAX(C.F5)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F5))   ELSE '' END F5,
							 CASE WHEN MAX(C.F6)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F6))   ELSE '' END F6,
							 CASE WHEN MAX(C.F7)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F7))   ELSE '' END F7,
							 CASE WHEN MAX(C.F8)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F8))   ELSE '' END F8,
							 CASE WHEN MAX(C.F9)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F9))   ELSE '' END F9,
							 CASE WHEN MAX(C.F10)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F10))  ELSE '' END F10,
							 CASE WHEN MAX(C.F11)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F11))  ELSE '' END F11,
							 CASE WHEN MAX(C.F12)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F12))  ELSE '' END F12,
							 CASE WHEN MAX(C.F13)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F13))  ELSE '' END F13,
							 CASE WHEN MAX(C.F14)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F14))  ELSE '' END F14,
							 CASE WHEN MAX(C.F15)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F15))  ELSE '' END F15,
							 CASE WHEN MAX(C.F16)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F16))  ELSE '' END F16,
							 CASE WHEN MAX(C.F17A)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F17A))  ELSE '' END F17A,
							 CASE WHEN MAX(C.F17B)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F17B))  ELSE '' END F17B,
							 CASE WHEN MAX(C.F18)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F18))  ELSE '' END F18,
							 CASE WHEN MAX(C.F19A)>0 THEN (SELECT answerValue FROM cada_results_answer WHERE id=MAX(C.F19A))  ELSE '' END F19A,
							 CASE WHEN MAX(C.F19B)>0 THEN (SELECT answerValue  FROM cada_results_answer WHERE id=MAX(C.F19B))  ELSE '' END F19B",
				"11"=>"CASE WHEN MAX(C.F1)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F1))   ELSE ''  END F1,
							 CASE WHEN MAX(C.F2)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F2))   ELSE ''  END F2,
							 CASE WHEN MAX(C.F3)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F3))   ELSE ''  END F3,
							 CASE WHEN MAX(C.F4)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F4))   ELSE ''  END F4,
							 CASE WHEN MAX(C.F5)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F5))   ELSE ''  END F5,
							 CASE WHEN MAX(C.F6)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F6))   ELSE ''  END F6,
							 CASE WHEN MAX(C.F7)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F7))   ELSE ''  END F7,
							 CASE WHEN MAX(C.F8)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F8))   ELSE ''  END F8,
							 CASE WHEN MAX(C.F9)>0  THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F9))   ELSE ''  END F9,
							 CASE WHEN MAX(C.F10)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F10))  ELSE '' END F10,
							 CASE WHEN MAX(C.F11)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F11))  ELSE '' END F11,
							 CASE WHEN MAX(C.F12)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F12))  ELSE '' END F12,
							 CASE WHEN MAX(C.F13)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F13))  ELSE '' END F13,
							 CASE WHEN MAX(C.F14)>0 THEN (SELECT title FROM cada_question_bank_answer WHERE id=MAX(C.F14))  ELSE '' END F14,
							 CASE WHEN MAX(C.F15A)>0 THEN (SELECT answerValue FROM cada_results_answer 			WHERE id=MAX(C.F15A))  ELSE '' END F15A,
							 CASE WHEN MAX(C.F15B)>0 THEN (SELECT answerValue FROM cada_results_answer 			WHERE id=MAX(C.F15B))  ELSE '' END F15B,
							 CASE WHEN MAX(C.F16)>0 THEN  (SELECT title FROM  cada_question_bank_answer WHERE id=MAX(C.F16))  ELSE '' END F16,
							 CASE WHEN MAX(C.F17A)>0 THEN (SELECT answerValue FROM cada_results_answer 			 WHERE id=MAX(C.F17A))  ELSE '' END F17A,
							 CASE WHEN MAX(C.F17B)>0 THEN (SELECT answerValue  FROM cada_results_answer 			 WHERE id=MAX(C.F17B))  ELSE '' END F17B");
$selectStr=array(
				"2"=>" CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F1'  THEN D.primitiveAnswerId ELSE 0 END F1,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F2'  THEN D.primitiveAnswerId ELSE 0 END F2,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F3'  THEN D.primitiveAnswerId ELSE 0 END F3,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F4'  THEN D.primitiveAnswerId ELSE 0 END F4,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F5'  THEN D.primitiveAnswerId ELSE 0 END F5,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F6'  THEN D.primitiveAnswerId ELSE 0 END F6,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F7'  THEN D.primitiveAnswerId ELSE 0 END F7,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F8'  THEN D.primitiveAnswerId ELSE 0 END F8,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F9'  THEN D.primitiveAnswerId ELSE 0 END F9,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F10' THEN D.primitiveAnswerId ELSE 0 END F10,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F11' THEN D.primitiveAnswerId ELSE 0 END F11,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F12' THEN D.primitiveAnswerId ELSE 0 END F12,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F13' THEN D.primitiveAnswerId ELSE 0 END F13,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F14' THEN D.primitiveAnswerId ELSE 0 END F14",
				"3"=>" CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S1'  THEN D.primitiveAnswerId ELSE 0 END F1,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S2'  THEN D.primitiveAnswerId ELSE 0 END F2,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S3'  THEN D.primitiveAnswerId ELSE 0 END F3,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S4'  THEN D.primitiveAnswerId ELSE 0 END F4,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S5'  THEN D.primitiveAnswerId ELSE 0 END F5,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S6'  THEN D.primitiveAnswerId ELSE 0 END F6,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S7'  THEN D.primitiveAnswerId ELSE 0 END F7,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S8'  THEN D.primitiveAnswerId ELSE 0 END F8,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S9'  THEN D.primitiveAnswerId ELSE 0 END F9,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S10' THEN D.primitiveAnswerId ELSE 0 END F10,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S11' THEN D.primitiveAnswerId ELSE 0 END F11,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S12' THEN D.primitiveAnswerId ELSE 0 END F12,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S13' THEN D.primitiveAnswerId ELSE 0 END F13,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S14' THEN D.primitiveAnswerId ELSE 0 END F14,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S15' THEN D.primitiveAnswerId ELSE 0 END F15,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S16' THEN D.primitiveAnswerId ELSE 0 END F16,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S17' THEN D.primitiveAnswerId ELSE 0 END F17,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S18' THEN D.primitiveAnswerId ELSE 0 END F18",
				"4"=>"CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z1'  THEN D.primitiveAnswerId ELSE 0 END F1,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z2'  THEN D.primitiveAnswerId ELSE 0 END F2,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z3'  THEN D.primitiveAnswerId ELSE 0 END F3,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z4'  THEN D.primitiveAnswerId ELSE 0 END F4,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z5'  THEN D.primitiveAnswerId ELSE 0 END F5,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z6'  THEN D.primitiveAnswerId ELSE 0 END F6,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z7'  THEN D.primitiveAnswerId ELSE 0 END F7,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z8'  THEN D.primitiveAnswerId ELSE 0 END F8,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z9'  THEN D.primitiveAnswerId ELSE 0 END F9,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z10' THEN D.primitiveAnswerId ELSE 0 END F10,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z11' THEN D.primitiveAnswerId ELSE 0 END F11,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z12' THEN D.primitiveAnswerId ELSE 0 END F12,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z13' THEN D.primitiveAnswerId ELSE 0 END F13,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z14' THEN D.primitiveAnswerId ELSE 0 END F14,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z15' THEN D.primitiveAnswerId ELSE 0 END F15,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z16' THEN D.primitiveAnswerId ELSE 0 END F16,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z17' THEN D.primitiveAnswerId ELSE 0 END F17",
				"5"=>" CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T1'  THEN D.primitiveAnswerId ELSE 0 END F1,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T2'  THEN D.primitiveAnswerId ELSE 0 END F2,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T3'  THEN D.primitiveAnswerId ELSE 0 END F3,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T4'  THEN D.primitiveAnswerId ELSE 0 END F4,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T5'  THEN D.primitiveAnswerId ELSE 0 END F5,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T6'  THEN D.primitiveAnswerId ELSE 0 END F6,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T7'  THEN D.primitiveAnswerId ELSE 0 END F7,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T8'  THEN D.primitiveAnswerId ELSE 0 END F8,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T9'  THEN D.primitiveAnswerId ELSE 0 END F9,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T10' THEN D.primitiveAnswerId ELSE 0 END F10,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T11' THEN D.primitiveAnswerId ELSE 0 END F11,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T12' THEN D.primitiveAnswerId ELSE 0 END F12,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T13' THEN D.primitiveAnswerId ELSE 0 END F13,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T14' THEN D.primitiveAnswerId ELSE 0 END F14,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T15' THEN D.primitiveAnswerId ELSE 0 END F15,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T16' THEN D.primitiveAnswerId ELSE 0 END F16,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T17' THEN D.primitiveAnswerId ELSE 0 END F17",
				"6"=>"CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P1'  THEN D.primitiveAnswerId ELSE 0 END F1,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P2'  THEN D.primitiveAnswerId ELSE 0 END F2,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P3'  THEN D.primitiveAnswerId ELSE 0 END F3,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P4'  THEN D.primitiveAnswerId ELSE 0 END F4,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P5'  THEN D.primitiveAnswerId ELSE 0 END F5,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P6'  THEN D.primitiveAnswerId ELSE 0 END F6,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P7'  THEN D.primitiveAnswerId ELSE 0 END F7,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P8'  THEN D.primitiveAnswerId ELSE 0 END F8,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P9'  THEN D.primitiveAnswerId ELSE 0 END F9,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P10'  THEN D.primitiveAnswerId ELSE 0 END F10",
				"7"=>" CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P1'  THEN D.primitiveAnswerId ELSE 0 END F1,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P2'  THEN D.primitiveAnswerId ELSE 0 END F2,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P3'  THEN D.primitiveAnswerId ELSE 0 END F3,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P4'  THEN D.primitiveAnswerId ELSE 0 END F4,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P5'  THEN D.primitiveAnswerId ELSE 0 END F5,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P6'  THEN D.primitiveAnswerId ELSE 0 END F6,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P7'  THEN D.primitiveAnswerId ELSE 0 END F7,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P8'  THEN D.primitiveAnswerId ELSE 0 END F8,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P9'  THEN D.primitiveAnswerId ELSE 0 END F9,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P10A' THEN D.id ELSE 0 END F10A,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P10B' THEN D.id ELSE 0 END F10B,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P11' THEN D.primitiveAnswerId ELSE 0 END F11,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P12A' THEN D.id ELSE 0 END F12A,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='P12B' THEN D.id ELSE 0 END F12B",
				"8"=>" CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T1'  THEN D.primitiveAnswerId ELSE 0 END F1,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T2'  THEN D.primitiveAnswerId ELSE 0 END F2,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T3'  THEN D.primitiveAnswerId ELSE 0 END F3,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T4'  THEN D.primitiveAnswerId ELSE 0 END F4,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T5'  THEN D.primitiveAnswerId ELSE 0 END F5,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T6'  THEN D.primitiveAnswerId ELSE 0 END F6,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T7'  THEN D.primitiveAnswerId ELSE 0 END F7,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T8'  THEN D.primitiveAnswerId ELSE 0 END F8,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T9'  THEN D.primitiveAnswerId ELSE 0 END F9,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T10' THEN D.primitiveAnswerId ELSE 0 END F10,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T11' THEN D.primitiveAnswerId ELSE 0 END F11,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T12' THEN D.primitiveAnswerId ELSE 0 END F12,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T13' THEN D.primitiveAnswerId ELSE 0 END F13,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T14' THEN D.primitiveAnswerId ELSE 0 END F14,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T15' THEN D.primitiveAnswerId ELSE 0 END F15,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T16' THEN D.primitiveAnswerId ELSE 0 END F16,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T17A' THEN D.id ELSE 0 END F17A,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T17B' THEN D.id ELSE 0 END F17B,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T18' THEN D.primitiveAnswerId ELSE 0 END F18,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T19A' THEN D.id ELSE 0 END F19A,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='T19B' THEN D.id ELSE 0 END F19B",
				"9"=>"CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z1'  THEN D.primitiveAnswerId ELSE 0 END F1,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z2'  THEN D.primitiveAnswerId ELSE 0 END F2,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z3'  THEN D.primitiveAnswerId ELSE 0 END F3,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z4'  THEN D.primitiveAnswerId ELSE 0 END F4,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z5'  THEN D.primitiveAnswerId ELSE 0 END F5,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z6'  THEN D.primitiveAnswerId ELSE 0 END F6,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z7'  THEN D.primitiveAnswerId ELSE 0 END F7,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z8'  THEN D.primitiveAnswerId ELSE 0 END F8,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z9'  THEN D.primitiveAnswerId ELSE 0 END F9,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z10' THEN D.primitiveAnswerId ELSE 0 END F10,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z11' THEN D.primitiveAnswerId ELSE 0 END F11,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z12' THEN D.primitiveAnswerId ELSE 0 END F12,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z13' THEN D.primitiveAnswerId ELSE 0 END F13,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z14' THEN D.primitiveAnswerId ELSE 0 END F14,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z15' THEN D.primitiveAnswerId ELSE 0 END F15,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z16A' THEN D.id ELSE 0 END F16A,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z16B' THEN D.id ELSE 0 END F16B,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z17' THEN D.primitiveAnswerId ELSE 0 END F17,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z18A' THEN D.id ELSE 0 END F18A,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='Z18B' THEN D.id ELSE 0 END F18B",
				"10"=>"CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S1'  THEN D.primitiveAnswerId ELSE 0 END F1,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S2'  THEN D.primitiveAnswerId ELSE 0 END F2,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S3'  THEN D.primitiveAnswerId ELSE 0 END F3,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S4'  THEN D.primitiveAnswerId ELSE 0 END F4,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S5'  THEN D.primitiveAnswerId ELSE 0 END F5,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S6'  THEN D.primitiveAnswerId ELSE 0 END F6,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S7'  THEN D.primitiveAnswerId ELSE 0 END F7,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S8'  THEN D.primitiveAnswerId ELSE 0 END F8,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S9'  THEN D.primitiveAnswerId ELSE 0 END F9,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S10' THEN D.primitiveAnswerId ELSE 0 END F10,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S11' THEN D.primitiveAnswerId ELSE 0 END F11,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S12' THEN D.primitiveAnswerId ELSE 0 END F12,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S13' THEN D.primitiveAnswerId ELSE 0 END F13,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S14' THEN D.primitiveAnswerId ELSE 0 END F14,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S15' THEN D.primitiveAnswerId ELSE 0 END F15,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S16' THEN D.primitiveAnswerId ELSE 0 END F16,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S17A' THEN D.id ELSE 0 END F17A,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S17B' THEN D.id ELSE 0 END F17B,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S18' THEN D.primitiveAnswerId ELSE 0 END F18,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S19A' THEN D.id ELSE 0 END F19A,
							CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='S19B' THEN D.id ELSE 0 END F19B",
				"11"=>"CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F1'  THEN D.primitiveAnswerId ELSE 0 END F1,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F2'  THEN D.primitiveAnswerId ELSE 0 END F2,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F3'  THEN D.primitiveAnswerId ELSE 0 END F3,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F4'  THEN D.primitiveAnswerId ELSE 0 END F4,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F5'  THEN D.primitiveAnswerId ELSE 0 END F5,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F6'  THEN D.primitiveAnswerId ELSE 0 END F6,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F7'  THEN D.primitiveAnswerId ELSE 0 END F7,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F8'  THEN D.primitiveAnswerId ELSE 0 END F8,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F9'  THEN D.primitiveAnswerId ELSE 0 END F9,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F10' THEN D.primitiveAnswerId ELSE 0 END F10,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F11' THEN D.primitiveAnswerId ELSE 0 END F11,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F12' THEN D.primitiveAnswerId ELSE 0 END F12,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F13' THEN D.primitiveAnswerId ELSE 0 END F13,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F14' THEN D.primitiveAnswerId ELSE 0 END F14,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F15A' THEN D.id ELSE 0 END F15A,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F15B' THEN D.id ELSE 0 END F15B,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F16' THEN   D.primitiveAnswerId ELSE 0 END F16,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F17A' THEN D.id ELSE 0 END F17A,
							 CASE WHEN SUBSTRING_INDEX(B.primitiveTitle,'、',1)='F17B' THEN D.id ELSE 0 END F17B");
		$sql="SELECT  C.sex,
							  C.age,
							  C.education,
							  C.vocation,
							  C.money,
							  C.buytime,
							  C.area,
							  C.brand,
							  C.carType,
							  C.operationTime,";
		$sql.=empty($findStr[$questionnaireId])?'1 AS  A1':$findStr[$questionnaireId];
		 $sql.="	    FROM (SELECT 	 A.id,
												 A.operationTime,
												 B.primitiveQuestionId,
												 B.primitiveTitle   AS name,
												 CASE WHEN F.sex=1 THEN '男' ELSE '女' END      	AS sex,
												 F.age,
												 F.qualifications AS education,
												 F.occupation AS  vocation,
												 F.income AS money,
												 F.carPeriod AS buytime,
												 G.name AS area,
												 K.name AS brand,
												 H.name AS carType,";
		$sql.=empty($selectStr[$questionnaireId])?'1 AS  A1':$selectStr[$questionnaireId];
		 $sql.="		FROM  	 cada_results_questionnaire  				  			 AS A 	
											LEFT JOIN cada_results_question_bank     		 AS B  ON  B.resultsQuestionnaireId=A.id	
											LEFT JOIN cada_results_answer        			     AS D  ON  D.resultsQuestionId=B.id	
											LEFT JOIN cada_persons                     	   	  	  	 AS F  ON   F.id=A.personsId 	
											LEFT JOIN cada_car_info                     		         AS H  ON  H.id=F.carModelId
											LEFT JOIN cada_car_info                     			     AS K  ON  K.id=H.parentId
											LEFT JOIN cada_area                       				     AS G  ON  G.id=A.areaId
					  WHERE   A.questionnaireId=".$questionnaireId." 			     AND 
								   A.status=1 ";
		 !empty($providerId) && $providerId!=0  &&  $sql.=" 	    AND A.merchantId=".$providerId;
		 !empty($groupId)     && $groupId!=0      &&   $sql.=" 	    AND A.groupId=".$groupId;
		 !empty($brandId)     && $brandId!=0		  &&   $sql.="	   		AND A.brandId=".$brandId;
		 !empty($areaId)	      && $areaId!=0		  &&   $sql.="	   		AND A.areaId=".$areaId;
		if((!empty($startTime) && !empty($endTime))){
			strtotime($startTime)<=strtotime($endTime) ? $sql.=" AND  A.operationTime    BETWEEN  '".$startTime." 00:00:00' AND '".$endTime."  23:59:59'":
																			   				 $sql.=" AND  A.operationTime   BETWEEN  '".$endTime." 00:00:00' AND '".$startTime."  23:59:59'";
		}
		 $sql.="		GROUP  BY   A.id,B.primitiveQuestionId ) 							      AS  C
							GROUP BY    C.id
		 					HAVING  LENGTH(F5)>0	  
							ORDER BY    C.id DESC";
		 ($type==2 || $type==3) && $query=$this->db->query($sql);
		 $type==1 && $query=$this->db->query($sql.' LIMIT '.$open.','.$last);
		return $type!=2 ? $query->result_array():$query->num_rows();	}
	/**
	 ***********************************************************
	 *方法::RecordModel::getQuestions($id)
	 * ----------------------------------------------------------
	 * 描述::获取一套问卷的全部试题
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.04.12  Add by zwx
	 ************************************************************
	 */
	public function getQuestions($id){
		$query=$this->db->query("SELECT   	 A.id,
																			 B.title,
																			 B.type
															FROM     cada_questionnaire_info                       	   A
																			LEFT  JOIN cada_question_bank                 B    ON B.id=A.questionId
															WHERE    A.status=1   AND
																			 B.status=1   AND
																			 A.questionnaireId=".$id."     
															ORDER       BY  A.id ASC");
	    return $query->result_array();
	}
	/**获取集团的调研区域*/
	public function getAreaList($groupid){
		$query=$this->db->query("SELECT   A.areaId,
																	  	 B.name
														FROM     cada_results_questionnaire A LEFT JOIN
																        cada_area           		       	    B ON B.id=A.areaId
														WHERE 	A.groupId=".$groupid."
														GROUP 	BY A.areaId");
		return $query->result_array();
	}
	/**获取集团的调研品牌*/
	public function getBrandList($groupid){
		$query=$this->db->query("SELECT A.brandId,
															B.name
												FROM  cada_results_questionnaire A LEFT JOIN
														   cada_car_info           		   B ON B.id=A.brandId
												WHERE A.groupId=".$groupid." AND A.brandId IS NOT NULL
												GROUP BY A.brandId");
		return $query->result_array();
	}
	/**获取集团的调研门店*/
	public function getMerchantList($groupid){
		$query=$this->db->query("SELECT A.merchantId,
															B.name
												FROM  cada_results_questionnaire A LEFT JOIN
														   cada_merchant_info           B ON B.id=A.merchantId
												WHERE A.groupId=".$groupid."
												GROUP BY A.merchantId");
		return $query->result_array();
	}
	/**获取模型列表*/
	public function getModels($modelid){
		$query=$this->db->query("SELECT  B.questionnaireId AS id,
															 			B.title
														 FROM   cada_model A LEFT JOIN cada_module B ON A.id=B.modelId
														 WHERE  A.status=1 AND B.status=1 AND A.id=".$modelid."  ORDER BY B.sorting ASC ");
		return $query->result_array();
	}
	public function getGroupList($modelid){
		$model=$this->getModels($modelid);
		$query=$this->db->query('SELECT  A.groupId,
																	    B.name
															FROM   cada_results_questionnaire A LEFT JOIN
																	   	  cada_merchant_info           	  B ON B.id=A.groupId
															WHERE questionnaireId IN ('.$model[0]['id'].','.$model[1]['id'].','.$model[2]['id'].','.$model[3]['id'].','.$model[4]['id'].')   	 AND
																		  A.status=1 AND B.status=1
															GROUP BY A.groupId');
		return $query->result_array();
	}
}