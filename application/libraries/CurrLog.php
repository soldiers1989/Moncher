<?php
header("Content-type: text/html; charset=utf-8");
/*****************************************************
 **作者：张文晓
**创始时间：2017-01-09
**描述：通用系统日志类，包含日志记录和日志处理
*****************************************************/
require_once (dirname(dirname(__FILE__)).'/config/database.php');
class CurrLog {
    /**连接数据库对象*/
    private $data;
    #.日志配置文件
    private $config=array("tableId"=>0,/*需要操作数据表id*/
    										 "nav"=>'',/*需要操作导航id*/
										    "operatorId"=>0,/*需要操作实际记录id*/
										    "logType"=>0,/*日志类型*/
										    "operatorType"=>0,/*操作类型*/
										    "operatorName"=>'',/*操作员*/
										    "operationTime"=>'',/*操作时间*/
										    "description"=>''/*操作描述，错误信息时的信息*/);
   #. 日志信息类型
   protected $logType=array("1"=>"错误日志","2"=>"平台日志","3"=>"商户日志");
   #. 日志操作类型
  protected $operatorType=array(  "1"=>"登录",
															   "2"=>"退出",
															   "3"=>"查看",
															   "4"=>"删除",
															   "5"=>"更新",
															   "6"=>"插入",
															   "7"=>"下载",
															   "8"=>"上传");
    #.日志操作内容
   protected    $table=array(  "1"=>'cada_admin|系统管理员表',
													"2"=>'cada_admin_roles|管理员角色表',
													"3"=>'cada_admin_roles_2|管理员角色详情',
													"4"=>'cada_admin_navs|平台导航表',
													"5"=>'cada_hover_log|平台操作日志表',
													"6"=>'cada_system_log|平台系统日志表',
													"7"=>'cada_message|平台系统消息表',
													"8"=>'cada_provider_feedback|平台商户审核表',
													"9"=>'cada_car_info|平台汽车品牌表',
													"10"=>'cada_area|平台区域城市表',
													"11"=>'cada_parameter|平台系统参数表',
													"12"=>'cada_dictioncry|平台数据字典表',
													"13"=>'cada_merchant_info|商户信息表',
													"14"=>'cada_question_bank|题库表',
													"15"=>'cada_question_bank_answer|题库答案表',
													"16"=>'cada_questionnaire|问卷表',
													"17"=>'cada_questionnaire_info|问卷明细表',
													"18"=>'cada_results_question_bank|结果题库表',
													"19"=>'cada_results_answer|结果答案表',
													"20"=>'cada_results_questionnaire|结果.问卷表',
													"21"=>'cada_provider_admin|商户管理员表', 
													"22"=>'cada_provider_admin_roles|商户权限角色表',
													"23"=>'cada_provider_admin_roles2|商户权限角色明细表',
													"24"=>'cada_provider_admin_navs|商户导航表',
													"25"=>'cada_provider_report_download|商户报告下载表',
													"26"=>'cada_provider_certification|商户认证表',
													"27"=>'cada_model|调研模型表',
													"28"=>'cada_module|调研模块表',
													"29"=>'cada_persons|车主信息表',
													"30"=>'cada_skin|多媒体皮肤表',
													"31"=>'cada_strategy|调研策略表',
													"32"=>'cada_activities|调研活动表');
    /**
     ***********************************************************
     *方法::CurrLog::__construct
     * ----------------------------------------------------------
     * 描述::通用日志类初始化方法
     *----------------------------------------------------------
     *参数:
     *parm2:in--    无
     *----------------------------------------------------------
     *返回：
     *return:out--  无
     * ----------------------------------------------------------
     * 日期:2017.01.09  Add by zwx
     ************************************************************
     */
    function __construct($logType,$operatorType,$operatorName,$operationTime,$nav,$description='',$tableId=0,$operatorId=0){
    	$this->config=array("tableId"=>$tableId,/*需要操作数据表id*/
								    			"nav"=>$nav,/*需要操作导航id*/
								    			"operatorId"=>$operatorId,/*需要操作实际记录id*/
								    			"logType"=>$logType,/*日志类型*/
								    			"operatorType"=>$operatorType,/*操作类型*/
								    			"operatorName"=>$operatorName,/*操作员*/
								    			"operationTime"=>$operationTime,/*操作时间*/
								    			"description"=>$description/*操作描述，错误信息时的信息*/);
    	$this->data=$this->getLink();
    }
    /**
     ***********************************************************
     *方法::CurrLog::__destruct
     * ----------------------------------------------------------
     * 描述::通用日志析构方法
     *----------------------------------------------------------
     *参数:
     *parm2:in--    无
     *----------------------------------------------------------
     *返回：
     *return:out--  无
     * ----------------------------------------------------------
     * 日期:2017.01.09  Add by zwx
     ************************************************************
     */
    public function __destruct(){
    	unset($this->data);
    }
    /**
     ***********************************************************
     *方法::CurrLog::error
     * ----------------------------------------------------------
     * 描述::记录错误日志方法
     *----------------------------------------------------------
     *参数:
     *parm2:in--    无
     *----------------------------------------------------------
     *返回：
     *return:out--  无
     * ----------------------------------------------------------
     * 日期:2017.01.09  Add by zwx
     ************************************************************
     */
    public function error(){
    	#.系统日志表
    	$log=array(	"type"=>$this->config['logType'],
						    	"status"=>1,
						    	"operationType"=>$this->config['operatorType'],
						    	"operatorName"=>$this->config['operatorName'],
						    	"operationTime"=>$this->config['operationTime']);
    	if($this->config['logType']==1){
    		$log['name']=$this->config['operationTime'].'管理员['.$this->config['operatorName'].']在'.'执行'.$this->operatorType[$this->config['operatorType']]."操作时系统出现异常信息";
    		$log['description']=$this->logType[$this->config['logType']].':'.$this->config['description'];
    	    #.保存错误日志
    	     $this->save(6,$log);
    	}
    }
    /**
     ***********************************************************
     *方法::CurrLog::write
     * ----------------------------------------------------------
     * 描述::通用日志记录方法
     *----------------------------------------------------------
     *参数:
     *parm1:in--    Array : beData  :: 记录修改之前数据
     *parm2:in--    Array : data       :: 修改后数据
     *----------------------------------------------------------
     *返回：
     *return:out--  无
     * ----------------------------------------------------------
     * 日期:2017.01.09  Add by zwx
     ************************************************************
     */
  function write($beData=array(),$data=array()){
    	#.系统日志表
    	$log=array("type"=>$this->config['logType'],
    						"status"=>1,
    						"operationType"=>$this->config['operatorType'],
    						"operatorName"=>$this->config['operatorName'],
    						"operationTime"=>$this->config['operationTime']); 
    	#.查询导航信息
    	$nav=NULL;
    	if($this->config['logType']==2 || $this->config['logType']==3){
	    		$this->config['tableId'] && $table=explode('|',$this->table[$this->config['tableId']]);
	    		$this->config['operatorId'] && $info=$this->query("SELECT	*  FROM ".$table[0]."  WHERE id=".$this->config['operatorId']);
	    		$log['name']=$this->config['operationTime'].'管理员['.$this->config['operatorName'].']针对['.$this->config['nav'].']执行'.$this->operatorType[$this->config['operatorType']].'操作';
	    		$log['description'] =$this->logType[$this->config['logType']].':';
	    		$log['description'].=$this->config['operatorName'].'于';
	    		$log['description'].=$this->config['operationTime'].'对['.$this->config['nav'].']执行';
	    		$log['description'].=$this->operatorType[$this->config['operatorType']]."操作;";
	    		$log['description'].="受影响数据表:".$table[0]."(".$table[1].");"."受影响数据:".(empty($info)?"无":json_encode($info));
	    		#.保存系统日志
	    		$this->save(6,$log);
	    		#.执行登录操作和更新操作
    		if($this->config['operatorType']==1||$this->config['operatorType']==5){
    			foreach ($beData AS $key=>$val){
    				($val!==$data[$key]) && $this->save(5,$muse=array("name"=>$key,
																												  "description"=>$this->config['operatorName'].'时间-'.$this->config['operationTime']."操作-".$key."结果-".$val.";",
																												   "type"=>$this->config['logType'],
																												   "status"=>1,
																												   "beforeData"=>$val,
																												   "laterDate"=>$data[$key],
																												   "operationType"=>$this->config['operatorType'],
																												   "operatorName"=>$this->config['operatorName'],
																												   "operationTime"=>$this->config['operationTime']));
    			}
    		}
    	}
    }
    /**
     ***********************************************************
     *方法::CurrLog::save
     * ----------------------------------------------------------
     * 描述::通用类保存数据记录方法
     *----------------------------------------------------------
     *参数:
     *parm1:in--    String : type      :: 日志表类型
     *parm2:in--    Array : data       :: 需要保存的数据
     *----------------------------------------------------------
     *返回：
     *return:out--  Int : rows            ::受影响结果记录行
     * ----------------------------------------------------------
     * 日期:2017.01.09  Add by zwx
     ************************************************************
     */
   function save($type=0,$data=array()) {
    	$type>0 && $table=explode('|',$this->table[$type]);
    	 $sql="INSERT INTO ".$table[0]."(%KEY%) VALUE (%VAL%) ";
    	 $KEY=array();
    	 $VAL=array();
    	 foreach ( $data AS $key=>$value){
    	 	$KEY[]=$key;
    	 	$VAL[]=is_numeric($value)?$value:"'".$value."'";
    	 }
    	 $sql=str_replace("%KEY%",implode(',',$KEY),$sql);
    	 $sql=str_replace("%VAL%",implode(',',$VAL),$sql);
    	 return $this->exec($sql);
    }
    /**执行数据库操作*/
    public function exec($sql){
    	return $this->data->exec($sql);
    }
    /**执行数据库操作*/
    public function query($sql){
    	$query=$this->data->query($sql);
    	$query->setFetchMode(PDO::FETCH_ASSOC);
    	$list=$query->fetchAll();
    	return $list;
    }
    /**获取数据连接对象*/
    public function getLink(){
    	try{
    		$link= new PDO("mysql:host=".HOSTNAME.";dbname=".DATANAME,USERNAME,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
    		return $link;
    	}catch(PDOException $e){
    		echo $e->getMessage();
    	}
    }
}
define ('HOSTNAME', $db['default']['hostname']);
/**定义数据库名称*/
define ('DATANAME', $db['default']['database']);
/**定义数据库用户*/
define ('USERNAME',$db['default']['username']);
/**定义数据库密码*/
define ('PASSWORD',$db['default']['password']);