/**
@描述:商户平台登录
@作者:Mr.zwx
@时间:2017-02-24
**/
/**导航高度一定但宽度需要自适应*/
var W = $(window).width() > 1200 ? $(window).width() : 1200;
var H = $(window).height() > 675 ?  $(window).height() : 675;
var U = $('base').attr('href');
var userStatus = false;
var codeStatus = false;
var passStatus = false; 
/**加载并执行*/
$(function(){
	/**自动适应宽高*/
	$('#main-bg').css({"height":(684/980)*H+"px"});
	$('.main-r').css({"margin-top":($('#main-bg').height()-$('.main-r').height())/2+"px"});
	$('.main-l-t').css({"height":(145/980)*H+"px"});
	$('.main-l-b').css({"height":(400/980)*H+"px"});
	$('.main-l').css({"margin-top":($('#main-bg').height()-$('.main-l').height())/2+"px"});
	$.trim($('#error').val()).length >0 && layer.msg($('#error').val(), {icon:2,time: 1500},function(){});
	/**检测验证码是否有效*/
	$("#code").focus(function() {
		(codeStatus == false && $.trim($(this).val()).length > 0) && $("#imgcode").attr('src', U + 'index.php/admin/Login/findCode?' + Math.random());
	}).blur(function() {
		if($.trim($(this).val()).length <= 0) {layer.tips('请输入验证码','#imgcode',{ tips: [2, '#f0ad4e']});return ;} 
		var pattern = /^[\u4e00-\u9fa5]+$/;
		var strAll=/[\uFE30-\uFFA0]/gi; 
		if(strAll.test($(this).val())){layer.tips('无法输入全角字符','#imgcode',{ tips: [2, '#f0ad4e']});return ;}
		if(codeStatus == false) {codeStatus = true;}
	}); 
	/**检测用户名是否存在*/
	$("#password").blur(function() {
		var strAll=/[\uFE30-\uFFA0]/gi; 
		if(strAll.test($(this).val())){layer.tips('无法输入全角字符','#password',{ tips: [2, '#f0ad4e']});return ;}
		if($.trim($(this).val()).length <= 0) {layer.tips('请输入密码', this,{ tips: [2, '#f0ad4e']}); return;}
		passStatus = true;
	}); 
    /**检测用户名是否存在*/
	$("#username").blur(function() {
		if($.trim($(this).val()).length <= 0){layer.tips('请输入用户名', this,{ tips: [2, '#f0ad4e']}); return;}
		var strAll=/[\uFE30-\uFFA0]/gi; 
		if(strAll.test($(this).val())){layer.tips('无法输入全角字符','#username',{ tips: [2, '#f0ad4e']});return ;}
		var reg=new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]","i"); 
		if(reg.test($(this).val())){layer.tips('无法输入特殊字符', this,{ tips: [2, '#f0ad4e']}); return;}
		var status = Fa('/merchant/Login/checkUser', 'userName=' + $(this).val());
		if (status == 4000) {
			userStatus = true;
			 layer.tips('OK！', this,{ tips: [2, '#5cb85c']});
		} else if (status == 4004) {
			userStatus = false;
			layer.tips('该用户不存在', this,{ tips: [2, '#e60012']});
		}
	}); 
	/**更换验证码*/
	$("#imgcode").click(function() {
		$("#imgcode").attr('src', U + 'index.php/admin/Login/findCode?' + Math.random());
   }); 
  /**提交数据*/
	$(".button").click(function() {
		if($.trim($("#username").val()).length <= 0){ layer.tips('请输入用户名',"#username",{ tips: [2, '#f0ad4e']}); return;}
		if($.trim($('#password').val()).length <= 0){layer.tips('请输入密码','#password',{ tips: [2, '#f0ad4e']}); 	   return;}
		if($.trim($("#code").val()).length <= 0){layer.tips('请输入验证码',"#imgCode",{ tips: [2, '#f0ad4e']});  return;}
	  /*如果验证码和用户名和密码都正确填写提交表单*/
	  (codeStatus && userStatus && passStatus) && $("#form-z").submit();
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