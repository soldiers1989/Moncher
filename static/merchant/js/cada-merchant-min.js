/*弹出层*/
var U = $('base').attr('href');
/*菜单树*/
var tree = {
	"operator": {
		"title": "管理员",
		"addUrl": "merchant/operator/add",
		"saveUrl": "merchant/operator/update",
		"delUrl": "merchant/operator/delete",
		"checkUrl": "merchant/operator/check",
		"width": 480,
		"height": 265
	},
	"role": {
		"title": "权限",
		"addUrl": "merchant/role/add",
		"saveUrl": "merchant/role/update",
		"delUrl": "merchant/role/delete",
		"checkUrl": "merchant/role/check",
		"width": 582,
		"height": 238
	},
	"message": {
		"title": "系统消息",
		"saveUrl": "merchant/messages/update",
		"checkUrl": "merchant/messages/check",
		"width": 330,
		"height": 240
	},
	"feedback": {
		"title": "咨询反馈",
		"addUrl": "merchant/feedback/add",
		"saveUrl": "merchant/feedback/update",
		"checkUrl": "merchant/feedback/check",
		"width": 480,
		"height": 265
	},
	"certi":{
		"title": "集团认证",
		"addUrl": "merchant/Certification/add",
		"saveUrl": "merchant/Certification/updated",
		"checkUrl": "merchant/Certification/check",
		"width": 480,
		"height": 220
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
	status==4000 ? layer_show('修改'+bole.title,bole.saveUrl+'?id='+id,bole.width,bole.height) : layer.msg('记录已删除', {icon:2,time: 2000},function(){location.reload();});
}
/**直接操作方法*/
function setAction(show,id,title,value){
	var status;
	var bole=findTree(show);
	status=Fa(bole.checkUrl,'id='+id);
	if(status==4000){
		var saveStatus=Fa(bole.saveUrl,'id='+id+'&'+title+'='+value);
		saveStatus==4000 ? layer.msg('操作已成功', {icon:1,time: 2000},function(){location.reload();}) : layer.msg('操作失败', {icon:2,time: 2000},function(){location.reload();});
	}else{
		layer.msg('记录已删除', {icon:2,time: 2000},function(){location.reload();});
	}
}
/**异步上传照片*/
function Fimg(that,img,hide){
	 $('#'+img).parent().css({"background":"#FFF","border":"1px solid #ddd"});
	 $('#'+img).attr('src','http://www.51hyc.com/Public/images/Approve/Dong.gif');
	  var formdata = new FormData();  var v_this = $(that); var fileObj = v_this.get(0).files; 
	  formdata.append("image", fileObj[0]);	  
	  formdata.append("name", "image");
	  $.ajax({url : U+'index.php/merchant/Register/addPic', type : 'POST', data : formdata,cache: false,processData: false,contentType: false,dataType : "json",
				 success : function(data){$('#'+img).attr('src','upload/merchant/images/'+data.image.url);$('#'+hide).val(data.image.url);}}); 
}
$(function(){
	var free={"feedback":$(window).width()>2400?$(window).width():2400,
				   "cert":$(window).width()>1500?$(window).width():1500,
				   "message":$(window).width()>1500?$(window).width():1500,
				   "user":$(window).width()>1500?$(window).width():1500,
				   "role":$(window).width(),
				   "record":12000};
	$("#cada-admin-menu").css({"height":$(window).height()+'px'});
	/**添加滚动条效果*/
	$('.form-inline').css({"border-bottom":"1px solid #CCC"});
	$('.dataDesc ul').css({"width":free[$("#formz").attr("icon")]+"px"});
	$('.dataList').css({"height":($(window).height()-($('.form-inline').height()+105))+"px"});
	$('.dataList ul').css({"width":(free[$("#formz").attr("icon")]-30)+"px"});
	$('.dataList').scroll(function() {$('.dataDesc').scrollLeft($(this).scrollLeft());});
	$('.dataDesc').scroll(function() {$('.dataList').scrollLeft($(this).scrollLeft());}); 
	$(".dataList ul").mouseover(function(){$(this).find('li').css({"background-color":"#F1F1F1"});}).mouseout(function(){$(this).find('li').css({"background-color":""});});
	/*默认定义宽度列表*/
	var defines={"Idx":60,"playx":180,"userx":120,"timex":150,"markx":80,"typex":100,"textx":200,"longstr":500},demo=$('.dataDesc ul li'),once=$('.dataDesc .onex'),width=0;
	$.each(demo,function(){defines[$(this).attr("class").toString()]>0? width +=defines[$(this).attr("class").toString()]: width +=0;});
	$('.onex').css({"width":((free[$("#formz").attr("icon")]-30)-width)/once.length+"px","text-align":"left","text-indent":"12px"});
	/**快速定义样式*/
	for(var key in defines){
		$('.dataList .'+key).css("width",defines[key]+"px");	
		$('.dataDesc .'+key).css("width",defines[key]+"px");
	}
});