<?php
date_default_timezone_set('PRC');
/**加载配置文件*/
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/PDFTool/tcpdf.php');
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/PDFTool/doing/config/config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/PDFTool/doing/Tools.class.php');
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/PDFTool/doing/Const.class.php');
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/PDFTool/doing/Toolso.class.php');
require_once(dirname(dirname(dirname(__FILE__))).'/libraries/PDFTool/doing/Consto.class.php');
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__))).'/libraries/Includes.php');
class PDFN extends CI_Controller{
	#.引用属性，每个控制器都需要有
	private $includes;
	private $session;
	private $system;
	private $service;
	private $modelid;
	private $year;
	private $month;
	/**
	 ***********************************************************
	 *方法::Login::__construct
	 * ----------------------------------------------------------
	 * 描述::初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.02.08  Add by zwx
	 ************************************************************
	 */
	public function __construct(){
		parent::__construct();
		$this->includes=new Includes(__FILE__);
		$this->includes->services('PDFService');
		$this->includes->services('PDFOService');
		$this->includes->libraries('CurrSession');
		$this->includes->libraries('CurrSystem');
		$this->service=new PDFService();
		$this->session=new CurrSession();
		$this->system=new CurrSystem();
		$this->load->helper('url');
	}
	public function index(){
		$data['startDate']=empty($_POST['startDate'])?date('Y',time()).'-01':$_POST['startDate'];
		$data['lastDate']=empty($_POST['lastDate'])?date('Y-m',time()):$_POST['lastDate'];
		$data['list']=$this->service->findList($this->session->getSession("Merchant","providerId"),$_SESSION['modelid'],5,$data['startDate'],$data['lastDate']);
		$this->load->view('merchant/PDFList.html',$data);
	}
	/**下载文档*/
	public function download(){
		/**这是一个神奇方法*/
		($_GET['y']>=2017 && $_GET['m']>=3)  && $this->toPDF(empty($_GET['id'])?$this->session->getSession("Merchant","providerId"):$_GET['id'],empty($_GET['mid'])?$_SESSION['modelid']:$_GET['mid'],$_GET['y'],$_GET['m']);
		($_GET['y']<=2017 && $_GET['m']<3)    && $this->oldPDF(empty($_GET['id'])?$this->session->getSession("Merchant","providerId"):$_GET['id'],empty($_GET['mid'])?$_SESSION['modelid']:$_GET['mid'],$_GET['y'],$_GET['m']);
	}
	private function toPDF($providerid,$modelid,$year,$month){
		/**实例化PDF类*/
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$tools=new Tools();
		/**设置页眉和页脚*/
		$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(33,33,33), array(124,181,236));
		$pdf->setFooterData(array(124,181,236), array(124,181,236));
		/**设置页眉页脚字体*/
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		/**设置默认字体*/
		$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		/**设置默认边距*/
		$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
		/**设置自动分页*/
		$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		/**设置图片比例缩放*/
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		/**设置字体*/
		$pdf->setFont('stsongstdlight', '',10);
		$pdf->setTextColor(33,33,33);
		/**设置CMYK值*/
		$tools->set($pdf);
		$personi		=$this->service->getPerson($providerid,$year,$month);
		$resulti		=$this->service->getResult($modelid,$providerid,$year,$month);
		$avgi			=$this->service->getQuestionAvg($modelid,$providerid,$year,$month);
		$provider	=$this->service->getProvider($providerid);
		$model   	=$this->service->getModels($modelid);
		/**单题数据*/
		$F1x	=$this->service->getQuestioni($providerid,$year,$month,$model[0]['id'],'F1');
		$F4x	=$this->service->getQuestioni($providerid,$year,$month,$model[0]['id'],'F4');
		$F5x	=$this->service->getQuestioni($providerid,$year,$month,$model[0]['id'],'F5');
		$F9x	=$this->service->getQuestioni($providerid,$year,$month,$model[0]['id'],'F9');
		$F10x	=$this->service->getQuestioni($providerid,$year,$month,$model[0]['id'],'F10');
		$F11x	=$this->service->getQuestioni($providerid,$year,$month,$model[0]['id'],'F11');
		$S1x	=$this->service->getQuestioni($providerid,$year,$month,$model[1]['id'],'S1');
		$S5x	=$this->service->getQuestioni($providerid,$year,$month,$model[1]['id'],'S5');
		$S7x	=$this->service->getQuestioni($providerid,$year,$month,$model[1]['id'],'S7');
		$S8x	=$this->service->getQuestioni($providerid,$year,$month,$model[1]['id'],'S8');
		$S9x	=$this->service->getQuestioni($providerid,$year,$month,$model[1]['id'],'S9');
		$S10x	=$this->service->getQuestioni($providerid,$year,$month,$model[1]['id'],'S10');
		$Z2x	=$this->service->getQuestioni($providerid,$year,$month,$model[2]['id'],'Z2');
		$Z3x	=$this->service->getQuestioni($providerid,$year,$month,$model[2]['id'],'Z3');
		$Z11x	=$this->service->getQuestioni($providerid,$year,$month,$model[2]['id'],'Z11');
		$T2x	=$this->service->getQuestioni($providerid,$year,$month,$model[3]['id'],'T2');
		$T3x	=$this->service->getQuestioni($providerid,$year,$month,$model[3]['id'],'T3');
		$T4x	=$this->service->getQuestioni($providerid,$year,$month,$model[3]['id'],'T4');
		$T5x	=$this->service->getQuestioni($providerid,$year,$month,$model[3]['id'],'T5');
		$T7x	=$this->service->getQuestioni($providerid,$year,$month,$model[3]['id'],'T7');
		$T8x	=$this->service->getQuestioni($providerid,$year,$month,$model[3]['id'],'T8');
		$T10x	=$this->service->getQuestioni($providerid,$year,$month,$model[3]['id'],'T10');
		$T11x	=$this->service->getQuestioni($providerid,$year,$month,$model[3]['id'],'T11');
		$T12x	=$this->service->getQuestioni($providerid,$year,$month,$model[3]['id'],'T12');
		$P4x	=$this->service->getQuestioni($providerid,$year,$month,$model[4]['id'],'P4');
		$P5x	=$this->service->getQuestioni($providerid,$year,$month,$model[4]['id'],'P5');
		/**分析题数据*/
		$P3		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[4]['id'],'P3');
		$T1		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[3]['id'],'T1');
		$T6		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[3]['id'],'T6');
		$T9		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[3]['id'],'T9');
		$T13	=$this->service->getQuestionAnswer($providerid,$year,$month,$model[3]['id'],'T13');
		$T14	=$this->service->getQuestionAnswer($providerid,$year,$month,$model[3]['id'],'T14');
		$T15	=$this->service->getQuestionAnswer($providerid,$year,$month,$model[3]['id'],'T15');
		$Z8		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[2]['id'],'Z8');
		$S2		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[1]['id'],'S2');
		$S3		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[1]['id'],'S3');
		$S4		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[1]['id'],'S4');
		$S11	=$this->service->getQuestionAnswer($providerid,$year,$month,$model[1]['id'],'S11');
		$S12	=$this->service->getQuestionAnswer($providerid,$year,$month,$model[1]['id'],'S12');
		$S14	=$this->service->getQuestionAnswer($providerid,$year,$month,$model[1]['id'],'S14');
		$F3		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[0]['id'],'F3');
		$F6		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[0]['id'],'F6');
		$F7		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[0]['id'],'F7');
		$F8		=$this->service->getQuestionAnswer($providerid,$year,$month,$model[0]['id'],'F8');
		/**模块归纳详情得分*/
		$Fscore=$this->service->getQi($modelid,$providerid,$year,$month,$model[0]['id']);
		$Sscore=$this->service->getQi($modelid,$providerid,$year,$month,$model[1]['id']);
		$Zscore=$this->service->getQi($modelid,$providerid,$year,$month,$model[2]['id']);
		$Tscore=$this->service->getQi($modelid,$providerid,$year,$month,$model[3]['id']);
		$Pscore=$this->service->getQi($modelid,$providerid,$year,$month,$model[4]['id']);
		/**目录页*/
		$color_arr=array(33,33,33);
		$pdf->Bookmark(Texts::TitleOneI, 0, 0, '1', '', $color_arr);
		$pdf->Bookmark(Texts::TitleTwoI1, 1, 0, '1', '', $color_arr);
		$pdf->Bookmark(Texts::TitleThrI1_1, 2, 0, '1', '', $color_arr);
		$pdf->Bookmark(Texts::TitleThrI1_2, 2, 0, '1', '', $color_arr);
		$pdf->Bookmark(Texts::TitleThrI1_3, 2, 0, '2', '', $color_arr);
		$pdf->Bookmark(Texts::TitleThrI1_4, 2, 0, '2', '', $color_arr);
		$pdf->Bookmark(Texts::TitleThrI1_5,2, 0, '3', '', $color_arr);
		$pdf->Bookmark(Texts::TitleThrI1_6, 2, 0, '3', '', $color_arr);
		$pdf->Bookmark(Texts::TitleTwoI2, 1, 0, '4', '', $color_arr);
		$pdf->Bookmark(Texts::TitleOneII, 0, 0, '4', '', $color_arr);
		$pdf->Bookmark(Texts::TitleTwoII1, 1, 0, '4', '', $color_arr);
		$pdf->Bookmark(Texts::TitleTwoII2, 1, 0, '5', '', $color_arr);
		/**服务顾问*/
		$pdf->Bookmark(Texts::TitleThrII2_1, 2, 0, '5', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_1_1, 3, 0, '5', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_1_2, 3, 0, '6', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_1_3, 3, 0, '6', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_1_4, 3, 0, '8', '', $color_arr);
		/**服务设施*/
		$pdf->Bookmark(Texts::TitleThrII2_2, 2, 0, '9', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_2_1, 3, 0, '9', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_2_2, 3, 0, '9', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_2_3, 3, 0, '11', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_2_4, 3, 0, '13', '', $color_arr);
		/**维修质量*/
		$pdf->Bookmark(Texts::TitleThrII2_3, 2, 0, '15', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_3_1, 3, 0, '15', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_3_2, 3, 0, '15', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_3_3, 3, 0, '16', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_3_4, 3, 0, '17', '', $color_arr);
		/**维修时间*/
		$pdf->Bookmark(Texts::TitleThrII2_4, 2, 0, '18', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_4_1, 3, 0, '18', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_4_2, 3, 0, '18', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_4_3, 3, 0, '19', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_4_4, 3, 0, '22', '', $color_arr);
		/**维修价格*/
		$pdf->Bookmark(Texts::TitleThrII2_5, 2, 0, '24', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_5_1, 3, 0, '24', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_5_2, 3, 0, '24', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_5_3, 3, 0, '25', '', $color_arr);
		$pdf->Bookmark(Texts::TitleFouII2_5_4, 3, 0, '25', '', $color_arr);
		$pdf->addTOCPage();
		$pdf->SetFont('stsongstdlight', 'B', 14);
		$pdf->Write ( 0,$provider['provider_name'], '', 0, 'C', true, 0, false, false, 0 );
		$pdf->Write ( 0,$year.'年'.$month.'月《汽车售后服务客户体验测评》月度报告', '', 0, 'C', true, 0, false, false, 0 );
		$pdf->Ln(5);
		$pdf->SetFont('stsongstdlight', 'B', 10);
		$pdf->Write ( 0, "目录", '', 0, 'L', true, 0, false, false, 0 );
		$pdf->SetFont('stsongstdlight', '',11 );
		$pdf->addTOC(1, 'stsongstdlight', '.', 'INDEX', 'B',NULL);
		$pdf->endTOCPage();
		/**
		 * 2.
		*/
		/**报告内容*/
		$pdf->AddPage();
		$pdf->SetFont('stsongstdlight', 'b',12);
		$pdf->Cell(0,12,Texts::TitleOneI, 0,1, 'C',0,'',0);
		$pdf->SetFont('stsongstdlight', '',10);
		$pdf->Write(8,Texts::TitleTwoI1, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(8,vsprintf(Texts::TextI1,array($personi['val'][0])), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(8,Texts::TitleThrI1_1, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(8,vsprintf(Texts::TextI2,array(round($personi['val'][1]*$personi['val'][0]), ($personi['val'][1]*100).'%', round($personi['val'][2]*$personi['val'][0]), ($personi['val'][2]*100).'%')), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Cell(0,12,'性别分布统计', 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,80,array($personi['val'][1]*100,$personi['val'][2]*100),array($personi['key'][1].'性比例',$personi['key'][2].'性比例'),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(15);
		$pdf->Write(4,Texts::TitleThrI1_2, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0,$tools->setTexts(1,array($personi['key'][3],$personi['key'][4],$personi['key'][5],$personi['key'][6],$personi['key'][7]),array($personi['val'][3]*100,$personi['val'][4]*100,$personi['val'][5]*100,$personi['val'][6]*100,$personi['val'][7]*100)), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Cell(0,12,'年龄分布统计', 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,175,array($personi['val'][3]*100,$personi['val'][4]*100,$personi['val'][5]*100,$personi['val'][6]*100,$personi['val'][7]*100),array($personi['key'][3],$personi['key'][4],$personi['key'][5],$personi['key'][6],$personi['key'][7]),true,true,$size=10,$weight=5);
	
		/**
		 * 3.
		*/
		$pdf->AddPage();
		$pdf->Write(8,Texts::TitleThrI1_3, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(4,$tools->setTexts(2,array($personi['key'][8],$personi['key'][9],$personi['key'][10],$personi['key'][11],$personi['key'][12]),array($personi['val'][8]*100,$personi['val'][9]*100,$personi['val'][10]*100,$personi['val'][11]*100,$personi['val'][12]*100)), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Cell(0,12,'学历分布统计', 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,55,array($personi['val'][8]*100,$personi['val'][9]*100,$personi['val'][10]*100,$personi['val'][11]*100,$personi['val'][12]*100),array($personi['key'][8],$personi['key'][9],$personi['key'][10],$personi['key'][11],$personi['key'][12]),true,true,$size=10,$weight=5);
		$pdf->Ln(20);
		$pdf->Write(4,Texts::TitleThrI1_4, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0,$tools->setTexts(3,	array($personi['key'][18],$personi['key'][19],$personi['key'][20],$personi['key'][21],$personi['key'][22],$personi['key'][23],$personi['key'][24],$personi['key'][25],$personi['key'][26],$personi['key'][27],$personi['key'][28],$personi['key'][29]),
		array($personi['val'][18]*100,$personi['val'][19]*100,$personi['val'][20]*100,$personi['val'][21]*100,$personi['val'][22]*100,$personi['val'][23]*100,$personi['val'][24]*100,$personi['val'][25]*100,$personi['val'][26]*100,$personi['val'][27]*100,$personi['val'][28]*100,$personi['val'][29]*100)),'', 0, 'L', true, 0, false, false, 0);
		$pdf->Cell(0,12,'职业分布统计', 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,170,array($personi['val'][18]*100,$personi['val'][19]*100,$personi['val'][20]*100,$personi['val'][21]*100,$personi['val'][22]*100,$personi['val'][23]*100,$personi['val'][24]*100,$personi['val'][25]*100,$personi['val'][26]*100,$personi['val'][27]*100,$personi['val'][28]*100,$personi['val'][29]*100),
		array($personi['key'][18],$personi['key'][19],$personi['key'][20],$personi['key'][21],$personi['key'][22],$personi['key'][23],$personi['key'][24],$personi['key'][25],$personi['key'][26],$personi['key'][27],$personi['key'][28],$personi['key'][29]),true,true,$size=5,$weight=3,270,55);
		/**
		 * 4.
		*/
		$pdf->AddPage();
		$pdf->Write(8,Texts::TitleThrI1_5, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0,$tools->setTexts(4,array($personi['key'][13],$personi['key'][14],$personi['key'][15],$personi['key'][16],$personi['key'][17]),array($personi['val'][13]*100,$personi['val'][14]*100,$personi['val'][15]*100,$personi['val'][16]*100,$personi['val'][17]*100)), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Cell(0,12,'收入分布统计', 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,55,array($personi['val'][13]*100,$personi['val'][14]*100,$personi['val'][15]*100,$personi['val'][16]*100,$personi['val'][17]*100),array($personi['key'][13],$personi['key'][14],$personi['key'][15],$personi['key'][16],$personi['key'][17]),true,true,$size=10,$weight=5);
		$pdf->Ln(15);
		$pdf->Write(4,Texts::TitleThrI1_6, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0,$tools->setTexts(5,array($personi['key'][30],$personi['key'][31],$personi['key'][32],$personi['key'][33]),array($personi['val'][30]*100,$personi['val'][31]*100,$personi['val'][32]*100,$personi['val'][33]*100)), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Cell(0,12,'年限分布统计', 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,160,array($personi['val'][30]*100,$personi['val'][31]*100,$personi['val'][32]*100,$personi['val'][33]*100),array($personi['key'][30],$personi['key'][31],$personi['key'][32],$personi['key'][33]),true,true,$size=10,$weight=5);
		/**
		 * 5.
		*/
		$pdf->AddPage();
		$pdf->SetFont('stsongstdlight', '',10);
		$pdf->Write(8,Texts::TitleTwoI2, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0,vsprintf(Texts::TextI8,array($resulti['val'][0])), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write ( 8,'五大模块样本量', '', 0, 'C', true, 0, false, false, 0 );
		$tools->setOblongT($pdf,55,55,array($resulti['val'][1],$resulti['val'][2],$resulti['val'][3],$resulti['val'][4],$resulti['val'][5]),array($resulti['key'][1],$resulti['key'][2],$resulti['key'][3],$resulti['key'][4],$resulti['key'][5]),false,false,$size=10,$weight=5);
		$pdf->Ln(30);
		$pdf->SetFont('stsongstdlight', 'B',12);
		$pdf->Cell(0,12,Texts::TitleOneII, 0,1, 'C',0,'',0);
		$pdf->SetFont('stsongstdlight', '',10);
		$pdf->Write ( 8, Texts::TitleTwoII1, '', 0, 'A', true, 0, false, false, 0 );
		$scorestr=array($year.'-'.$month,$resulti['val'][6],$resulti['val'][7],$resulti['val'][8],$resulti['val'][9],$resulti['val'][10],$resulti['val'][11]);
		$pdf->Write ( 8,vsprintf(Texts::TextII1,$scorestr), '', 0, 'A', true, 0, false, false, 0 );
		$pdf->SetFont ( 'stsongstdlight', '', 10 );
		$pdf->Write ( 8,'测评总分情况', '', 0, 'C', true, 0, false, false, 0 );
		$pdf->SetFont ( 'stsongstdlight', '', 10 );
		$tools->setOblongY($pdf,55,190,array($resulti['val'][6],$resulti['val'][7],$resulti['val'][8],$resulti['val'][9],$resulti['val'][10],$resulti['val'][11]),array($resulti['key'][6],$resulti['key'][7],$resulti['key'][8],$resulti['key'][9],$resulti['key'][10],$resulti['key'][11]));
		/*
		 * 7.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8,'    '.Texts::TitleTwoII2, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8, Texts::TitleThrII2_1, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8, Texts::TitleFouII2_1_1, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8,'指标详细得分', '', 0, 'C', true, 0, false, false, 0 );
		$tools->setOblongL($pdf,30,75,array($resulti['val'][7],$avgi['val'][1],$avgi['val'][2],$avgi['val'][3],$avgi['val'][4],$avgi['val'][5],$avgi['val'][6],$avgi['val'][7],$avgi['val'][8],$avgi['val'][9],$avgi['val'][10]),
		array($resulti['key'][7].'平均分',$avgi['key'][1],$avgi['key'][2],$avgi['key'][3],$avgi['key'][4],$avgi['key'][5],$avgi['key'][6],$avgi['key'][7],$avgi['key'][8],$avgi['key'][9],$avgi['key'][10]));
		$pdf->Ln(30);
		$pdf->Write ( 8, Texts::TitleFouII2_1_2, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->SetFont ( 'stsongstdlight', '', 8 );
		$pdf->writeHTML ('<table   border="0" cellspacing="1" cellpadding="9" style="border:0.5px solid #CCC">
										<tr>
										<td width="60%" style="text-align:center; background-color:#538DD5;style="border:0.5px solid #CCC"">三级指标</td>
										<td width="25%" style="text-align:center;background-color:#538DD5;style="border:0.5px solid #CCC"">汇总指标</td>
										<td width="15%" style="text-align:center;background-color:#538DD5;style="border:0.5px solid #CCC"">加权得分</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">F2、服务顾问仪表着装是否干净整洁？</td>
										<td style="text-align:center;border:0.5px solid #CCC">着装仪表</td>
										<td style="text-align:center;border:0.5px solid #CCC">'.$Fscore[0]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">F4、您感觉服务顾问的态度是：</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="2">服务态度 </td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="2">'.$Fscore[1]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">F1、进入服务区是否有人主动接待？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">F8、服务顾问对建议维修保养项目的解释说明：</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="3">经验能力</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="3">'.$Fscore[2]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">F7、服务顾问给您的维修保养建议：</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">F6、您提出的需求，服务顾问：</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">F9、服务顾问对您的用车、养车是否主动给出合理化建议及注意事项？</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="4">操作规范</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="4">'.$Fscore[3]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">F3、服务顾问是否能准确提出车主上次维修保养的内容并询问此次需求？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">F11、服务顾问是否完整记录接车单、维修保养作业确认书、费用结算单并让您签字确认？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">F10、服务顾问是否对您全程一对一服务？</td>
										</tr>
										</table>' ,true, false, false, false, '');
		$pdf->AddPage();
		$pdf->SetFont ( 'stsongstdlight', '', 10 );
		$pdf->Write ( 8, Texts::TitleFouII2_1_3, '', 0, 'L', true, 0, false, false, 0 );
		$pdf->Cell(0,12,$F1x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,55,array($F1x['val'][1],$F1x['val'][2]),array('选择'.$F1x['key'][1],'选择'.$F1x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$F4x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,135,array($F4x['val'][1],$F4x['val'][2]),array('选择'.$F4x['key'][1],'选择'.$F4x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$F5x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,215,array($F5x['val'][1],$F5x['val'][2]),array('选择'.$F5x['key'][1],'选择'.$F5x['key'][2]),true,true,$size=15,$weight=20,360,52);
		/**
			新一页
		*/
		$pdf->AddPage();
		$pdf->Cell(0,12,$F9x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,55,array($F9x['val'][1],$F9x['val'][2]),array('选择'.$F9x['key'][1],'选择'.$F9x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$F10x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,135,array($F10x['val'][1],$F10x['val'][2]),array('选择'.$F10x['key'][1],'选择'.$F10x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$F11x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,215,array($F11x['val'][1],$F11x['val'][2]),array('选择'.$F11x['key'][1],'选择'.$F11x['key'][2]),true,true,$size=15,$weight=20,360,52);
		/**
			新一页
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Texts::TitleFouII2_1_4, '', 0, 'L', true, 0, false, false, 0 );
		$pdf->Cell(0,12,$F3['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,38,$F3['val'],$F3['key'],true,true,$size=10,$weight=5);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$F6['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,120,$F6['val'],$F6['key'],true,true,$size=10,$weight=5);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$F8['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,200,$F8['val'],$F8['key'],true,true,$size=10,$weight=5);
		/**
			新一页
		*/
		$pdf->AddPage();
		$pdf->Cell(0,12,$F7['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,35,$F7['val'],$F7['key'],true,true,$size=10,$weight=5);
		/**
		 * 10.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8,'    '.Texts::TitleThrII2_2, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8,Texts::TitleFouII2_2_1, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8,'指标详细得分', '', 0, 'C', true, 0, false, false, 0 );
		$tools->setOblongL($pdf,30,75,array($resulti['val'][8],$avgi['val'][12],$avgi['val'][13],$avgi['val'][14],$avgi['val'][15],$avgi['val'][16],$avgi['val'][17],$avgi['val'][18],$avgi['val'][19],$avgi['val'][20]),
		array($resulti['key'][8].'平均分',$avgi['key'][12],$avgi['key'][13],$avgi['key'][14],$avgi['key'][15],$avgi['key'][16],$avgi['key'][17],$avgi['key'][18],$avgi['key'][19],$avgi['key'][20]));
		$pdf->Ln(30);
		$pdf->Write ( 8,Texts::TitleFouII2_2_2, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->SetFont ( 'stsongstdlight', '', 8 );
		$pdf->writeHTML ('<table    border="0" cellspacing="1" cellpadding="9" style="border:0.5px solid #CCC">
										<tr>
										<td width="50%" style="text-align:center; background-color:#538DD5;border:0.5px solid #CCC">三级指标</td>
										<td width="30%" style="text-align:center;background-color:#538DD5;border:0.5px solid #CCC">汇总指标</td>
										<td width="20%" style="text-align:center;background-color:#538DD5;border:0.5px solid #CCC">加权得分</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">S1、您认为门店的位置是否便利？</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="4">门店便利性</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="4">'.$Zscore[0]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">S3、您进店时停车场车位是否充足？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">S5、是否有专人引导停车？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">S6、停车位置到维修接待区是否便利</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">S11、您对本店提供的饮料种类和质量是否满意？</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="2">餐饮品质</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="2">'.$Sscore[1]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">S12、您对本店提供的餐食种类和质量是否满意？</td>
										</tr>
										</table>' ,true, false, false, false, '');
		$pdf->AddPage();
		$pdf->SetFont ( 'stsongstdlight', '', 10 );
		$pdf->Write ( 8, Texts::TitleFouII2_2_3, '', 0, 'L', true, 0, false, false, 0 );
		$pdf->Cell(0,12,$S1x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,55,array($S1x['val'][1],$S1x['val'][2]),array('选择'.$S1x['key'][1],'选择'.$S1x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$S5x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,135,array($S5x['val'][1],$S5x['val'][2]),array('选择'.$S5x['key'][1],'选择'.$S5x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$S7x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,215,array($S7x['val'][1],$S7x['val'][2]),array('选择'.$S7x['key'][1],'选择'.$S7x['key'][2]),true,true,$size=15,$weight=20,360,52);
		/**
			新一页
		*/
		$pdf->AddPage();
		$pdf->Cell(0,12,$S8x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,55,array($S8x['val'][1],$S8x['val'][2]),array('选择'.$S8x['key'][1],'选择'.$S8x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$S9x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,135,array($S9x['val'][1],$S9x['val'][2]),array('选择'.$S9x['key'][1],'选择'.$S9x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$S10x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,215,array($S10x['val'][1],$F11x['val'][2]),array('选择'.$S10x['key'][1],'选择'.$S10x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->AddPage();
		$pdf->Write ( 8, Texts::TitleFouII2_2_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,$S2['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,48,$S2['val'],$S2['key'],true,true,$size=10,$weight=5);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$S3['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,130,$S3['val'],$S3['key'],true,true,$size=10,$weight=5);
		$pdf->Ln(5);
		$pdf->Cell(0,12,$S4['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,200,$S4['val'],$S4['key'],true,true,$size=10,$weight=5);
		/**新一页*/
		$pdf->AddPage();
		$pdf->Cell(0,12,$S11['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,38,$S11['val'],$S12['key'],true,true,$size=10,$weight=5);
		$pdf->Ln(20);
		$pdf->Cell(0,12,$S12['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,130,$S12['val'],$S12['key'],true,true,$size=10,$weight=5);
		$pdf->Ln(15);
		$pdf->Cell(0,12,$S14['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,210,$S14['val'],$S14['key'],true,true,$size=10,$weight=5);
		/**
		 * 15.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8,'    '.Texts::TitleThrII2_3, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8, Texts::TitleFouII2_3_1, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8,'指标详细得分', '', 0, 'C', true, 0, false, false, 0 );
		$tools->setOblongL($pdf,30,75,array($resulti['val'][9],$avgi['val'][22],$avgi['val'][23],$avgi['val'][24],$avgi['val'][25],$avgi['val'][26],$avgi['val'][27],$avgi['val'][28]),
		array($resulti['key'][9].'平均分',$avgi['key'][22],$avgi['key'][23],$avgi['key'][24],$avgi['key'][25],$avgi['key'][26],$avgi['key'][27],$avgi['key'][28]));
		$pdf->Ln(30);
		$pdf->Write ( 8, Texts::TitleFouII2_3_2, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->SetFont ( 'stsongstdlight', '', 8 );
		$pdf->writeHTML ('<table   border="0" cellspacing="1" cellpadding="9" style="border:0.5px solid #CCC">
										<tr>
										<td width="50%" style="text-align:center; background-color:#538DD5;border:0.5px solid #CCC">三级指标</td>
										<td width="30%" style="text-align:center;background-color:#538DD5;border:0.5px solid #CCC">汇总指标</td>
										<td width="20%" style="text-align:center;background-color:#538DD5;border:0.5px solid #CCC">加权得分</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">Z1、每次维修/保养是否能解决您的问题？</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="4">维修保养结果</td>
										<td style="text-align:center;border:0.5px solid #CCC"rowspan="4">'.$Zscore[1]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">Z8、交车时，车辆是否清洁？ </td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">Z9、服务完成后，座椅、倒车镜、音响、空调等车辆设置与入厂时是否一致？（可多选）</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">Z10、交车时服务顾问是否与您确认维修保养结果？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">Z3、店里是否允许您与维修保养技师直接沟通？</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="3">维修保养透明度</td>
										<td style="text-align:center;border:0.5px solid #CCC"rowspan="3">'.$Zscore[0]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">Z5、维修保养的过程是否透明？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">Z12、服务顾问是否主动询问剩余材料和旧件的处理方式？</td>
										</tr>
										</table>' ,true, false, false, false, '');
		$pdf->AddPage();
		$pdf->SetFont ( 'stsongstdlight', '', 10 );
		$pdf->Write ( 8, Texts::TitleFouII2_3_3, '', 0, 'L', true, 0, false, false, 0 );
		$pdf->Cell(0,12,$Z2x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,55,array($Z2x['val'][1],$Z2x['val'][2]),array('选择'.$Z2x['key'][1],'选择'.$Z2x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$Z3x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,135,array($Z3x['val'][1],$Z3x['val'][2]),array('选择'.$Z3x['key'][1],'选择'.$Z3x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$Z11x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,215,array($Z11x['val'][1],$Z11x['val'][2]),array('选择'.$Z11x['key'][1],'选择'.$Z11x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->AddPage();
		$pdf->Write ( 8, Texts::TitleFouII2_3_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,$Z8['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,40,$Z8['val'],$Z8['key'],true,true,$size=10,$weight=5);
		/**
		 * 20.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, '    '.Texts::TitleThrII2_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8, Texts::TitleFouII2_4_1, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8,'指标详细得分', '', 0, 'C', true, 0, false, false, 0 );
		$tools->setOblongL($pdf,30,75,array($resulti['val'][10],$avgi['val'][30],$avgi['val'][31],$avgi['val'][32],$avgi['val'][33],$avgi['val'][34],$avgi['val'][35],$avgi['val'][36],$avgi['val'][37]),
				array($resulti['key'][10].'平均分',$avgi['key'][30],$avgi['key'][31],$avgi['key'][32],$avgi['key'][33],$avgi['key'][34],$avgi['key'][35],$avgi['key'][36],$avgi['key'][37]));
		$pdf->Ln(30);
		$pdf->Write ( 8, Texts::TitleFouII2_4_2, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->SetFont ( 'stsongstdlight', '', 8 );
		$pdf->writeHTML ('<table   border="0" cellspacing="1" cellpadding="9" style="border:0.5px solid #CCC">
										<tr>
										<td style="text-align:center; background-color:#538DD5;border:0.5px solid #CCC">三级指标</td>
										<td style="text-align:center;background-color:#538DD5;border:0.5px solid #CCC">汇总指标</td>
										<td style="text-align:center;background-color:#538DD5;border:0.5px solid #CCC">加权得分</td></tr>
										<tr>
										<td style="border:0.5px solid #CCC">T2、预约是否有优惠？</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="1">预约服务提供</td>
										<td style="text-align:center;border:0.5px solid #CCC"rowspan="1">'.$Tscore[0]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">T5、进入接待区后是否需要等待？ </td>
										<td style="text-align:center; border:0.5px solid #CCC" rowspan="7">维修保养服务时长</td>
										<td style="text-align:center; border:0.5px solid #CCC"rowspan="7">'.$Tscore[1]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">T6、是否提前告知维修保养时长？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">T7、维修工位是否需要等待？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">T8、服务顾问预计的维修保养等待时长您是否满意？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">T4、进入接待区是否需要等待？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">T11、完工后交车是否需要等待？</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">T12、付款结算环节是否需要等待？</td>
										</tr>
										</table>',true, false, false, false, '');
		$pdf->AddPage();
		$pdf->SetFont ( 'stsongstdlight', '', 10 );
		$pdf->Write ( 8, Texts::TitleFouII2_4_3, '', 0, 'L', true, 0, false, false, 0 );
		$pdf->Cell(0,12,$T2x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,55,array($T2x['val'][1],$S1x['val'][2]),array('选择'.$T2x['key'][1],'选择'.$T2x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$T3x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,135,array($T3x['val'][1],$T3x['val'][2]),array('选择'.$T3x['key'][1],'选择'.$T3x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$T4x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,215,array($T4x['val'][1],$T4x['val'][2]),array('选择'.$T4x['key'][1],'选择'.$T4x['key'][2]),true,true,$size=15,$weight=20,360,52);
		/**
			新一页
		*/
		$pdf->AddPage();
		$pdf->Cell(0,12,$T5x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,55,array($T5x['val'][1],$T5x['val'][2]),array('选择'.$T5x['key'][1],'选择'.$T5x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$T7x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,135,array($T7x['val'][1],$T7x['val'][2]),array('选择'.$T7x['key'][1],'选择'.$T7x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$T8x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,215,array($T8x['val'][1],$T8x['val'][2]),array('选择'.$T8x['key'][1],'选择'.$T8x['key'][2]),true,true,$size=15,$weight=20,360,52);
		/**新一页*/
		$pdf->Ln(12);
		$pdf->Cell(0,12,$T10x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,55,array($T10x['val'][1],$T10x['val'][2]),array('选择'.$T10x['key'][1],'选择'.$T10x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$T11x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,135,array($T11x['val'][1],$T11x['val'][2]),array('选择'.$T11x['key'][1],'选择'.$T11x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$T12x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,215,array($T12x['val'][1],$T12x['val'][2]),array('选择'.$T12x['key'][1],'选择'.$T12x['key'][2]),true,true,$size=15,$weight=20,360,52);
		/**新一页*/
		$pdf->AddPage();
		$pdf->Write ( 8, Texts::TitleFouII2_4_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,$T6['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,40,$T6['val'],$T6['key'],true,true,$size=10,$weight=5);
		$pdf->Ln(12);
		$pdf->Cell(0,12,$T9['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,120,$T9['val'],$T9['key'],true,true,$size=10,$weight=5);
		$pdf->Ln(20);
		$pdf->Cell(0,12,$T13['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,210,$T13['val'],$T13['key'],true,true,$size=10,$weight=5);
		/**新一页*/
		$pdf->AddPage();
		$pdf->Write ( 8, Texts::TitleFouII2_4_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,$T14['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,40,$T14['val'],$T14['key'],true,true,$size=10,$weight=5);
		$pdf->Ln(30);
		$pdf->Cell(0,12,$T15['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,140,$T15['val'],$T15['key'],true,true,$size=8,$weight=3);
		/**
		 * 25.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, '    '.Texts::TitleThrII2_5, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8, Texts::TitleFouII2_5_1, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8,'指标详细得分', '', 0, 'C', true, 0, false, false, 0 );
		$tools->setOblongL($pdf,30,75,array($resulti['val'][11],$avgi['val'][39],$avgi['val'][40],$avgi['val'][41],$avgi['val'][42]),
		 array($resulti['key'][11].'平均分',$avgi['key'][39],$avgi['key'][40],$avgi['key'][41],$avgi['key'][42]));
		$pdf->Ln(30);
		$pdf->Write ( 8, Texts::TitleFouII2_5_2, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->SetFont ( 'stsongstdlight', '', 8 );
		$pdf->writeHTML ('<table border="0" cellspacing="1" cellpadding="9" style="border:0.5px solid #CCC">
										<tr>
										<td width="50%" style="text-align:center; background-color:#538DD5;border:0.5px solid #CCC">指标</td>
										<td width="30%" style="text-align:center;background-color:#538DD5;border:0.5px solid #CCC">三级指标</td>
										<td width="20%" style="text-align:center;background-color:#538DD5;border:0.5px solid #CCC">加权得分</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">P1、维修、保养价格是否公开透明？</td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="1">价格透明度</td>
										<td style="text-align:center; border:0.5px solid #CCC"rowspan="1">'.$Pscore[0]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">P2、您觉得店内维修保养的配件和材料定价是否合理？ </td>
										<td style="text-align:center;border:0.5px solid #CCC" rowspan="3">定价合理性</td>
										<td style="text-align:center;border:0.5px solid #CCC"rowspan="3">'.$Pscore[1]["score"].'</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">P3、您觉得店内维修保养的工时定价是否合理</td>
										</tr>
										<tr>
										<td style="border:0.5px solid #CCC">P4、店内是否提供配件的多种选择（如：原厂件、配套件等）？</td>
										</tr>
										</table>' ,true, false, false, false, '');
		$pdf->AddPage();
		$pdf->SetFont ( 'stsongstdlight', '', 10 );
		$pdf->Write ( 8, Texts::TitleFouII2_5_3, '', 0, 'L', true, 0, false, false, 0 );
		$pdf->Cell(0,12,$P4x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,45,array($P4x['val'][1],$P4x['val'][2]),array('选择'.$P4x['key'][1],'选择'.$P4x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(8);
		$pdf->Cell(0,12,$P5x['val'][0], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,125,array($P5x['val'][1],$P5x['val'][2]),array('选择'.$P5x['key'][1],'选择'.$P5x['key'][2]),true,true,$size=15,$weight=20,360,52);
		$pdf->Ln(8);
		$pdf->Write ( 8, Texts::TitleFouII2_5_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,$P3['name'], 0,1, 'C',0,'',0);
		$tools->setOblongT($pdf,55,205,$P3['val'],$P3['key'],true,true,$size=10,$weight=5);
		/**
			*输出PDF
		*/
		$pdf->Output('cada.pdf', 'I');
	}
	/**
	 *老版本PDF报告
	 */
	private function oldPDF($providerid,$modelid,$ye,$month){
		$Any=new PDFOService();
		$models=$Any->getModels($modelid);
		$provider=$Any->getProvider($providerid);
		$model=array($models[0]['id'],$models[1]['id'],$models[2]['id'],$models[3]['id'],$models[4]['id']);
		$tan=array('F14','S18','Z17','T17','P8');
		/**便于后期修改的接口*/
		/**实例化PDF类*/
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$tools=new Toolso();
		/**设置页眉和页脚*/
		$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(33,33,33), array(124,181,236));
		$pdf->setFooterData(array(124,181,236), array(124,181,236));
		/**设置页眉页脚字体*/
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		/**设置默认字体*/
		$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		/**设置默认边距*/
		$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
		/**设置自动分页*/
		$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		/**设置图片比例缩放*/
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		/**设置字体*/
		$pdf->setFont('stsongstdlight', '',10);
		$pdf->setTextColor(33,33,33);
		/**设置CMYK值*/
		$tools->set($pdf);
	
		/**报告目录*/
		/**
		 * 目录页
		*/
		$color_arr=array(33,33,33);
		$pdf->Bookmark(Textso::TitleOneI, 0, 0, '1', '', $color_arr);
		$pdf->Bookmark(Textso::TitleTwoI1, 1, 0, '1', '', $color_arr);
		$pdf->Bookmark(Textso::TitleThrI1_1, 2, 0, '1', '', $color_arr);
		$pdf->Bookmark(Textso::TitleThrI1_2, 2, 0, '1', '', $color_arr);
		$pdf->Bookmark(Textso::TitleThrI1_3, 2, 0, '2', '', $color_arr);
		$pdf->Bookmark(Textso::TitleThrI1_4, 2, 0, '2', '', $color_arr);
		$pdf->Bookmark(Textso::TitleThrI1_5,2, 0, '3', '', $color_arr);
		$pdf->Bookmark(Textso::TitleThrI1_6, 2, 0, '3', '', $color_arr);
		$pdf->Bookmark(Textso::TitleTwoI2, 1, 0, '4', '', $color_arr);
		$pdf->Bookmark(Textso::TitleOneII, 0, 0, '5', '', $color_arr);
		$pdf->Bookmark(Textso::TitleTwoII1, 1, 0, '5', '', $color_arr);
		$pdf->Bookmark(Textso::TitleTwoII2, 1, 0, '6', '', $color_arr);
		/**服务顾问*/
		$pdf->Bookmark(Textso::TitleThrII2_1, 2, 0, '6', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_1_1, 3, 0, '6', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_1_2, 3, 0, '6', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_1_3, 3, 0, '7', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_1_4, 3, 0, '8', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_1_5, 3, 0, '8', '', $color_arr);
		/**服务设施*/
		$pdf->Bookmark(Textso::TitleThrII2_2, 2, 0, '9', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_2_1, 3, 0, '9', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_2_2, 3, 0, '9', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_2_3, 3, 0, '10', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_2_4, 3, 0, '11', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_2_5, 3, 0, '14', '', $color_arr);
		/**维修质量*/
		$pdf->Bookmark(Textso::TitleThrII2_3, 2, 0, '15', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_3_1, 3, 0, '15', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_3_2, 3, 0, '15', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_3_3, 3, 0, '16', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_3_4, 3, 0, '17', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_3_5, 3, 0, '19', '', $color_arr);
		/**维修时间*/
		$pdf->Bookmark(Textso::TitleThrII2_4, 2, 0, '20', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_4_1, 3, 0, '20', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_4_2, 3, 0, '20', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_4_3, 3, 0, '21', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_4_4, 3, 0, '22', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_4_5, 3, 0, '24', '', $color_arr);
		/**维修价格*/
		$pdf->Bookmark(Textso::TitleThrII2_5, 2, 0, '25', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_5_1, 3, 0, '25', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_5_2, 3, 0, '25', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_5_3, 3, 0, '26', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_5_4, 3, 0, '27', '', $color_arr);
		$pdf->Bookmark(Textso::TitleFouII2_5_5, 3, 0, '28', '', $color_arr);
		/**探查题目*/
		$pdf->Bookmark(Textso::TitleTwoII3, 1, 0, '29', '', $color_arr);
		$pdf->Bookmark(Textso::TitleTwoII4, 1, 0, '29', '', $color_arr);
		/**可点击目录*/
		$pdf->addTOCPage();
		$pdf->SetFont('stsongstdlight', 'B', 14);
		$pdf->Write ( 0,$provider['provider_name'], '', 0, 'C', true, 0, false, false, 0 );
		$pdf->Write ( 0,$ye.'年'.$month.'月《汽车售后服务客户体验测评》月度报告', '', 0, 'C', true, 0, false, false, 0 );
		$pdf->Ln(5);
		$pdf->SetFont('stsongstdlight', 'B', 10);
		$pdf->Write ( 0, "目录", '', 0, 'L', true, 0, false, false, 0 );
		$pdf->SetFont('stsongstdlight', '',11 );
		$pdf->addTOC(1, 'stsongstdlight', '.', 'INDEX', 'B',NULL);
		$pdf->endTOCPage();
	
		/**
		 * 2.
		*/
		/**报告内容*/
		$pdf->AddPage();
		$pdf->SetFont('stsongstdlight', 'b',12);
		$pdf->Cell(0,12,Textso::TitleOneI, 0,1, 'C',0,'',0);
		$pdf->SetFont('stsongstdlight', '',10);
		$pdf->Write(8,Textso::TitleTwoI1, '', 0, 'L', true, 0, false, false, 0);
		$size=$Any->getPersonSize($providerid,$ye,$month);
		$pdf->Write(0,vsprintf(Textso::TextI1,array($size)), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(8,Textso::TitleThrI1_1, '', 0, 'L', true, 0, false, false, 0);
		$sex=$Any->getPersonSexSize($providerid,$ye,$month);
		$sexs=array(round($sex['val'][0]*$size), ($sex['val'][0]*100).'%', round($sex['val'][1]*$size), ($sex['val'][1]*100).'%');
		$pdf->Write(0,vsprintf(Textso::TextI2,$sexs), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Cell(0,12,'性别分布统计', 0,1, 'C',0,'',0);
		/**设置扇形统计图*/
		Toolso::setRound($pdf,100,135,$sex['val'],$sex['key']);
		$pdf->Ln(8);
		/**统计图后追加文字*/
		$age=$Any->getPersonAgeSize($providerid,$ye,$month);
		$agei=$Any->setBub($age);
		$ages=array($agei['key'][0], ($agei['val'][0]*100).'%', $agei['key'][1], ($agei['val'][1]*100).'%', array_pop($agei['key']),(array_pop($agei['val'])*100).'%');
		$pdf->Write(8,Textso::TitleThrI1_2, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0,vsprintf(Textso::TextI3,$ages), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Cell(0,12,'年龄分布统计', 0,1, 'C',0,'',0);
		/**设置扇形统计图*/
		Toolso::setRound($pdf,204,250,$age['val'],$age['key']);
		
		/**
		 * 3.
		*/
		$pdf->AddPage();
		$education=$Any->getPersonEducationSize($providerid,$ye,$month);
		$educationi=$Any->setBub($education);
		$educations=array($educationi['key'][0], ($educationi['val'][0]*100).'%', $educationi['key'][1], ($educationi['val'][1]*100).'%', array_pop($educationi['key']),(array_pop($educationi['val'])*100).'%');
		$pdf->Write(8,Textso::TitleThrI1_3, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0,vsprintf(Textso::TextI4,$educations), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Cell(0,12,'学历分布统计', 0,1, 'C',0,'',0);
		/**设置扇形统计图*/
		Toolso::setRound($pdf,80,118,$education['val'],$education['key']);
		$pdf->Ln(8);
		$vocation=$Any->getPersonVocationSize($providerid,$ye,$month);
		$vocationi=$Any->setBub($vocation);
		$vocations=array($vocationi['key'][0], ($vocationi['val'][0]*100).'%', $vocationi['key'][1], ($vocationi['val'][1]*100).'%', array_pop($vocationi['key']),(array_pop($vocationi['val'])*100).'%');
		$pdf->Write(8,Textso::TitleThrI1_4, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0,vsprintf(Textso::TextI5,$vocations), '', 0, 'L', true, 0, false, false, 0);
		$tools->setCellColor($pdf,145,'职业分布统计');
		/**坐标轴*/
		Toolso::setOblongX($pdf,30,160,$vocation['val'],$vocation['key'],false,false,8);
		
		/**
		 * 4.
		*/
		$pdf->AddPage();
		$money=$Any->getPersonMoneySize($providerid,$ye,$month);
		$moneyi=$Any->setBub($money);
		$moneys=array($moneyi['key'][0], ($moneyi['val'][0]*100).'%', $moneyi['key'][1], ($moneyi['val'][1]*100).'%', array_pop($moneyi['key']),(array_pop($moneyi['val'])*100).'%');
		$pdf->Write(8,Textso::TitleThrI1_5, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0,vsprintf(Textso::TextI6,$moneys), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Cell(0,12,'收入分布统计', 0,1, 'C',0,'',0);
		/**设置扇形统计图*/
		Toolso::setRound($pdf,85,118,$money['val'],$money['key']);
		$pdf->Ln(12);
		$year=$Any->getPersonYearSize($providerid,$ye,$month);
		$yeari=$Any->setBub($year);
		$years=array($yeari['key'][0], ($yeari['val'][0]*100).'%', $yeari['key'][1], ($yeari['val'][1]*100).'%', array_pop($yeari['key']),(array_pop($yeari['val'])*100).'%');
		$pdf->Write(8,Textso::TitleThrI1_6, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0,vsprintf(Textso::TextI7,$years), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Cell(0,12,'年限分布统计', 0,1, 'C',0,'',0);
		/**设置扇形统计图*/
		Toolso::setRound($pdf,200,248,$year['val'],$year['key']);
		
		/**
		 * 5.
		*/
		$pdf->AddPage();
		$pdf->SetFont('stsongstdlight', '',10);
		$pdf->Write(8,Textso::TitleTwoI2, '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0,vsprintf(Textso::TextI8,array($size)), '', 0, 'L', true, 0, false, false, 0);
		$tools->setCellColor($pdf,40,'五大模块样本数量');
		/**坐标轴*/
		$result=$Any->getResultSize($providerid,$modelid,$ye,$month);
		Toolso::setOblongX($pdf,38,55,$result['val'],$result['key'],true,false);
		
		/**
		 * 6.
		*/
		$pdf->AddPage();
		$pdf->SetFont('stsongstdlight', 'B',12);
		$pdf->Cell(0,12,Textso::TitleOneII, 0,1, 'C',0,'',0);
		$pdf->SetFont('stsongstdlight', '',10);
		$pdf->Write ( 8, Textso::TitleTwoII1, '', 0, 'A', true, 0, false, false, 0 );
		$score=$Any->getResultMonth($providerid,$modelid,$ye,$month);
	    $scorestr=array($ye.'-'.$month,$score['val'][0]*100,$score['val'][1]*100,$score['val'][2]*100,$score['val'][3]*100,$score['val'][4]*100,$score['val'][5]*100);
		$pdf->Write ( 8,vsprintf(Textso::TextII1,$scorestr), '', 0, 'A', true, 0, false, false, 0 );
		$pdf->SetFont ( 'stsongstdlight', '', 10 );
		$pdf->Write ( 8,'测评总分情况', '', 0, 'C', true, 0, false, false, 0 );
		$pdf->SetFont ( 'stsongstdlight', '', 10 );
		Toolso::setOblongY($pdf,55,75,$score['val'],$score['key']);
		/**
		 * 7.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8,Textso::TitleTwoII2, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8, Textso::TitleThrII2_1, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8, Textso::TitleFouII2_1_1, '', 0, 'A', true, 0, false, false, 0 );
		$this->setLines($pdf,$Any,$model[0],$providerid,$score['val'][1],$X=4,$Y=60,$ye,$month);
		$pdf->Write ( 8, Textso::TitleFouII2_1_2, '', 0, 'A', true, 0, false, false, 0 );
		$this->setTable($pdf,$Any,$model[0],$providerid,Textso::$Tabi,$modelid,$ye,$month);
		/**
		 * 8.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Textso::TitleFouII2_1_3, '', 0, 'A', true, 0, false, false, 0 );
		$this->setMaxMin($pdf,$Any,$model[0],$providerid,$ye,$month);
		
		/**
		 * 9.
		*/
		$pdf->AddPage();
		$pdf->Write (8, Textso::TitleFouII2_1_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'车主对服务顾问着装仪表、服务态度、经验能力、操作规范重要性比较', 0,1, 'C',0,'',0);
	    $im=$Any->getQuestionAnswer($providerid,$ye,$month,$model[0],'F13');
	    $imi=$Any->setBub($im);
	    $ims=array($imi['key'][0], ($imi['val'][0]*100).'%', $imi['key'][1],($imi['val'][1]*100).'%');
		Toolso::setRound($pdf,75,110,$im['val'],$im['key']);
		$pdf->Ln(8);
		$pdf->writeHTML (Toolso::setTextIV($ims,4), true, false, false, false, '' );
		$pdf->Ln(8);
		$pdf->Write (8, Textso::TitleFouII2_1_5, '', 0, 'A', true, 0, false, false, 0 );
		$this->setTan($pdf,$Any,$model[0],$tan[0],$providerid,200,110,$ye,$month);
		/**
		 * 10.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8,Textso::TitleThrII2_2, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8,Textso::TitleFouII2_2_1, '', 0, 'A', true, 0, false, false, 0 );
		$this->setLines($pdf,$Any,$model[1],$providerid,$score['val'][2],$X=4,$Y=50,$ye,$month);
		$pdf->Write ( 8,Textso::TitleFouII2_2_2, '', 0, 'A', true, 0, false, false, 0 );
		$this->setTable($pdf,$Any,$model[1],$providerid,Textso::$Tabii,$modelid,$ye,$month);
	
		/**
		 * 11.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Textso::TitleFouII2_2_3, '', 0, 'A', true, 0, false, false, 0 );
		$this->setMaxMin($pdf,$Any,$model[1],$providerid,$ye,$month);
	
		/**
		 * 12.
		*/
		$pdf->AddPage();
		$pdf->Write (8, Textso::TitleFouII2_2_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write (8, Textso::TitleFivII2_2_4_A, '', 0, 'A', true, 0, false, false, 0 );
		$tools->setCellColor($pdf,40,'门店地理位置因素评价');
		$im=$Any->getQuestionAnswer($providerid,$ye,$month,$model[1],'S2');
		$imi=$Any->setBub($im);
		$ims=array($imi['key'][0], ($imi['val'][0]*100).'%', array_pop($imi['key']),(array_pop($imi['val'])*100).'%');
		Toolso::setOblongX($pdf,12,55,$im['val'],$im['key'],false,false);
		$pdf->Ln(8);
		$pdf->writeHTML (Toolso::setTextIV($ims,5), true, false, false, false, '' );
		$pdf->Ln(8);
		$pdf->Write (8, Textso::TitleFivII2_2_4_B, '', 0, 'A', true, 0, false, false, 0 );
		$tools->setCellColor($pdf,160,'门店无停车位时应对');
		$im=$Any->getQuestionAnswer($providerid,$ye,$month,$model[1],'S4');
		$imi=$Any->setBub($im);
		$ims=array($imi['key'][0], ($imi['val'][0]*100).'%', array_pop($imi['key']),(array_pop($imi['val'])*100).'%');
		Toolso::setOblongX($pdf,12,175,$im['val'],$im['key'],false,false);
		$pdf->Ln(8);
		$pdf->writeHTML (vsprintf(Textso::TextIIUl3,$ims), true, false, false, false, '' );
		/**
		 * 13.
		*/
		$pdf->AddPage();
		$pdf->Write (8, Textso::TitleFivII2_2_4_C, '', 0, 'A', true, 0, false, false, 0 );
		$im=$Any->getTwoAnswer($providerid,$ye,$month,$model[1],'S14','S15');
		$imi=$Any->setBub(array('val'=>$im['bub'],'key'=>$im['key']));
		$ims=array($imi['key'][0], round(($imi['val'][0]*100),2).'%', array_pop($imi['key']),round((array_pop($imi['val'])*100),2).'%');
		Toolso::setOblongXC($pdf,38,50,$im['val'],$im['key'],false,true,array('落差','车主满意','店内提供'));
		$pdf->Ln(80);
		$pdf->writeHTML (Toolso::setTextIV($ims,12), true, false, false, false, '' );
		$pdf->Write (8, Textso::TitleFivII2_2_4_D, '', 0, 'A', true, 0, false, false, 0 );
		$tools->setCellColor($pdf,165,'希望新增服务设施');
		$im=$Any->getQuestionAnswer($providerid,$ye,$month,$model[1],'S16');
		$imi=$Any->setBub($im);
		Toolso::setOblongX($pdf,24,180,$ratio=$im['val'],$im['key'],false,false,5,4);
		$pdf->Ln(8);
		$pdf->writeHTML (Toolso::setTextOneLii($im), true, false, false, false, '' );
		/**
		 * 14.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Textso::TitleFouII2_2_5, '', 0, 'A', true, 0, false, false, 0 );
		$this->setTan($pdf,$Any,$model[1],$tan[1],$providerid,75,110,$ye,$month);
		/**
		 * 15.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8,Textso::TitleThrII2_3, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8, Textso::TitleFouII2_3_1, '', 0, 'A', true, 0, false, false, 0 );
		$this->setLines($pdf,$Any,$model[2],$providerid,$score['val'][3],$X=4,$Y=50,$ye,$month);
		$pdf->Write ( 8, Textso::TitleFouII2_3_2, '', 0, 'A', true, 0, false, false, 0 );
		$this->setTable($pdf,$Any,$model[2],$providerid,Textso::$Tabiii,$modelid,$ye,$month);
		/**
		 * 16.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Textso::TitleFouII2_3_3, '', 0, 'A', true, 0, false, false, 0 );
		$this->setMaxMin($pdf,$Any,$model[2],$providerid,$ye,$month);
		
		/**
		 * 17.
		*/
		$pdf->AddPage();
		$pdf->Write (8, Textso::TitleFouII2_3_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write (8, Textso::TitleFivII2_3_4_A, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'返修对换店的影响', 0,1, 'C',0,'',0);
		$this->setArea($pdf,$Any,85,120,$model[2],'Z2',$providerid,$ye,$month);
		$pdf->Ln(8);
		$pdf->Write (8, Textso::TitleFivII2_3_4_B, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'车主对三包和质保了解', 0,1, 'C',0,'',0);
		$this->setArea($pdf,$Any,200,240,$model[2],'Z5',$providerid,$ye,$month);
		/**
		 * 18.
		*/
		$pdf->AddPage();
		$pdf->Write (8, Textso::TitleFivII2_3_4_C, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'车主希望在什么时候了解三包内容', 0,1, 'C',0,'',0);
		$this->setArea($pdf,$Any,85,120,$model[2],'Z7',$providerid,$ye,$month);
		$pdf->Write (8, Textso::TitleFivII2_3_4_D, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'车主自行处理剩余材料与旧件意愿', 0,1, 'C',0,'',0);
		$this->setArea($pdf,$Any,200,240,$model[2],'Z13',$providerid,$ye,$month);
		/**
		 * 19.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Textso::TitleFouII2_3_5, '', 0, 'A', true, 0, false, false, 0 );
		$this->setTan($pdf,$Any,$model[2],$tan[2],$providerid,75,110,$ye,$month);

		/**
		 * 20.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Textso::TitleThrII2_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8, Textso::TitleFouII2_4_1, '', 0, 'A', true, 0, false, false, 0 );
		$this->setLines($pdf,$Any,$model[3],$providerid,$score['val'][4],$X=4,$Y=50,$ye,$month);
		$pdf->Write ( 8, Textso::TitleFouII2_4_2, '', 0, 'A', true, 0, false, false, 0 );
		$this->setTable($pdf,$Any,$model[3],$providerid,Textso::$Tabiv,$modelid,$ye,$month);
		
		/**
		 * 21.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Textso::TitleFouII2_4_3, '', 0, 'A', true, 0, false, false, 0 );
		/**设置扇形统计图*/
		$this->setMaxMin($pdf,$Any,$model[3],$providerid,$ye,$month);
		/**
		 * 22.
		*/
		$pdf->AddPage();
		$pdf->Write (8, Textso::TitleFouII2_4_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write (8, Textso::TitleFivII2_4_4_A, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'预约习惯比例', 0,1, 'C',0,'',0);
		$this->setArea($pdf,$Any,85,120,$model[3],'T1',$providerid,$ye,$month);
		$pdf->Ln(8);
		$pdf->Write (8, Textso::TitleFivII2_4_4_B, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'原因比例', 0,1, 'C',0,'',0);
		$this->setArea($pdf,$Any,200,240,$model[3],'T4',$providerid,$ye,$month);
		/**
		 * 23.
		*/
		$pdf->AddPage();
		$pdf->Write (8, Textso::TitleFivII2_4_4_C, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'超长交车换店影响', 0,1, 'C',0,'',0);
		$this->setArea($pdf,$Any,85,120,$model[3],'T14',$providerid,$ye,$month);
		$pdf->Write (8, Textso::TitleFivII2_4_4_D, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'进店时间偏好', 0,1, 'C',0,'',0);
		$this->setArea($pdf,$Any,200,240,$model[3],'T16',$providerid,$ye,$month);
		/**
		 * 24.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Textso::TitleFouII2_4_5, '', 0, 'A', true, 0, false, false, 0 );
		/**设置扇形统计图*/
		$this->setTan($pdf,$Any,$model[3],$tan[3],$providerid,75,110,$ye,$month);
	
		/**
		 * 25.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Textso::TitleThrII2_5, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write ( 8, Textso::TitleFouII2_5_1, '', 0, 'A', true, 0, false, false, 0 );
		$this->setLines($pdf,$Any,$model[4],$providerid,$score['val'][5],$X=4,$Y=50,$ye,$month);
		$pdf->Write ( 8, Textso::TitleFouII2_5_2, '', 0, 'A', true, 0, false, false, 0 );
		$this->setTable($pdf,$Any,$model[4],$providerid,Textso::$Tabv,$modelid,$ye,$month);
		
		/**
		 * 26.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Textso::TitleFouII2_5_3, '', 0, 'A', true, 0, false, false, 0 );
		$this->setMaxMin($pdf,$Any,$model[4],$providerid,$ye,$month);
		/**
		 * 27.
		*/
		$pdf->AddPage();
		$pdf->Write (8, Textso::TitleFouII2_5_4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Write (8, Textso::TitleFivII2_5_4_A, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'价格影响换店', 0,1, 'C',0,'',0);
		$this->setArea($pdf,$Any,85,120,$model[4],'P5',$providerid,$ye,$month);
		$pdf->Ln(8);
		$pdf->Write (8, Textso::TitleFivII2_5_4_B, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'价差影响换店', 0,1, 'C',0,'',0);
		$this->setArea($pdf,$Any,200,240,$model[4],'P6',$providerid,$ye,$month);
		
		/**
		 * 28.
		*/
		$pdf->AddPage();
		$pdf->Write ( 8, Textso::TitleFouII2_5_5, '', 0, 'A', true, 0, false, false, 0 );
		$this->setTan($pdf,$Any,$model[4],$tan[4],$providerid,75,110,$ye,$month);
		/**
		 * 29.
		*/
		$pdf->AddPage();
		$pdf->SetFont ( 'stsongstdlight', '', 10 );
		$pdf->Write ( 8, Textso::TitleTwoII3, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'下次是否来本店', 0,1, 'C',0,'',0);
		$lastI=$Any->getQuestionAnswer($providerid,$ye,$month,$model[4],'P9');
		$lastIs=array($lastI['key'][0]=='是'?($lastI['val'][0]*100).'%':($lastI['val'][1]*100).'%',$lastI['key'][1]=='否'?($lastI['val'][1]*100).'%':($lastI['val'][0]*100).'%');
		Toolso::setRound($pdf,75,115,$lastI['val'],$lastI['key']);
		$pdf->Ln(8);
		$pdf->writeHTML(Toolso::setTextV($lastIs,26), true, false, true, false, '');
		$pdf->Ln(8);
		$pdf->Write ( 8, Textso::TitleTwoII4, '', 0, 'A', true, 0, false, false, 0 );
		$pdf->Cell(0,12,'是否向朋友推荐本店', 0,1, 'C',0,'',0);
		$lastII=$Any->getQuestionAnswer($providerid,$ye,$month,$model[4],'P10');
		$lastIIs=array($lastII['key'][0]=='是'?($lastII['val'][0]*100).'%':($lastII['val'][1]*100).'%',$lastII['key'][1]=='否'?($lastII['val'][1]*100).'%':($lastII['val'][0]*100).'%');
		Toolso::setRound($pdf,200,248,$lastII['val'],$lastII['key']);
		$pdf->Ln(8);
		$pdf->writeHTML(Toolso::setTextV($lastIIs,27), true, false, true, false, '');
		$pdf->Ln(8);
	   $pdf->Output('cada.pdf', 'I');
	}
/**设置表格通用方法*/
	public function setTable($pdf,$Any,$id,$providerid,$table,$modelid,$y,$m){
		$tab=$Any->getTable($modelid,$providerid,$y,$m,$id);
		$tabi=$Any->setBub($tab);
		$tabs=array($tabi['key'][0], ($tabi['val'][0]*100), array_pop($tabi['key']),(array_pop($tabi['val'])*100));
		$pdf->SetFont ( 'stsongstdlight', '', 8 );
		$pdf->writeHTML (vsprintf($table,array(($tab['val'][0]*100).'',($tab['val'][1]*100).'',($tab['val'][2]*100).'',($tab['val'][3]*100).'')) ,true, false, false, false, '' );
		$pdf->SetFont ( 'stsongstdlight', '', 10 );
		$pdf->writeHTML (Toolso::setTextIV($tabs,1), true, false, false, false, '' );
	}
	/**设置探查通用方法*/
	public function setTan($pdf,$Any,$id,$questionid,$providerid,$X=75,$Y=110,$y,$m){
		$pdf->Cell(0,12,'改进分析', 0,1, 'C',0,'',0);
		$see=$Any->getSee($providerid,$y,$m,$id,$questionid);
		Toolso::setRoundO($pdf,$X,$Y,$see['open'],$see['last']['val'],$see['last']['key']);
		$pdf->Ln(8);
		$pdf->writeHTML ( Toolso::setTextsLi($see), true, false, false, false, '' );
		$pdf->Ln(8);
	}
	/**设置极值通用方法*/
	public function setMaxMin($pdf,$Any,$id,$providerid,$y,$m){
		/**设置扇形统计图*/
		$maxI  = $Any->getQuestionMax($id,$providerid,$y,$m);
		$maxStr=explode('、',$maxI['name']);
		$maxIi = $Any->getQuestionAnswer($providerid,$y,$m,$id,$maxStr[0]);
		$pdf->Cell(0,12,$maxI['name'], 0,1, 'C',0,'',0);
		Toolso::setRound($pdf,75,110,$maxIi['val'],$maxIi['key']);
		$pdf->Ln(8);
		$pdf->writeHTML (Toolso::setTextOneLi($maxIi), true, false, false, false, '' );
		$pdf->Ln(8);
		$minI  = $Any->getQuestionMin($id,$providerid,$y,$m);
		$minStr=explode('、',$minI['name']);
		$minIi = $Any->getQuestionAnswer($providerid,$y,$m,$id,$minStr[0]);
		$pdf->Cell(0,12,$minI['name'], 0,1, 'C',0,'',0);
		Toolso::setRound($pdf,190,225,$minIi['val'],$minIi['key']);
		$pdf->Ln(8);
		$pdf->writeHTML (Toolso::setTextOneLi($minIi), true, false, false, false, '' );
	}
	/**设置指标得分通用方法*/
	public function setLines($pdf,$Any,$id,$providerid,$index,$X=4,$Y=50,$y,$m){
		$line=$Any->getQuestionAvg($id,$providerid,$y,$m);
		Toolso::setLinesY($pdf,$X,$Y,$line['val'],$line['key'],$Any->setPoor($index,$line['val']),$index*100,false,false,$y,$m);
		$linei=$Any->setBub($line);
		$lines=array($linei['key'][0], ($linei['val'][0]*100), array_pop($linei['key']),(array_pop($linei['val'])*100));
		$pdf->Ln(8);
		$pdf->writeHTML (Toolso::setTextIV($lines,1), true, false, false, false, '' );
		$pdf->Ln(8);
	}
	/**设置单一分析扇形图*/
	public function setArea($pdf,$Any,$X,$Y,$id,$str,$providerid,$y,$m){
		$im=$Any->getQuestionAnswer($providerid,$y,$m,$id,$str);
		$imi=$Any->setBub($im);
		$ims=array($imi['key'][0], ($imi['val'][0]*100).'%', array_pop($imi['key']),(array_pop($imi['val'])*100).'%');
		Toolso::setRound($pdf,$X,$Y,$im['val'],$im['key']);
		$pdf->Ln(8);
		$pdf->writeHTML (Toolso::setTextIV($ims,3), true, false, false, false, '' );
	}
}