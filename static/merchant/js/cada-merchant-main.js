/**异步请求数据方法*/
function Fa(url,data){
	var message;
	$.ajax({type: "POST",url: U+'index.php'+url,async: false,
			  data: data,success:function(msg){message=msg;}
	});
	return message;
}
/**开始执行以上方法*/
$(function(){
	/**总分*/
	$('#total_score').highcharts({
		chart: {},
		title: {text:json.F1+'分',align: 'center',verticalAlign: 'middle',y: 50},
		exporting: {enabled:false},credits: {enabled: false},
		tooltip: {headerFormat: '',pointFormat: '<b>{point.percentage:.2f}</b>'},
		plotOptions: {
			pie: {size:200,colors:["#FFB012",'#CDCCCB'],dataLabels: {enabled: true,distance: -10,
					style: {fontWeight: 'bold',color: 'white', textShadow: '0px 1px 2px #CDCCCB'}},
				startAngle: -90,
				endAngle: 90,
				center: ['50%', '90%']}},
		series: [{type: 'pie',name: '得分',innerSize: '40%', data: [['',parseFloat(json.F1)],['',  100-parseFloat(json.F1)],]}]
	});
	/**排行*/
	$('#rank_all').highcharts({
		chart: { plotBackgroundColor: null,plotBorderWidth: null,plotShadow: false,spacing : [40, 0 , 40, 0]},
		exporting: {enabled:false},credits: {enabled: false},
		title: {floating:true,style : {'fontSize' : '12px','color':'#F55738'},text: '共'+topc.size+'名'},
		tooltip: {pointFormat: '{point.percentage:.2f}%</b>'},
		plotOptions: { pie: {size:110,allowPointSelect: true,colors:["#EAE3E3",'#F55738'],cursor: 'pointer',dataLabels: {enabled: true, format: ' {point.percentage:.2f} %',style: {color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || '#F55738'}},}},
		series: [{type: 'pie',innerSize: '70%',name: '排名',data: [['我超越的',(topc.size-topc.top)], ['',topc.top]]}]
	}, function(c) {var centerY = c.series[0].center[1], titleHeight = parseInt(c.title.styles.fontSize);c.setTitle({y:centerY + titleHeight/2});chart = c;});
	/**一次修复率*/
	$('#xf_index').highcharts({
			chart: {},
			title: false,
			exporting: {enabled:false},
			credits: {enabled: false},
			tooltip: {headerFormat: '', pointFormat: '{point.percentage:.2f}%</b>'},
			plotOptions: {
				pie: {colors:["#15A354",'#0064AE','#E35A02'],allowPointSelect: false,cursor: 'pointer',dataLabels: {enabled: false},showInLegend: false}},
			series: [{type: 'pie', name: '一次修复率',innerSize: '25%',
				data: [['',parseFloat(jsonNPS.S1)],['',parseFloat(jsonNPS.S2)],['',parseFloat(jsonNPS.S3)]]
			}]
		});
		/**NPS*/
		$('#nps_index').highcharts({
			chart: {},
			title:false,
			exporting: {enabled:false},
			credits: {enabled: false},
			tooltip: {headerFormat: '', pointFormat: '{point.percentage:.2f}%</b>'},
			plotOptions: {
				pie: {colors:["#15A354",'#E35A02'],allowPointSelect: false,cursor: 'pointer',dataLabels: {enabled: false},showInLegend: false}},
			series: [{type: 'pie', name: 'nps',innerSize: '25%',
			   data: [['',parseFloat(jsonNPS.S4)],['',parseFloat(jsonNPS.S5)]]
			}]
		});
		/**售后忠诚度*/
		$('#loyal_index').highcharts({
			chart: {},
			title:false,
			exporting: {enabled:false},
			credits: {enabled: false},
			tooltip: {headerFormat: '', pointFormat: '{point.percentage:.2f}%</b>'},
			plotOptions: {
				pie: {colors:["#029BD5",'#0064AE'],allowPointSelect: false,cursor: 'pointer',dataLabels: {enabled: false},showInLegend: false}},
			series: [{type: 'pie', name: 'nps',innerSize: '25%',
				data: [['',parseFloat(jsonNPS.S6)],['',parseFloat(jsonNPS.S7)]]
			}]
		});
	/**服务顾问*/
		$('#fwgw_score').highcharts({
		chart: {spacing : [10, 0 , 5, 0]},
		title: {floating:true,text: json.F9+'分'},
		tooltip: {pointFormat: '{point.percentage:.2f}'},
		exporting: {enabled:false},
		credits: {enabled: false},
		plotOptions: {
			pie: {cursor: 'pointer',colors:["#0064AE",'#CDCCCB'],dataLabels: {enabled: false,format: '{point.percentage:.2f} ',style: { color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'}}}
		},
		series: [{type: 'pie', innerSize: '80%',name: '',data: [['得分',parseFloat(json.F9)],['失分',100-parseFloat(json.F9)]]}]
	}, function(c) {var centerY = c.series[0].center[1],titleHeight = parseInt(c.title.styles.fontSize);c.setTitle({ y:centerY + titleHeight/2});chart = c;});
	/**服务设施*/
	$('#fwss_score').highcharts({
		chart: {spacing : [10, 0 , 5, 0]},
		title: {floating:true,text: json.F10+'分'},
		tooltip: {pointFormat: '{point.percentage:.2f}'},
		exporting: {enabled:false},
		credits: {enabled: false},
		plotOptions: {
			pie: {cursor: 'pointer',colors:["#02A6AF",'#CDCCCB'],dataLabels: {enabled: false,format: '{point.percentage:.2f} ',style: { color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'}}}
		},
		series: [{type: 'pie', innerSize: '80%',name: '',data: [['得分',parseFloat(json.F10)],['失分',100-parseFloat(json.F10)]]}]
	}, function(c) {var centerY = c.series[0].center[1],titleHeight = parseInt(c.title.styles.fontSize);c.setTitle({ y:centerY + titleHeight/2});chart = c;});
	/**维修质量*/
	$('#fwzl_score').highcharts({
		chart: {spacing : [10, 0 , 5, 0]},
		title: {floating:true,text:json.F11+'分'},
		tooltip: {pointFormat: '{point.percentage:.2f}'},
		exporting: {enabled:false},
		credits: {enabled: false},
		plotOptions: {
			pie: {cursor: 'pointer',colors:["#019E47",'#CDCCCB'],dataLabels: {enabled: false,format: '{point.percentage:.2f} ',style: { color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'}},}
		},
		series: [{type: 'pie', innerSize: '80%',name: '',data: [['得分',parseFloat(json.F11)],['失分',100-parseFloat(json.F11)]]}]
	}, function(c) {
		var centerY = c.series[0].center[1],titleHeight = parseInt(c.title.styles.fontSize); c.setTitle({ y:centerY + titleHeight/2});
	chart = c;
	});
	/**维修价格*/
	$('#wxjg_score').highcharts({
		chart: {spacing : [10, 0 , 5, 0]},
		title: {floating:true,text: json.F12+'分'},
		tooltip: {pointFormat: '{point.percentage:.2f}'},
		exporting: {enabled:false},
		credits: {enabled: false},
		plotOptions: {pie: {
				cursor: 'pointer',colors:["#E45A02",'#CDCCCB'],
				dataLabels: {
					enabled: false,format: '{point.percentage:.2f} ',style: { color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'}},}},
		series: [{type: 'pie', innerSize: '80%',name: '',data: [['得分',parseFloat(json.F12)],['失分',100-parseFloat(json.F12)]]}]
	}, function(c) {
		var centerY = c.series[0].center[1],titleHeight = parseInt(c.title.styles.fontSize); c.setTitle({ y:centerY + titleHeight/2});
	chart = c;
	});
	/**维修时间*/
	$('#wxss_score').highcharts({
		chart: {spacing : [10, 0 , 5, 0]},
		title: {floating:true,text: json.F13+'分'},
		tooltip: {pointFormat: '{point.percentage:.2f}'},
		exporting: {enabled:false},
		credits: {enabled: false},
		plotOptions: {pie: {
				cursor: 'pointer',colors:["#E18901",'#CDCCCB'],
				dataLabels: {
				enabled: false,format: '{point.percentage:.2f} ',style: { color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'}},}},
		series: [{type: 'pie', innerSize: '80%',name: '',data: [['得分',parseFloat(json.F13)],['失分',100-parseFloat(json.F13)]]}]
	}, function(c) {var centerY = c.series[0].center[1],titleHeight = parseInt(c.title.styles.fontSize); c.setTitle({ y:centerY + titleHeight/2});chart = c;});
   $('.highcharts-title').css({"fontSize":"16px"});
});