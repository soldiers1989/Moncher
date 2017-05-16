<?php
/*****************************************************
 **作者：zwx
**创始时间：2017-03-18
**描述：门店评测分析
*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class AnagroupService{
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
	 *描述::集团分析service类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function __construct(){	
		$this->includes=new Includes(__FILE__);
		$this->includes->models("DataBase","global");
 	    $this->includes->models("AnagroupModel");
	    $this->includes->libraries("CurrLog");
	    $this->includes->libraries("CurrSystem");
	    $this->includes->libraries("CurrSession");
	    $this->session=new CurrSession();
	    $this->system=new CurrSystem();
		$this->model=new AnagroupModel();
	    $this->data=new DataBase();
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getAreaList
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取区域列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	 public function getAreaList(){
		 return $this->model->getAreaList($this->session->getSession("Merchant","providerId"));
	 }
	/**
	 ***********************************************************
	 *方法::AnastoreService::getBrandList
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取品牌列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	 public function getBrandList(){
		 return $this->model->getBrandList($this->session->getSession("Merchant","providerId"));
	 }
	/**
	 ***********************************************************
	 *方法::AnastoreService::getMerchantList
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取门店列表
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	 public function getMerchantList(){
		 return $this->model->getMerchantList($this->session->getSession("Merchant","providerId"));
	 }
	/**
	 ***********************************************************
	 *方法::AnastoreService::getMerchantList
	 * ----------------------------------------------------------
	 *描述::集团分析service类获单区域总体得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getAreaiScore($groupid,$areaid,$modelid,$startDate,$endDate){
		$list=$this->model->getAreaiScore($groupid,$areaid,$modelid,$startDate,$endDate);
		return $list[0];
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getAreaiModelScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取单区域各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getAreaiModelScore($groupid,$areaid,$modelid,$startDate,$endDate){
		$list=$this->model->getAreaiModelScore($groupid,$areaid,$modelid,$startDate,$endDate);
		return $list;
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getAreaiModelScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取双区域各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
    public function getAreaiiScore($groupid,$modelid,$startDate,$areai,$areaii){
		$list=$this->model->getAreaiiScore($groupid,$modelid,$startDate,$areai,$areaii);
		return $list[0];
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getAreaiModelScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取双区域各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getAreaiiModelScore($groupid,$modelid,$startDate,$areai,$areaii){
		$list=$this->model->getAreaiiModelScore($groupid,$modelid,$startDate,$areai,$areaii);
		return $list;
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::getEvalAllScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getEvalAllScore($groupid,$modelid,$startDate,$endDate){
		$list=$this->model->getEvalAllScore($groupid,$modelid,$startDate,$endDate);
		return $list[0];
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getEvalAllModelScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getEvalAllModelScore($groupid,$modelid,$startDate,$endDate){
		$list=$this->model->getEvalAllModelScore($groupid,$modelid,$startDate,$endDate);
		return $list;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getBrandiiScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getBrandiScore($groupid,$modelid,$brandid,$startDate,$endDate,$areaid){
		$list=$this->model->getBrandiScore($groupid,$modelid,$brandid,$startDate,$endDate);
		return $list[0];
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getBrandiiModelScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getBrandiModelScore($groupid,$modelid,$brandid,$startDate,$endDate,$areaid){
		$list=$this->model->getBrandiModelScore($groupid,$modelid,$brandid,$startDate,$endDate);
		$model=$this->model->getModels($modelid);
		$muse=array();
		for($i=0;$i<count($model);$i++){
			$isCheck=false;
			for($j=0;$j<count($list);$j++){
				if($model[$i]['questionnaireId']==$list[$j]['questionnaireId']){$isCheck=true;$muse[$i]=$list[$j];break;}
			}
			if(!$isCheck){
				$muse[$i]=array("title"=>$model[$i]['title'],"questionnaireId"=>$model[$i]['questionnaireId'],"F1"=>0,"F2"=>0,"F3"=>0,"F4"=>0);
			}
		}
		return $muse;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getBrandiiScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getBrandiiScore($groupid,$modelid,$startDate,$areaid,$brandi,$brandii){
		$list=$this->model->getBrandiiScore($groupid,$modelid,$startDate,$areaid,$brandi,$brandii);
		return $list[0];
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getBrandiiModelScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getBrandiiModelScore($groupid,$modelid,$startDate,$areaid,$brandi,$brandii){
		$list=$this->model->getBrandiiModelScore($groupid,$modelid,$startDate,$areaid,$brandi,$brandii);
		$model=$this->model->getModels($modelid);
		$muse=array();
		for($i=0;$i<count($model);$i++){
			   $isCheck=false;
				for($j=0;$j<count($list);$j++){
					if($model[$i]['questionnaireId']==$list[$j]['questionnaireId']){$isCheck=true;$muse[$i]=$list[$j];break;}
				}
		      if(!$isCheck){
		      	$muse[$i]=array("title"=>$model[$i]['title'],"questionnaireId"=>$model[$i]['questionnaireId'],"F1"=>0,"F2"=>0,"F3"=>0,"F4"=>0);
		      }
		}
		return $muse;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getEvaliiScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getEvaliiScore($groupid,$modelid,$startDate,$merchantidi,$merchantidii){
		$list=$this->model->getEvaliiScore($groupid,$modelid,$startDate,$merchantidi,$merchantidii);
		return $list[0];
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getEvaliiModelScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getEvaliiModelScore($groupid,$modelid,$startDate,$merchantidi,$merchantidii){
	    $list=$this->model->getEvaliiModelScore($groupid,$modelid,$startDate,$merchantidi,$merchantidii);
		return $list;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getEvaliScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getEvaliScore($merchantid,$modelid,$startDate,$endDate){
		$list=$this->model->getEvaliScore($merchantid,$modelid,$startDate,$endDate);
		return $list[0];
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getEvaliModelScore
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getEvaliModelScore($merchantid,$modelid,$startDate,$endDate){
	    $list=$this->model->getEvaliModelScore($merchantid,$modelid,$startDate,$endDate);
		return $list;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getEvalaQuestionTop
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getEvalaQuestionTop($groupid,$modelid,$startDate,$endDate,$data){
		$model=$this->model->getModels($modelid);
		$data['Fa']=$this->model->getEvalaQuestionTop('DESC',$model[0]['questionnaireId'],$groupid,$startDate,$endDate,1);
		$data['Fb']=$this->model->getEvalaQuestionTop('ASC',$model[0]['questionnaireId'],$groupid,$startDate,$endDate,1);
		return $data;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getEvalaQuestionTop
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getEvaliQuestionTop($providerid,$modelid,$startDate,$endDate,$data){
		$model=$this->model->getModels($modelid);
		$data['Fa']=$this->model->getEvaliQuestionTop('DESC',$model[0]['questionnaireId'],$providerid,$startDate,$endDate);
		$data['Sa']=$this->model->getEvaliQuestionTop('DESC',$model[1]['questionnaireId'],$providerid,$startDate,$endDate);
		$data['Za']=$this->model->getEvaliQuestionTop('DESC',$model[2]['questionnaireId'],$providerid,$startDate,$endDate);
		$data['Ta']=$this->model->getEvaliQuestionTop('DESC',$model[3]['questionnaireId'],$providerid,$startDate,$endDate);
		$data['Pa']=$this->model->getEvaliQuestionTop('DESC',$model[4]['questionnaireId'],$providerid,$startDate,$endDate);
		$data['Fb']=$this->model->getEvaliQuestionTop('ASC',$model[0]['questionnaireId'],$providerid,$startDate,$endDate);
		$data['Sb']=$this->model->getEvaliQuestionTop('ASC',$model[1]['questionnaireId'],$providerid,$startDate,$endDate);
		$data['Zb']=$this->model->getEvaliQuestionTop('ASC',$model[2]['questionnaireId'],$providerid,$startDate,$endDate);
		$data['Tb']=$this->model->getEvaliQuestionTop('ASC',$model[3]['questionnaireId'],$providerid,$startDate,$endDate);
		$data['Pb']=$this->model->getEvaliQuestionTop('ASC',$model[4]['questionnaireId'],$providerid,$startDate,$endDate);
		return $data;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getEvalaQuestionTop
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getEvaliiQuestionTop($modelid,$provideri,$providerii,$startDate,$data){
		$model=$this->model->getModels($modelid);
		$data['Fa']=$this->model->getEvaliiQuestionTop('DESC',$model[0]['questionnaireId'],$provideri,$providerii,$startDate);
		$data['Sa']=$this->model->getEvaliiQuestionTop('DESC',$model[1]['questionnaireId'],$provideri,$providerii,$startDate);
		$data['Za']=$this->model->getEvaliiQuestionTop('DESC',$model[2]['questionnaireId'],$provideri,$providerii,$startDate);
		$data['Ta']=$this->model->getEvaliiQuestionTop('DESC',$model[3]['questionnaireId'],$provideri,$providerii,$startDate);
		$data['Pa']=$this->model->getEvaliiQuestionTop('DESC',$model[4]['questionnaireId'],$provideri,$providerii,$startDate);
		$data['Fb']=$this->model->getEvaliiQuestionTop('ASC',$model[0]['questionnaireId'],$provideri,$providerii,$startDate);
		$data['Sb']=$this->model->getEvaliiQuestionTop('ASC',$model[1]['questionnaireId'],$provideri,$providerii,$startDate);
		$data['Zb']=$this->model->getEvaliiQuestionTop('ASC',$model[2]['questionnaireId'],$provideri,$providerii,$startDate);
		$data['Tb']=$this->model->getEvaliiQuestionTop('ASC',$model[3]['questionnaireId'],$provideri,$providerii,$startDate);
		$data['Pb']=$this->model->getEvaliiQuestionTop('ASC',$model[4]['questionnaireId'],$provideri,$providerii,$startDate);
		return $data;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getAreaiQuestionTop
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getAreaiQuestionTop($groupid,$modelid,$areaid,$startDate,$endDate,$data){
	    $model=$this->model->getModels($modelid);
		$data['Fa']=$this->model->getAreaiQuestionTop('DESC',$model[0]['questionnaireId'],$groupid,$areaid,$startDate,$endDate,1);
		$data['Fb']=$this->model->getAreaiQuestionTop('ASC',$model[0]['questionnaireId'],$groupid,$areaid,$startDate,$endDate,1);
		return $data;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getAreaiiQuestionTop
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getAreaiiQuestionTop($groupid,$modelid,$areai,$areaii,$startDate,$data){
		$model=$this->model->getModels($modelid);
		$data['Fa']=$this->model->getAreaiiQuestionTop('DESC',$model[0]['questionnaireId'],$groupid,$areai,$areaii,$startDate,1);
		$data['Fb']=$this->model->getAreaiiQuestionTop('ASC',$model[0]['questionnaireId'],$groupid,$areai,$areaii,$startDate,1);
		return $data;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getBrandiQuestionTop
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getBrandiQuestionTop($groupid,$modelid,$brandid,$startDate,$endDate,$data){
		$model=$this->model->getModels($modelid);
		$data['Fa']=$this->model->getBrandiQuestionTop('DESC',$model[0]['questionnaireId'],$groupid,$brandid,$startDate,$endDate);
		$data['Sa']=$this->model->getBrandiQuestionTop('DESC',$model[1]['questionnaireId'],$groupid,$brandid,$startDate,$endDate);
		$data['Za']=$this->model->getBrandiQuestionTop('DESC',$model[2]['questionnaireId'],$groupid,$brandid,$startDate,$endDate);
		$data['Ta']=$this->model->getBrandiQuestionTop('DESC',$model[3]['questionnaireId'],$groupid,$brandid,$startDate,$endDate);
		$data['Pa']=$this->model->getBrandiQuestionTop('DESC',$model[4]['questionnaireId'],$groupid,$brandid,$startDate,$endDate);
		$data['Fb']=$this->model->getBrandiQuestionTop('ASC',$model[0]['questionnaireId'],$groupid,$brandid,$startDate,$endDate);
		$data['Sb']=$this->model->getBrandiQuestionTop('ASC',$model[1]['questionnaireId'],$groupid,$brandid,$startDate,$endDate);
		$data['Zb']=$this->model->getBrandiQuestionTop('ASC',$model[2]['questionnaireId'],$groupid,$brandid,$startDate,$endDate);
		$data['Tb']=$this->model->getBrandiQuestionTop('ASC',$model[3]['questionnaireId'],$groupid,$brandid,$startDate,$endDate);
		$data['Pb']=$this->model->getBrandiQuestionTop('ASC',$model[4]['questionnaireId'],$groupid,$brandid,$startDate,$endDate);
		return $data;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getBrandiiQuestionTop
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getBrandiiQuestionTop($groupid,$modelid,$brandi,$brandii,$startDate,$data){
		$model=$this->model->getModels($modelid);
		$data['Fa']=$this->model->getBrandiiQuestionTop('DESC',$model[0]['questionnaireId'],$groupid,$brandi,$brandii,$startDate);
		$data['Sa']=$this->model->getBrandiiQuestionTop('DESC',$model[1]['questionnaireId'],$groupid,$brandi,$brandii,$startDate);
		$data['Za']=$this->model->getBrandiiQuestionTop('DESC',$model[2]['questionnaireId'],$groupid,$brandi,$brandii,$startDate);
		$data['Ta']=$this->model->getBrandiiQuestionTop('DESC',$model[3]['questionnaireId'],$groupid,$brandi,$brandii,$startDate);
		$data['Pa']=$this->model->getBrandiiQuestionTop('DESC',$model[4]['questionnaireId'],$groupid,$brandi,$brandii,$startDate);
		$data['Fb']=$this->model->getBrandiiQuestionTop('ASC',$model[0]['questionnaireId'],$groupid,$brandi,$brandii,$startDate);
		$data['Sb']=$this->model->getBrandiiQuestionTop('ASC',$model[1]['questionnaireId'],$groupid,$brandi,$brandii,$startDate);
		$data['Zb']=$this->model->getBrandiiQuestionTop('ASC',$model[2]['questionnaireId'],$groupid,$brandi,$brandii,$startDate);
		$data['Tb']=$this->model->getBrandiiQuestionTop('ASC',$model[3]['questionnaireId'],$groupid,$brandi,$brandii,$startDate);
		$data['Pb']=$this->model->getBrandiiQuestionTop('ASC',$model[4]['questionnaireId'],$groupid,$brandi,$brandii,$startDate);
		return $data;
	}
    /**
	 ***********************************************************
	 *方法::AnastoreService::getNPS
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function getNPS($providerid,$modelid,$startDate,$endDate){
		$list=$this->model->getNPS($providerid,$modelid,$startDate,$endDate);
		return $list[0];
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::findAreaiQuestionTop
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function findAreaiQuestionTop($groupid,$modelid,$questionnaireid,$areaid,$startDate,$endDate,$rank){
		$data['Qa']=$this->model->getAreaiQuestionTop('DESC',$questionnaireid,$groupid,$areaid,$startDate,$endDate,$rank);
		$data['Qb']=$this->model->getAreaiQuestionTop('ASC',$questionnaireid,$groupid,$areaid,$startDate,$endDate,$rank);
		return $data;
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::findAreaiiQuestionTop
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function findAreaiiQuestionTop($groupid,$modelid,$questionnaireid,$areai,$areaii,$startDate,$rank){
		$data['Qa']=$this->model->getAreaiiQuestionTop('DESC',$questionnaireid,$groupid,$areai,$areaii,$startDate,$rank);
		$data['Qb']=$this->model->getAreaiiQuestionTop('ASC',$questionnaireid,$groupid,$areai,$areaii,$startDate,$rank);
		return $data;
	}
	/**
	 ***********************************************************
	 *方法::AnastoreService::findEvalaQuestionTop
	 * ----------------------------------------------------------
	 *描述::集团分析service类获取总体各模块的得分
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.04.14  Add by zwx
	 ************************************************************
	 */
	public function findEvalaQuestionTop($groupid,$modelid,$questionnaireid,$startDate,$endDate,$rank){
		$data['Qa']=$this->model->getEvalaQuestionTop('DESC',$questionnaireid,$groupid,$startDate,$endDate,$rank);
		$data['Qb']=$this->model->getEvalaQuestionTop('ASC',$questionnaireid,$groupid,$startDate,$endDate,$rank);
		return $data;
	}
}