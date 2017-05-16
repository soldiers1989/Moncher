/**
@描述:商户平台登录
@作者:Mr.zwx
@时间:2017-02-24
**/
/**导航高度一定但宽度需要自适应*/
var W = $(window).width() > 1200 ? $(window).width() : 1200;
var H = $(window).height() > 675 ?  $(window).height() : 675;
var U = $('base').attr('href');
var numberStatus=false,picStatus=false,smsStatus=false,passwordStatus=false;
/**异步请求数据方法*/
function Fa(url, data) {
	var message;
	$.ajax({type: "POST",url: U + 'index.php' + url,async: false,
				data: data,success: function(msg) {message = msg;}
	});
	return message;
}
/**加载并执行*/
$(function(){
	$('#number').blur(function(){
		if($.trim($("#number").val()).length <= 0) {
			layer.tips('请输入注册手机号', '#number',{ tips: [2, '#f0ad4e']});
			return false;
		}
	   var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
		if(!myreg.test($("#number").val())){
				layer.tips('请输入正确手机号', '#number',{ tips: [2, '#e60012']});
				return false;
		}
	   var status = Fa('/merchant/Register/checkNumber', 'number=' + $("#number").val());
		if (status == 4004) {
			$("#number").attr('readonly','readonly');
			numberStatus=true;
			layer.tips('OK！', '#number',{ tips: [2, '#5cb85c']});
			return true;
		} else if (status == 4000) {
			layer.tips('该手机号未注册过CADA云数聚', '#number',{ tips: [2, '#e60012']});
			return false;
		}
	});
	/**更换验证码*/
	$("#showCode").click(function() {
		$("#showCode").attr('src', U + 'admin/Login/findCode?' + Math.random());
   }); 
   $('#PicCode').blur(function(){
	   if($.trim($(this).val()).length <= 0) {
			layer.tips('请输入图片验证码','#showCode',{ tips: [2, '#f0ad4e']});
		} else {
			 var status = Fa('/merchant/Login/checkVerifyi', 'code=' + $(this).val());
			if(status==4000){
				$('#PicStatus').val(1);
				picStatus=true;
				layer.tips('OK！', '#showCode',{ tips: [2, '#5cb85c']});
			}else{
				layer.tips('图片验证码无效','#showCode',{ tips: [2, '#e60012']});
			}
		}
   });
   function findCode(){
	   if($("#PicStatus").val()==1){
	   var code=Fa('/merchant/Login/findSMS', 'number=' +$("#number").val());
	   $('#smsStatus').val(code);
	   alert(code);
	   $("#smsCodeis a").off("click");
	   i=100;
		var func=function(){
		$("#smsCodeis a").text(i+"s");i--;
			if(i>0){setTimeout(func,1000);
		}else{
			$("#smsCodeis a").text("获取短信验证码");
			$("#smsCodeis a").on("click",findCode); 
		}
		};
		setTimeout(func,1);
	}else{
	   layer.tips('图片验证码无效','#smsCodeis',{ tips: [2, '#e60012']});
	   }
   }
   $('#smsCodeis a').click(findCode);
   	/**检测用户名是否存在*/
	$("#smsCode").blur(function() {
		if($.trim($(this).val()).length <= 0) {
			layer.tips('请输入短信验证码','#smsCodeis',{ tips: [2, '#f0ad4e']});
		} else {
			if($(this).val()==$('#smsStatus').val()){
				smsStatus=true;
			}else{
				layer.tips('手机验证码无效','#smsCodeis',{ tips: [2, '#e60012']});
			}
		}
	});
	$('#index-y').css({"display":"none"});
	$('#index-z').css({"display":"none"});
	$('.SXC').eq(0).css({"border-bottom":"2px solid #e60012"});
	$('.SXC span').eq(0).css({"background":"#e60012"});
	/**检测用户名是否存在*/
	$("#password").blur(function() {
		if($.trim($(this).val()).length <= 0) {
			layer.tips('请输入密码', this,{ tips: [2, '#f0ad4e']});
		} else {
			if($(this).val()==$("#password").val()){
			return ;
			}else{
				layer.tips('两次密码不一致', this,{ tips: [2, '#e60012']});
			}
		}
	});
	/**检测用户名是否存在*/
	$("#passwordi").blur(function() {
		if($.trim($(this).val()).length <= 0) {
			layer.tips('请输入密码', this,{ tips: [2, '#f0ad4e']});
		} else {
			if($(this).val()==$("#password").val()){
				passwordStatus=true;
			}else{
				layer.tips('两次密码不一致', this,{ tips: [2, '#e60012']});
			}
		}
	});
	/**提交信息*/
	$("#submit").click(function(){
		if(!numberStatus){
			layer.tips('请仔细核对手机号！', '#number',{ tips: [2, '#e60012']});
			return;
		}
		if(!picStatus){
			layer.tips('请仔细核对图片验证码','#showCode',{ tips: [2, '#e60012']});
			return;
		}
		if(!smsStatus){
			layer.tips('请仔细核对手机验证码','#smsCodeis',{ tips: [2, '#e60012']});
			 return ;
		}
		if(numberStatus && picStatus && smsStatus && !passwordStatus){
				$('#index-x').css({"display":"none"});
				$('#index-y').css({"display":"block"});
				$('.SXC').eq(0).css({"border-bottom":"2px solid #FFF"});
				$('.SXC').eq(1).css({"border-bottom":"2px solid #e60012"});
				$('.SXC span').eq(0).css({"background":"#ccc"});
				$('.SXC span').eq(1).css({"background":"#e60012"});
				return ;
		}
		if(numberStatus && picStatus && smsStatus && passwordStatus){
				$('#index-x').css({"display":"none"});
				$('#index-y').css({"display":"none"});
				$('#index-z').css({"display":"block"});
				$('.button').css({"display":"none"});
				$('.SXC').eq(0).css({"border-bottom":"2px solid #FFF"});
				$('.SXC span').eq(0).css({"background":"#ccc"});
				$('.SXC').eq(1).css({"border-bottom":"2px solid #FFF"});
				$('.SXC span').eq(1).css({"background":"#ccc"});
				$('.SXC').eq(2).css({"border-bottom":"2px solid #e60012"});
				$('.SXC span').eq(2).css({"background":"#e60012"});
				var status=Fa('/merchant/Login/resetPass','number='+$("#number").val()+'&password='+$("#password").val());
				if(status==1){
					layer.confirm('密码重置成功请返回登录',function(index){layer.close(index);window.location.href=U +'merchant/Login';});
				}else{
					layer.confirm('密码重置失败,请重新设置',function(index){layer.close(index);window.location.reload();});
				}
		}
	});
});