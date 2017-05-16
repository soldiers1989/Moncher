<?php 
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：品牌管理MODEL类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class BrandModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::BrandModel::__construct
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
	 *方法::BrandModel::getBrandList
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
	public function getBrandList($type=1,$Pid=0,$open=0,$last=20,$order='id',$desc='DESC'){
		if($type==1){
			$query=$this->db->query("SELECT 			*
															 FROM   			cada_car_info
															 WHERE      	status=1				AND 
																					parentId=".$Pid."		
															 ORDER  BY    ".$order."  ".$desc."
															 LIMIT				".$open.",".$last);
			return $query->result_array();
		}else{
			$query=$this->db->query('SELECT * FROM cada_car_info WHERE status=1 AND parentId='.$Pid);
			return $query->num_rows();
		}
	}
	/**
	 ***********************************************************
	 *方法::BrandModel::getSearch
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open      :: 分页起始
	 *parm3:in--    String :: last         :: 分页结束
	 *parm4:in--    String :: series     :: 车系id
	 *parm5:in--    String :: rank       ::档次分类
	 *parm6:in--    String :: name     ::汽车名称
	 *parm7:in--    String :: lastDate ::汽车简码
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function getSearch($type=1,$Pid,$series,$rank,$name,$code,$open=0,$last=20){
		$sql="SELECT 			*
				    FROM				cada_car_info
					WHERE			status=1			 AND 
											parentId=".$Pid;
		!empty($series) 		    && $sql.="		AND	series=".$series;
		!empty($rank)				&& $sql.=" 	AND 	rank=".$rank;
		!empty($name)			&& $sql.="		AND	name='".$name."'";
		!empty($code)				&& $sql.="		AND	shortCode='".$code."'";
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