<?php
/*****************************************************
 **作者：hjm
**创始时间：2017-03-18
**描述：门店评测分析
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class AnaindustryService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $system;
	private $session;
	private $model;
	/**
	 ***********************************************************
	 *方法::AnaindustryService::__construct
	 * ----------------------------------------------------------
	 *描述::厂家service类初始化方法
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
	    $this->includes->models("AnaindustryModel");
	    $this->includes->libraries("CurrLog");
	    $this->includes->libraries("CurrSession");
	    $this->session=new CurrSession();
	    $this->system=new CurrSystem();
		$this->model=new AnaindustryModel();
	    $this->data=new DataBase();

	}

	/**
	 * 门店评测分析-厂家主页总分
	 * 日期:2017.03.29  Add by hjm
	 */
	public function getScore($brnadid,$month){
		return $this->model->getScoreData($brnadid,$month);
	}
	/**
	 * 门店评测分析-厂家主页排名
	 * 日期:2017.03.29  Add by hjm
	 */
	public function getRank($rank){
		return $this->model->getRankData($rank);
	}
	/**
	 * 门店评测分析-本品牌总样本量
	 * 日期:2017.03.30  Add by hjm
	 */
	public function getNum($brandid){
		return $this->model->getNumData($brandid);
	}
	/**
	 * 门店评测分析-所有品牌总样本量
	 * 日期:2017.03.30  Add by hjm
	 */
	public function getAllNum(){
		return $this->model->getAllNumData();
	}
	
	/**
	 * 门店评测分析-评测得分
	 * 日期:2017.03.30  Add by hjm
	 */
	public function getAnaScore($brandid,$month){
	return $this->model->getAnaScoreData($brandid,$month);
	}
	/**
	 * 门店评测分析-行业评测得分
	 * 日期:2017.03.30  Add by hjm
	 */
 	public function gethyScore($rank,$month){
	return $this->model->gethyScoreData($rank,$month);
	} 
	/**
	 * 门店评测分析-关键指标分析
	 * 日期:2017.03.30  Add by hjm
	 */
	public function getIndex($brandid,$que){
		return $this->pre_num($this->model->getIndexData($brandid,$que));
	}
	/**
	 * 门店评测分析-本年各月度品侧的分
	 * 日期:2017.03.30  Add by hjm
	 */
	public function getMonthScore($brandid){
		return $this->model->getMonthScoreData($brandid);
	}
	/**
	 * 数据分析-门店评测分析-换算百分比率
	 * 参数:$data_name 答案数组
	 * 日期:2017.03.21  Add by hjm
	 */
	public function pre_num($data_name){
		$arr=0;
		foreach($data_name as $vv){
			$all+=$vv['num'];
		}
		$ans=array();
		for($i=0; $i<count($data_name);$i++){
			$ans[$i]['num_pre'] =substr(($data_name[$i]['num']/$all)*100,0,4);
			$ans[$i]['answer']    =$data_name[$i]['answer'];
			$ans[$i]['title']         =$data_name[$i]['title'];
		}
		return $ans;
	}
	
	
}