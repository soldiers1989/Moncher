/*弹出层*/
var U = $('base').attr('href');
/*菜单树*/
var tree = {
	"area": {
		"title": "区域",
		"addUrl": "admin/Area/add",
		"saveUrl": "admin/Area/update",
		"delUrl": "admin/Area/delete",
		"checkUrl": "admin/Area/check",
		"width": 480,
		"height": 165
	},
	"brand": {
		"title": "汽车",
		"addUrl": "admin/Brand/add",
		"saveUrl": "admin/Brand/update",
		"delUrl": "admin/Brand/delete",
		"checkUrl": "admin/Brand/check",
		"width": 480,
		"height": 170
	},
	"report":{
		"title": "报告",
		"addUrl":"admin/Report/updatedReport",
		"saveUrl":"admin/Report/Seek",
		"delUrl":"admin/Report/deleteReport",
		"checkUrl":"admin/Report/addReport",
		"width":480,
		"height":170,
	},

	"dictionary": {
		"title": "字典",
		"addUrl": "admin/Dictionary/add",
		"saveUrl": "admin/Dictionary/update",
		"delUrl": "admin/Dictionary/delete",
		"checkUrl": "admin/Dictionary/check",
		"width": 480,
		"height": 226
	},
	"menu": {
		"title": "菜单",
		"addUrl": "admin/Menu/add",
		"saveUrl": "admin/Menu/update",
		"delUrl": "admin/Menu/delete",
		"checkUrl": "admin/Menu/check",
		"width": 480,
		"height": 167
	},
	"operator": {
		"title": "管理员",
		"addUrl": "admin/operator/add",
		"saveUrl": "admin/operator/update",
		"delUrl": "admin/operator/delete",
		"checkUrl": "admin/operator/check",
		"width": 480,
		"height": 265
	},
	"param": {
		"title": "参数",
		"addUrl": "admin/Parameter/add",
		"saveUrl": "admin/Parameter/update",
		"delUrl": "admin/Parameter/delete",
		"checkUrl": "admin/Parameter/check",
		"width": 480,
		"height": 226
	},
	"role": {
		"title": "权限",
		"addUrl": "admin/role/add",
		"saveUrl": "admin/role/update",
		"delUrl": "admin/role/delete",
		"checkUrl": "admin/role/check",
		"width": 585,
		"height": 350
	},
	"mernav": {
		"title": "商户菜单",
		"addUrl": "admin/MerchantNav/add",
		"saveUrl": "admin/MerchantNav/update",
		"delUrl": "admin/MerchantNav/delete",
		"checkUrl": "admin/MerchantNav/check",
		"width": 480,
		"height": 200
	},
	"message":{
		"title": "系统消息",
		"addUrl": "admin/Messages/add",
		"saveUrl": "admin/Messages/update",
		"delUrl": "admin/Messages/delete",
		"checkUrl": "admin/Messages/check",
		"width": 480,
		"height": 360
	},
	"feedback":{
		"title": "意见反馈",
		"saveUrl": "admin/Feedback/update",
		"delUrl": "admin/Feedback/delete",
		"checkUrl": "admin/Feedback/check",
		"width": 550,
		"height": 400	
	},
	"question":{
		"title": "问卷试题",
		"delUrl": "admin/Question/deleteQuestion",
		"checkUrl": "admin/Feedback/check",
		"width": 550,
		"height": 400	
	},
	"provider":{
		"title": "维护商户",
		"delUrl": "admin/Provider/DeleteProvider",
		"checkUrl": "admin/Provider/check",
		"disableUrl":"admin/Provider/disPro",
		"backUrl":"admin/Provider/backPro",
		"width": 550,
		"height": 400	
	},
	"model":{
	"title": "模型列表",
	"delUrl": "admin/Mould/deleteMould",
	"checkUrl": "admin/Mould/check",
	"disableUrl":"admin/Mould/disableMould",
	"backUrl":"admin/Mould/backMould",
	"saveUrl":"admin/Mould/updateMould",
	"width": 490,
	"height": 245	
	},
	"block":{
		"title": "模块",
		"delUrl": "admin/Mould/deleteBlock",
		"checkUrl": "admin/Mould/Blockcheck",
		"backUrl":"admin/Mould/backMould",
		"saveUrl":"admin/Mould/updateBlock",
		"width": 490,
		"height": 245	
		},
	"inves":{
		"title": "调研列表",
		"delUrl": "admin/Inves/deleteInves",
		"checkUrl": "admin/Inves/check",
		"disableUrl":"admin/Inves/disableInves",
		"backUrl":"admin/Inves/backInves",
		"saveUrl":"admin/Inves/updateInves",
		"width": 490,
		"height": 340	
	},
	"questionnaire":{
		"title": "问卷列表",	
		"delUrl": "admin/Questionnaire/deleteQuestionnaire",
		"checkUrl": "admin/Questionnaire/check",	
		"width": 550,
		"height": 400	
	},
	"addmodel":{
		"title": "模型",
		"addUrl": "admin/Mould/addMould",
		"checkUrl": "admin/Mould/check",
		"width": 490,
		"height": 245
	},
	"addblock":{
		"title": "模块",
		"addUrl": "admin/Mould/addBlock",
		"checkUrl": "admin/Mould/Blockcheck",
		"width": 490,
		"height": 245
	},
	"addinves":{
		"title":"调研",
		"addUrl":"admin/Inves/addinves",
		"checkUrl":"admin/Inves/check",
		"width":490,
		"height":344
	},
		"providerref":{
		"title":"拒绝信息",
		"refUrl":"admin/Provider/refInfo",
		"width":350,
		"height":130
		}
};
/**弹出页面方法*/
function layer_show(title,url,width,height){
    if(title.length<= 0) title=false;
    if(url.length<=0) url="404";
    if(width<=0)  width=800;
    if(height<=0)  height=494;
    /*打开新窗口*/
     layer.open({type: 2,area: [width+'px', height +'px'],fix:false,shadeClose: true,maxmin: true,shade:0.8,title: title,content: U+'index.php/'+url,end:function(){location.reload();}});
}
/**异步请求数据方法*/
function Fa(url, data) {	
	var message;
	$.ajax({type: "GET",url: U + 'index.php/' + url,async: false,data: data,success: function(msg) {message = msg;}});
	return message;
}
/**查找需要执行的对象*/
function findTree(show){
	var bole;
	for(var key in tree){
	  if(key==show){ bole=tree[key];break;}
	}
	return bole;
}
/**新增方法*/
function  addShow(show){
	var bole=findTree(show);
	layer_show('新增'+bole.title,bole.addUrl,bole.width,bole.height);
}
/**禁用方法*/
function  disableRows(show,id){
//	alert(show);
	var bole=findTree(show);
	layer.confirm('确认禁用？',function(index){
		layer.close(index);
		status=Fa(bole.disableUrl,'id='+id);
		status==4000 ? layer.msg('禁用成功', {icon:1,time: 2000},function(){location.reload();}) : layer.msg('禁用失败', {icon:2,time: 2000},function(){location.reload();});
	});
}
/**恢复方法*/
function  backRows(show,id){
	var bole=findTree(show);
	layer.confirm('确认恢复？',function(index){
		layer.close(index);
		status=Fa(bole.backUrl,'id='+id);
		status==4000 ? layer.msg('恢复成功', {icon:1,time: 2000},function(){location.reload();}) : layer.msg('恢复失败', {icon:2,time: 2000},function(){location.reload();});
	});
}
/**拒绝信息*/
function refuse(show,id){
	var status=1;
	var bole=findTree(show);
	 status=1? layer_show(''+bole.title,bole.refUrl+'?id='+id,bole.width,bole.height) : layer.msg('拒绝信息输入完成', {icon:2,time: 2000},function(){layer.close(index);});	
}
/**删除方法*/
function delRows(show,id){
	var status;
	var bole=findTree(show);
	layer.confirm('确认删除？',function(index){
		layer.close(index);
		status=Fa(bole.delUrl,'id='+id);
		status==4000 ? layer.msg('删除成功', {icon:1,time: 2000},function(){location.reload();}) : layer.msg('删除失败', {icon:2,time: 2000},function(){location.reload();});
	});
}
/**修改方法*/
function saveShow(show,id){
	var status;
	var bole=findTree(show);
	
	status=Fa(bole.checkUrl,'id='+id);
	status==4000 ? layer_show('修改'+bole.title,bole.saveUrl+'?id='+id,bole.width,bole.height) : layer.msg('记录已修改', {icon:2,time: 2000},function(){location.reload();});
}
// 报告修改方法
function reportShow(show,id){
	var status
	var bole=findTree(show);
	status=Fa(bole.checkUrl,'id='+id);
	status==4000 ? layer_show('修改'+bole.title,bole.saveUrl+'?id='+id,bole.width,bole.height) : layer.msg('记录已删除', {icno:2,time: 2000},function(){location.reload();});
}
/**异步上传照片*/
function Fimg(that,img,hide,Aoc,title){
	  var formdata = new FormData();  var v_this = $(that); var fileObj = v_this.get(0).files; 
	  formdata.append("image", fileObj[0]);	  
	  formdata.append("name", "image");
	  $.ajax({url : U+'index.php/admin/Messages/addPic', type : 'POST', data : formdata,cache: false,processData: false,contentType: false,dataType : "json",
				 success : function(data){$('#'+hide).val(data.image.url);}}); 
}
$(function(){
	var free={"area":$(window).width(),
					  "brand":$(window).width(),
					   "dict":$(window).width(),
					   "feedback":$(window).width()>2400?$(window).width():2400,
					   "hover":$(window).width()>1600?$(window).width():1600,
					   "menu":$(window).width(),
					   "mould":$(window).width()>1500?$(window).width():1500,
					   "inves":$(window).width()>1500?$(window).width():1500,
					   "message":$(window).width()>2000?$(window).width():2000,
					   "question":$(window).width()>1500?$(window).width():1500,
					   "provider":$(window).width()>1600?$(window).width():1600,
					    "queastionnaire":$(window).width()>1500?$(window).width():1500,
					   "nav":$(window).width(),
					   "user":$(window).width()>1500?$(window).width():1500,
					   "param":$(window).width(),
					   "role":$(window).width(),
					   "system":$(window).width()>1600?$(window).width():1600};
	$("#cada-admin-menu").css({"height":$(window).height()+'px'});
	/**滚动条样式*/
	$('#smonar') && $('#smonar').css({"height":$(window).height()+"px"});
	$('#smonar') &&  $(window).on("load",function(){$("#smonar").mCustomScrollbar({theme:"rounded-dark",axis:"yx"});});
	/**添加滚动条效果*/
	$('.form-inline').css({"border-bottom":"1px solid #CCC"});
	$('.dataDesc ul').css({"width":free[$("#formz").attr("icon")]+"px"});
	$('.dataList').css({"height":($(window).height()-($('.form-inline').height()+105))+"px"});
	$('.dataList ul').css({"width":(free[$("#formz").attr("icon")]-30)+"px"});
	$('.dataList').scroll(function() {$('.dataDesc').scrollLeft($(this).scrollLeft());});
	$('.dataDesc').scroll(function() {$('.dataList').scrollLeft($(this).scrollLeft());}); 
	$(".dataList ul").mouseover(function(){$(this).find('li').css({"background-color":"#F1F1F1"});}).mouseout(function(){$(this).find('li').css({"background-color":""});});
	/*默认定义宽度列表*/
	var defines={"name":400,"address":350,"Idx":60,"playx":180,"userx":120,"timex":150,"markx":80,"typex":100,"textx":200},demo=$('.dataDesc ul li'),once=$('.dataDesc .onex'),width=0;
	$.each(demo,function(){defines[$(this).attr("class").toString()]>0? width +=defines[$(this).attr("class").toString()]: width +=0;});
	$('.onex').css({"width":((free[$("#formz").attr("icon")]-30)-width)/once.length+"px","text-align":"left","text-indent":"12px"});
	/**快速定义样式*/
	for(var key in defines){
		$('.dataList .'+key).css("width",defines[key]+"px");	
		$('.dataDesc .'+key).css("width",defines[key]+"px");
	}
});