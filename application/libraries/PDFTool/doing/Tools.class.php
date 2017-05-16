<?php
class Tools{
	public  static $Xi=72;
	public  static $Ri=30;
     /**设置CMYK值*/
	public static function set($pdf){
		$pdf->AddSpotColor('color1', 54, 21, 0,0);
		$pdf->AddSpotColor('color2', 47, 0, 64,0);
		$pdf->AddSpotColor('color3', 22, 88, 100,0);
		$pdf->AddSpotColor('color4', 4, 47, 65,0);
		$pdf->AddSpotColor('color5', 58, 48, 0,0);
		$pdf->AddSpotColor('color6', 5, 77, 30,0);
		$pdf->AddSpotColor('color7', 18, 16, 74,0);
		$pdf->AddSpotColor('color8', 78, 31, 47,0);
		$pdf->AddSpotColor('color9', 3, 78, 55,0);
		$pdf->AddSpotColor('color0', 44, 0, 21,0);
		$pdf->AddSpotColor('colori', 23, 18, 17,0);
	}
   /**设置扇形图*/
   public static function setOblongT($pdf,$X,$Y,$ratio=array(),$text=array(),$B=false,$T=false,$size=10,$weight=5,$cos=270,$location=55){
		$Yi=$Y;$Xii=$X;
		$pdf->SetFont ( 'stsongstdlight', '', 8 );
		$style=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(66, 66, 66));
		$color=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>2, 'color' => array(212, 212, 212));
		#.X坐标轴
		for($i=10;$i>=0;$i--){ 
		    $i !=10 && $pdf->Line($X,$Y,$X+100,$Y,$color);
			$B?$pdf->Text(48, $Y-3, ($i*10).'%'):$pdf->Text(48, $Y-3, ($i*10).'');$Y+=5;
		 }
		$pdf->Line($X,$Yi+50,$X+100,$Yi+50,$style);
		#.Y坐标线
		$pdf->Line($X,$Yi,$X,$Yi+50,$style);
		#.绘制柱形图
		$X+=$weight;
		$point=array();
		for($i=0;$i<count($ratio);$i++){
			$pdf->SetFillSpotColor('color1', 100);
			$pdf->Rect($X,$Yi+(50-($ratio[$i]*0.5)),$size,$ratio[$i]*0.5, 'F');
			$pdf->Text($X+($size/2)-5, $Yi+(45-($ratio[$i]*0.5)),$T?($ratio[$i]).'%':($ratio[$i]));
			$X+=($size+$weight);
		}
		#.绘制文本
		$Xii+=$weight;
		for($i=0;$i<count($text);$i++){
			$pdf->Rotate($cos,$Xii+4, $Yi+$location);
			$pdf->Text($Xii,$Yi+$location, substr($text[$i],0,21));
			$pdf->Rotate(0-$cos,$Xii+4, $Yi+$location);
			$Xii+=($size+$weight);
		 }
		 $pdf->SetFont ( 'stsongstdlight', '', 10 );
   }
   /**设置纵向柱形图*/
   public static function setOblongY($pdf,$X,$Y,$ratio=array(),$text=array(),$B=false,$T=false,$size=10,$weight=5){
   	$Xi=55;$Yi=$Y;$Xii=$X;
   	$style=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(66, 66, 66));
   	$color=array('width' =>0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(237, 125, 49));
	$color1=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>2, 'color' => array(212, 212, 212));
   	#.X坐标轴
   	for($i=10;$i>=0;$i--){ $i !=10 && $pdf->Line($X,$Y,$X+100,$Y,$color1);$B?$pdf->Text(48, $Y-3, ($i*5).'%'):$pdf->Text(48, $Y-3, ($i*10).'');$Y+=5;}
   	$pdf->Line(55,$Yi+50,155,$Yi+50,$style);
   	#.Y坐标线
   	$pdf->Line(55,$Yi,55,$Yi+50,$style);
   	#.绘制柱形图
   	$X+=$weight;
   	$point=array();
   	for($i=0;$i<count($ratio);$i++){
		$i==0?$pdf->SetFillSpotColor('color7', 100):$pdf->SetFillSpotColor('color1', 100);
   		$pdf->Rect($X,$Yi+(50-($ratio[$i]*0.5)),$size,$ratio[$i]*0.5, 'F');
   		$pdf->Text($X+($size/2)-5, $Yi+(45-($ratio[$i]*0.5)),($ratio[$i]).'');
   		$point[$i]['X']=$X+($size/2);
   		$point[$i]['Y']=$Yi+(49-($ratio[$i]*0.5));
   		$X+=($size+$weight);
   	}
   	#.绘制线
   	for($i=1;$i<count($point)-1;$i++){
   		$pdf->Line($point[$i]['X'],$point[$i]['Y'],$point[$i+1]['X'],$point[$i+1]['Y'],$color);
   	}
   	#.绘制文本
   	$Xii+=$weight;
   	for($i=0;$i<count($text);$i++){
   		$pdf->Rotate(270,$Xii+5, $Yi+50);
   		$pdf->Text($Xii+5,$Yi+50, $text[$i]);
   		$pdf->Rotate(-270,$Xii+5, $Yi+50);
   		$Xii+=($size+$weight);
   	 }
   }
   /**设置纵向柱形图*/
   public static function setOblongL($pdf,$X,$Y,$ratio=array(),$text=array(),$B=false,$T=false,$size=8,$weight=5){
   	$Xi=55;$Yi=$Y;$Xii=$X;
   	$style=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(66, 66, 66));
   	$color=array('width' =>0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(237, 125, 49));
	$color1=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>2, 'color' => array(212, 212, 212));
   	#.X坐标轴
   	for($i=10;$i>=0;$i--){ $i !=10 && $pdf->Line($X,$Y,$X+150,$Y,$color1);$B?$pdf->Text(23, $Y-3, ($i*5).'%'):$pdf->Text(23, $Y-3, ($i*10).'');$Y+=5;}
   	$pdf->Line(30,$Yi+50,185,$Yi+50,$style);
   	#.Y坐标线
   	$pdf->Line(30,$Yi,30,$Yi+50,$style);
   	#.绘制柱形图
   	$X+=$weight;
   	$point=array();
   	for($i=0;$i<count($ratio);$i++){
		$i==0?$pdf->SetFillSpotColor('color7', 100):$pdf->SetFillSpotColor('color1', 100);
   		$pdf->Rect($X,$Yi+(50-($ratio[$i]*0.5)),$size,$ratio[$i]*0.5, 'F');
   		$pdf->Text($X+($size/2)-5, $Yi+(45-($ratio[$i]*0.5)),($ratio[$i]).'');
   		$point[$i]['X']=$X+($size/2);
   		$point[$i]['Y']=$Yi+(49-($ratio[$i]*0.5));
   		$X+=($size+$weight);
   	}
   	#.绘制线
   	for($i=1;$i<count($point)-1;$i++){
   		$pdf->Line($point[$i]['X'],$point[$i]['Y'],$point[$i+1]['X'],$point[$i+1]['Y'],$color);
   	}
   	#.绘制文本
   	$Xii+=$weight;
   	for($i=0;$i<count($text);$i++){
   		$pdf->Rotate(270,$Xii+5, $Yi+50);
   		$pdf->Text($Xii+5,$Yi+50, $text[$i]);
   		$pdf->Rotate(-270,$Xii+5, $Yi+50);
   		$Xii+=($size+$weight);
   	 }
   }
  /**设置横向柱形图*/
   public static function setOblongX($pdf,$X,$Y,$ratio=array(),$text=array(),$B=false,$T=false,$size=10,$weight=4){
	   	$Xi=55;$Yii=$Y;
	   	$pdf->SetFillSpotColor('color1', 100);
	   	$style=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(66, 66, 66));
	   	$color=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>'1,5', 'color' => array(191, 191, 191));
	   	$pdf->SetFillSpotColor('color1', 100);
	   	#.统计图
	   	$pdf->SetFont ( 'stsongstdlight', '', 9 );
	   	for($i=0;$i<count($ratio);$i++){
	   		$pdf->Text($X, $weight==4?$Y:$Y+($size-$weight)/2+($weight-4)/2, $text[$i]);
	   		$pdf->Rect(55, $weight==4?$Y:$Y+($size-$weight)/2, $ratio[$i]*100, $weight, 'F');
	   		$pdf->Text(55+($ratio[$i]*100), $weight==4?$Y:$Y+($size-$weight)/2+($weight-4)/2, $B==true?($ratio[$i]*100):($ratio[$i]*100).'%');
	   		$Y+=$size;
	   	}
	   	$pdf->Line(55,$Yii-1,55,$size==10?$Y-5:$Y,$style);
	   	$pdf->SetFont ( 'stsongstdlight', '', 10 );
	   	#.X坐标线
   }
   /**设置用户名引导*/
   public function setTexts($type,$key,$val){
	   $str='					';
	   ($type ==1 && $str='本月参与测评的车主年龄，') ||
	   ($type ==2 && $str='本月参与测评的车主学历，') ||
	   ($type ==3 && $str='本月参与测评的车主职业分布，') ||
	   ($type ==4 && $str='本月参与测评的家庭输入，') ||
	   ($type ==5 && $str='本月参与测评的购车年限，') ;
	   for($i=0;$i<count($key);$i++){
		   $val[$i]<=0 ? $str.="本月无".$key[$i].'区间的车主；':$str.='在区间'.$key[$i].'的车主比例为：'.($val[$i])."%；";
	   }
	   return $str;
   }
}
?>