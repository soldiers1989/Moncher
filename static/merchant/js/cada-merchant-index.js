/**
@描述:主页框架
@作者:Mr.zwx
@时间:2017-02-06 
**/
/**导航高度一定但宽度需要自适应*/
var W = $(window).width() > 1366 ? $(window).width() : 1366;
var H = $(window).height() > 600 ? $(window).height() : 600;
var U = $('base').attr('href');
var logoStatus=false;
var menuStatus = false;
var json = eval('(' + Fa('merchant/index/getUserRole', '') + ')'); 
/**定义通用css对象*/
var color1={"background": "#e60012","color": "#FFF"};
var color2={"background": "#FFF","color": "#323232"};
var showx={"display": "block"};
var hidex={"display": "none"};
var headH=100
var mainH=H-100;
var mainW=W-200;
var li_not={"height": "50px","text-align": "center","line-height": "50px","font-size": "14px","color": "#333","font-family": "微软雅黑","border-bottom":"1px solid #d9d9d9","margin-bottom":"0"};
var li_first={"height":"50px","background": "#e60012","color": "#FFF","font-size":"16px","line-height":"50px","margin-top": "0","text-align": "center","font-family": "微软雅黑","border-bottom":"1px solid #FFF"};
var admin_index={"width": W + 'px',"height": H + 'px',"overflow": 'hidden'};
var index_head={"width": W + 'px',"height": headH + 'px',"border-bottom": "3px solid #e60012","background": 'url(' + U + 'static/admin/images/admin-index-logo.png) no-repeat 30px center /'+((362/1080)* H)+'px '+((52/1080)* H)+'px'};
var menu_left={"display": "none","position": "absolute","z-index": "300","top": "0","width":'120px',"background": "#FFF","border-top":"1px solid #d9d9d9","border-left":"1px solid #d9d9d9","border-right":"1px solid #d9d9d9"};
var index_main={"width": W + 'px',"height": mainH+ 'px',"background": '#F1F1F1'};
var index_main_l={"width": '200px',"height": mainH+ 'px',"float": "left","border-right": "1px solid #FFF","background":"#FFF"};
var index_main_r={"width": mainW - 10 + 'px',"height": mainH - 10 + 'px',"float": "left","background": "#FFF","margin-left":"5px","margin-top":"5px"};
var iframex={"width": mainW - 10 + 'px',"height": mainH - 10 + 'px'};
var dt_first={"height":"60px","background": "#e60012","color": "#FFF","font-size": "18px","font-family": "微软雅黑","line-height": "60px","font-weight":"normal"};
var menu_nav={"height":"50px","border-bottom": "1px solid #d9d9d9","font-size":"16px","font-family": "微软雅黑","line-height":"50px","color": "#323232","font-weight":"normal"};
/**弹出页面方法*/
function layer_show(title,url,width,height){
    if(title.length<= 0) title=false;
    if(url.length<=0) url="404";
    if(width<=0)  width=800;
    if(height<=0)  height=494;
    /*打开新窗口*/
     layer.open({type: 2,area: [width+'px', height +'px'],fix:false,shadeClose: true,maxmin: true,shade:0.8,title: title,content: U+'index.php/'+url,end:function(){location.reload();}});
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
/**头像上传*/
function FimgHead(that,img,hide,userid){
	 $('#'+img).parent().css({"background":"#FFF","border":"1px solid #ddd"});
	 $('#'+img).attr('src','http://www.51hyc.com/Public/images/Approve/Dong.gif');
	  var formdata = new FormData();  var v_this = $(that); var fileObj = v_this.get(0).files; 
	  formdata.append("image", fileObj[0]);
	  formdata.append("name", "image");
	  formdata.append("id",userid);
	  $.ajax({url : U+'index.php/merchant/Register/addPichead', type : 'POST', data : formdata,cache: false,processData: false,contentType: false,dataType : "json",
				 success : function(data){  $('#'+img).attr('src',U+'upload/merchant/images'+data.image.url);$('#'+hide).val('images'+data.image.url);}}); 
}
/**修改方法*/
function saveShow(show,id){
	var status;
	var bole={
		"title": "系统消息",
		"saveUrl": "merchant/messages/update",
		"checkUrl": "merchant/messages/check",
		"width": 330,
		"height": 240
	};
	status=FGET(bole.checkUrl,'id='+id);
	status==4000 ? layer_show('查看'+bole.title,bole.saveUrl+'?id='+id,bole.width,bole.height) : layer.msg('记录已删除', {icon:2,time: 2000},function(){location.reload();});
}
/**异步请求数据方法*/
function FGET(url, data) {
	var message;
	$.ajax({type: "GET",url: U + 'index.php/' + url,async: false,data: data,success: function(msg) {message = msg;}});
	return message;
}
/**异步请求数据方法*/
function Fa(url, data) {
	var message;
	$.ajax({type: "POST",url: U + 'index.php/' + url,async: false,
			   data: data,success: function(msg) {message = msg;}
	});
	return message;
} /**框架搭建主方法*/
function Fb() {
	/**生成用户的菜单*/
	$.each(json.role, function(index, item) {
		$("#main-menu").append('<dt class="menu-nav" openStatus="0" navId="' + item.id + '"><div class="love" icon="fa ' + item.icon + '"></div><i class="icons fa ' + item.icon + '"></i><span>' + item.title + '</span><i class="last fa fa-angle-right"></i></dt>');
	});
} /**框架渲染主方法*/
function Fc() {
	
	$("#cada-admin-index").css(admin_index);
	$("#index-head").css(index_head);
	$("#head-main").css({"height":"100%","width":"40%","float":"right","padding-right":"12px"});
	$(".head-main-t").css({"height":"50%","width":"100%"});
	$(".head-main-b").css({"height":"50%","width":"100%"});
	$(".head-main-b .scroll-box").css({"width":"320px","height":"30px","overflow": "hidden","float":"right","margin-top":"12px"});
	$('.fa-volume-up').css({"display":"block","font-size":"18px","width":"20px","float":"right","margin-top":"18px","margin-right":"5px","color":"#5f5f5f"});
	$('.head-main-b .scroll-box ul li').css({"width": "100%","height":"30px","box-sizing":"border-box","font-size":"13px","line-height":"30px","text-align": "left","cursor":"pointer"});
	$(".head-main-t ul").css({"display":"block","float":"right","height":"100%"});
	$(".dropdown").css({"display":"block","float":"right","margin-top":"14px"});
	$(".dropdown button").css({"width":"120px","background":"#e60012","border":0,"color":"#FFF"});
	$(".dropdown .dropdown-menu").css("min-width","120px");
	$(".head-main-t ul li").css({"display":"block","float":"left","font-size":"18px","color":"#5f5f5f","height":"100%","line-height":$(".head-main-t").height()+"px","padding":"0 6px"});
	$(".head-main-t ul li:eq(3) img").css({"border-radius":"50%","display":"block","height":"36px","width":"36px","margin-top":"7px"});
	$("#menu-left").css(menu_left);
	$("#menu-left ul").css(hidex);
	$("#index-main").css(index_main);
	$("#index-main-l").css(index_main_l);
	$("#index-main-r").css(index_main_r);
	$("#index-main-r iframe").css(iframex);
	$("#main-menu dt:first").css(dt_first).hover(function(){$("#menu-left").attr("showId",0);$("#menu-left").css(hidex);},function(){});
	$("#main-menu dt:first").find('span').css({"display":"block","width":"100px","text-align":"center","height":"60px","line-height":"3.0","text-indent":(20 / 1920) * W+"px","float":"left"});
	$("#main-menu dt:first").find('i').css({"display":"block","width":"60px","height":"100%","float":"left","text-align":"center","line-height":"60px","font-size":"28px"});
	$("#main-menu .menu-nav").css(menu_nav);
	$("#main-menu .menu-nav  .love").css({"display":"block","width":"2px","background":"#e60012","height":"49px","position":"absolute","z-index":"211","text-align":"center","font-size":"24px","line-height":"50px","color":"#FFF"});
	$("#main-menu .menu-nav  .icons").css({"display":"block","width":"60px","height":"50px","float":"left","text-align":"center","line-height":"50px","font-size":"24px","border-right":"1px solid #d9d9d9","position":"absolute","z-index":"888"});
	$("#main-menu .menu-nav  span").css({"display":"block","width":'100px',"text-indent":(20 / 1920) * W+"px","height":"50px","margin-left":"58px","line-height":"50px","text-align":"center","float":"left"});
	$("#main-menu .menu-nav  .fa-angle-right").css({"display":"block","width":'40px',"text-align":"center","height":"50px","line-height":"50px","text-align":"center","float":"left"});
	$("#menu-null").css({"width":"100%","height":"60px"});
	$("#menu-null").hover(function(){$("#menu-left").attr("showId",0);$("#menu-left").css(hidex);},function(){});
	$(".dropdown").find("button").css({"width":"140px"});
}
/**生成菜单事件*/
function Fd(){
	$.each(json.role, function(index, item) {
		var menu = '';
		$.each(item.menu, function(i, son) {
			menu += '<li url="' + U + son.url + '">' + son.title + '</li>';
		});
		$("#menu-left").append('<ul id="Uid'+item.id+'" style="margin:0;padding:0;"><li class="title-one">' + item.title + '</li>' + menu + '</ul>');
	});
	$("#menu-left ul li:not(.title-one)").css(li_not).mousemove(function() {
		$(this).css(color1);
	}).mouseleave(function() {
		$(this).css(color2);
	}).click(function(){
		if(json.user.status==2){
			layer.confirm('审核失败信息：'+json.user.mess,function(index){layer.close(index);});
			$("#index-main-r iframe").attr('src',U + 'merchant/Information/index');
			return ;
		}else if(json.user.status==0){
			layer.confirm('信息审核中！',function(index){layer.close(index);});
			return ;
		}else{
			if($(this).attr('url')==(U+'URL1')){
				layer.confirm('请联系客服！',function(index){layer.close(index);});
				return;
			}else if($(this).attr('url')==(U+'URL1')){
				layer.confirm('功能正在开发，敬请期待！',function(index){layer.close(index);});
				return;
			}
			$("#index-main-r iframe").attr('src',$(this).attr('url'));
		}
	});
	$("#menu-left ul .title-one").css(li_first);
}
/**运行开始*/
$(function() {
	//alert(jsonhead);
	Fb();Fc();Fd();	
	$('#user-logo').click(function(){
		if(!logoStatus){
			logoStatus=true;
			$("#cada-admin-index").append('<div id="setLogo"><div id="logoshow">'+
																  '<input type="hidden" id="hiddenUrl" value=""/><img src="upload/merchant/'+jsonhead+'" width="120" height="120" style="display:block;border-radius:50%;" id="imageUrlo">'+
																  '<input type="file"  id="filelogo"  accept="image/gif, image/jpeg,image/png"/></div><div id="logomess">点击图片更换</div><a href="javascript:void(0);" id="save-button" class="btn btn-default">保存图片<a></div>');
			$("#setLogo").css({"top":$('#user-logo').offset().top+48,"left":$('#user-logo').offset().left-75,"width":"150px","height":"200px","position":"absolute","border":"1px solid #f1f1f1","background":"#FFF","border-radius":"5px"});
			$("#filelogo").css({"display":"block","height":"120px","width":"120px","position":"relative","top":"-120px","opacity":"0"});
			$('#logomess').css({"text-align":"center","color":"#666","font-size":"10px"});
			$('#save-button').css({"margin-top":"12px","margin-left":"36px"});
			var useid=json.user.id;
			$("#filelogo").change(function(){FimgHead(this,'imageUrlo','hiddenUrl',useid);});
			$("#save-button").click(function(){
				if($.trim($("#hiddenUrl").val()).length <= 0){
					 $("#cada-admin-index #setLogo").remove();
					return
				}else{
					 var status=Fa('merchant/Index/setLogo', 'headPicture='+$("#hiddenUrl").val());
					 if(status==0){
						 $("#cada-admin-index #setLogo").remove();
						 return ;
					 }else{
						 $('#user-logo img').attr('src','upload/merchant/'+$("#hiddenUrl").val());
						  json.user.logo=$("#hiddenUrl").val();
						 $("#cada-admin-index #setLogo").remove();
						 return;
					 }
				}
			});
			$("#logoshow").css({"width":"120px","height":"120px","border":"1px solid #ccc","border-radius":"50%","margin":"12px auto"});
		}else{
			logoStatus=false;
			$("#cada-admin-index #setLogo").remove();
		}
	});
	$("#user-name").text(json.user.name);
	/**主菜单折叠点击事件*/
	$(".fa-home").click(function() {
		$("#menu-left").css(hidex);
		$("#main-menu .menu-nav").attr("openStatus", 0);
		if (!menuStatus) {
			menuStatus = true;
			$("dt span,dt .last").css(hidex);
			$("#index-main-l").animate({"width": "60px"}, 62.5);
			$("#index-main-r").animate({"width": (W - 10-61) + 'px'}, 62.5);
		    $("#index-main-r iframe").animate({"width": (W - 10-61) + 'px'},62.5);
		}else {
			menuStatus = false;
			$("#index-main-l").css({"width":"200px"});
			$("#index-main-r").css({"width": mainW - 10 + 'px'});
		    $("#index-main-r iframe").css({"width": mainW - 10 + 'px'});
			$("dt span,dt .last").show();
		}
	});
	/**菜单点击事件*/
	$("#main-menu .menu-nav").click(function() {$("#menu-left").css(hidex);$(this).css(color2);}).hover(function() {
		var navId = $(this).attr("navId");
		var showId=$("#menu-left").attr("showId");
		var display = $("#menu-left").css("display");
		$("#menu-left ul").css(hidex);
		//--如果大菜单为开启状态
	   if(menuStatus){
			$(this).find('.icons').css({"color":"#323232"});
			$(this).find('.love').animate({"width": "59px"},360);
			$("#menu-left ul .title-one").css(showx);
		}else{
			$(this).find('.icons').css({"color":"#FFF"});
		    $(this).find('.love').animate({"width": "59px"},360);
			$("#menu-left ul .title-one").css(hidex);
		}
		//--如果左侧小菜单为开启状态
	    if(display=="block" && showId!='0'){
			$("#menu-left").css({"top":$(this).offset().top-1,"left":$(this).width()-1});
			$("#menu-left #Uid"+showId).css(hidex);
			$("#menu-left #Uid"+navId).css(showx);
		}else{
		   $("#menu-left").css({"display":"block","top":$(this).offset().top-1,"left":$(this).width()-1});
		   $("#Uid"+navId).css(showx);
		   $("#menu-left").attr("showId",navId);
		}
	},function(){
		$(this).find('.icons').css({"color":"#323232"});
		$(this).find('.love').animate({"width": "2px"},62.5);
	});
	$("#menu-left").mouseleave(function() {$("#menu-left").attr("showId",0);$("#menu-left").css(hidex);});
   var $uList = $(".scroll-box ul");var timer = null;
   $uList.hover(function () {clearInterval(timer);},function () {timer = setInterval(function (){scrollList($uList);},3600);}).trigger("mouseleave");
   /*滚动通用方法*/
   function scrollList(obj) {
		var scrollHeight = $(".scroll-box ul li:first").height();
		$uList.stop().animate({marginTop:-scrollHeight},500,function () {$uList.css({marginTop:0}).find("li:first").appendTo($uList);});
   }
   $('#model-list li a').click(function(){
	   var status=Fa('merchant/index/start', 'modelid='+$(this).attr('modelId'));
	   if(status==4000){
		   $('#dropdownMenu1').text($(this).text());
		   $("#index-main-r iframe").attr("src",$("#index-main-r iframe").attr("src")).ready();
	   }
   });
   $('.fa-power-off').click(function(){$("#index-main-r iframe").attr('src','index.php/merchant/index/exiti');});
   $('#mainpage').click(function(){
	   if(json.user.status==0){
			layer.confirm('信息审核中！',function(index){layer.close(index);});
			return ;
		}else if(json.user.status==2){
			layer.confirm('审核失败信息：'+json.user.mess,function(index){layer.close(index);});
			$("#index-main-r iframe").attr('src',U + 'merchant/Information/index');
			return ;
		}else{
			$("#index-main-r iframe").attr('src','index.php/merchant/index/main');
		}
	});
   $('.fa-question-circle').click(function(){
	   	 if(json.user.status==0){
			layer.confirm('信息审核中！',function(index){layer.close(index);});
			return ;
		}else if(json.user.status==2){
			layer.confirm('审核失败信息：'+json.user.mess,function(index){layer.close(index);});
			$("#index-main-r iframe").attr('src',U + 'merchant/Information/index');
			return ;
		}else{
			$("#index-main-r iframe").attr('src','index.php/merchant/index/help');
		}
	 });
   $('.fa-bell').click(function(){
	   	if(json.user.status==0){
			layer.confirm('信息审核中！',function(index){layer.close(index);});
			return ;
		}else if(json.user.status==2){
			layer.confirm('审核失败信息：'+json.user.mess,function(index){layer.close(index);});
			$("#index-main-r iframe").attr('src',U + 'merchant/Information/index');
			return ;
		}else{
			$("#index-main-r iframe").attr('src','index.php/merchant/Certification/index');
		}
	});
	if(json.user.logo.length>0){
		$('#user-logo img').attr('src','upload/merchant/'+json.user.logo);
	}else{
		$('#user-logo img').attr('src','static/admin/images/admin-index-logo.png');
	}
	 
});