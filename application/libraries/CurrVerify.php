<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-01-06
**描述：图片验证码类，包括验证码生成后，
*				显示，以及验证。
*****************************************************/
class CurrVerify {
	protected $config =	array(
			#. 验证码加密密钥
			'seKey'     	    =>  'CADAYUN.CN',   
			#.验证码字符集合
			'codeSet'         =>  '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY', 
			#.验证码过期时间（s）
			'expire'            =>  1800,            
			#.使用中文验证码
			'useZh'            => false,   
			#.中文验证码字符串
			'zhSet'             =>  '们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借',              
			#.使用背景图片
			'useImgBg'     =>  false,           
			#.验证码字体大小(px)
			'fontSize'        =>  24, 
			#. 是否画混淆曲线
			'useCurve'      =>  true,           
			#.是否添加杂点
			'useNoise'      =>  true,    
			#.验证码图片高度
			'imageH'        => 124,        
			#.验证码图片宽度
			'imageW'       =>  200,      
			#.验证码位数
			'length'          =>  5,      
			#.验证码字体，不设置随机获取
			'fontTtf'          =>  '',        
			#.背景颜色
			'bg'                =>  array(243, 251, 254),  
			#.验证成功后是否重置
			'reset'            =>  true,      
	);
	private  $fontttf;
	#.验证码图片实例
	private $_image   = NULL;     
	#.验证码字体颜色
	private $_color   = NULL;  
	/**
	 ***********************************************************
	 *方法::CurrVerify::__construct
	 * ----------------------------------------------------------
	 * 描述::图片验证码类初始化方法
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    Array : config :: 验证码配置数组
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.01.07  Add by zwx
	 ************************************************************
	 */
	public function __construct($config=array()){
		$this->config=array_merge($this->config, $config);
	}
	/**
	 ***********************************************************
	 *方法::CurrVerify::check
	 * ----------------------------------------------------------
	 * 描述::检测验证码是否正确
	 *----------------------------------------------------------
	 *参数:
	 *parm1:in--    String : code :: 验证码的编码
	 *parm2:in--    String : id      :: 验证码的id
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  bool  : ture|false ::成功|失败 
	 * ----------------------------------------------------------
	 * 日期:2017.01.07  Add by zwx
	 ************************************************************
	 */
	public function check($code,$id=''){
		$key = $this->authcode($this->config['seKey']).$id;
		$secode =$_SESSION[$key];
		if(empty($code) || empty($secode)) return false;
		/*SESSION过期*/
		if(time() - $secode['verify_time'] > $this->config['expire']) {
			$_SESSION[$key]=NULL;
			return false;
		}
		if($this->authcode(strtoupper($code)) == $secode['verify_code']) {
			$this->config['reset'] && $_SESSION[$key]=NULL;
			return true;
		}
		return false;
	}
	/**
	 ***********************************************************
	 *方法::CurrVerify::entry()
	 * ----------------------------------------------------------
	 * 描述::输出验证码并把验证码的值保存的session中；
	 * 			 验证码保存到session的格式为： 
	 *          array('verify_code' => '验证码值',
	 *                    'verify_time' => '验证码创建时间'
	 *                   );
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    String : id      :: 设置验证码的id
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.01.07  Add by zwx
	 ************************************************************
	 */
	public function entry($id='') {
		#.图片宽(px)
		$this->config['imageW'] || $this->config['imageW'] = $this->config['length']*$this->config['fontSize']*1 + $this->config['length']*$this->config['fontSize']/2;
		#. 图片高(px)
		$this->config['imageH'] || $this->config['imageH'] = $this->config['fontSize'] * 2.5;
		#. 建立一幅 $this->config['imageW'] x $this->config['imageH'] 的图像
		$this->_image = imagecreate($this->config['imageW'], $this->config['imageH']);
		#. 设置背景
		imagecolorallocate($this->_image, $this->config['bg'][0], $this->config['bg'][1], $this->config['bg'][2]);
		#. 验证码字体随机颜色
		$this->_color = imagecolorallocate($this->_image, mt_rand(1,150), mt_rand(1,150), mt_rand(1,150));
		#.重新赋值字体文件
		$this->config['fontTtf']=dirname(__FILE__) . '/code.ttf';;
		#.设置背景图
		//$this->useImgBg && $this->_background();
		#. 绘杂点
		//$this->useNoise && $this->_writeNoise();
		$this->_writeNoise();
		#. 绘干扰线
		//$this->useCurve && $this->_writeCurve();
	    $this->_writeCurve();
	   /*绘验证码*/
		#. 验证码
		$code = array();
		#. 验证码第N个字符的左边距
		$codeNX = 0; 
		#. 中文验证码
		if($this->config['useZh']){ 
			for ($i = 0; $i<$this->config['length']; $i++) {
				$code[$i] =iconv_substr($this->config['zhSet'],floor(mt_rand(0,mb_strlen($this->config['zhSet'],'utf-8')-1)),1,'utf-8');
				imagettftext($this->_image, $this->config['fontSize'], mt_rand(-40, 40), $this->config['fontSize']*($i+1)*1.0, $this->config['fontSize'] + mt_rand(10, 20), $this->_color, $this->config['fontTtf'], $code[$i]);
			}
		}else{
			for ($i = 0; $i<$this->config['length']; $i++) {
				$code[$i] = $this->config['codeSet'][mt_rand(0, strlen($this->config['codeSet'])-1)];
				$codeNX += mt_rand($this->config['fontSize']*0.7, $this->config['fontSize']*0.7);
				imagettftext($this->_image, $this->config['fontSize'], mt_rand(-40, 40), $codeNX, $this->config['fontSize']*1.0, $this->_color, $this->config['fontTtf'], $code[$i]);
			}
		}
		#. 保存验证码
		$key=$this->authcode($this->config['seKey']);
		$code= $this->authcode(strtoupper(implode('', $code)));
		$secode=array();
		#. 把校验码保存到session
		$secode['verify_code'] = $code; 
		#. 验证码创建时间
		$secode['verify_time'] =time();
		#.将验证码存入SESSION
		$_SESSION[$key.$id]=$secode;
		#. 输出图像
		header('Cache-Control: private, max-age=0, no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		header("content-type: image/png");
		imagepng($this->_image);
		imagedestroy($this->_image);
	}
	/**
	 ***********************************************************
	 *方法::CurrVerify::_writeCurve()
	 * ----------------------------------------------------------
	 * 描述::画一条由两条连在一起构成的随机正弦,
	 * 			 函数曲线作干扰线(你可以改成更帅的曲线函数)
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.01.07  Add by zwx
	 ************************************************************
	 */
	private function _writeCurve() {
		/**
		 *正弦型函数解析式：y=Asin(ωx+φ)+b
		 *各常数值对函数图像的影响：
		 *A：决定峰值（即纵向拉伸压缩的倍数）
		 *b：表示波形在Y轴的位置关系或纵向移动距离（上加下减）
		 *φ：决定波形与X轴位置关系或横向移动距离（左加右减）
		 *ω：决定周期（最小正周期T=2π/∣ω∣）
		 */
		#. 曲线前部分
		$px = $py = 0;
		#. 振幅
		$A = mt_rand(1, $this->config['imageH']/2);
		#. Y轴方向偏移量
		$b = mt_rand(-$this->config['imageH']/4, $this->config['imageH']/4); 
		#. X轴方向偏移量
		$f = mt_rand(-$this->config['imageH']/4, $this->config['imageH']/4);   
		#. 周期
		$T = mt_rand($this->config['imageH'], $this->config['imageW']*2);  
		$w = (2* M_PI)/$T;
		#. 曲线横坐标起始位置
		$px1 = 0;  
		#. 曲线横坐标结束位置
		$px2 = mt_rand($this->config['imageW']/2, $this->config['imageW'] * 0.8);  
		for ($px=$px1; $px<=$px2; $px = $px + 1) {
			if ($w!=0) {
				#. y = Asin(ωx+φ) + b
				$py = $A * sin($w*$px + $f)+ $b + $this->config['imageH']/2;  
				$i = (int) ($this->config['fontSize']/5);
				while ($i > 0) {
					#. 这里(while)循环画像素点比imagettftext和imagestring用字体大小一次画出（不用这while循环）性能要好很多
					imagesetpixel($this->_image, $px + $i , $py + $i, $this->_color);  
					$i--;
				}
			}
		}
		#. 曲线后部分
		#. 振幅
		$A = mt_rand(1, $this->config['imageH']/2); 
		#. X轴方向偏移量
		$f = mt_rand(-$this->config['imageH']/4, $this->config['imageH']/4);
		#. 周期
		$T = mt_rand($this->config['imageH'], $this->config['imageW']*2);  
		$w = (2* M_PI)/$T;
		$b = $py - $A * sin($w*$px + $f) - $this->config['imageH']/2;
		$px1 = $px2;
		$px2 = $this->config['imageW'];
		for ($px=$px1; $px<=$px2; $px=$px+ 1) {
			if ($w!=0) {
				#. y = Asin(ωx+φ) + b
				$py = $A * sin($w*$px + $f)+ $b + $this->config['imageH']/2;  
				$i = (int) ($this->config['fontSize']/5);
				while ($i > 0) {
					imagesetpixel($this->_image, $px + $i, $py + $i, $this->_color);
					$i--;
				}
			}
		}
	}
	/**
	 ***********************************************************
	 *方法::CurrVerify::_writeNoise()
	 * ----------------------------------------------------------
	 * 描述::	 * 画杂点，往图片上写不同颜色的字母或数字
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.01.07  Add by zwx
	 ************************************************************
	 */
	private function _writeNoise() {
		$codeSet = '2345678abcdefhijkmnpqrstuvwxyz';
		for($i = 0; $i < 10; $i++){
			#.杂点颜色
			$noiseColor = imagecolorallocate($this->_image, mt_rand(150,225), mt_rand(150,225), mt_rand(150,225));
			for($j = 0; $j < 5; $j++) {
				#. 绘杂点
				imagestring($this->_image, 5, mt_rand(-10, $this->config['imageW']),  mt_rand(-10, $this->config['imageH']), $codeSet[mt_rand(0, 29)], $noiseColor);
			}
		}
	}
	/**
	 ***********************************************************
	 *方法::CurrVerify::_background
	 * ----------------------------------------------------------
	 * 描述::绘制背景图片,如果验证码输出图片比较大，
	 * 			 将占用比较多的系统资源
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    无
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.01.07  Add by zwx
	 ************************************************************
	 */
	private function _background() {
		$path = dirname(__FILE__).'/Verify/bgs/';
		$dir = dir($path);
		$bgs = array();
		while (false !== ($file = $dir->read())) {
		 ($file[0] != '.' && substr($file, -4) == '.jpg') && $bgs[] = $path . $file;		
		}
		$dir->close();
		$gb = $bgs[array_rand($bgs)];
		list($width, $height) = @getimagesize($gb);
		#. Resample
		$bgImage=@imagecreatefromjpeg($gb);
		@imagecopyresampled($this->_image, $bgImage, 0, 0, 0, 0, $this->config['imageW'], $this->config['imageH'], $width, $height);
		@imagedestroy($bgImage);
	}
	/**
	 ***********************************************************
	 *方法::CurrVerify::authcode
	 * ----------------------------------------------------------
	 * 描述::验证码加密类
	 *----------------------------------------------------------
	 *参数:
	 *parm2:in--    String : str :: 加密字符串
	 *----------------------------------------------------------
	 *返回：
	 *return:out--  无
	 * ----------------------------------------------------------
	 * 日期:2017.01.07  Add by zwx
	 ************************************************************
	 */
	private function authcode($str){
		$key = substr(md5($this->config['seKey']), 5, 8);
		$str = substr(md5($str), 8, 10);
		return md5($key . $str);
	}
}
