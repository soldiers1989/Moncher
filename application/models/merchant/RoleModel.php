<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：权限角色管理MODEL类
*****************************************************/
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/system/core/Model.php');
class RoleModel extends CI_Model {
	/**
	 ***********************************************************
	 *方法::RoleModel::__construct
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
	 *方法::RoleModel::getRoleList
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束 
	 *parm4:in--    String :: order :: 排序字段
	 *parm5:in--    String :: desc   ::正序 OR 倒序
	 *parm6:in--    String :: desc   ::商户id
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function getRoleList($providerid,$type=1,$open=0,$last=20,$order='id',$desc='DESC'){
		if($type==1){
			$query=$this->db->query("SELECT 			*
															 FROM   			cada_provider_admin_roles
															 WHERE      	status=1       					AND	
																					providerId=".$providerid." 
															 ORDER  BY    ".$order."  ".$desc."
															 LIMIT				".$open.",".$last);
			return $query->result_array();
		}else{
			$query=$this->db->query('SELECT * FROM cada_provider_admin_roles WHERE status=1 AND providerId='.$providerid);
			return $query->num_rows();
		}
	}
	/**
	 ***********************************************************
	 *方法::RoleModel::getRoleTree
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id ::获取权限id
	 *----------------------------------------------------------
	 *返回：
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function getRoleTree($id){
		$query=$this->db->query("SELECT 		    A.id,
																				B.pId,
																				C.navTitle AS title,
																				C.iconUrl,
																				B.navTitle,
																				B.navUrl,
																				A.symbol
														 FROM   	  		cada_provider_admin_roles2						AS 	A
																				LEFT JOIN cada_provider_admin_navs       AS    B ON B.id=A.sector
																				LEFT JOIN cada_provider_admin_navs       AS    C ON C.id=B.pId
																				LEFT JOIN cada_provider_admin_roles       AS    D ON D.id=A.adminRolesID
														 WHERE      	A.status=1 				AND 
																				B.status=1              AND 
																				C.status=1				AND
																				D.status=1             AND 
																				A.adminRolesID=".$id."
														 ORDER  BY    C.navSort ASC, B.navSort  DESC" );
		return $query->result_array();
	}
	/**
	 ***********************************************************
	 *方法::RoleModel::getNavList
	 * ----------------------------------------------------------
	 * 描述::获取商户菜单列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id ::获取权限id
	 *----------------------------------------------------------
	 *返回：
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function getNavList($type){
		$s=$type==0?2:$type;
		$query=$this->db->query('SELECT    A.* 
														FROM      cada_provider_admin_navs    AS A 
														WHERE     A.id IN  (SELECT pId
																						FROM     cada_provider_admin_navs    AS A 
																						WHERE    A.status=1 								 AND 
																										 A.merchantType=0 					 OR 
																										 A.merchantType='.$s.' 
																						GROUP BY pId
																						HAVING pId>0)				 											OR 
																	 	(A.merchantType ='.$s.' AND  A.pId>0 AND A.status=1)		OR 
																	 	(A.merchantType=0  AND  A.pId>0 AND A.status=1)');
		return $query->result_array();
	}
}