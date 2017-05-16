/**
.@描述:登录页脚本文件
@作者:Mr.zwx
@时间:2017-02-04 
**/
/**配置全局参数*/
var W = $(window).width() > 1366 ? $(window).width() : 1366;
var H = $(window).height() > 720 ? $(window).height() : 720;
var U = $('base').attr('href');
var userStatus = false;
var codeStatus = false;
var passStatus = false; 
/**异步请求数据方法*/
function Fa(url, data) {
	var message;
	$.ajax({
		type: "POST",
		url: U + 'index.php' + url,
		async: false,
		data: data,
		success: function(msg) {
			message = msg;
		}
	});
	return message;
} 
/**渲染框架样式*/

function Fc() {
	$("#cada-admin-login").css({
		"height": H + 'px',
		"width": W + 'px',
		"overflow": 'hidden'
	});
	$("#cada-admin-login .login-bg").css({
		"position": "absolute",
		"height": H + "px",
		"width": W + "px",
		"z-index": -1
	});
	$("#cada-admin-login .login-main-bg").css({
		"position": "absolute",
		"height": (H / 2) + "px",
		"width": W + "px",
		"top": (H / 4) + "px",
		"z-index": 1
	});
	$(".login-foot").css({
		"position": "absolute",
		"top": (H * 0.75) + (103 / 1080) * H + "px",
		"z-index": 2
	});
	$(".login-foot p").css({
		"font-size": "16px",
		"width": W + "px",
		"text-align": "center",
		"line-height": "24px",
		"color": "#FFF",
		"font-family": "微软雅黑"
	});
	$(".login-main").css({
		"position": "absolute",
		"height": (H / 2) + "px",
		"width": W + "px",
		"top": (H / 4) + "px",
		"z-index": 2
	});
	$(".login-main .login-main-l").css({
		"float": "left",
		"height": (H / 2) + "px",
		"width": (1030 / 1920) * W - ((64 / 1920) * W) + "px",
		"background": "url(" + U + "static/admin/images/admin-login-logo.png) no-repeat center right",
		"margin-right": ((64 / 1920) * W) + "px"
	});
	$(".login-main .login-main-c").css({
		"float": "left",
		"height": (H / 2) * (1 - (18 / 541)) + "px",
		"width": (455 / 1920) * W + "px",
		"background": "#7c7d7d",
		"margin-top": (H / 2) * (9 / 541) + "px"
	});
	$(".login-main .login-main-r").css({
		"float": "left",
		"height": (H / 2) + "px",
		"width": (435 / 1920) * W + "px"
	}); 
	/**需要计算比例*/
	var mainH = $(".login-main .login-main-c").height();
	var mainW = $(".login-main .login-main-c").width();
	$(".login-main .login-main-c h2").css({
		"width": "100%",
		"color": "#FFF",
		"font-family": "微软雅黑",
		"height": Math.floor((42 / 524) * mainH) + "px",
		"font-size": Math.floor((42 / 524) * mainH) + "px",
		"font-weight": "normal",
		"text-align": "center",
		"margin-top": Math.floor((62 / 524) * mainH) + "px"
	});
	$(".login-main .login-main-c ul").css({
		"width": Math.floor((333 / 455) * mainW) + "px",
		"margin": "0 auto",
		"margin-top": Math.floor((54 / 524) * mainH) + "px"
	});
	$(".login-main .login-main-c ul li").css({
		"width": "100%",
		"height": Math.floor((46 / 524) * mainH) + 'px',
		"margin-bottom": Math.floor((17 / 524) * mainH) + "px"
	});
	$(".login-main .login-main-c ul li label").css({
		"width": Math.floor((49 / 455) * mainW) + "px",
		"height": Math.floor((46 / 524) * mainH) + 'px',
		"float": "left"
	});
	$(".login-main .login-main-c ul li label img").css({
		"display": "block",
		"width": Math.floor((49 / 455) * mainW) > 31 ? 31 : (Math.floor((49 / 455) * mainW) - 4) + 'px',
		"height": Math.floor((46 / 524) * mainH) > 35 ? 35 : (Math.floor((46 / 524) * mainH) - 2) + 'px',
		"margin-top": Math.floor((46 / 524) * mainH) > 35 ? ((Math.floor((46 / 524) * mainH) - 35) / 2) + "px" : "0px"
	});
	$("#userName").css({
		"display": "block",
		"float": "left",
		"height": Math.floor((44 / 524) * mainH) + "px",
		"width": Math.floor((282 / 455) * mainW) + "px",
		"text-indent": "12px",
		"font-size": "16px",
		"border": "0"
	});
	$("#passWord").css({
		"display": "block",
		"float": "left",
		"height": Math.floor((44 / 524) * mainH) + "px",
		"width": Math.floor((282 / 455) * mainW) + "px",
		"text-indent": "12px",
		"font-size": "16px",
		"border": "0"
	});
	$("#imgCode").css({
		"display": "block",
		"cursor":"pointer",
		"float": "left",
		"height": Math.floor((44 / 524) * mainH) + "px",
		"width": Math.floor((127 / 455) * mainW) + "px",
		"text-indent": "12px",
		"font-size": "16px",
		"border": "0"
	});
	$("#showCode").css({
		"display": "block",
		"float": "left",
		"margin-left": Math.floor((28 / 455) * mainW) + "px",
		"height": Math.floor((46 / 524) * mainH) + 'px',
		"width": Math.floor((127 / 455) * mainW) + "px"
	});
	$("#submit").css({
		"height": Math.floor((50 / 524) * mainH) + 'px',
		"width": Math.floor((333 / 455) * mainW) + "px",
		"text-decoration":"none",
		"margin": "0 auto",
		"background": "#e60012",
		"text-align": "center",
		"font-size": Math.floor((30 / 524) * mainH) + 'px',
		"line-height": Math.floor((48 / 524) * mainH) + 'px',
		"color": "#FFF",
		"font-family": "微软雅黑",
		"margin-top": Math.floor((34 / 524) * mainH) + 'px'
	});
	$(".login-check").css({
		"width": Math.floor((333 / 455) * mainW) + "px",
		"margin": "0 auto",
		"color": "#FFF",
		"font-size": "18px",
		"font-family": "微软雅黑",
		"margin-top": Math.floor((22 / 524) * mainH) + 'px',
		"line-height": "20px"
	});
	$(".login-check input[type='checkbox']").css({
		"height": "20px",
		"width": "20px",
		"padding": "0",
		"margin": "0",
		"border": "0",
		"display": "block",
		"float": "left",
		"margin-right": "8px"
	});
} /**检测是否版本过低*/

function Fd() {
	var version = navigator.appVersion.toString();
	if (version.indexOf('MSIE 7.0') > -1 || version.indexOf('MSIE 6.0') > -1) {
		$("#cada-admin-login").append('<div id="versionCode">您的浏览器版本过低，无法完成登录，请下载<a href="https://www.baidu.com/link?url=RYx2dw5xY4MkXomIv7pxwzMiWfuLUghOiwvFUp78_iZ4q8Z7OsvRGUhOpTABEJk3CFunVOHv7KTq_3xF0pPkqWPjf1mDwGi3MMt-N9F1Dve&wd=&eqid=a97551d9000089ad0000000358074820">火狐浏览器</a></div>');
		$("#versionCode").css({
			"height": "40px",
			"width": W + 'px',
			"line-height": "40px",
			"background": "#FCF8E3",
			"text-align": "center",
			"font-size": "13px",
			"position": "absolute",
			"z-index": "12",
			"top": (H * 0.75) + (20 / 1080) * H + "px",
			"left": "0"
		});
		$("#versionCode a").css({
			"display": "inline-block"
		});
	}
} /**开始执行以上方法*************************************************************************************************************************************/
$(function() { /**渲染界面*/
	Fc();
	Fd();
	Placeholder.init(); 
	/**屏幕伸缩处理*/
	$(window).resize(function() {
		W = $(window).width() >= 1366 ? $(window).width() : 1366;
		H = $(window).height() >= 720   ? $(window).height() : 720;
		Fc();
	});
	$.trim($('#error').val()).length >0 && layer.msg($('#error').val(), {icon:2,time: 1500},function(){});
	/**更换验证码*/
	$("#showCode").click(function() {
		$("#showCode").attr('src', U + 'index.php/admin/Login/findCode?' + Math.random());
	}); 
	/**检测用户名是否存在*/
	$("#userName").focus(function() {
	}).blur(function() {
		if ($.trim($(this).val()).length <= 0) {
			layer.tips('请输入用户名', this,{ tips: [2, '#f0ad4e']});
		} else {
			var status = Fa('/admin/Login/checkUser', 'userName=' + $(this).val());
			if (status == 4000) {
				userStatus = true;
				layer.tips('OK！', this,{ tips: [2, '#5cb85c']});
			} else if (status == 4004) {
				userStatus = false;
				layer.tips('该用户不存在！', this,{ tips: [2, '#e60012']});
			}
		}
	}); /**检测验证码是否有效*/
	$("#imgCode").focus(function() {
		(codeStatus == false && $.trim($(this).val()).length > 0) && $("#showCode").attr('src', U + 'index.php/admin/Login/findCode?' + Math.random());
	}).blur(function() {
		if ($.trim($(this).val()).length <= 0) {
			layer.tips('请输入验证码', "#showCode",{ tips: [2, '#f0ad4e']});
		}else{
		    codeStatus = true;
		}
	}); 
	/**检测用户名是否存在*/
	$("#passWord").blur(function() {
		if ($.trim($(this).val()).length <= 0) {
			layer.tips('请输入密码', this,{ tips: [2, '#f0ad4e']});
		} else {
			passStatus = true;
		}
	}); 
	/**提交数据*/
	$("#submit").click(function() {
	  /*如果验证码和用户名和密码都正确填写提交表单*/
		if($.trim($("#userName").val()).length <= 0){ layer.tips('请输入用户名',"#userName",{ tips: [2, '#f0ad4e']}); return;}
		if($.trim($('#passWord').val()).length <= 0){layer.tips('请输入密码','#passWord',{ tips: [2, '#f0ad4e']}); 	   return;}
		if($.trim($("#imgCode").val()).length <= 0){layer.tips('请输入验证码',"#showCode",{ tips: [2, '#f0ad4e']});  return;}
	    (codeStatus && userStatus && passStatus) && $("#joinData").submit();
	}).mousemove(function() {
		$(this).css({
			"background": "#f10013"
		});
	}).mouseleave(function() {
		$(this).css({
			"background": "#e60012"
		});
	});
});