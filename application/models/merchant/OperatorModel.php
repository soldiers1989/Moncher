<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-24
**描述：操作员管理MODEL类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class OperatorModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::OperatorModel::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	/**
	 ***********************************************************
	 *方法::OperatorModel::getOperatorList
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
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function getOperatorList($providerid,$type=1,$open=0,$last=20,$order='id',$desc='DESC'){
		if($type==1){
			$query=$this->db->query("SELECT 			A.*,
																					B.roleName 									 				  AS  roleName,
																					C.name      														  AS   areaName,
																					D.name	   									 	 				  AS   brandName
															 FROM   			cada_provider_admin   				 				  AS    A
																					LEFT JOIN cada_provider_admin_roles 		  AS B ON B.id=A.staffRoleId 
																					LEFT JOIN cada_area				   		 				  AS C ON C.id=A.areaId
																					LEFT JOIN cada_car_info 			     				  AS D ON D.id=A.carId
															 WHERE      	A.status=1														  AND 
																					A.providerId=".$providerid." 
															 ORDER  BY    A.".$order."  ".$desc."
															 LIMIT				".$open.",".$last);
			return $query->result_array();
		}else{
			$query=$this->db->query('SELECT * FROM cada_provider_admin WHERE status=1');
			return $query->num_rows();
		}
	}
	/**
	 ***********************************************************
	 *方法::OperatorModel::getSearch
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束
	 *parm4:in--    String :: name :: 用户名
	 *parm5:in--    String :: areaId   ::区域ID
	 *parm6:in--    String :: roleId   ::权限ID
	 *parm7:in--    String :: brandId   ::品牌ID 
	 *parm8:in--    String :: userStatus :: 用户状态 
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function getSearch($type=1,$id,$name,$roleId,$areaId,$brandId,$userStatus,$open=0,$last=20){
		$sql="SELECT 			A.*,
											B.roleName 									 				AS  roleName,
											C.name      										 				AS   areaName,
											D.name	   									 	 				AS   brandName
				    FROM   			cada_provider_admin   								AS   A
											LEFT JOIN cada_provider_admin_roles 		AS B ON B.id=A.staffRoleId
											LEFT JOIN cada_area				   		 				AS C ON C.id=A.areaId
											LEFT JOIN cada_car_info  			 				AS D ON D.id=A.carId
					 WHERE      	A.status=1   AND A.providerId=".$id;
		!empty($name) && $sql.="			AND 	 A.loginName='".$name."'";
		!empty($roleId) && $sql.="			AND 	 A.staffRoleId=".$roleId;
		!empty($areaId) && $sql.="			AND 	 A.areaId=".$areaId;
		!empty($brandId) && $sql.="	    AND     A.carId=".$brandId;
		!empty($userStatus) && $sql.="	AND 	 A.userStatus=".$userStatus;
		if($type==1){
			$sql.= "	ORDER  BY    A.id  DESC   LIMIT				".$open.",".$last;
			$query=$this->db->query($sql);
			return $query->result_array();
		}else{
			$query=$this->db->query($sql);
			return $query->num_rows();
		}
	}
}