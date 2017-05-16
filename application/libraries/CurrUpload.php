<?php
/*****************************************************
 **作者：hjm

**创始时间：2017-01-05

**描述：上传类
**修改：ZWX
**描述：1.针对图片上传方法和多图片上传方法
*					做了整合；
*				  2.原有多图片上传修改为多文件格式
*					 多文件上传
*                3.初始化方法直接执行上传操作
**时间：2017-02-14  21:30
*****************************************************/
class CurrUpload{
	//配置选项
	public $config=array(
					"max"=>0,
					"min"=>0,
					"path"=>null,
					"files"=>null);
	//返回上传信息
	public $message=array();
	/**
	 ***********************************************************
	 *方法 :Upload::__construct
	 * ----------------------------------------------------------
	 * 描述::构造函数
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   Array	: config   :: 上传类初始化设置
	 *parm2:in--   String : type      ::   上传文件类型
	 *----------------------------------------------------------
	 *返回：
	 *return:out-- void 
	 * ----------------------------------------------------------
	 *示例：   
	 *case1  :  $upload=new CurrUpload($config)    :: 上传图片
	 * 日期:2017.01.06  Add  by hjm
	 ************************************************************
	 */
	public function __construct($config=array()){
		$config['max']=$config['max']*1024;
		$config['min']=$config['min']*1024;
		$this->config=$config;
		$this->config['path']=dirname(dirname(dirname(__FILE__))).substr($this->config['path'],1,-1);
	}
	/**
	 ***********************************************************
	 *方法 :Upload::getUrls
	 * ----------------------------------------------------------
	 * 描述::构造函数
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : type      ::   上传文件类型
	 *----------------------------------------------------------
	 *返回：
	 *return:out-- void
	 * ----------------------------------------------------------
	 *示例：
	 *case1  :  $upload=new CurrUpload($config)  
	 *				 $upload->getUrls(1)  ::  上传图片文件 
	 *				 $upload->getUrls(2)  ::  上传报告文件
	 * 日期:2017.01.06  Add  by hjm
	 ************************************************************
	 */
	public  function getUrls($type=1){
		return $type==1?$this->upload():$this->uploadMany();
	}
	/**
	 ***********************************************************
	 *方法 :Upload::Upload
	 * ----------------------------------------------------------
	 * 描述::上传图片（单图片上传）
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   $this->config  上传参数配置项
	 *parm2:in--   Array :$_FILES   ::上传文件数组
	 *parm3:in--   Array : path        ::上传文件保存路径   
     *----------------------------------------------------------  
	 *示例：   
	 *example  :  $path=$_SERVER['DOCUMENT_ROOT'].'/CADA/static/admin/images/';
	 *----------------------------------------------------------
	 *返回：
	 *return:out-- void : 数组: $message   :   url ::图片路径	or  不符合要求文件信息	
	 * ----------------------------------------------------------
	 * 日期:2017.01.11  Add  by hjm 
     *----------------------------------------------------------  
	 *修改：
	 *描述：单一图片多图整合为一个方法
	 *日期：2017.02.14 Update by zwx
	 ************************************************************
	 */
	private function upload(){
		date_default_timezone_set('PRC');
		ini_set('date.timezone','Asia/Shanghai');
		//--文件夹是否存在
		!file_exists($this->config['path']) && mkdir($this->config['path'],0777);
		//--检查上传图片是否在允许上传的类型
		$type = array("image/gif","image/jpg","image/jpeg","image/png");
		foreach($this->config['files'] as  $key=>$files){
			$this->message[$key]=array();
			if($files["error"]!= 0) continue; 
			//判断文件类型
			if(!in_array($files["type"],$type)){
				$this->message[$key]['status']=0;
				$this->message[$key]['mess']="文件类型错误!";
				continue;
			}
			//规定图片大小
			if($files["size"]>$this->config['max'] || $files["size"]<$this->config['min']){
				$this->message[$key]['status']=0;
				$this->message[$key]['mess']="文件超出固定尺寸!";
				continue;
			}
			//文件的重命名（日期+随机数+后缀）
			$name=date('YmdHis').mt_rand(1000,9999).strrchr($files["name"],'.');
			//开始上传文件
			move_uploaded_file($files["tmp_name"], $this->config['path'].$name);
			$this->message[$key]['status']=1;
			$this->message[$key]['url']=$name;
		}
		return  $this->message;
	}
	

	/**
	 ***********************************************************
	 *方法 : Upload::uploadMany
	 * ----------------------------------------------------------
	 * 描述::上传多种文件
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   无
	 *----------------------------------------------------------
	 *返回：
	 *return:: out: URL  : 上传成功文件所在目录路径
	 * ----------------------------------------------------------
     *示例:
     *case1:use--  uploadMany();
     *----------------------------------------------------------
	 * 日期:2017.1.12   by hjm
	 ************************************************************
	 */
	private function uploadMany(){
		date_default_timezone_set('PRC');
		ini_set('date.timezone','Asia/Shanghai');
		//--文件是否存在
		!file_exists($this->config['path']) && mkdir($this->config['path'],0777);
		foreach ($this->config['files'] as $key=>$files){
			$this->message[$key]=array();
			if($files["error"]!= 0) continue;
			//文件的重命名（日期+随机数+后缀）
			$name=date('YmdHis').mt_rand(1000,9999).strrchr($files["name"],'.');
			//开始上传文件
			move_uploaded_file($files["tmp_name"], $this->config['path'].$name);
			$this->message[$key]['status']=1;
			$this->message[$key]['url']=$name;
		}
		return  $this->message;
	}
}