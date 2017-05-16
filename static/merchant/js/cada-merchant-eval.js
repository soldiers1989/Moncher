/**总体数据**/
function show_score(that,month,score,color){
	$(that).highcharts({
	    chart: {margin:[-5,0,-5,0]},
	    title: {text: month,align: 'center',verticalAlign: 'middle',y:60},
	    exporting: {enabled:false},credits: {enabled: false},
	    tooltip: {headerFormat: '',pointFormat: '<b>{point.percentage:.1f}</b>'},
	    plotOptions: {
		pie: {size:150,colors:[color,'#CDCCCB'],dataLabels: {enabled: true,distance: false,style: {fontWeight: 'bold',color: 'white', textShadow: '0px 1px 2px #CDCCCB'}},
		startAngle: -90,endAngle: 90,center: ['50%', '90%']}},
	    series: [{type: 'pie',name: '得分',innerSize: '40%', data: [['',score],['',100-score],]}]
	});
	var arr=[];
}
/**开始执行以上方法*/
$(function(){
	$(".main").css({"width":$(window).width()+"px","min-width":"1150px"});
	$(".form-inline").css({"border":"1px solid #fff"});
	/**关键指标对比一*/
	 var chart = Highcharts.chart('container', {
	        chart: {type: 'column'},
	        title: {text: '一次修复率'},
	        subtitle: {text: '每次维修保养是否能解决你的问题呢？',x: 30},
    		plotOptions: {column:{ dataLabels:{enabled:true,  style:{color:'#D7DEE9'}}}},
	        xAxis: { categories: [start, last],labels: {x: -10}},
	        yAxis: { allowDecimals: false,title: {text: ''}},
	        exporting: {enabled:false},credits: {enabled: false},
	        series: [{name: '可以修复',data: [parseFloat(tree.S1), parseFloat(tree.S4)],color:"#15A354"}, {name: '需要返修一次',data: [parseFloat(tree.S2), parseFloat(tree.S5)],color:'#0064AE'}, {name: '需要多次返修', data: [parseFloat(tree.S3), parseFloat(tree.S6)],color:'#E35A02'}],
	        responsive: {rules: [{condition: {maxWidth: 500},chartOptions: {legend: {align: 'center', verticalAlign: 'bottom',layout: 'horizontal'},
					yAxis: {labels: {align: 'left',x: 0,y: -5},title: {text: null}},credits: { enabled: false}}}]}
       });
	/**关键指标对比二*/
	 var chart = Highcharts.chart('nps', {
	        chart: {type: 'column'},
	        title: {text: '净推荐率,即NPS'},
	        subtitle: {text: '你是否推荐其他人来这家店进行维修保养？', x: 30},
	        colors:['#21AD71', '#FCBE00'],			
    		plotOptions: {column:{ dataLabels:{enabled:true,  style:{color:'#D7DEE9'}}}},
	        xAxis: { categories: [start, last],labels: {x: -10}},
	        yAxis: { allowDecimals: false,title: {text: ''}},
	        exporting: {enabled:false},credits: {enabled: false},
	        series: [{name: '会',data: [parseFloat(tree.S7), parseFloat(tree.S9)],color:'#15A354'}, {name: '不会',data: [parseFloat(tree.S8), parseFloat(tree.S10)],color:'#E35A02'}],
	        responsive: {rules: [{condition: {maxWidth: 500},chartOptions: {legend: {align: 'center', verticalAlign: 'bottom',layout: 'horizontal'},
	                    yAxis: {labels: {align: 'left',x: 0,y: -5},title: {text: null}}, credits: { enabled: false}}}]}
	   });
		/**关键指标对比三*/
	 var chart = Highcharts.chart('loyal', {
	        chart: {type: 'column'},
	        title: {text: '售后服务忠诚度'},
	        subtitle: {text: '您下次还会选择来这家店进行维修保养么？', x: 30},
	        colors:['#0064AE', '#029BD5'],			
    		plotOptions: {column:{ dataLabels:{enabled:true,  style:{color:'#D7DEE9'}}}},
	        xAxis: { categories: [start, last],labels: {x: -10}},
	        yAxis: { allowDecimals: false,title: {text: ''}},
	        exporting: {enabled:false},credits: {enabled: false},
	        series: [{name: '会',data: [parseFloat(tree.S11), parseFloat(tree.S13)],color:"#029BD5"}, {name: '不会',data: [parseFloat(tree.S12), parseFloat(tree.S14)],color:'#0064AE'}],
	        responsive: {rules: [{condition: {maxWidth: 500},chartOptions: {legend: {align: 'center', verticalAlign: 'bottom',layout: 'horizontal'},
	                    yAxis: {labels: {align: 'left',x: 0,y: -5},title: {text: null}},credits: { enabled: false}}}]}
	 	});
	 /**总体数据半圆*/
	 show_score("#container-one",start,parseFloat(json.F1),"#029BD5");
	 show_score("#container-two",last,parseFloat(json.F2),"#029BD5");
	 show_score("#industry-one",start,parseFloat(json.F3),"#EFCB06");
	 show_score("#industry-two",last,parseFloat(json.F4),"#EFCB06");
	 $('.highcharts-title').css({"font-size":"13px"});
});

