<?php
/*****************************************************
 **作者：武靖人
**创始时间：2017-02-24
**描述：集团service类。
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class ConceptualService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $data;
	private $system;
	private $session;
	private $model;
	/**
	 ***********************************************************
	 *方法::RoleService::__construct
	 * ----------------------------------------------------------
	 *描述::数据监控service类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.05  Add by 武靖人
	 ************************************************************
	 */
	public function __construct(){

		$this->includes=new Includes(__FILE__);
		$this->includes->models("DataBase","global");
		$this->includes->models("ConceptualModel");
		$this->includes->libraries("CurrSystem");
	    $this->includes->libraries("CurrLog");
	    $this->includes->libraries("CurrSession");
	    $this->session=new CurrSession();
	    $this->system=new  CurrSystem();
	    $this->model=new ConceptualModel();
	    $this->data=new DataBase();


	}
	// 总体总样本量
	public function getSize($mid){
		return $this->model->getSizeData($mid);
	}
	//总体总平均分
	public function getAllSize($fid){
		return $this->model->getAllSizeData($fid);
	}
	// 总体各模块平均分
	public function getMean($pid){
		return $this->model->getMeanData($pid);
	}
	// 总体各模块数量
	public function getCount($sid){
		return $this->model->getCountData($sid);
	} 
	//总体进度条换算百分比
	public function pre_num($sid){
		$arr=0;
		foreach($sid as $vv){
			$all+=$vv['size'];
		}
		$ans=array();
		for($i=0; $i<count($sid);$i++){
			$ans[$i]['size']   =substr(($sid[$i]['size']/$all)*100,0,4);
		}
		return $ans;
	}
	// 本日样本量总数
	public function getDay($did){
		return $this->model->getDayData($did);
	}
	//本日样本总平均分
	public function getDays($rid){
		return $this->model->getDaysData($rid);
	}
	//本日样本数量
	public function getdayy($y_id){
		return $this->model->getDayyData($y_id);
	}
	//本日各模块测评得分
	public function getDayf($d_id){
		return $this->model->getDayfData($d_id);
	}
	//年度用户样本得分
	public function getYear($nid){
		return $this->model->getYearData($nid);
	}
	// // 条形各模块数量
	// public function getLeaf($lid,$time){
	// 	return $this->model->getLeafData($lid);
	// }
	// // 集团各月份得分
	// public function getMonth($mfid){
	// 	return $this->model->getMonthData($mfid);
	// }
	//四个季度样本数量
	public function getQuarter($jyid){
		return $this->model->getQuarterData($jyid);
	}
	//月份总数量
	public function getMonth($msid){
		return $this->model->getMonthData($msid);
	}
	//月份总得分
	public function getMontha($yfid){
		return $this->model->getMonthaData($yfid);
	}
	// 月份各模块数量
	public function getMonths($m_id){
		return $this->model->getMonthsData($m_id);
	}
	//月份各模块测评得分
	public function getMonthb($b_id){
		return $this->model->getMonthbData($b_id);
	}
	//当前月份中每一天的测评得分
	// public function getMonthday($mdid){
	// 	return $this->model->getMonthdayData($mdid);
	// }
	//当前季度测评评分
	public function getQuaterf($qyid){
		return $this->model->getQuarterfData($qyid);
	}
	//当前季度各模块样本数量
	public function getQuarters($qsid){
		return $this->model->getQuartersData($qsid);
	}
	//当前季度各模块测评得分
	public function getQuarta($a_id){
		return $this->model->getQuartaData($a_id);
	}
	//本年度样本总数
	public function getYeara($yid){
		return $this->model->getYearaData($yid);
	}
	//年度下各模块测评得分
	public function getYears($ysid){
		return $this->model->getYearsData($ysid);
	}
	//年度各模块下样本数量
	public function getYearc($cid){
		return $this->model->getYearcData($cid);
	}
	//总体条形图百分比

	/**
	 * 数据分析-门店主页分析-五大模块防止空值
	 */
	public function empty_data($data){
 		echo "<pre>";
       $da=array();
		foreach($data as $key=>$vp){
			if($key==0 && $vp['name']!='服务顾问'){
				$da['name']='服务顾问';
				$da['score']='0';
				array_push($data,$da);
			}
			if($key==1 && $vp['name']!='服务设施'){
				$key['name']='服务设施';
				$key['score']='0';
				array_push($data,$key);
			}
			if($key==2 && $vp['name']!='维修质量'){
				$da['name']='维修质量';
				$da['score']='0';
				array_push($data,$da);
			}
			if($key==3 && $vp['name']!='维修价格'){
				$da['name']='维修价格';
				$da['score']='0';
				array_push($data,$da);
			}
			if($key==4 && $vp['name']!='维修时间'){
				$da['name']='维修时间';
				$da['score']='0';
				array_push($data,$da);
			}
		}
// 		print_r($data);die;
		return $data;
	}
}