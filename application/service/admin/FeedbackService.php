<?php/***************************************************** **作者：张文晓**创始时间：2017-03-01**描述：平台意见反馈service类。*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");class FeedbackService{	#.引用属性，每个控制器都需要有	private $includes;	private $data;	private $model;	private $item=8;	private $system;	private $session;
/** *********************************************************** *方法::FeedbackService::__construct * ---------------------------------------------------------- *描述::平台意见反馈service类初始化方法 *---------------------------------------------------------- *参数: *parm1:in--    无 *---------------------------------------------------------- *返回： *return:out--  无 * ---------------------------------------------------------- * 日期:2017.03.01  Add by zwx ************************************************************ */
public function __construct(){	$this->includes=new Includes(__FILE__);	$this->includes->models("DataBase","global");	$this->includes->models("FeedbackModel");	$this->includes->libraries("CurrSystem");    $this->includes->libraries("CurrLog");    $this->includes->libraries("CurrSession");    $this->session=new CurrSession();    $this->system=new CurrSystem();	$this->model=new FeedbackModel();    $this->data=new DataBase();}
/** *********************************************************** *方法::FeedbackService::getList * ---------------------------------------------------------- * 描述::平台意见反馈service类获取列表方法 *---------------------------------------------------------- *参数: *parm1:in--    无 *---------------------------------------------------------- *返回： *return:out--  Array :: bool :: 返回数据列表 * ---------------------------------------------------------- * 日期:2017.03.01  Add by zwx ************************************************************ */
public function getList($page){    try{		$bool=Array();		$list=$this->model->getFeedbackList(1,($page-1)*20,20);		(!empty($list) && count($list)>0) && $bool=$list;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::FeedbackService::getFeedback * ---------------------------------------------------------- * 描述::平台意见反馈service类获取数据详情 *---------------------------------------------------------- *参数: *parm2:in--   String :: id  			::需要获取的id *---------------------------------------------------------- *返回： *return:out--  String :: bool   ::已经获取的数组列表 * ---------------------------------------------------------- * 日期:2017.03.01  Add by zwx ************************************************************ */
public function getFeedback($id){    try{		$bool=Array();		$area=$this->data->select($this->item,array("status"=>1,"id"=>$id));		(!empty($area) && count($area)>0) && $bool=$area;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::FeedbackService:addFeedback * ---------------------------------------------------------- * 描述::平台意见反馈service类新增数据方法 *---------------------------------------------------------- *参数: *parm1:in--    Array :: data :: 需要新增的数据 *---------------------------------------------------------- *返回： *return:out--  Array :: bool :: 新增成功id * ---------------------------------------------------------- * 日期:2017.03.01  Add by zwx ************************************************************ */
public function addFeedback($data=array()){    try{		$bool=false;		$rows=$this->data->insert($this->item,$data);		$rows>0 && $bool=true;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,6,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::FeedbackService::saveFeedback * ---------------------------------------------------------- * 描述::平台意见反馈service类保存数据方法 *---------------------------------------------------------- *参数: *parm1:in--    String :: id     :: 需要保存的id *parm2:in--    Array :: data  ::需要保存的数据 *---------------------------------------------------------- *返回： *return:out--  Array :: bool :: 操作成功状态 * ---------------------------------------------------------- * 日期:2017.03.01  Add by zwx ************************************************************ */
public function saveFeedback($id,$data){    try{		$bool=false;		$rows=$this->data->update($this->item,$id,$data);		$rows>0 && $bool=true;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,5,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::FeedbackService::delete * ---------------------------------------------------------- * 描述::平台意见反馈service类删除数据方法 *---------------------------------------------------------- *参数: *parm1:in--    String :: id        :: 需要删除的id *---------------------------------------------------------- *返回： *return:out--  Array :: bool     :: 验证状态 * ---------------------------------------------------------- * 日期:2017.03.01  Add by zwx ************************************************************ */
public function delete($id){    try{		$bool=false;		$rows=$this->data->delete($this->item,$id);		$rows>0 && $bool=true;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,4,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/**************************************************************方法::FeedbackService::checkFeedback* ----------------------------------------------------------* 描述::平台意见反馈service类检测名称或者记录的状态*----------------------------------------------------------*参数:*parm1:in--    String :: id        :: 需要获取的id*parm2:in--    String :: name  ::需要验证的名称*----------------------------------------------------------*返回：*return:out--  Array :: bool :: 验证状态* ----------------------------------------------------------* 日期:2017.03.01  Add by zwx*************************************************************/
public function checkFeedback($name=NULL,$id=NULL){    try{		$bool=false;		(!empty($name) && $where=array("status"=>1,"name"=>$name)) ||		(!empty($id) && $where=array("status"=>1,"id"=>$id));		$rows=$this->data->select($this->item,$where);		(!empty($rows) && count($rows)>0) && $bool=true;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::FeedbackService::findFeedback * ---------------------------------------------------------- * 描述::平台意见反馈service类提供给外部调用的查找方法 *---------------------------------------------------------- *参数: *parm1:in--    Array :: where  ::需要查找的条件 *---------------------------------------------------------- *返回： *return:out--  String :: bool   ::返回数据列表 * ---------------------------------------------------------- * 日期:2017.03.01  Add by zwx ************************************************************ */
public function findFeedback($where=array()){    try{		$bool=Array();		$find=$this->data->select($this->item,empty($where)?array("status"=>1):$where);		(!empty($find) && count($find)>0) && $bool=$find;		return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/** *********************************************************** *方法::FeedbackService::search * ---------------------------------------------------------- * 描述::平台意见反馈service类页面搜索方法 *---------------------------------------------------------- *参数: *parm1:in--    Array :: where  ::需要查找的条件 *---------------------------------------------------------- *返回： *return:out--  String :: bool   ::返回数据列表 * ---------------------------------------------------------- * 日期:2017.03.01  Add by zwx ************************************************************ */
public function search($name,$status,$types,$startFeedTime,$lastFeedTime,$startReplyTime,$lastReplyTime,$baseType,$satisfaction,$operatorName,$page){    try{    	$bool=Array();
    	$list=$this->model->getSearch(1,$name!=NULL?$name:NULL,$status!=NULL?$status:NULL,$types!=NULL?$types:NULL,$startFeedTime!=NULL?$startFeedTime:NULL,$lastFeedTime!=NULL?$lastFeedTime:NULL,$startReplyTime!=NULL?startReplyTime:NULL,$lastReplyTime!=NULL?$lastReplyTime:NULL,$baseType!=NULL?$baseType:NULL,$satisfaction!=NULL?$satisfaction:NULL,$operatorName!=NULL?$operatorName:NULL,($page-1)*100,100);
    	(!empty($list) && count($list)>0) && $bool=$list;
    	return $bool;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}/**************************************************************方法::FeedbackService::getTotal* ----------------------------------------------------------*描述::获取所有记录行数*----------------------------------------------------------*参数:*parm1:in--    无*----------------------------------------------------------*返回：*return:out--  无* ----------------------------------------------------------*日期:2017.03.01  Add by zwx*************************************************************/
public function getTotal(){    try{		$model=new FeedbackModel();		$rows=$this->model->getFeedbackList(2);		return  $rows>0?$rows:0;	}catch(Exception $e) {		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());		$log->error();	}}
/**
 ***********************************************************
 *方法::FeedbackService::getSearchTotal
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
public function getSearchTotal($name,$status,$types,$startFeedTime,$lastFeedTime,$startReplyTime,$lastReplyTime,$baseType,$satisfaction,$operatorName){
	try{
		$rows=$this->model->getSearch(2,$name!=NULL?$name:NULL,$status!=NULL?$status:NULL,$types!=NULL?$types:NULL,$startFeedTime!=NULL?$startFeedTime:NULL,$lastFeedTime!=NULL?$lastFeedTime:NULL,$startReplyTime!=NULL?startReplyTime:NULL,$lastReplyTime!=NULL?$lastReplyTime:NULL,$baseType!=NULL?$baseType:NULL,$satisfaction!=NULL?$satisfaction:NULL,$operatorName!=NULL?$operatorName:NULL);
		return  $rows>0?$rows:0;
	}catch(Exception $e) {
		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
		$log->error();
	}
}/**
 ***********************************************************
 *方法::FeedbackService::findProvider
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
 */
public function findProvider(){
	try{
		$bool=Array();
		$find=$this->data->select(13,array("status"=>1));
		(!empty($find) && count($find)>0) && $bool=$find;
		return $bool;
	}catch(Exception $e) {
		$log=new CurrLog(1,3,$this->session->getSession("Admin","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
		$log->error();
	}
}
}