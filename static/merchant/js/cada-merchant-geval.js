/**总体数据**/
function showScore(that,score){
	$(that).highcharts({
	    chart: {margin:[-5,0,-5,0]},
	    title: {text: score[0],align: 'center',verticalAlign: 'middle',y:50},
	    exporting: {enabled:false},credits: {enabled: false},
	    tooltip: {headerFormat: '',pointFormat: '<b>{point.percentage:.1f}</b>'},
	    plotOptions: {
		pie: {size:150,colors:[score[1],'#CDCCCB'],dataLabels: {enabled: true,distance: false,style: {fontWeight: 'bold',color: 'white', textShadow: '0px 1px 2px #CDCCCB'}},
		startAngle: -90,endAngle: 90,center: ['50%', '80%']}},
	    series: [{type: 'pie',name: '得分',innerSize: '40%', data: [['',parseFloat(score[2])],['',100-parseFloat(score[2])]]}]
	});
	var arr=[];
}
/**开始执行以上方法*/
$(function(){
	$(".form-inline").css({"border":"none"});
	 /**总体数据半圆*/
	 $.each($('.skypie'),function(index,item){
		 showScore('#skypie'+(index+1),$(item).attr('SKY').split('|'));
	});
	$('.highcharts-title').css({"font-size":"13px"});
});

