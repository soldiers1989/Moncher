/**
@描述:主页框架
@作者:Mr.zwx
@时间:2017-02-06 
**/
/**导航高度一定但宽度需要自适应*/
var W = $(window).width() > 1366 ? $(window).width() : 1366;
var H = $(window).height() > 620 ? $(window).height() : 620;
var U = $('base').attr('href');
var menuStatus = false;
var json = eval('(' + Fa('admin/index/getUserRole', '') + ')'); 
/**定义通用css对象*/
var color1={"background": "#e60012","color": "#FFF"};
var color2={"background": "#F1F1F1","color": "#323232"};
var showx={"display": "block"};
var hidex={"display": "none"};
var headH=(114 / 1080) * H;
var mainH=((1080 - 117) / 1080)*H;
var mainW=W-181;
var li_not={"height": "34px","text-align": "center","line-height": "34px","font-size": "14px","color": "#333","font-family": "微软雅黑","border-bottom":"1px solid #f1f1f1"};
var li_first={"height":"40px","background": "#e60012","color": "#FFF","font-size":"16px","line-height":"40px","margin-top": "0","text-align": "center","font-family": "微软雅黑"};
var admin_index={"width": W + 'px',"height": H + 'px',"overflow": 'hidden'};
var index_head={"width": W + 'px',"height": headH + 'px',"border-bottom": "3px solid #e60012","background": 'url(' + U + 'static/admin/images/admin-index-logo.png) no-repeat  30px center'};
var menu_left={"display": "none","position": "absolute","z-index": "12","top": "0","width":'120px',"border-right":"1px solid #f1f1f1","background": "#FFF"};
var head_user={"float": "right","width": '100px',"height": headH + 'px',"line-height": headH+ 'px',"text-align": "right","margin-right": (13 / 1920) * W + 'px',"font-size": '16px',"font-family": "微软雅黑"};
var head_logo={"float": "right","width": '50px',"height": '50px',"border-radius": '25px',"margin-top": ((57 / 1080) * H - 25) + 'px',"margin-right": "24px"};
var head_logo_img={"width": '50px',"height": '50px',"border-radius": '25px'};
var head_exit={"float": "right","width": "18px","height": headH + 'px',"line-height": headH + 'px',"margin-right": (52 / 1920) * W + 'px',"font-size": "16px"};
var index_main={"width": W + 'px',"height": mainH+ 'px',"background": '#F1F1F1'};
var index_main_l={"width":'180px',"height": mainH+ 'px',"float": "left","border-right": "1px solid #FFF"};
var index_main_r={"width": mainW - 10 + 'px',"height": mainH - 10 + 'px',"float": "left","background": "#FFF","margin-top": "5px","margin-left": "5px"};
var iframex={"width": mainW - 10 + 'px',"height": mainH - 10 + 'px'};
var dt_first={"height":"60px","background": "#e60012","color": "#FFF","font-size": "18px","font-family": "微软雅黑","line-height": "60px"};
var menu_nav={"height":"40px","border-bottom": "1px solid #d9d9d9","border-top": "1px solid #fafafa","font-size":"16px","font-family": "微软雅黑","line-height":"40px","color": "#323232"};
var dd_ul={"border-bottom": "1px solid #d9d9d9","background": "#FFF","display": "none"};
var dd_ul_li={"width": "136px","height": "26px","font-size": "14px","font-family": "微软雅黑","line-height":"26px","margin-top": "8px","margin-left": "22px","margin-bottom":"8px","border-radius": "2px","float": "left"};
var navicon1={"margin-left":"8px","font-size":"25px","line-height":"60px"};
var icons1={"margin-left":"8px","font-size":"25px","line-height": "42px"};
var navicon2={"margin-left": "20px","font-size": "18px","line-height": "60px"};
var icons2={"margin-left": "20px","font-size": "16px","line-height":"40px"};
var user_bar={"width":"120px","background":"#f1f1f1","color":"#333","font-size":"13px","display":"none","position": "absolute","z-index": "12","left":"0","top":"0","border":"1px solid #CCC","border-radius":"4px"};
var user_bar_li={"height":"30px","line-height":"30px","font-size":"13px","font-family": "微软雅黑","text-align":"center","cursor": "pointer"};
/**异步请求数据方法*/
function Fa(url, data) {
	var message;
	$.ajax({
		type: "POST",
		url: U + 'index.php/' + url,
		async: false,
		data: data,
		success: function(msg) {
			message = msg;
		}
	});
	return message;
} /**框架搭建主方法*/
function Fb() {
	$("#cada-admin-index").append('<div id="index-head"><div class="head-exit"><i class="fa fa-power-off"></i></div><div class="head-logo"><img src="' + U + 'static/' + json.user.logo + '"/></div><div class="head-user">' + json.user.name + '&nbsp;<i class="fa fa-caret-down"></i></div><div style="clear:both;"></div></div>');
	$("#cada-admin-index").append('<div id="index-main"><div id="index-main-l"><div id="menu-bar"><span>平台管理</span><i class="fa fa-navicon"></i></div><dl id="main-menu"></dl></div><div id="index-main-r"><iframe src="'+U+'index.php/admin/index/start" frameborder="0"  scrolling="no"/></div><div style="clear:both;"></div></div>');
	$("#cada-admin-index").append('<div id="menu-left" showId="0"></div>');
	$("#cada-admin-index").append('<div id="user-bar"><ul><li url="index.php/admin/Index/think">修改密码</li><li url="index.php/admin/Index/exiti">退出登录</li></ul></div>');
	$.each(json.role, function(index, item) {
		var menu = '';
		$("#main-menu").append('<dt class="menu-nav" openStatus="0" navId="' + item.id + '"><i class="icons fa ' + item.icon + '"></i><span>' + item.title + '</span><i class="last fa fa-angle-down"></i></dt>');
		$.each(item.menu, function(i, son) {
			menu += '<li url="' + U + 'index.php/' + son.url + '">' + son.title + '</li>';
		});
		$("#main-menu").append('<dd><ul>' + menu + '<div style="clear:both;"></div></ul></dd>');
	});
} /**框架渲染主方法*/
function Fc() {
	$("#cada-admin-index").css(admin_index);
	$("#index-head").css(index_head);
	$("#menu-left").css(menu_left);
	$("#user-bar").css(user_bar);
	$("#user-bar ul li").css(user_bar_li).click(function(){$("#index-main-r iframe").attr('src',$(this).attr('url'));});
	$('.fa-power-off').click(function(){$("#index-main-r iframe").attr('src','index.php/admin/Index/exiti');});
	$("#index-head .head-user").css(head_user).click(function(){
		$("#user-bar").css("display")=='none'?$("#user-bar").css({"display":"block","left":$(this).offset().left-4,"top":((57 / 1080) * H)+28}):$("#user-bar").css(hidex);
	});
	$("#index-head .head-logo").css(head_logo);
	$("#index-head .head-logo img").css(head_logo_img);
	$("#index-head .head-exit").css(head_exit).mousemove(function() {$(this).css({"color": "#e60012"});}).mouseleave(function() {$(this).css({"color": "#333"});});
	$("#index-main").css(index_main);
	$("#index-main-l").css(index_main_l);
	$("#index-main-r").css(index_main_r);
	$("#index-main-r iframe").css(iframex);
	$("#main-menu").css({"height":(mainH-68)+"px"});
	$("#menu-bar").css(dt_first);
	$("#menu-bar").find('span').css({"margin-left":"40px"});
	$("#menu-bar").find('i').css({"margin-left": "20px"});
	$("#main-menu .menu-nav").css(menu_nav);
	$("#main-menu .menu-nav .icons").css({"margin-left":"20px"});
	$("#main-menu .menu-nav  span").css({"margin-left":"12px"});
	$("#main-menu .menu-nav  .fa-angle-down").css("margin-left", "24px");
	$("#main-menu  dd ul").css(dd_ul);
	$("#main-menu  dd ul li").css(dd_ul_li).mousemove(function() {
		$(this).css(color1);
	 }).mouseleave(function() {
	   $(this).css({"background": "#FFF","color": "#323232"});
	 }).click(function(){
	   $("#index-main-r iframe").attr('src',$(this).attr('url'));
	});
}
/**生成菜单事件*/
function Fd(object,navId){
	$("#menu-left ul li").remove();
	$.each(json.role, function(index, item) {
		if (navId == item.id) {
			var menu = '';
			$.each(item.menu, function(i, son) {
				menu += '<li url="' + U + 'index.php/' + son.url + '">' + son.title + '</li>';
			});
			$("#menu-left").append('<ul><li>' + item.title + '</li>' + menu + '<div style="clear:both;"></div></ul>');
		}
	});
	$("#menu-left").css({"top": ($(object).offset().top + 1) + 'px',"left":40});
	$("#menu-left ul li:not(:first)").css(li_not).mousemove(function() {
		$(this).css(color1);
	}).mouseleave(function() {
		$(this).css({"background": "#FFF","color": "#323232"});
	}).click(function(){
		$("#index-main-r iframe").attr('src',$(this).attr('url'));
	});
		$("#menu-left ul li:first").css(li_first);
}
/************************************************************************************************************/
$(function() {
	Fb();Fc(); 
	$(window).on("load",function(){$("#main-menu").mCustomScrollbar({theme:"light-thin"});});
	/**主菜单点击事件*/
	$(".fa-navicon").click(function() {
		$("#menu-left").css(hidex);
		$("#menu-left ul li").remove();
		$("#main-menu .menu-nav").attr("openStatus", 0);
		if (!menuStatus) {
			menuStatus = true;
			$("dt span,dt .last,dd ul,#menu-bar span").css(hidex);
			$("#index-main-l").animate({"width": "40px"}, 62.5);
			$("#index-main-r").animate({"width": (W - 51) + 'px'}, 62.5);
		    $("#index-main-r iframe").animate({"width": (W - 51) + 'px'},62.5);
			$('.fa-navicon').css(navicon1);
			$('.icons').css(icons1);
		} else {
			menuStatus = false;
			$("dt span,dt .last,#menu-bar span").show();
			$("#index-main-l").animate({"width": "180px"}, 62.5);
			$("#index-main-r").animate({"width": mainW - 10 + 'px'}, 62.5);
		    $("#index-main-r iframe").animate({"width": mainW - 10 + 'px'},62.5);
			$('.fa-navicon').css(navicon2);
			$('.icons').css(icons2);
		}
	}); 
	/**菜单点击事件*/
	$("#main-menu .menu-nav").click(function() {
		if (!menuStatus) { /**判断一级菜单*/
			var display = $(this).next().find('ul').css("display");
			if (display == 'block') {
				$(this).next().find('ul').css(hidex);
				$(this).find('i:last').removeClass('fa-angle-up');
				$(this).find('i:last').addClass('fa-angle-down');
				$(this).next().find('ul li').css({"text-indent": "0px"});
			} else {
				$("#main-menu dd ul").css(hidex);
				$("#main-menu .menu-nav i:not(.icons)").removeClass('fa-angle-up').addClass('fa-angle-down');
				$("#main-menu dd ul li").css("text-indent", "0");
				$(this).next().find('ul').show();
				$(this).find('i:last').removeClass('fa-angle-down');
				$(this).find('i:last').addClass('fa-angle-up');
				$(this).next().find('ul li').animate({"text-indent": "25px"}, 200);
			}
		}else{
			$("#menu-left").css(hidex);$(this).css(color2);
		}
	}).hover(function() {
		$('#main-menu .menu-nav').css(color2);
		var navId = $(this).attr("navId");
		$("#menu-left").attr("showId",navId);
		var display = $("#menu-left").css("display");
		if(menuStatus){
			$(this).css(color1);
			if(display=="block"){
				Fd(this,navId);
			}else{
			   $("#menu-left").css(showx);
			   Fd(this,navId);
			}
		}
	},function(){
	 !menuStatus && $(this).css(color2);
	});
	$("#menu-left").mouseleave(function() {
		$("#menu-left").attr("showId",0);
		$("#menu-left").css(hidex);
		$('#main-menu dt:not(:first)').css(color2);
	});
});