<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wechat extends CI_Controller {
	/**
	 ***********************************************************
	 *方法::Wechat::__construct
	 * ----------------------------------------------------------
	 * 描述::管理员类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2016.02.25  Add by zwx
	 ************************************************************
	 */
	public function __construct(){
		parent::__construct(); 
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('form');
		$this->load->database();
	}
	/**
	 ***********************************************************
	 *方法::Wechat::index
	 * ----------------------------------------------------------
	 * 描述::微信端页面显示
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : NULL
	 *parm2:in--   String : NULL
	 *----------------------------------------------------------
	 *返回：
	 *return::NULL
	 * ----------------------------------------------------------
	 * 日期:2016.02.25  Add by zwx
	 ************************************************************
	 */
	public function index(){
		$openid=$_GET['openid'];
		if($_GET['openid']>500000){
			$query=$this->db->query("SELECT id,oldid FROM cada_merchant_info WHERE oldid=".$_GET['openid']);
			$one=$query->result_array();
			$openid=$one[0]['id'];
		}
		echo "<script language='javascript' type='text/javascript'>window.location.href='http://www.51hyc.com/car/wechat/skypie.php?openid=".$openid."&t=1';</script>";
	}
	/**基础版本*/
	public function basis(){
		$openid=$_GET['openid'];
		if($_GET['openid']>500000){
			$query=$this->db->query("SELECT id,oldid FROM cada_merchant_info WHERE oldid=".$_GET['openid']);
			$one=$query->result_array();
			$openid=$one[0]['id'];
		}
		echo "<script language='javascript' type='text/javascript'>window.location.href='http://www.51hyc.com/car/wechat/skypie.php?openid=".$openid."&t=2]'</script>";
	}
	/**三国版本*/
	public function sanguo(){
		$openid=$_GET['openid'];
		if($_GET['openid']>500000){
			$query=$this->db->query("SELECT id,oldid FROM cada_merchant_info WHERE oldid=".$_GET['openid']);
			$one=$query->result_array();
			$openid=$one[0]['id'];
		}
		echo "<script language='javascript' type='text/javascript'>window.location.href='http://www.51hyc.com/car/wechat/skypie.php?openid=".$openid."&t=3';</script>";
	}
}
