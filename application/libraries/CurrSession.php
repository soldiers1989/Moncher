<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-01-06
**描述：公用SESSSION类，包括获取，设置和检测
*****************************************************/
require_once('CurrLog.php');
class CurrSession{
	#.SESSSION有效时间
	private $valid=3600;
	#.默认SESSION名称
	private $default='Admin';
	/**
	 ***********************************************************
	 *方法::CurrSession::__construct
	 * ----------------------------------------------------------
	 * 描述::SESSSION类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.01.11  Add by zwx
	 ************************************************************
	 */
	function __construct(){
		!isset($_SESSION) && session_start();
		 error_reporting(0);ini_set('display_errors', 0);
	}
	/**
	 ***********************************************************
	 *方法::CurrSession::getSession
	 * ----------------------------------------------------------
	 * 描述::SESSSION类获取session
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : name  ::需要获取的SESSION名称
	 *parm2:in--    String : key  	 ::需要获取的SESSION字段
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array : session ::获取的SESSION数据
	 * ----------------------------------------------------------
	 * 日期:2017.01.11  Add by zwx
	 ************************************************************
	 */
	function getSession($name='',$key=''){
		return  ($name=='') ? ($key=='' ? $_SESSION[$this->default] : $_SESSION[$this->default][$key]) :
											  ($key=='' ? $_SESSION[$name] : $_SESSION[$name][$key]);
	}
	/**
	 ***********************************************************
	 *方法::CurrSession::setSession
	 * ----------------------------------------------------------
	 * 描述::SESSSION类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : name  ::需要设置的SESSION名称
	 *parm2:in--    Array  : data  ::需要设置的SESSION数据
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.01.11  Add by zwx
	 ************************************************************
	 */
	function setSession($data=array(),$name=''){
		!empty($data) && $_SESSION[$name==''?$this->default:$name]=$data;
		$_SESSION[$name==''?$this->default:$name]['startTime']=time();
	}
	/**
	 ***********************************************************
	 *方法::CurrSession::checkSession
	 * ----------------------------------------------------------
	 * 描述::SESSSION类验证方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : name  ::需要验证的SESSION名称
	 *----------------------------------------------------------
	 *返回：
	 *return:out--   bool : bool      ::验证是否通过 
	 * ----------------------------------------------------------
	 * 日期:2017.01.11  Add by zwx
	 ************************************************************
	 */
	function checkSession($name=''){
		$bool=false;
		$check=$_SESSION[$name==''?$this->default:$name];
		if(empty($check) ||  time()-$check['startTime']>=$this->valid ){
			$_SESSION[$name==''?$this->default:$name]=NULL;
		    echo $name=='Merchant'?'<script>window.top.location.href="'.base_url().'index.php/merchant/login"</script>':'<script>window.top.location.href="'.base_url().'index.php/admin/login"</script>';
		}else{
			$token=$this->findToken($name,$check['id']);
			if($check['token']!=$token){
				$_SESSION[$name==''?$this->default:$name]=NULL;
				echo $name=='Merchant'?'<script>window.top.location.href="'.base_url().'index.php/merchant/login"</script>':'<script>window.top.location.href="'.base_url().'index.php/admin/login"</script>';
			}else{
				$bool=true;
			}
		}
		return $bool;
	}
	/**
	 ***********************************************************
	 *方法::CurrSession::findToken
	 * ----------------------------------------------------------
	 * 描述::获取管理员操作
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : name  ::需要验证的SESSION名称
	 *----------------------------------------------------------
	 *返回：
	 *return:out--   bool : bool      ::验证是否通过
	 * ----------------------------------------------------------
	 * 日期:2017.01.11  Add by zwx
	 ************************************************************
	 */
	function findToken($name,$id){
		$log=new CurrLog(0,0,0,0,0);
		$name=='Admin'? $sql="SELECT id,token FROM cada_admin WHERE id=".$id." AND status=1"	: 
										  $sql="SELECT 	 A.id,
										  							 A.token 
										  		     FROM  	 cada_provider_admin  			    AS  A 
										  							 LEFT JOIN cada_merchant_info  AS B ON B.id=A.providerId 
										  		   WHERE     A.status=1  AND 
										  							 B.status=1  AND 
										  							 A.id=".$id;
		$one=$log->query($sql);
		return $one[0]['token'];
	}
}