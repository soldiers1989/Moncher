<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-02-17
**描述：菜单管理service类。
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class MenuService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $item=4;
	private $session;
	private $system;
	/**
	 ***********************************************************
	 *方法::MenuService::__construct
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
		$this->includes->models('MenuModel');
		$this->includes->libraries('CurrSystem');
		$this->includes->libraries('CurrLog');
		$this->includes->libraries('CurrSession');
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::MenuService::getList
	 * ----------------------------------------------------------
	 * 描述::获取列表方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 返回数据列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getList($Pid,$page){
		try{
			$bool=Array();
			$model=new MenuModel();
			$menu=$model->getMenuList(1,$Pid,($page-1)*20,20);
			(!empty($menu) && count($menu)>0) && $bool=$menu;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::MenuService::getMenus
	 * ----------------------------------------------------------
	 * 描述::权限管理service类获取权限明细
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: Pid       ::父级id
	 *parm2:in--   String :: id  			::菜单id
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  String :: bool   ::已经获取的数组列表
	 * ----------------------------------------------------------
	 * 日期:2017.02.17  Add by zwx
	 ************************************************************
	 */
	public function getMenus($Pid,$id=0){
		try{
			$bool=Array();
			$menu=$this->data->select($this->item,$id==0?Array('status'=>1,'pId'=>$Pid):Array('status'=>1,'id'=>$id));
			(!empty($menu) && count($menu)>0) && $bool=$menu;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::MenuService:addMenu
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
	public function addMenu($data=Array()){
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
	 *方法::MenuService::saveMenu
	 * ----------------------------------------------------------
	 * 描述::菜单保存数据方法
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
	public function saveMenu($id,$data=Array()){
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
	 *方法::MenuService::checkMenu
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
	public function checkMenu($name=NULL,$id=NULL){
		try{
			$bool=false;
			(!empty($name) && $where=Array("status"=>1,"navTitle"=>$name)) ||
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
	 *方法::MenuService::delete
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
	 *方法::MenuService::getTotal
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
			$model=new MenuModel();
			$rows=$model->getMenuList(2,$Pid);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::AreaService::findMenu
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
	public function findMenu($where=Array()){
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
	/**
	 ***********************************************************
	 *方法::MenuService::search
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束
	 *parm4:in--    String :: Pid    :: 父级id
	 *parm5:in--    String :: navTitle   ::导航标题
	 *parm6:in--    String :: startDate ::起始时间
	 *parm7:in--    String :: lastDate   ::结束时间
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function search($Pid,$navTitle,$startDate,$lastDate,$page){
		try{
			$bool=Array();
			$model=new MenuModel();
			$menu=$model->getSearch(1,$Pid!=NULL?$Pid:NULL,$navTitle!=NULL?$navTitle:NULL,$startDate!=NULL?$startDate:NULL,$lastDate!=NULL?$lastDate:NULL,($page-1)*20,20);
			(!empty($menu) && count($menu)>0) && $bool=$menu;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
	/**
	 ***********************************************************
	 *方法::MenuService::getSearchTotal
	 * ----------------------------------------------------------
	 * 描述::获取列表分页及数量方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :: type ::获取数量 OR 结果
	 *parm2:in--    String :: open :: 分页起始
	 *parm3:in--    String :: last    :: 分页结束
	 *parm4:in--    String :: Pid    :: 父级id
	 *parm5:in--    String :: navTitle   ::导航标题
	 *parm6:in--    String :: startDate ::起始时间
	 *parm7:in--    String :: lastDate   ::结束时间
	 *----------------------------------------------------------
	 *返回：
	 *return:out1--  Int :: rows      :: 获取数量
	 *return:out2--  Array::query  :: 获取结果数组
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function getSearchTotal($Pid,$navTitle,$startDate,$lastDate){
		try{
			$model=new MenuModel();
			$rows=$model->getSearch(2,$Pid!=NULL?$Pid:NULL,$navTitle!=NULL?$navTitle:NULL,$startDate!=NULL?$startDate:NULL,$lastDate!=NULL?$lastDate:NULL);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
}
