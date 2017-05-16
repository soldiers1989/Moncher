<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：品牌管理service类。
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class BrandService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $item=9;
	private $session;
	private $system;
	/**
	 ***********************************************************
	 *方法::BrandService::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function __construct(){
		$this->includes=new Includes(__FILE__);
		$this->includes->models('DataBase','global');
		$this->includes->models('BrandModel');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::BrandService::getList
	 * ----------------------------------------------------------
	 * 描述::获取列表方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool ::获取数据列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getList($Pid,$page){
		try{
			$bool=Array();
			$model=new BrandModel();
			$cars=$model->getBrandList(1,$Pid,($page-1)*100,100);
			(!empty($cars) && count($cars)>0) && $bool=$cars;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::BrandService::getBrands
	 * ----------------------------------------------------------
	 * 描述::获取汽车列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: sid        ::车系id
	 *parm2:in--   String :: id  			::汽车id
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  String :: bool   ::已经获取的数组列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getBrands($sid,$id=0){
		try{
			$bool=Array();
			$cars=$this->data->select($this->item,$id==0?Array('status'=>1,'parentId'=>0,"series"=>$sid):Array("status"=>1,"id"=>$id));
			(!empty($cars) && count($cars)>0) && $bool=$cars;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::BrandService::addBrands
	 * ----------------------------------------------------------
	 * 描述::新增品牌列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    Array :: data :: 需要新增的数据
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 新增成功id
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function addBrands($data=Array()){
		try{
			$bool=false;
			$rows=$this->data->insert($this->item,$data);
			$rows>0 && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,6,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::BrandService::saveBrands
	 * ----------------------------------------------------------
	 * 描述::品牌保存数据方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id     :: 需要保存的id
	 *parm2:in--    Array :: data  ::需要保存的数据
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 操作成功状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function saveBrands($id,$data=Array()){
		try{
			$bool=false;
			$rows=$this->data->update($this->item,$id,$data);
			$rows>0 && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,5,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::BrandService::delete
	 * ----------------------------------------------------------
	 * 描述::删除数据方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id        :: 需要删除的id
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool     :: 验证状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function delete($id){
		try{
			$bool=false;
			$rows=$this->data->delete($this->item,$id);
			$rows>0 && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,4,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::BrandService::checkBrands
	 * ----------------------------------------------------------
	 * 描述::检测名称或者记录的状态
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: id        :: 需要获取的id
	 *parm2:in--    String :: name  ::需要验证的名称
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 验证状态
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function checkBrands($name=NULL,$id=NULL){
		try{
			$bool=false;
			(!empty($name) && $where=Array("status"=>1,"name"=>$name)) ||
			(!empty($id) && $where=Array("status"=>1,"id"=>$id));
			$rows=$this->data->select($this->item,$where);
			(!empty($rows) && count($rows)>0) && $bool=true;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::BrandService::getTotal
	 * ----------------------------------------------------------
	 * 描述::获取所有记录行数
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getTotal($Pid){
		try{
			$model=new BrandModel();
			$rows=$model->getBrandList(2,$Pid);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::BrandModel::search
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
	 *parm7:in--    String :: code ::汽车简码
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function search($Pid,$series,$rank,$name,$code,$page){
			try{
			$bool=Array();
			$model=new BrandModel();
			$cars=$model->getSearch(1,$Pid,$series!=NULL?$series:NULL,$rank!=NULL?$rank:NULL,$name!=NULL?$name:NULL,$code!=NULL?$code:NULL,($page-1)*100,100);
			(!empty($cars) && count($cars)>0) && $bool=$cars;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::BrandService::getSearchTotal
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
	public function getSearchTotal($Pid,$series,$rank,$name,$code){
		try{
			$model=new BrandModel();
			$rows=$model->getSearch(2,$Pid,$series!=NULL?$series:NULL,$rank!=NULL?$rank:NULL,$name!=NULL?$name:NULL,$code!=NULL?$code:NULL);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::BrandService::findBrand
	 * ----------------------------------------------------------
	 * 描述::提供给外部调用的查找方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    Array :: where  ::需要查找的条件
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  String :: bool   ::返回数据列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function findBrand($where=Array()){
		try{
			$bool=Array();
			$find=$this->data->select($this->item,empty($where)?Array('status'=>1):$where);
			(!empty($find) && count($find)>0) && $bool=$find;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
}
