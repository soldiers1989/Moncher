/**五个模块得分**/
function  modelRound(that,item){
	$(that).highcharts({
	    chart: {spacing : [20, 0 , 10, 0]},
	    title: {floating:true,text: item?item[2]+'分':0+'分'},
	    tooltip: {pointFormat: '{point.percentage:.1f}'},
	    exporting: {enabled:false},
	    credits: {enabled: false},
	    plotOptions: {pie: {cursor: 'pointer', colors:[item[1],'#CDCCCB'],dataLabels: {enabled: false,format: '{point.percentage:.1f} ',style: { color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'} }}},
	    series: [{type: 'pie', innerSize: '80%',name: '',data: [[item?item[0]:0,parseInt(item?item[2]:0)],['失分',100-parseInt(item?item[2]:0)]]}]
	}, function(c) {
	    var centerY = c.series[0].center[1],titleHeight = parseInt(c.title.styles.fontSize);c.setTitle({ y:centerY + titleHeight/2});chart = c;
	});
	$('.highcharts-container').css('height','130px');
	$(that).append('<div style="text-align:center;width:100%;">'+item[0]+'</div>');
}
/**用户样本量**/
function modelLine(that,item){
	return $(that).css({"float":"left","width":"100%","height":"24px","border-bottom":"none;","margin-top":"8px"}).append(
									"<div class='before_month' style='height:60px;'><div class='one_data' style='margin-top:10px;'><div class='me_tit'>"+item[0]+"</div>" +
									"<div class='me_line'>" +"<div style='width:"+(item[2]/(allsize/100))+"%;background-color:"+item[1]+";' class='me_sty'></div>" +
									"</div><div class='me_score'>"+item[2]+"</div></div><div class='clear'></div>" +
									"</div></div>"); 
}
/**月各模块详细评测得分**/
function chartXY(that,tit,label,data){
	$(that).highcharts({
	    chart: { zoomType: 'xy'},
	    title: {text: tit},
		exporting: {enabled:false},
		credits: {enabled: false},
		plotOptions: {column:{ dataLabels:{enabled:true,  style:{color:'#333'}}}},
	    xAxis: [{categories:label,crosshair: true}],
	    yAxis: [{ labels: {style: {color: Highcharts.getOptions().colors[1]}},
		title: {text: '',style: {color: Highcharts.getOptions().colors[1]}}}, { title: { text: '趋势',style: {color: Highcharts.getOptions().colors[0]}},labels: {style: {color: Highcharts.getOptions().colors[0]}},opposite: true}],
	    tooltip: {shared: true},
	    series: [{name: '得分',type: 'column',yAxis: 1,data:data},{name: '趋势', type: 'spline',data:data,color:"#666"}]
	});
}
/** 月度各模块详细用户参与样本量**/
function chartX(that,tit,label,data){
	var chart = new Highcharts.Chart(that, {
	    title: { text: tit,x: -20 },
	    exporting: {enabled:false},credits: {enabled: false},
	    xAxis: {categories:label},
	    yAxis: {title: { text: ' '}, 
		plotLines: [{value: 0,width: 1,color: '#808080'}]},
	    legend: {layout: 'vertical', align: 'right', verticalAlign: 'middle',borderWidth: 0},
	    series:data
	});
}
/**开始执行以上方法*/
$(function(){
	$(".main").css({"width":$(window).width()+"px","min-width":"1150px"});   
	$(".clear").css({"clear":"both"});
	var queri=['第一季度','第二季度','第三季度','第四季度']
	var yeari=['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'];
	var moni= new Array;
	for(var i=0;i<mon.size[0]['data'].length;i++){
		moni[i]=(i+1)+'日';
	}
	/**渲染样本量*/
	$.each($('.skypie'),function(index,item){modelLine(item,$(item).attr('SKY').split('|'));});
	/**渲染评测分*/
	$.each($('.skyround'),function(index,item){modelRound('#skyround'+(index+1),$(item).attr('SKY').split('|'));});
	/**条形统计图效果*/
	chartX('month_a',"月度各模块用户参与样本量",moni,mon.size);
	chartX('quar_a',"季度各模块用户参与样本量",queri,quer.size);
	chartX('year_a',"年度各模块用户参与样本量",yeari,year.size);
    chartXY('#month_b',"月度各模块评测得分",moni,mon.score[0]['data']);
	chartXY('#quar_b',"季度各模块评测得分",queri,quer.score[0]['data']);
	chartXY('#year_b',"年度各模块评测得分",yeari,year.score[0]['data']);
	$('.highcharts-title').css('font-size','14px');
	$(".form-inline").css({"border":"none"});
	$(".minvo").css({"min-height":"1200px"});
});
