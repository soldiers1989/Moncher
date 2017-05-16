<?php/***************************************************** **作者：张文晓**创始时间：2017-02-24**描述：商户菜单管理service类。*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");	class MerchantNavService{		#.引用属性，每个控制器都需要有		private $includes;		private $data;		private $item=24;		private $system;		private $session;
	/**	 ***********************************************************	 *方法::MerchantNavService::__construct	 * ----------------------------------------------------------	 *描述::商户菜单管理service类初始化方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    无	 *----------------------------------------------------------	 *返回：	 *return:out--  无	 * ----------------------------------------------------------	 * 日期:2017.02.24  Add by zwx	 ************************************************************	 */
	public function __construct(){		$this->includes=new Includes(__FILE__);		$this->includes->models("DataBase","global");		$this->includes->models("MerchantNavModel");		$this->includes->libraries("CurrSystem");	    $this->includes->libraries("CurrLog");	    $this->includes->libraries("CurrSession");	    $this->session=new CurrSession();	    $this->system=new CurrSystem();	    $this->data=new DataBase();	}
	/**	 ***********************************************************	 *方法::MerchantNavService::getList	 * ----------------------------------------------------------	 * 描述::商户菜单管理service类获取列表方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    无	 *----------------------------------------------------------	 *返回：	 *return:out--  Array :: bool :: 返回数据列表	 * ----------------------------------------------------------	 * 日期:2017.02.24  Add by zwx	 ************************************************************	 */
	public function getList($Pid,$page){	    try{			$bool=Array();			$model=new MerchantNavModel();			$list=$model->getMerchantNavList(1,$Pid,($page-1)*20,20);			(!empty($list) && count($list)>0) && $bool=$list;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	 ***********************************************************	 *方法::MerchantNavService::getMerchantNav	 * ----------------------------------------------------------	 * 描述::商户菜单管理service类获取数据详情	 *----------------------------------------------------------	 *参数:	 *parm2:in--   String :: id  			::需要获取的id	 *----------------------------------------------------------	 *返回：	 *return:out--  String :: bool   ::已经获取的数组列表	 * ----------------------------------------------------------	 * 日期:2017.02.24  Add by zwx	 ************************************************************	 */
	public function getMerchantNav($Pid,$id=0){	    try{			$bool=Array();			$area=$this->data->select($this->item,$id==0?Array('status'=>1,'pId'=>$Pid):Array('status'=>1,'id'=>$id));			(!empty($area) && count($area)>0) && $bool=$area;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	 ***********************************************************	 *方法::MerchantNavService:addMerchantNav	 * ----------------------------------------------------------	 * 描述::商户菜单管理service类新增数据方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    Array :: data :: 需要新增的数据	 *----------------------------------------------------------	 *返回：	 *return:out--  Array :: bool :: 新增成功id	 * ----------------------------------------------------------	 * 日期:2017.02.24  Add by zwx	 ************************************************************	 */
	public function addMerchantNav($data=array()){	    try{			$bool=false;			$rows=$this->data->insert($this->item,$data);			$rows>0 && $bool=true;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,6,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	 ***********************************************************	 *方法::MerchantNavService::saveMerchantNav	 * ----------------------------------------------------------	 * 描述::商户菜单管理service类保存数据方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    String :: id     :: 需要保存的id	 *parm2:in--    Array :: data  ::需要保存的数据	 *----------------------------------------------------------	 *返回：	 *return:out--  Array :: bool :: 操作成功状态	 * ----------------------------------------------------------	 * 日期:2017.02.24  Add by zwx	 ************************************************************	 */
	public function saveMerchantNav($id,$data){	    try{			$bool=false;			$rows=$this->data->update($this->item,$id,$data);			$rows>0 && $bool=true;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,5,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	 ***********************************************************	 *方法::MerchantNavService::delete	 * ----------------------------------------------------------	 * 描述::商户菜单管理service类删除数据方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    String :: id        :: 需要删除的id	 *----------------------------------------------------------	 *返回：	 *return:out--  Array :: bool     :: 验证状态	 * ----------------------------------------------------------	 * 日期:2017.02.24  Add by zwx	 ************************************************************	 */
	public function delete($id){	    try{			$bool=false;			$rows=$this->data->delete($this->item,$id);			$rows>0 && $bool=true;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,4,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	***********************************************************	*方法::MerchantNavService::checkMerchantNav	* ----------------------------------------------------------	* 描述::商户菜单管理service类检测名称或者记录的状态	*----------------------------------------------------------	*参数:	*parm1:in--    String :: id        :: 需要获取的id	*parm2:in--    String :: name  ::需要验证的名称	*----------------------------------------------------------	*返回：	*return:out--  Array :: bool :: 验证状态	* ----------------------------------------------------------	* 日期:2017.02.24  Add by zwx	************************************************************	*/
	public function checkMerchantNav($name=NULL,$id=NULL){	    try{			$bool=false;			(!empty($name) && $where=array("status"=>1,"navTitle"=>$name)) ||			(!empty($id) && $where=array("status"=>1,"id"=>$id));			$rows=$this->data->select($this->item,$where);			(!empty($rows) && count($rows)>0) && $bool=true;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	 ***********************************************************	 *方法::MerchantNavService::findMerchantNav	 * ----------------------------------------------------------	 * 描述::商户菜单管理service类提供给外部调用的查找方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    Array :: where  ::需要查找的条件	 *----------------------------------------------------------	 *返回：	 *return:out--  String :: bool   ::返回数据列表	 * ----------------------------------------------------------	 * 日期:2017.02.24  Add by zwx	 ************************************************************	 */
	public function findMerchantNav($where=array()){	    try{			$bool=Array();			$find=$this->data->select($this->item,empty($where)?array("status"=>1):$where);			(!empty($find) && count($find)>0) && $bool=$find;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	***********************************************************	*方法::MerchantNavService::getTotal	* ----------------------------------------------------------	*描述::获取所有记录行数	*----------------------------------------------------------	*参数:	*parm1:in--    无	*----------------------------------------------------------	*返回：	*return:out--  无	* ----------------------------------------------------------	*日期:2017.02.24  Add by zwx	************************************************************	*/
	public function getTotal($Pid){	    try{			$model=new MerchantNavModel();			$rows=$model->getMerchantNavList(2,$Pid);			return  $rows>0?$rows:0;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}	/**
	 ***********************************************************
	 *方法::MerchantNav::search
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
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function search($Pid,$navTitle,$startDate,$lastDate,$page){
		try{
			$bool=NULL;
			$model=new MerchantNavModel();
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
	 *方法::MerchantNav::getSearchTotal
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
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function getSearchTotal($Pid,$navTitle,$startDate,$lastDate){
		try{
			$model=new MerchantNavModel();
			$rows=$model->getSearch(2,$Pid!=NULL?$Pid:NULL,$navTitle!=NULL?$navTitle:NULL,$startDate!=NULL?$startDate:NULL,$lastDate!=NULL?$lastDate:NULL);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession('Admin','loginName'),$this->system->getSystemTime('A'),'',$e->getMessage());
			$log->error();
		}
	}
}