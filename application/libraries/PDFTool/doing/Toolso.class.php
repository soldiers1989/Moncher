<?php
class Toolso{
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
   public static function setRound($pdf,$Y,$H,$ratio=array(),$text=array()){
	     $Angle=0;$Area=0;$Hi=$Y-30+((60-count($ratio)*5)/2);
	     $style=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(66, 66, 66));
	     #.交叉线
	   	 for ($i=0;$i<count($ratio);$i++){
	   	 	if($ratio[$i]<=0){continue;}
	   	 	#.设置颜色
	   	 	switch ($i%10){
	   	 		case 0:
	   	 			$pdf->SetFillColor(124,181,236);
	   	 			$pdf->SetFillSpotColor('color1', 100);
	   	 			break;
	   	 		case 1:
	   	 			$pdf->SetFillColor(144, 237, 125);
	   	 			$pdf->SetFillSpotColor('color2', 100);
	   	 			break;
	   	 		case 2:
	   	 			$pdf->SetFillColor(211,63,15);
	   	 			$pdf->SetFillSpotColor('color3', 100);
	   	 			break;
	   	 		case 3:
	   	 			$pdf->SetFillColor(247, 163, 92);
	   	 			$pdf->SetFillSpotColor('color4', 100);
	   	 			break;
	   	 		case 4:
	   	 			$pdf->SetFillColor(128, 133, 233);
	   	 			$pdf->SetFillSpotColor('color5', 100);
	   	 			break;
	   	 		case 5:
	   	 			$pdf->SetFillColor(241, 92, 128);
	   	 			$pdf->SetFillSpotColor('color6', 100);
	   	 			break;
	   	 		case 6:
	   	 			$pdf->SetFillColor(228, 211, 84);
	   	 			$pdf->SetFillSpotColor('color7', 100);
	   	 			break;
	   	 		case 7:
	   	 			$pdf->SetFillColor(43, 144, 143);
	   	 			$pdf->SetFillSpotColor('color8', 100);
	   	 			break;
	   	 		case 8:
	   	 			$pdf->SetFillColor(244, 91, 91);
	   	 			$pdf->SetFillSpotColor('color9', 100);
	   	 			break;
	   	 		case 9:
	   	 			$pdf->SetFillColor(145, 232, 225);
	   	 			$pdf->SetFillSpotColor('color0', 100);
	   	 			break;
	   	 	}
	   	 	#.设置扇形角度
		    $helf=$Angle+(($ratio[$i]*180));
	   	 	$Area=$Angle>=360?0:($Angle+($ratio[$i]*360));
	   	 	#.绘制扇形区域
	   	 	$pdf->PieSector(self::$Xi, $Y, self::$Ri,$Angle,$Area,'F',false, 0, 2);
	   	 	#.坐标中定位显示文字
			#.$pdf->Text(round((self::$Xi+(cos($helf*3.1514926/180)*20)),2),round(($Y-(sin($helf*3.1515926/180)*20))-3,2),($ratio[$i]*100).'%');
	   	 	$Angle=$Area;
	   	    $pdf->Rect(self::$Xi+35,$Hi, 4, 4, 'F');
	   	    $pdf->SetFont('stsongstdlight', '',8);
	   	 	$pdf->Text(self::$Xi+40,$Hi-0.25,$text[$i].'('.($ratio[$i]*100).'%'.')');
	   	 	$pdf->SetFont('stsongstdlight', '',10);
	   	 	$Hi+=5;
	   	 }
	   	 $pdf->Text(self::$Xi+40,$H-8,'');
   }
   /**设置纵向柱形图*/
   public static function setOblongY($pdf,$X,$Y,$ratio=array(),$text=array(),$B=false,$T=false,$size=10,$weight=5){
   	$Xi=55;$Yi=$Y;$Xii=$X;
   	$style=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(66, 66, 66));
   	$color=array('width' =>0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(237, 125, 49));
   	#.X坐标轴
   	for($i=10;$i>=0;$i--){
   		if($B){
   			$pdf->Text(48, $Y-3, ($i*10).'%');
   			$pdf->Text(155,$Y-3,($i-5).'%');
   		}else{
   			$pdf->Text(48, $Y-3, ($i*10).'');
   			$pdf->Text(155,$Y-3,($i-5).'');
   		}
   		$Y+=10;
   	}
   	$pdf->Line(55,$Yi+100,155,$Yi+100,$style);
   	#.Y坐标线
   	$pdf->Line(55,$Yi,55,$Yi+100,$style);
   	#.绘制柱形图
   	$X+=$weight;
   	$point=array();
   	for($i=0;$i<count($ratio);$i++){
   		if($i==0){
   			$pdf->SetFillSpotColor('color7', 100);
   		}else{
   			$pdf->SetFillSpotColor('color1', 100);
   		}
   		$pdf->Rect($X,$Yi+(100-($ratio[$i]*100)),$size,$ratio[$i]*100, 'F');
   		$pdf->Text($X+($size/2)-4, $Yi+(96-($ratio[$i]*100)),($ratio[$i]*100).'');
   		$point[$i]['X']=$X+($size/2);
   		$point[$i]['Y']=$Yi+(99-($ratio[$i]*100));
   		$X+=($size+$weight);
   	}
   	#.绘制线
   	for($i=1;$i<count($point)-1;$i++){
   		$pdf->Line($point[$i]['X'],$point[$i]['Y'],$point[$i+1]['X'],$point[$i+1]['Y'],$color);
   	}
   	#.绘制文本
   	$Xii+=$weight;
   	for($i=0;$i<count($text);$i++){
   		$pdf->Rotate(45,$Xii-5, $Yi+112);
   		$pdf->Text($Xii-5,$Yi+112, $text[$i]);
   		$pdf->Rotate(-45,$Xii-5, $Yi+112);
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
   /**设置多维度拼色横向统计图*/
   public static function setColorOblongX($pdf,$X,$Y,$ratio=array(),$text=array(),$blog=array()){
	   	$Xi=55;$Yii=$Y;
	   	$style=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(66, 66, 66));
	   	$pdf->SetFillSpotColor('color1', 100);
	   	$pdf->SetTextColor(255,255,255);//333
	   	/**坐标轴*/
	   	#.统计图
	   	for($i=0;$i<count($ratio);$i++){
	   		$pdf->SetTextColor(33,33,33);
	   		$pdf->Text($X,$Y, $text[$i]);
	   		$index=55;
	   		for($z=0;$z<count($ratio[$i]);$z++){
	   			#.设置颜色
	   			switch ($z%10){
	   				case 0:
	   					$pdf->SetFillColor(124,181,236);
	   					break;
	   				case 1:
	   					$pdf->SetFillColor(144, 237, 125);
	   					break;
	   				case 2:
	   					$pdf->SetFillColor(211,63,15);
	   					break;
	   				case 3:
	   					$pdf->SetFillColor(247, 163, 92);
	   					break;
	   				case 4:
	   					$pdf->SetFillColor(128, 133, 233);
	   					break;
	   				case 5:
	   					$pdf->SetFillColor(241, 92, 128);
	   					break;
	   				case 6:
	   					$pdf->SetFillColor(228, 211, 84);
	   					break;
	   				case 7:
	   					$pdf->SetFillColor(43, 144, 143);
	   					break;
	   				case 8:
	   					$pdf->SetFillColor(244, 91, 91);
	   					break;
	   				case 9:
	   					$pdf->SetFillColor(145, 232, 225);
	   					break;
	   			}
	   			$pdf->SetTextColor(255,255,255);
	   			$pdf->Rect($index,$Y, $ratio[$i][$z]*100,4, 'F');
	   			$pdf->Text($index, $Y, ($ratio[$i][$z]*100).'%');
	   			$index+=$ratio[$i][$z]*100;
	   		}
	   		$Y+=10;
	   	}
	   	$pdf->SetTextColor(33,33,33);
	   	#.Y坐标线
	   	$pdf->Line(55,$Yii-1,55,$Y-5,$style);
	   	#.设置提示块
	   	for($i=0;$i<count($blog);$i++){
	   		switch ($i%10){
	   			case 0:
	   				$pdf->SetFillSpotColor('color1', 100);
	   				break;
	   			case 1:
	   				$pdf->SetFillSpotColor('color2', 100);
	   				break;
	   			case 2:
	   				$pdf->SetFillSpotColor('color3', 100);
	   				break;
	   			case 3:
	   				$pdf->SetFillSpotColor('color4', 100);
	   				break;
	   			case 4:
	   				$pdf->SetFillSpotColor('color5', 100);
	   				break;
	   			case 5:
	   				$pdf->SetFillSpotColor('color6', 100);
	   				break;
	   			case 6:
	   				$pdf->SetFillSpotColor('color7', 100);
	   				break;
	   			case 7:
	   				$pdf->SetFillSpotColor('color8', 100);
	   				break;
	   			case 8:
	   				$pdf->SetFillSpotColor('color9', 100);
	   				break;
	   			case 9:
	   				$pdf->SetFillSpotColor('color0', 100);
	   				break;
	   		}
	   		#.绘制提示块
	   		$pdf->Rect(158,$Yii, 2, 2, 'F');
	   		$pdf->Text(160,$Yii,$blog[$i]);
	   		$Yii+=8;
	   	}
   }
   /**绘制纵向折线统计图*/
   public static function setLinesY($pdf,$X,$Y,$ratio=array(),$text=array(),$left=array(),$score=87,$XL=false,$YL=false,$year,$monthxii){
   	$Xi=100;$point=array();$Yi=$Y;
   	$pdf->SetFillSpotColor('colori', 100);
   	$pdf->Rect($X-2,$Yi-10, 153,9, 'F');
   	$pdf->Rect(155,$Yi-10,53 ,9, 'F');
   	$pdf->SetFont('stsongstdlight', 'B',10);
   	$pdf->Text($X,$Yi-7,'模块平均得分:   '.$score);
   	$pdf->Text(125,$Yi-7,$year.'-'.$monthxii);
   	$pdf->Text(170,$Yi-7,'与平均分分差');
   	$pdf->SetFont('stsongstdlight', '',10);
   	$style=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(124, 181, 236));
   	$color=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>'0', 'color' => array(66,66,66));
   	$colori=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>'1,1,1,1', 'color' => array(66,66,66));
   	$pdf->Line($X-2,$Y-10,208,$Y-10,$color);
   	#.绘制点
   	for($i=0;$i<count($ratio);$i++){
   		$pdf->Line($X-2,$Y-1,208,$Y-1,$colori);
   		$pdf->SetFont('stsongstdlight', '',8);
   		$pdf->Text($X,$Y,$text[$i]);
   		$pdf->Circle($Xi+($ratio[$i]*48),$Y+1.5,0.5,0,360,'F',null,array(124, 181, 236));
   		$pdf->Text($Xi+($ratio[$i]*48),$Y-2,($ratio[$i]*100)+'');
   		$point[$i]['X']=$Xi+($ratio[$i]*48);
   		$point[$i]['Y']=$Y+1.5;
   		$Y+=5;
   	}
   	#.绘制线
   	for($i=0;$i<count($point)-1;$i++){
   		$pdf->Line($point[$i]['X'],$point[$i]['Y'],$point[$i+1]['X'],$point[$i+1]['Y'],$style);
   	}
   	if($XL){
   		#.X坐标轴
   		for($i=0;$i<=10;$i++){
   			$pdf->Line($Xi,$Y-1,$Xi,$Y,$style);
   			$pdf->Text($Xi-1.8, $Y, ($i*10).'');
   			$Xi+=5;
   		}
   		$pdf->Line(100,$Y,$Xi-5,$Y,$style);
   	}
   	if($YL){
   		$Xii=$Xi;
   		#.X坐标轴
   		for($i=0;$i<=10;$i++){
   			$pdf->Line($Xi,$Y-1,$Xi,$Y,$style);
   			$pdf->Text($Xi-1.8, $Y, (($i-5)*5).'');
   			$Xi+=5;
   		}
   		$pdf->Line($Xii,$Y,$Xi-5,$Y,$style);
   	}

   	#.参考线
   	$pdf->Line($X-2,$Y,208,$Y,$color);
   	$pdf->Line($X-2,$Yi-10,$X-2,$Y,$color);
   	$pdf->Line(208,$Yi-10,208,$Y,$color);
    $pdf->Line(155,$Yi-10,155,$Y,$color);
   	#.横向柱形图
   	$pdf->SetFillSpotColor('color1', 100);
   	/**坐标轴*/
   	#.统计图
   	for($i=0;$i<count($left);$i++){
   		if($left[$i]>0){
   			$pdf->Rect(180,$Yi, $left[$i]*0.24,3, 'F');
   			$pdf->Text(180+($left[$i]*0.24),$Yi-1,round($left[$i],2));
   		}elseif($left[$i]<0){
   			$pdf->Rect(155+(25-(-0.24*$left[$i])),$Yi, (-0.24*$left[$i]), 3, 'F');
   			$pdf->Text(155+(17-(-0.24*$left[$i])),$Yi-1, round($left[$i],2));
   		}
   		$Yi+=5;
   	}
   	$pdf->SetFont('stsongstdlight', '',10);
   }
   /**双向横向柱形图*/
   public static function setOblongXC($pdf,$X,$Y,$ratio=array(),$text=array(),$B=false,$T=false,$blog=array(),$size=6){
	   	$Xi=55;$Yii=$Y;
	   	$pdf->SetFillSpotColor('color1', 100);
	   	$style=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(66, 66, 66));
	   	$pdf->SetFillSpotColor('color1', 100);
	   	/**坐标轴*/
	   	#.统计图
	   	$int=0;
	   	foreach ($ratio AS $ratio){
	   		$pdf->Text($X,$Y, $text[$int]);
		   	for($i=0;$i<count($ratio);$i++){
		   		switch ($i%10){
		   			case 0:
		   				$pdf->SetFillSpotColor('color1', 100);
		   				break;
		   			case 1:
		   				$pdf->SetFillSpotColor('color2', 100);
		   				break;
		   			case 2:
		   				$pdf->SetFillSpotColor('color3', 100);
		   				break;
		   			case 3:
		   				$pdf->SetFillSpotColor('color4', 100);
		   				break;
		   			case 4:
		   				$pdf->SetFillSpotColor('color5', 100);
		   				break;
		   			case 5:
		   				$pdf->SetFillSpotColor('color6', 100);
		   				break;
		   			case 6:
		   				$pdf->SetFillSpotColor('color7', 100);
		   				break;
		   			case 7:
		   				$pdf->SetFillSpotColor('color8', 100);
		   				break;
		   			case 8:
		   				$pdf->SetFillSpotColor('color9', 100);
		   				break;
		   			case 9:
		   				$pdf->SetFillSpotColor('color0', 100);
		   				break;
		   		}
		   		#.绘制满意度比例
		   		if($i>0){
		   			$pdf->Rect(105,$Y, ($ratio[$i]*50),4, 'F');
		   			$pdf->Text(105+($ratio[$i]*50),$Y-1,round(($ratio[$i]*100),2).'%');
		   		}elseif($i==0){
		   			$linStr=$ratio[$i];
		   			$ratio[$i]=$ratio[$i]>0?(-1*$ratio[$i]):$ratio[$i];
		   			$pdf->Rect(55+(50-(-1*($ratio[$i]*50))),$Y, (-1*($ratio[$i]*50)), 4, 'F');
		   			$pdf->Text(55+(38-(-1*($ratio[$i]*50))),$Y-1, round(($linStr*100),2).'%');
		   		}
		   		$Y+=$size;
		   	}
		   	$int++;
	   	}
	   	#.Y坐标线
	   	for($i=0;$i<=10;$i++){
	   	$Xi+=10;
	   	}
	   	$pdf->Line(105,$Yii-1,105,$size==10?$Y-5:$Y,$style);
	   	#.X坐标线
	   	if($T){
	   	$pdf->Line(55,$size==10?$Y-5:$Y,$Xi-5,$size==10?$Y-5:$Y,$style);
	   	}
	   	#.设置提示块
	   	for($i=0;$i<count($blog);$i++){
	   		switch ($i%10){
	   			case 0:
	   				$pdf->SetFillSpotColor('color1', 100);
	   				break;
	   			case 1:
	   				$pdf->SetFillSpotColor('color2', 100);
	   				break;
	   			case 2:
	   				$pdf->SetFillSpotColor('color3', 100);
	   				break;
	   			case 3:
	   				$pdf->SetFillSpotColor('color4', 100);
	   				break;
	   			case 4:
	   				$pdf->SetFillSpotColor('color5', 100);
	   				break;
	   			case 5:
	   				$pdf->SetFillSpotColor('color6', 100);
	   				break;
	   			case 6:
	   				$pdf->SetFillSpotColor('color7', 100);
	   				break;
	   			case 7:
	   				$pdf->SetFillSpotColor('color8', 100);
	   				break;
	   			case 8:
	   				$pdf->SetFillSpotColor('color9', 100);
	   				break;
	   			case 9:
	   				$pdf->SetFillSpotColor('color0', 100);
	   				break;
	   		}
	   		#.绘制提示块
	   		$pdf->Rect(165,$Yii, 2, 2, 'F');
	   		$pdf->Text(167,$Yii-2,$blog[$i]);
	   		$Yii+=6;
	   	}
   }
   /**设置扇形图*/
   public static function setRoundO($pdf,$Y,$H,$ratio=array(),$dis=array(),$text=array()){
   	/*设置颜色*/
   	$style=array('width' =>0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' =>0, 'color' => array(66, 66, 66));
   	/*线永远在一个位置*/
   	$Hii=($Y+30)-((1-$ratio[0])*60);
   	#.循环绘制色块
   	$Hix=$Hii;
   		for($i=0;$i<count($dis);$i++){
   			switch ($i%10){
   				case 9:
   					$pdf->SetFillColor(124,181,236);
   					$pdf->SetFillSpotColor('color1', 100);
   					break;
   				case 8:
   					$pdf->SetFillColor(144, 237, 125);
   					$pdf->SetFillSpotColor('color2', 100);
   					break;
   				case 7:
   					$pdf->SetFillColor(211,63,15);
   					$pdf->SetFillSpotColor('color3', 100);
   					break;
   				case 6:
   					$pdf->SetFillColor(247, 163, 92);
   					$pdf->SetFillSpotColor('color4', 100);
   					break;
   				case 5:
   					$pdf->SetFillColor(128, 133, 233);
   					$pdf->SetFillSpotColor('color5', 100);
   					break;
   				case 4:
   					$pdf->SetFillColor(241, 92, 128);
   					$pdf->SetFillSpotColor('color6', 100);
   					break;
   				case 3:
   					$pdf->SetFillColor(228, 211, 84);
   					$pdf->SetFillSpotColor('color7', 100);
   					break;
   				case 2:
   					$pdf->SetFillColor(43, 144, 143);
   					$pdf->SetFillSpotColor('color8', 100);
   					break;
   				case 1:
   					$pdf->SetFillColor(244, 91, 91);
   					$pdf->SetFillSpotColor('color9', 100);
   					break;
   				case 0:
   					$pdf->SetFillColor(145, 232, 225);
   					$pdf->SetFillSpotColor('color0', 100);
   					break;
   			}
   			$pdf->Rect(55, $Hii,20,$dis[$i]*60*$ratio[1], 'F');
   			$pdf->Rect(125,$Hix, 4, 4, 'F');
   			$pdf->Text(130,$Hix,$text[$i].'('.round(($dis[$i]*100*$ratio[1]),2).'%)');
   			$Hii+=$dis[$i]*60*$ratio[1];
   			$Hix+=6;
   		}
   		$pdf->SetFillSpotColor('color1', 100);
   		$pdf->Rect(90,($Y+30)-($ratio[0]*60),20,$ratio[0]*60, 'F');
   		$pdf->Text(95,($Y+30)-($ratio[0]*60)-5,($ratio[0]*100).'%');
   		$pdf->Text(60,($Y+25)-((1-$ratio[0])*60),((1-$ratio[0])*100).'%');
   		$pdf->Line(50,$Y+30,115,$Y+30,$style);/*线永远不移位于底部*/
   		$pdf->Text(96,$Y+30,'否');
   		$pdf->Text(61,$Y+30,'是');
   	}
   	/**设置颜色区域*/
   	public function setCellColor($pdf,$Y,$text=''){
   		$pdf->SetDrawColor(255,255,255);
   		$pdf->SetFillColor(104,185,225);
   		$pdf->SetTextColor(255, 255, 255);
   		$pdf->setCellHeightRatio(2);
   		$pdf->SetXY(55,$Y);
   		$pdf->Cell(50, 0, $text, 1, 1, 'C', 1, '', 0, false, 'T', 'C');
   		$pdf->SetTextColor(33, 33, 33);
   	}
   	/**设置探查文本*/
   	public static function setTextsLi($list){
   		$str="<ul>";
   		$str.="<li>".($list['open'][0]*100)."%的车主认为本模块表现很好，无需改进。</li><li>";
   		for($i=0;$i<count($list['last']['val']);$i++){
   			$str.=round(($list['last']['val'][$i]*100*$list['open'][1]),2)."%的车主认为“".$list['last']['key'][$i]."”，有待提高；";
   		}
   		$str.="</li>";
   		$str.="<ul>";
   		return $str;
   	}
   	/**针对于指标的描述*/
   	public static function setTextOneLi($list){
   		$str="<ul>";
   		for($i=0;$i<count($list['val']);$i++){
   			 $str.="<li>".($list['val'][$i]*100)."%的车主针对于该问题选了:“".$list['key'][$i]."”</li>";
			 if($list['val'][$i]==1){break;}
   		}
   		$str.="<ul>";
   		return $str;
   	}
   	/**针对于指标的描述*/
   	public static function setTextOneLii($list){
   		$str="<ul>";
   		for($i=0;$i<count($list['val']);$i++){
   			$str.="<li>".($list['val'][$i]*100)."%的车主希望增加“".$list['key'][$i]."”，以便于提高服务质量；</li>";
   		}
   		$str.="<ul>";
   		return $str;
   	}
   	/**极值指标描述*/
   	public static function setTextIV($list,$label){
   		$str="<ul>";
   		if($label==1){#.得分文本
   			if($list[0]!=null&&$list[1]!=null){
   			$str.="<li>“".$list[0]."”得分最高，为".$list[1]."分</li>";
   			}
   			if($list[2]!=null&&$list[3]!=null&&$list[3]!="100"){
   			 $str.="<li>“".$list[2]."”得分最低，为".$list[3]."分</li>";
   			}
   		}else if($label==3){#.比例文本
   			if($list[0]!=null&&$list[1]!=null){
   				$str.="<li>车主选择“".$list[0]."”的比例最高，为".$list[1]."</li>";
   			}
   			if($list[2]!=null&&$list[3]!=null&&$list[3]!="100%"){
   				$str.="<li>车主选择“".$list[2]."”	的比例最低，为".$list[3]."</li>";
   			}
   		}else if($label==4){#.因素文本
   			if($list[0]!=null&&$list[1]!=null){
   				$str.="<li>车主认为【服务顾问】里“".$list[0]."”是最重要的因素，比例为".$list[1]."</li>";
   			}
   			if($list[2]!=null&&$list[3]!=null&&$list[3]!="100%"){
   				$str.="<li>车主认为【服务顾问】里“".$list[2]."”是第二重要的因素，比例为".$list[3]."</li>";
   			}
   		}else if($label==5){#.位置文本
   			if($list[0]!=null&&$list[1]!=null){
   				$str.="<li>车主认为【门店地理位置】里“".$list[0]."”是最重要的因素，比例为".$list[1]."</li>";
   			}
   			if($list[2]!=null&&$list[3]!=null&&$list[3]!="100%"){
   				$str.="<li>车主认为【门店地理位置】里“".$list[2]."”是最不重要的因素，比例为".$list[3]."</li>";
   			}
   		}else if($label==12){#.落差文本
   			if($list[0]!=null&&$list[1]!=null){
   				$str.="<li>“".$list[0]."”娱乐落差比例最低，比例为".$list[1]."</li>";
   			}
   			if($list[2]!=null&&$list[3]!=null&&$list[3]!="100%"){
   				$str.="<li>“".$list[2]."”娱乐落差比例最高，比例为".$list[3]."</li>";
   			}
   		}else{}
   		$str.="<ul>";
   		return $str;
   	}
   	/*满意度调查*/
   	public static function setTextV($list,$label){
   		$str="<ul>";
   		if($label==26){
   			if($list[0]!=null){
   				$str.="<li>".$list[0]."的车主表示下次“仍会接受”本店的服务</li>";
   			}
   			if($list[1]!=null&&$list[1]!="100%"){
   				$str.="<li>".$list[1]."的车主表示下次“不会来”本店接受服务</li>";
   			}
   		}else if($label==27){
   			if($list[0]!=null){
   				$str.="<li>".$list[0]."的车主表示“会向朋友推荐”本店</li>";
   			}
   			if($list[1]!=null&&$list[1]!="100%"){
   				$str.="<li>".$list[1]."的车主表示“不会向朋友推荐”本店</li>";
   			}
   		}else{}
   		$str.="<ul>";
   		return $str;
   	}
}
?>