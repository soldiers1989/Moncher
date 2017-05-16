<?php	/*****************************************************	 **作者：张文晓	**创始时间：2017-04-12	**描述：样本查询service类。	*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");	class RecordService{		#.引用属性，每个控制器都需要有		private $includes;		private $data;		private $model;		private $item=29;		private $system;		private $session;
/**	 ***********************************************************	 *方法::RecordService::__construct	 * ----------------------------------------------------------	 *描述::样本查询service类初始化方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    无	 *----------------------------------------------------------	 *返回：	 *return:out--  无	 * ----------------------------------------------------------	 * 日期:2017.04.12  Add by zwx	 ************************************************************	 */
public function __construct(){		$this->includes=new Includes(__FILE__);		$this->includes->models("DataBase","global");		$this->includes->models("RecordModel");		$this->includes->libraries("CurrSystem");		$this->includes->libraries("CurrLog");		$this->includes->libraries("CurrSession");		$this->session=new CurrSession();		$this->system=new CurrSystem();		$this->model=new RecordModel();		$this->data=new DataBase();	}
	/**	 ***********************************************************	 *方法::RecordService::getList	 * ----------------------------------------------------------	 * 描述::样本查询service类获取列表方法	 *----------------------------------------------------------	 *参数:	 *parm1:in--    无	 *----------------------------------------------------------	 *返回：	 *return:out--  Array :: bool :: 返回数据列表	 * ----------------------------------------------------------	 * 日期:2017.04.12  Add by zwx	 ************************************************************	 */
	public function getList($questionnaireId,$providerId,$groupId,$brandId,$areaId,$startTime,$endTime,$page){			try{				$bool=Array();				$list=$this->model->getRecordList(1,$questionnaireId,$providerId,$groupId,$brandId,$areaId,$startTime,$endTime,($page-1)*100,100);				(!empty($list) && count($list)>0) && $bool=$list;				return $bool;			}catch(Exception $e) {				$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());				$log->error();			}
	}	/**	 ***********************************************************	 *方法::RecordService::getQuestions	 * ----------------------------------------------------------	 * 描述::获取一套问卷的详细得分	 *----------------------------------------------------------	 *参数:	 *parm1:in--    无	 *----------------------------------------------------------	 *返回：	 *return:out--  Array :: bool :: 返回数据列表	 * ----------------------------------------------------------	 * 日期:2017.04.12  Add by zwx	 ************************************************************	 */    public function getQuestions($id){			try{				$bool=Array();				$list=$this->model->getQuestions($id);				(!empty($list) && count($list)>0) && $bool=$list;				return $bool;			}catch(Exception $e) {				$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());				$log->error();			}	}
	/**	***********************************************************	*方法::RecordService::getTotal	* ----------------------------------------------------------	*描述::获取所有记录行数	*----------------------------------------------------------	*参数:	*parm1:in--    无	*----------------------------------------------------------	*返回：	*return:out--  无	* ----------------------------------------------------------	*日期:2017.04.12  Add by zwx	************************************************************	*/
	public function getTotal($questionnaireId,$providerId,$groupId,$brandId,$areaId,$startTime,$endTime){			try{				$model=new RecordModel();				$rows=$this->model->getRecordList(2,$questionnaireId,$providerId,$groupId,$brandId,$areaId,$startTime,$endTime);				return  $rows>0?$rows:0;			}catch(Exception $e) {				$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());				$log->error();			}	}	/**获取搜索条件*/
	public  function getMerchantList($groupid){
		return $this->model->getMerchantList($groupid);
	}
	/**获取搜索条件*/
	public function getBrandList($groupid){
		return $this->model->getBrandList($groupid);
	}
	/**获取搜索条件*/
	public function getAreaList($groupid){
		return $this->model->getAreaList($groupid);
	}
	/**获取搜索条件*/
	public function getGroupList($modelid){
		return $this->model->getGroupList($modelid);
	}
	/**获取搜索条件*/
	public function getModelList(){
		return $this->data->select(27,array("status"=>1));
	}	/**获取搜索条件*/	public function getModels($modelid){		return $this->model->getModels($modelid);	}	/**导出列表*/	public function getXlsList($questionnaireId,$providerId,$groupId,$brandId,$areaId,$startTime,$endTime){
		try{
			$bool=Array();
			$list=$this->model->getRecordList(3,$questionnaireId,$providerId,$groupId,$brandId,$areaId,$startTime,$endTime);
			(!empty($list) && count($list)>0) && $bool=$list;
			return $bool;
		}catch(Exception $e) {
			$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
			$log->error();
		}
	}
}