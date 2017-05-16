<?php
	/*****************************************************
	 **作者：张文晓
	**创始时间：2017-04-12
	**描述：报告下载service类。
	*****************************************************/
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class PDFOService{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $model;
	private $system;
	private $session;
/**
	 ***********************************************************
	 *方法::PDFService::__construct
	 * ----------------------------------------------------------
	 *描述::报告下载service类初始化方法
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
		$this->includes->models("PDFOModel");
		$this->includes->libraries("CurrSystem");
		$this->includes->libraries("CurrLog");
		$this->includes->libraries("CurrSession");
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->model=new  PDFOModel();
	}
	/**获取车主数量*/
	public function getPersonSize($id,$y,$m){
		return $this->model->getPersonSize($id,$y,$m);
	}
	/**获取车主男女数量*/
	public function getPersonSexSize($id,$y,$m){
		$title=array('男','女');
		return $this->setSize($id,$this->model->getPersonSexSize($id,$y,$m),$title,'sex',false,'size',$y,$m);
	}
	/**获取车主年龄数量*/
	public function getPersonAgeSize($id,$y,$m){
		$title=array('60+岁','50-59岁','40-49岁','30-39岁','18-29岁');
		return $this->setSize($id,$this->model->getPersonAgeSize($id,$y,$m),$title,'age',false,'size',$y,$m);
	}
	/**获取车主收入数量*/
	public function getPersonMoneySize($id,$y,$m){
		$title=array('>=30万','20-30万','10-20万','5-10万','<=5万');
		return $this->setSize($id,$this->model->getPersonMoneySize($id,$y,$m),$title,'money',false,'size',$y,$m);
	}
	/**获取车主职业数量*/
	public function getPersonVocationSize($id,$y,$m){
		$title=array('高层管理人员','中层管理人员','普通职员','教育界人员','律师、会计师..','私营公司老板','科技、体育...','个体工商业者','自由职业者','其他','无业','拒绝回答');
		return $this->setSize($id,$this->model->getPersonVocationSize($id,$y,$m),$title,'vocation',false,'size',$y,$m);
	}
	/**获取车主年限数量*/
	public function getPersonYearSize($id,$y,$m){
		$title=array('1年以内','1-3年','3-5年','5年以上');
		return $this->setSize($id,$this->model->getPersonYearSize($id,$y,$m),$title,'buytime',false,'size',$y,$m);
	}
	/**获取车主学历数量*/
	public function getPersonEducationSize($id,$y,$m){
		$title=array('初中及以下','高中','大专','本科','硕士及以上');
		return $this->setSize($id,$this->model->getPersonEducationSize($id,$y,$m),$title,'education',false,'size',$y,$m);
	}
	/**获取车主问卷数量*/
	public function getResultSize($id,$modelid,$y,$m){
		$title=array('服务顾问','服务设施','维修质量','维修时间','维修价格');
		return $this->setSize($id,$this->model->getResultSize($id,$modelid,$y,$m),$title,'model',true);
	}
	/**获取门店五大纬度数量*/
	public  function getResultMonth($id,$modelid,$y,$m){
		$title=array('服务顾问','服务设施','维修质量','维修时间','维修价格');
		$result=$this->model->getResultMonthScore($id,$modelid,$y,$m);
		$data=$this->setSize($id,$result,$title,'model',true);
		array_unshift($data['key'],'总平均分');
		$avg=$this->setAvg($result);
		array_unshift($data['val'],$avg/100);
		return $data;
	}
	/**获取单一模块每个题目的得分*/
	public function getQuestionAvg($questionnaireId,$providerid,$y,$m){
		return $this->setSizeB($this->model->getQuestionAvg($questionnaireId,$providerid,$y,$m),'score','name');
	}
	/**获取单一问卷得分最高的题目*/
	public function getQuestionMax($questionnaireId,$providerid,$y,$m){
		$data=$this->model->getQuestionMaxMin($questionnaireId,$providerid,$y,$m);
		return $data[0];
	}
	/**获取单一问卷得分最低的题目*/
	public function getQuestionMin($questionnaireId,$providerid,$y,$m){
		$data=$this->model->getQuestionMaxMin($questionnaireId,$providerid,$y,$m);
		return array_pop($data);	
	}
	/**获取单一试题所有答案*/
	public function getQuestionAnswer($providerid,$y,$m,$questionnaireid,$str){
		return $this->setSizeC($this->model->getQuestionAnswer($providerid,$y,$m,$questionnaireid,$str),'size','content');
	}
	/**获取探查数据整体内容*/
	public function getSee($providerid,$y,$m,$questionnaireid,$str){
		$list=$this->model->getQuestionAnswer($providerid,$y,$m,$questionnaireid,$str);
		$data['open']=$this->setSizeD($list);
		$data['last']=$this->setSizeC($this->setSizeE($list),'size','content');
		return $data;
	}
	/**获取问卷表格具体分类*/
	public function getTable($modelid,$providerid,$y,$m,$questionnaireid){
		$model=$this->model->getModels($modelid);
		($questionnaireid==$model[0]['id'] && $title=array('着装仪表','服务态度','经验能力','操作规范')) 				 ||
		($questionnaireid==$model[1]['id'] && $title=array('门店便利性','客休区服务及设施','餐饮品质')) 			 ||
		($questionnaireid==$model[2]['id'] && $title=array('维修保养结果','维修保养透明度','投诉与处理')) 		 ||
		($questionnaireid==$model[3]['id'] && $title=array('预约服务提供','维修保养服务时长','营业时间便利')) ||
		($questionnaireid==$model[4]['id'] && $title=array('价格透明度','定价合理性')) ;
		return  $this->setSize($providerid,$this->model->getQi($modelid,$providerid,$y,$m,$questionnaireid),$title,'title',true,'score');
	}
	/**获取两组数据对比数据*/
	public function getTwoAnswer($providerid,$y,$m,$questionnaireid,$str1,$str2){
		$title=array('报纸杂志','电脑上网','电视娱乐','按摩座椅','无线网络（wifi）');
		return $this->setSizeF($this->model->getQuestionAnswer($providerid,$y,$m,$questionnaireid,$str1),$this->model->getQuestionAnswer($providerid,$y,$m,$questionnaireid,$str2),$title);
	}
   /**整合数据方法A*/
	private function setSize($id,$list,$title,$type,$percent=false,$s='size',$year='',$month=''){
		$data=array('key'=>array(),'val'=>array());
		foreach ($title as $t){
			$size=0;$bool=false;
			$data['key'][]=$t;
			for($i=0;$i<count($list);$i++){
				if($t==$list[$i][$type]){
					if($percent){
						$data['val'][]=round(($list[$i][$s]/100),4);
					}else{
						$data['val'][]=round(($list[$i][$s]/($this->getPersonSize($id,$year,$month))),4);
					}
					$bool=true;
					break;
				}
			}
		    if($bool==false){
		    	$data['val'][]=0;
		    }
		}
	 return $data;
	}
   /**整合数据方法B*/
	public function setSizeB($list,$type,$title,$bool=false){
		$data=array('key'=>array(),'val'=>array());
		for($i=0;$i<count($list);$i++){
			$data['key'][]=$list[$i][$title];
			$data['val'][]=round(($list[$i][$type]/100),4);
		}
		return $data;
	}
	/**整合数据方法C*/
	public function setPoor($key,$list){
		$data=array();
		for($i=0;$i<count($list);$i++){
			$data[]=($list[$i]-$key)*100;
		}
		return $data;
	}
	/**整合数据方法D*/
	public function setSizeC($list,$type,$title){
		$data=array('key'=>array(),'val'=>array());
		$sum=0;
		foreach($list as $item){$sum+=$item[$type];}
		foreach($list as $item){
			$data['key'][]=$item[$title];
			$data['val'][]=round(($item[$type]/$sum),4);
		}
		return $data;
	}
	/**整合数据方法E*/
	public function setSizeD($list){
		$data=array();
		$sum=0;$size=0;
		for($i=0;$i<count($list);$i++){
			$sum+=$list[$i]['size'];
		}
		for($i=0;$i<count($list);$i++){
			if($list[$i]['score']>0){
				$data[0]=round(($list[$i]['size']/$sum),4);
			}else{
				$size+=$list[$i]['size'];
			}
		}
		$data[0]=empty($data[0])?0:$data[0];
		$data[1]=round(($size/$sum),4);
		return $data;
	}
	public function setSizeF($list1,$list2,$title){
		$data=array('key'=>array(),'val'=>array(),'bub'=>array());
		$array1=$list1;$array2=$list2;
		$sum1=0;$sum2=0;
		for($i=0;$i<count($array1);$i++){
			$sum1+=$array1[$i]['size'];
		}
		for($i=0;$i<count($array2);$i++){
			$sum2+=$array2[$i]['size'];
		}
		$index=0;
		foreach ($title as  $t){
			$size1=0;$size2=0;
			for($i=0;$i<count($array1);$i++){
				if($array1[$i]['content']==$t){
					$size1=$array1[$i]['size']/$sum1;
				}
			}
			for($i=0;$i<count($array2);$i++){
				if($array2[$i]['content']==$t){
					$size2=$array2[$i]['size']/$sum2;
				}
			}
			#.计算差值取值
			if($size1>0&&$size2>0){
				$data['val'][$index][0]=$size1-$size2;
				$data['val'][$index][1]=$size1;
				$data['val'][$index][2]=$size2;
				$data['key'][$index]=$t;
				$data['bub'][$index]=$data['val'][$index][0];
				$index++;
			}
		}
		return $data;
	}
	/**整合数据方法F*/
	public function setSizeE($list){
		$data=$list;
		for($i=0;$i<count($list);$i++){
			if($list[$i]['score']!=0){
				unset($data[$i]);
			}
		}
		return $data;
	}
	/**数据冒泡排序法*/
	public function setBub($data){
		$list=$data['val'];$key=$data['key'];
		for($i=1;$i<count($list);$i++){
			for($j=count($list)-1;$j>=$i;$j--){
				if($list[$j]>$list[$j-1]){$x=$list[$j];$list[$j]=$list[$j-1];$list[$j-1]=$x;$y=$key[$j];$key[$j]=$key[$j-1];$key[$j-1]=$y;}
		    }
	     }
	 return array("key"=>$key,'val'=>$list);
    }
   /**数据求取平均值*/
    public function setAvg($list){
    	$avg=0;
    	foreach ($list as $item){
    		$avg+=$item['size'];
    	}
    	return round(($avg/count($list)),2);
    }
    /**获取门店详情*/
    public function getProvider($id){
    	$data=$this->model->getProvider($id);
    	return $data[0];
    }
    public function getModels($modelid){
    	return $this->model->getModels($modelid);
    }
}