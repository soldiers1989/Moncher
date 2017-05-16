<?php
/*****************************************************
 **作者：hjm
**创始时间：2017-03-18
**描述：门店评测分析
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class AnastoreService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $system;
	private $session;
	private $model;
	/**
	 ***********************************************************
	 *方法::AnastoreService::__construct
	 * ----------------------------------------------------------
	 *描述::商户注册service类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.24  Add by zwx
	 ************************************************************
	 */
	public function __construct(){		
		$this->includes=new Includes(__FILE__);
		$this->includes->models("DataBase","global");
	    $this->includes->models("AnastoreModel");
	    $this->includes->libraries("CurrLog");
	    $this->includes->libraries("CurrSession");
	    $this->session=new CurrSession();
	    $this->system=new CurrSystem();
		$this->model=new AnastoreModel();
	    $this->data=new DataBase();

	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getTotal
	 * ----------------------------------------------------------
	 *描述::门店总体数据
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
	public function getTotal($providerid,$modelid,$rank,$startDate,$endDate){
		$data=$this->model->getTotaldata($providerid,$modelid,$rank,$startDate,$endDate);
		return count($data)>0?$data[0]:array();
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getNPS
	 * ----------------------------------------------------------
	 *描述::门店总体重点指标分析
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
	public function getNPS($providerid,$modelid){
		$data=$this->model->getMerchantNPS($providerid,$modelid);
		return count($data)>0?$data[0]:array();
	}
	/**
	***********************************************************
	*方法::AnastoreService::getTop
	* ----------------------------------------------------------
	*描述::门店总体排名
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
	public function getTop($providerid,$modelid,$rank){
		$data=$this->model->getMerchantTop($providerid,$modelid,$rank);
		$data['size']=count($data)>0?count($data):0;
		for($i=0;$i<count($data);$i++){
			$data[$i]['merchantId']==$providerid && $data['top']=($i+1);
		}
		return $data;
	}
	/**
	***********************************************************
	*方法::AnastoreService::getTop
	* ----------------------------------------------------------
	*描述::门店总体排名
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
	public function getEvalData($providerid,$modelid,$rank,$startDate,$endDate){
		$data=$this->model->getEvalData($providerid,$modelid,$rank,$startDate,$endDate);
		return count($data)>0?$data[0]:array();
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getNPS
	 * ----------------------------------------------------------
	 *描述::门店总体重点指标分析
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
	public function getNPSi($providerid,$modelid,$startDate,$endDate){
		$data=$this->model->getMerchantNPSi($providerid,$modelid,$startDate,$endDate);
		return count($data)>0?$data[0]:array();
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getQuestionTop
	 * ----------------------------------------------------------
	 *描述::门店总体重点指标分析
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
	public function getQuestionTop($providerid,$modelid,$startDate,$endDate,$data){
		$model=$this->model->getModels($modelid);
		$data['Fa']=$this->model->getQuestionTop('DESC',$model[0]['id'],$providerid,$startDate,$endDate);
		$data['Sa']=$this->model->getQuestionTop('DESC',$model[1]['id'],$providerid,$startDate,$endDate);
		$data['Za']=$this->model->getQuestionTop('DESC',$model[2]['id'],$providerid,$startDate,$endDate);
		$data['Ta']=$this->model->getQuestionTop('DESC',$model[3]['id'],$providerid,$startDate,$endDate);
		$data['Pa']=$this->model->getQuestionTop('DESC',$model[4]['id'],$providerid,$startDate,$endDate);
		$data['Fb']=$this->model->getQuestionTop('ASC',$model[0]['id'],$providerid,$startDate,$endDate);
		$data['Sb']=$this->model->getQuestionTop('ASC',$model[1]['id'],$providerid,$startDate,$endDate);
		$data['Zb']=$this->model->getQuestionTop('ASC',$model[2]['id'],$providerid,$startDate,$endDate);
		$data['Tb']=$this->model->getQuestionTop('ASC',$model[3]['id'],$providerid,$startDate,$endDate);
		$data['Pb']=$this->model->getQuestionTop('ASC',$model[4]['id'],$providerid,$startDate,$endDate);
		return $data;
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getMerchantStore
	 * ----------------------------------------------------------
	 *描述::获取门店不同时间的得分和数量
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
	public function getMerchantStore($type,$providerid,$modelid){
		$data=$this->model->getMerchantStore($type,$providerid,$modelid);
		return count($data)>0?$data[0]:array();
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getQuarScore
	 * ----------------------------------------------------------
	 *描述::获取门店季度得分
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
	public function getQuarScore($providerid,$modelid){
		$model=$this->model->getModels($modelid);
		$F=$this->model->getQuarScore($providerid,$model[0]['id']);
		$data[0]=$F[0];
		$S=$this->model->getQuarScore($providerid,$model[1]['id']);
		$data[1]=$S[0];
		$Z=$this->model->getQuarScore($providerid,$model[2]['id']);
		$data[2]=$Z[0];
		$T=$this->model->getQuarScore($providerid,$model[3]['id']);
		$data[3]=$T[0];
		$P=$this->model->getQuarScore($providerid,$model[4]['id']);
		$data[4]=$P[0];
		return $this->setModels(4,$data);
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getYearScore
	 * ----------------------------------------------------------
	 *描述::获取门店年度得分
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
	public function getYearScore($providerid,$modelid){
		$model=$this->model->getModels($modelid);
		$F=$this->model->getYearScore($providerid,$model[0]['id']);
		$data[0]=$F[0];
		$S=$this->model->getYearScore($providerid,$model[1]['id']);
		$data[1]=$S[0];
		$Z=$this->model->getYearScore($providerid,$model[2]['id']);
		$data[2]=$Z[0];
		$T=$this->model->getYearScore($providerid,$model[3]['id']);
		$data[3]=$T[0];
		$P=$this->model->getYearScore($providerid,$model[4]['id']);
		$data[4]=$P[0];
		return $this->setModels(12,$data);
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getMonthScore
	 * ----------------------------------------------------------
	 *描述::获取门店本月得分
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
	public function getMonthScore($providerid,$modelid,$startDate){
		$model=$this->model->getModels($modelid);
		$F=$this->model->getMonthScore($providerid,$model[0]['id'],$startDate);
		$data[0]=$F[0];
		$S=$this->model->getMonthScore($providerid,$model[1]['id'],$startDate);
		$data[1]=$S[0];
		$Z=$this->model->getMonthScore($providerid,$model[2]['id'],$startDate);
		$data[2]=$Z[0];
		$T=$this->model->getMonthScore($providerid,$model[3]['id'],$startDate);
		$data[3]=$T[0];
		$P=$this->model->getMonthScore($providerid,$model[4]['id'],$startDate);
		$data[4]=$P[0];
		return $this->setModels(date('t',$startDate),$data);
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::setModels
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
		for($i=0;$i<count($data);$i++){
			for($j=1;$j<=$size;$j++){
				$json['size'][$i]['data'][]=(int)$data[$i]['F'.$j];
				$json['score'][$i]['data'][]=(float)$data[$i]['F'.($j+$size)];
			}
		}
	   return $json;
	}
}