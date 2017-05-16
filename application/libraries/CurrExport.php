<?php
header('content-type:text/html;charset=utf-8');
/*****************************************************
 **作者：zwx

**创始时间：2017-01-10

**描述：数据导出类,-----excel导出，xml导出，csv导出
*****************************************************/
class CurrExport{
	#.导出文件名
	private  $name;
	#.需要导出的数组
	private  $dataArray;
	#.导出表格的表头
	private  $th;
	/**
	 ***********************************************************
	 *方法::Export::__construct
	 * ----------------------------------------------------------
	 * 描述::导出类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : name :: 需要设置的文件名称
	 *parm2:in--   Array  : data   :: 需要导出的数据数组
	 *parm3:in--   Array  : th       :: 导出表格的表头数组
	 *----------------------------------------------------------
	 *返回：
	 *return::out-- 无
	 * ----------------------------------------------------------
	 * 日期:2017-01-10  Add by	zwx
	 ************************************************************
	 */
	function __construct($name,$data,$th=array()){
		$this->name=$name;
		$this->dataArray=$data;
		$this->th=$th;
	}
	/**
	 ***********************************************************
	 *方法::CurrExport::export
	 * ----------------------------------------------------------
	 * 描述::导出类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   String : type :: 导出文件的类型
	 *----------------------------------------------------------
	 *返回：
	 *return::out-- 无
	 * ----------------------------------------------------------
	 *示例:
	 *case1:use--   export('xls')   ::  导出表格
	 *case1:use--   export('csv')  :: 导出csv文件
     *case1:use--   export('xml') :: 导出xml文件
	 *----------------------------------------------------------
	 * 日期:2017-01-10  Add by	zwx
	 ************************************************************
	 */
	function  export($type){
		($type=='xls'  && !empty($this->th))  &&  $this->excel();
		($type=='csv') &&  $this->csv();
		($type=='xml') && $this->xml();
	}
	/**
	 ***********************************************************
	 *方法::CurrExport::excel
	 * ----------------------------------------------------------
	 * 描述::导出类，导出表格
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   无
	 *----------------------------------------------------------
	 *返回：
	 *return::out-- excel表格文件
	 * ----------------------------------------------------------
	 * 日期:2017-01-10  Add by	zwx
	 ************************************************************
	 */
	private function  excel(){
		header('Content-Type: text/xls');
		header ( "Content-type:application/vnd.ms-excel;charset=utf-8" );
		header('Content-Disposition: attachment;filename="' .$this->name. '.xls"');
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		$table = '<table border="1"><tr>';
		foreach($this->th as $i){
			$table.="<th>".$i."</th>";
		}
		$table.='</tr>';
		foreach ($this->dataArray as $line){
			$table .= '<tr>';
			foreach ($line as $key => &$item){
				$item = $item;
				$table .= '<td>' . $item . '</td>';
			}
			$table .= '</tr>';
		}
		$table .='</table>';
		echo $table;
		die();
	}
	/**
	 ***********************************************************
	 *方法::CurrExport::xml
	 * ----------------------------------------------------------
	 * 描述::导出类，导出xml文件
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   无
	 *----------------------------------------------------------
	 *返回：
	 *return::out-- xml文件
	 * ----------------------------------------------------------
	 * 日期:2017-01-10  Add by	zwx
	 ************************************************************
	 */
	private function  xml(){
		header('Content-Type: text/xml;');
		header('Content-Disposition: attachment;filename="' .$this->name. '.xml"');
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xml .= "<data>\n";
		foreach ($this->dataArray as $data) {
			$xml .= "<item>\n";
			foreach ($data as $key=>$val){
				$item .= "<".$key.">" . empty($val)?'无':$val. "</".$key.">\n";
			}
			$xml.= "</item>\n";
		}
		$xml.= "</data>\n";
		echo $xml;
		die();
	}
	/**
	 ***********************************************************
	 *方法::CurrExport::csv
	 * ----------------------------------------------------------
	 * 描述::导出类，导出csv文件
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--   无
	 *----------------------------------------------------------
	 *返回：
	 *return::out-- csv表格文件
	 * ----------------------------------------------------------
	 * 日期:2017-01-10  Add by	zwx
	 ************************************************************
	 */
	private function csv(){
		header('Content-Type: text/csv;');
		header('Content-Disposition: attachment;filename="' .$this->name. '.csv"');
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		$out=fopen("php://output", 'a');
		$item= 0;
		$limit= 100000;
		foreach($this->dataArray as $item) {
			$item++;
			if($limit == $item){ob_flush();flush();$item= 0;}
			foreach ($item as $key =>$val) {
				$val[$key]=iconv('utf-8', 'gbk', empty($val)?'NULL':$val);
			}
			fputcsv($out,$val);
		}
		fclose($out);
		die;
	}
}