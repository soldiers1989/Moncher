<?php
	/*****************************************************
	 **作者：张文晓
	**创始时间：2017-04-12
	**描述：门店预警service类。
	*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
	class MonitorService{
		#.引用属性，每个控制器都需要有
		private $includes;
		private $data;
		private $model;
		private $system;
		private $session;
/**
	 ***********************************************************
	 *方法::MonitorService::__construct
	 * ----------------------------------------------------------
	 *描述::门店预警service类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.12  Add by zwx
	 ************************************************************
	 */
public function __construct(){
		$this->includes=new Includes(__FILE__);
		$this->includes->models("DataBase","global");
		$this->includes->models("MonitorModel");
		$this->includes->libraries("CurrSystem");
		$this->includes->libraries("CurrLog");
		$this->includes->libraries("CurrSession");
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->model=new MonitorModel();
		$this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::MonitorService::getList
	 * ----------------------------------------------------------
	 * 描述::门店预警service类获取列表方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Array :: bool :: 返回数据列表
	 * ----------------------------------------------------------
	 * 日期:2017.04.12  Add by zwx
	 ************************************************************
	 */
	public function getList($groupid,$modelid,$brandid,$areaid,$providerid,$page){
			try{
				$bool=Array();
				$list=$this->model->getMonitorList(1,$groupid,$modelid,$brandid,$areaid,$providerid,$page);
				(!empty($list) && count($list)>0) && $bool=$list;
				return $bool;
			}catch(Exception $e) {
				$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
				$log->error();
			}
	}
	/**
	***********************************************************
	*方法::MonitorService::getTotal
	* ----------------------------------------------------------
	*描述::获取所有记录行数
	*----------------------------------------------------------
	*参数:
	*parm1:in--    无
	*----------------------------------------------------------
	*返回：
	*return:out--  无
	* ----------------------------------------------------------
	*日期:2017.04.12  Add by zwx
	************************************************************
	*/
	public function getTotal($groupid,$modelid,$brandid,$areaid,$providerid){
			try{
				$rows=$this->model->getMonitorList(2,$groupid,$modelid,$brandid,$areaid,$providerid);
				return  $rows>0?$rows:0;
			}catch(Exception $e) {
				$log=new CurrLog(1,3,$this->session->getSession("Merchant","loginName"),$this->system->getSystemTime("A"),"",$e->getMessage());
				$log->error();
			}
	}
	/**
	 ***********************************************************
	 *方法::MonitorService::getGroupStore
	 * ----------------------------------------------------------
	 *描述::获取集团不同时间的得分和数量
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.03.18  Add by ZWX
	 ************************************************************
	 */
	public function getGroupScore($type,$providerid,$modelid,$rank,$areaid,$brandid){
		$data=$this->model->getGroupScore($type,$providerid,$modelid,$rank,$areaid,$brandid);
		return count($data)>0?$data[0]:array();
	}
	/**
	 ***********************************************************
	 *方法::MonitorService::getQuarScore
	 * ----------------------------------------------------------
	 *描述::获取集团季度得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.03.18  Add by ZWX
	 ************************************************************
	 */
	public function getQuarScore($providerid,$modelid,$rank,$areaid,$brandid){
		$model=$this->model->getModels($modelid);
		$F=$this->model->getQuarScore($providerid,$model[0]['id'],$rank,$areaid,$brandid);$data[0]=$F[0];
		$S=$this->model->getQuarScore($providerid,$model[1]['id'],$rank,$areaid,$brandid);$data[1]=$S[0];
		$Z=$this->model->getQuarScore($providerid,$model[2]['id'],$rank,$areaid,$brandid);$data[2]=$Z[0];
		$T=$this->model->getQuarScore($providerid,$model[3]['id'],$rank,$areaid,$brandid);$data[3]=$T[0];
		$P=$this->model->getQuarScore($providerid,$model[4]['id'],$rank,$areaid,$brandid);$data[4]=$P[0];
		return $this->setModels(4,$data);
	}
	/**
	 ***********************************************************
	 *方法::MonitorService::getYearScore
	 * ----------------------------------------------------------
	 *描述::获取集团年度得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.03.18  Add by ZWX
	 ************************************************************
	 */
	public function getYearScore($providerid,$modelid,$rank,$areaid,$brandid){
		$model=$this->model->getModels($modelid);
		$F=$this->model->getYearScore($providerid,$model[0]['id'],$rank,$areaid,$brandid);$data[0]=$F[0];
		$S=$this->model->getYearScore($providerid,$model[1]['id'],$rank,$areaid,$brandid);$data[1]=$S[0];
		$Z=$this->model->getYearScore($providerid,$model[2]['id'],$rank,$areaid,$brandid);$data[2]=$Z[0];
		$T=$this->model->getYearScore($providerid,$model[3]['id'],$rank,$areaid,$brandid);$data[3]=$T[0];
		$P=$this->model->getYearScore($providerid,$model[4]['id'],$rank,$areaid,$brandid);$data[4]=$P[0];
		return $this->setModels(12,$data);
	}
	/**
	 ***********************************************************
	 *方法::MonitorService::getMonthScore
	 * ----------------------------------------------------------
	 *描述::获取集团本月得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.03.18  Add by ZWX
	 ************************************************************
	 */
	public function getMonthScore($providerid,$modelid,$startDate,$rank,$areaid,$brandid){
		$model=$this->model->getModels($modelid);
		$F=$this->model->getMonthScore($providerid,$model[0]['id'],$startDate,$rank,$areaid,$brandid);$data[0]=$F[0];
		$S=$this->model->getMonthScore($providerid,$model[1]['id'],$startDate,$rank,$areaid,$brandid);$data[1]=$S[0];
		$Z=$this->model->getMonthScore($providerid,$model[2]['id'],$startDate,$rank,$areaid,$brandid);$data[2]=$Z[0];
		$T=$this->model->getMonthScore($providerid,$model[3]['id'],$startDate,$rank,$areaid,$brandid);$data[3]=$T[0];
		$P=$this->model->getMonthScore($providerid,$model[4]['id'],$startDate,$rank,$areaid,$brandid);$data[4]=$P[0];
		return $this->setModels(date('t',$startDate),$data);
	}
	/**
	 ***********************************************************
	 *方法::MonitorService::setModels
	 * ----------------------------------------------------------
	 *描述::设置JSON数据格式
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String :
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  Bool : bool
	 * ----------------------------------------------------------
	 * 日期:2017.03.18  Add by ZWX
	 ************************************************************
	 */
	public function setModels($size,$data,$models=array("服务顾问","服务设施","维修质量","维修时间","维修价格")){
		$json=array();
		foreach($models as $key=>$m){
			$json['size'][$key]['name']=$m;
			$json['size'][$key]['data']=array();
			$json['score'][$key]['name']=$m;
			$json['score'][$key]['data']=array();
		}
		/*此处用于拼接数组*/
		for($i=0;$i<count($data);$i++){
			for($j=1;$j<=$size;$j++){
				$json['size'][$i]['data'][]=(int)$data[$i]['F'.$j];
				$json['score'][$i]['data'][]=(float)$data[$i]['F'.($j+$size)];
			}
		}
		return $json;
	}
}