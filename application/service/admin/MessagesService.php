<?php/***************************************************** **作者：张文晓**创始时间：2017-03-01**描述：平台系统消息service类。*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");class MessagesService{	#.引用属性，每个控制器都需要有	private $includes;	private $data;	private $model;	private $item=7;	private $system;	private $session;
	/**	 ***********************************************************	 *方法::MessagesService::__construct	 * ----------------------------------------------------------	 *描述::平台系统消息service类初始化方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    无	 *----------------------------------------------------------	 *返回：	 *return:out--  无	 * ----------------------------------------------------------	 * 日期:2017.03.01  Add by zwx	 ************************************************************	 */
	public function __construct(){		$this->includes=new Includes(__FILE__);		$this->includes->models("DataBase","global");		$this->includes->models("MessagesModel");		$this->includes->libraries("CurrSystem");	    $this->includes->libraries("CurrLog");	    $this->includes->libraries("CurrSession");	    $this->session=new CurrSession();	    $this->system=new CurrSystem();		$this->model=new MessagesModel();	    $this->data=new DataBase();	}
	/**	 ***********************************************************	 *方法::MessagesService::getList	 * ----------------------------------------------------------	 * 描述::平台系统消息service类获取列表方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    无	 *----------------------------------------------------------	 *返回：	 *return:out--  Array :: bool :: 返回数据列表	 * ----------------------------------------------------------	 * 日期:2017.03.01  Add by zwx	 ************************************************************	 */
	public function getList($page){	    try{			$bool=Array();			$list=$this->model->getMessagesList(1,($page-1)*20,20);			(!empty($list) && count($list)>0) && $bool=$list;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	 ***********************************************************	 *方法::MessagesService::getMessages	 * ----------------------------------------------------------	 * 描述::平台系统消息service类获取数据详情	 *----------------------------------------------------------	 *参数:	 *parm2:in--   String :: id  			::需要获取的id	 *----------------------------------------------------------	 *返回：	 *return:out--  String :: bool   ::已经获取的数组列表	 * ----------------------------------------------------------	 * 日期:2017.03.01  Add by zwx	 ************************************************************	 */
	public function getMessages($id){	    try{			$bool=Array();			$area=$this->data->select($this->item,array("status"=>1,"id"=>$id));			(!empty($area) && count($area)>0) && $bool=$area;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	 ***********************************************************	 *方法::MessagesService:addMessages	 * ----------------------------------------------------------	 * 描述::平台系统消息service类新增数据方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    Array :: data :: 需要新增的数据	 *----------------------------------------------------------	 *返回：	 *return:out--  Array :: bool :: 新增成功id	 * ----------------------------------------------------------	 * 日期:2017.03.01  Add by zwx	 ************************************************************	 */
	public function addMessages($data=array()){	    try{			$bool=false;			$rows=$this->data->insert($this->item,$data);			$rows>0 && $bool=true;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,6,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	 ***********************************************************	 *方法::MessagesService::saveMessages	 * ----------------------------------------------------------	 * 描述::平台系统消息service类保存数据方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    String :: id     :: 需要保存的id	 *parm2:in--    Array :: data  ::需要保存的数据	 *----------------------------------------------------------	 *返回：	 *return:out--  Array :: bool :: 操作成功状态	 * ----------------------------------------------------------	 * 日期:2017.03.01  Add by zwx	 ************************************************************	 */
	public function saveMessages($id,$data){	    try{			$bool=false;			$rows=$this->data->update($this->item,$id,$data);			$rows>0 && $bool=true;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,5,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	 ***********************************************************	 *方法::MessagesService::delete	 * ----------------------------------------------------------	 * 描述::平台系统消息service类删除数据方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    String :: id        :: 需要删除的id	 *----------------------------------------------------------	 *返回：	 *return:out--  Array :: bool     :: 验证状态	 * ----------------------------------------------------------	 * 日期:2017.03.01  Add by zwx	 ************************************************************	 */
	public function delete($id){	    try{			$bool=false;			$rows=$this->data->delete($this->item,$id);			$rows>0 && $bool=true;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,4,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	***********************************************************	*方法::MessagesService::checkMessages	* ----------------------------------------------------------	* 描述::平台系统消息service类检测名称或者记录的状态	*----------------------------------------------------------	*参数:	*parm1:in--    String :: id        :: 需要获取的id	*parm2:in--    String :: name  ::需要验证的名称	*----------------------------------------------------------	*返回：	*return:out--  Array :: bool :: 验证状态	* ----------------------------------------------------------	* 日期:2017.03.01  Add by zwx	************************************************************	*/
	public function checkMessages($name=NULL,$id=NULL){	    try{			$bool=false;			(!empty($name) && $where=array("status"=>1,"name"=>$name)) ||			(!empty($id) && $where=array("status"=>1,"id"=>$id));			$rows=$this->data->select($this->item,$where);			(!empty($rows) && count($rows)>0) && $bool=true;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	 ***********************************************************	 *方法::MessagesService::findMessages	 * ----------------------------------------------------------	 * 描述::平台系统消息service类提供给外部调用的查找方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    Array :: where  ::需要查找的条件	 *----------------------------------------------------------	 *返回：	 *return:out--  String :: bool   ::返回数据列表	 * ----------------------------------------------------------	 * 日期:2017.03.01  Add by zwx	 ************************************************************	 */
	public function findMessages($where=array()){	    try{			$bool=Array();			$find=$this->data->select($this->item,empty($where)?array("status"=>1):$where);			(!empty($find) && count($find)>0) && $bool=$find;			return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	 ***********************************************************	 *方法::MessagesService::search	 * ----------------------------------------------------------	 * 描述::平台系统消息service类页面搜索方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    Array :: where  ::需要查找的条件	 *----------------------------------------------------------	 *返回：	 *return:out--  String :: bool   ::返回数据列表	 * ----------------------------------------------------------	 * 日期:2017.03.01  Add by zwx	 ************************************************************	 */
	public function search($name,$types,$mark,$startPublicDate,$lastPublicDate,$startPushTime,$lastPushTime,$areaId,$brandId,$operatorName,$page){	    try{	    	$bool=array();	    	$list=$this->model->getSearch(1,$name!=NULL?$name:NULL,$types!=NULL?$types:NULL,$mark!=NULL?$mark:NULL,$startPublicDate!=NULL?$startPublicDate:NULL,$lastPublicDate!=NULL?$lastPublicDate:NULL,$startPushTime!=NULL?$startPushTime:NULL,$lastPushTime!=NULL?$startPushTime:NULL,$areaId!=NULL?$areaId:NULL,$brandId!=NULL?$brandId:NULL,$operatorName!=NULL?$operatorName:NULL,($page-1)*100,100);	    	(!empty($list) && count($list)>0) && $bool=$list;	    	return $bool;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}
	/**	***********************************************************	*方法::MessagesService::getTotal	* ----------------------------------------------------------	*描述::获取所有记录行数	*----------------------------------------------------------	*参数:	*parm1:in--    无	*----------------------------------------------------------	*返回：	*return:out--  无	* ----------------------------------------------------------	*日期:2017.03.01  Add by zwx	************************************************************	*/
	public function getTotal(){	    try{			$model=new MessagesModel();			$rows=$this->model->getMessagesList(2);			return  $rows>0?$rows:0;		}catch(Exception $e) {			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());			$log->error();		}	}	/**
	 ***********************************************************
	 *方法::MessagesService::getTotal
	 * ----------------------------------------------------------
	 *描述::获取所有记录行数
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 *日期:2017.03.01  Add by zwx
	 ************************************************************
	 */
	public function getSearchTotal($name,$types,$mark,$startPublicDate,$lastPublicDate,$startPushTime,$lastPushTime,$areaId,$brandId,$operatorName){
		try{
			$rows=$this->model->getSearch(2,$name!=NULL?$name:NULL,$types!=NULL?$types:NULL,$mark!=NULL?$mark:NULL,$startPublicDate!=NULL?$startPublicDate:NULL,$lastPublicDate!=NULL?$lastPublicDate:NULL,$startPushTime!=NULL?$startPushTime:NULL,$lastPushTime!=NULL?$startPushTime:NULL,$areaId!=NULL?$areaId:NULL,$brandId!=NULL?$brandId:NULL,$operatorName!=NULL?$operatorName:NULL);
			return  $rows>0?$rows:0;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}	/**
	 ***********************************************************
	 *方法::MessagesService::findGro
	 * ----------------------------------------------------------
	 *描述::获取所有集团列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 *日期:2017.03.01  Add by zwx
	 ************************************************************
	 */	public function findGro(){		try{
			$bool=Array();
			$find=$this->data->select(13,array("status"=>1,"isCompany"=>0));
			(!empty($find) && count($find)>0) && $bool=$find;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}	}	/**
	 ***********************************************************
	 *方法::MessagesService::findProvider
	 * ----------------------------------------------------------
	 *描述::获取所有门店列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 *日期:2017.03.01  Add by zwx
	 ************************************************************
	 */	public function findProvider(){		try{
			$bool=Array();
			$find=$this->data->select(13,array("status"=>1));
			(!empty($find) && count($find)>0) && $bool=$find;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}	}
}