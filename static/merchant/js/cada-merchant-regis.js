/**
@描述:商户平台登录
@作者:Mr.zwx
@时间:2017-02-24
**/
/**导航高度一定但宽度需要自适应*/
var W = $(window).width() > 1200 ? $(window).width() : 1200;
var H = $(window).height() > 675 ?  $(window).height() : 675;
var U = $('base').attr('href');
var statusM={
	"userStatus":false,
	"passStatus":false,
	"passIStatus":false,
	"personStatus":false,
	"number":false,
	"Mname":false,
	"Maddress":false,
	"Nature":false,
	"Marea":false,
	"Mbrand":false,
	"MtelePhone":false,
	"Mwechat":false,
	"Memployee":false,
	"Mstation":false,
	"Macreage":false,
	"MstartTime":false,
	"MendTime":false,
	"Mlogo":false,
	"Mpicture":false,
	"Mrevenue":false,
	"Mlicense":false,
	"Mservice":false,
	"MdescriPtion":false,
	"hasSigning":false
};
var errorM={
		"userStatus":"请仔细检查用户名信息",
		"passStatus":"请仔细检查密码信息",
		"passIStatus":"请仔细检查验证密码",
		"personStatus":"请仔细检查联系人信息",
		"number":"请仔细检手机号",
		"Mname":"请仔细检查门店名称信息",
		"Maddress":"请仔细检查地址信息",
		"Nature":"请仔细检查商户资质",
		"Marea":"请仔细检查区域",
		"Mbrand":"请仔细检查品牌",
		"MtelePhone":"请仔细检查联系电话",
		"Mwechat":"请仔细检查微信号",
		"Memployee":"请仔细检查员工数量",
		"Mstation":"请仔细检查工位数量",
		"Macreage":"请仔细检查门店面积",
		"MstartTime":"请仔细检查营业时间",
		"MendTime":"请仔细检查营业时间",
		"Mlogo":"请上传LOGO",
		"Mpicture":"请上传门店大图",
		"Mrevenue":"请上传营业执照",
		"Mlicense":"请上传资质证书",
		"Mservice":"请选择服务项目",
		"MdescriPtion":"请填写门店介绍",
		"hasSigning":"请同意服务协议"
	};
var statusB={
		"userStatus":false,
		"passStatus":false,
		"passIStatus":false,
		"personStatus":false,
		"number":false,
		"Bname":false,
		"Baddress":false,
		"Barea":false,
		"Bbrand":false,
		"BdescriPtion":false,
		"hasSigning":false
	};
	var statusG={
		"userStatus":false,
		"passStatus":false,
		"passIStatus":false,
		"number":false,
		"personStatus":false,
		"Gname":false,
		"Gaddress":false,
		"Gpicture":false,
		"Glogo":false,
		"Garea":false,
		"GdescriPtion":false,
		"hasSigning":false
	};
var errorB={
		"userStatus":"请仔细检查用户名信息",
		"passStatus":"请仔细检查密码信息",
		"passIStatus":"请仔细检查验证密码",
		"personStatus":"请仔细检查联系人信息",
		"number":"请仔细检手机号",
		"Bname":"请检厂家名称信息",
		"Baddress":"请检查总部地址",
		"Barea":"请选择总部区域",
		"Bbrand":"请选择主营品牌",
		"BdescriPtion":"请填写厂家介绍",
		"hasSigning":"请同意服务协议"
	};
var errorG={
		"userStatus":"请仔细检查用户名信息",
		"passStatus":"请仔细检查密码信息",
		"passIStatus":"请仔细检查验证密码",
		"personStatus":"请仔细检查联系人信息",
		"number":"请仔细检手机号",
		"Gname":"请检查集团名称",
		"Gaddress":"请检查总部地址",
		"Garea":"请检查总部区域",
		"GdescriPtion":"请填写集团嘉绍",
		"hasSigning":"请同意服务协议",
		"Gpicture":"请选择集团大图",
		"Glogo":"请选择集团logo"
	};
/**异步请求数据方法*/
function Fa(url, data) {
	var message;
	$.ajax({type: "POST",url: U + 'index.php' + url,async: false,
				data: data,success: function(msg) {message = msg;}
	});
	return message;
} 
function think(){
	if($.trim($("#number").val()).length <= 0) {
		layer.tips('请输入手机号', '#number',{ tips: [2, '#f0ad4e']});
		return false;
	}
   var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
	if(!myreg.test($("#number").val())){
			layer.tips('请输入正确手机号', '#number',{ tips: [2, '#e60012']});
			return false;
	}
   var status = Fa('/merchant/Register/checkNumber', 'number=' + $("#number").val());
	if (status == 4000) {
		statusM['number']=true;statusB['number']=true;statusG['number']=true;
		$("#number").attr('readonly','readonly');
		layer.tips('OK！', '#number',{ tips: [2, '#5cb85c']});
		return true;
	} else if (status == 4004) {
		layer.tips('该手机号已存在', '#number',{ tips: [2, '#e60012']});
		return false;
	}
}
/**加载并执行*/
$(function(){
	/**验证手机号*/
	$('#drag').drag(think);
	/**点击切换菜单*/
	$("#"+$(".selects li:eq(0)").attr("findId")).css("display","block");
	$(".selects li").click(function(){
		$(".selects li").removeClass('addbg').addClass('addborder');
	    $(this).addClass('addbg').removeClass('addborder');
		var type={"Merchant":1,"Group":0,"Brand":3};
		$(".baseinfo").css({"display":"none"});
		$("#isCompany").val(type[$(this).attr("findId")]);
		$("#"+$(this).attr("findId")).css("display","block");
	});
	/**检测用户名是否存在*/
	$("#username").blur(function() {
		if($.trim($(this).val()).length <= 0) {
			layer.tips('请输入用户名', this,{ tips: [2, '#f0ad4e']});
		} else {
			var status = Fa('/merchant/Register/checkUser', 'userName=' + $(this).val());
			if (status == 4000) {
				statusM['userStatus']=true;statusB['userStatus']=true;statusG['userStatus']=true;
				 layer.tips('OK！', this,{ tips: [2, '#5cb85c']});
			} else if (status == 4004) {
				layer.tips('该用户已存在', this,{ tips: [2, '#e60012']});
			}
		}
	});
	/**检测密码*/
	/**检测用户名是否存在*/
	$("#password").blur(function() {
		if($.trim($(this).val()).length <= 0) {
			layer.tips('请输入密码', this,{ tips: [2, '#f0ad4e']});
		} else {
			if($(this).val()==$("#password").val()){
				if($(this).val()==$("#username").val()){
					layer.tips('密码与用户名不同重复', this,{ tips: [2, '#e60012']});
					return;
				}
				statusM['passStatus']=true;statusB['passStatus']=true;statusG['passStatus']=true;
				layer.tips('OK！', this,{ tips: [2, '#5cb85c']});
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
				if($(this).val()==$("#username").val()){
					layer.tips('密码与用户名不同重复', this,{ tips: [2, '#e60012']});
					return;
				}
				statusM['passIStatus']=true;statusB['passIStatus']=true;statusG['passIStatus']=true;
				statusM['passStatus']=true;statusB['passStatus']=true;statusG['passStatus']=true;
				layer.tips('OK！', this,{ tips: [2, '#5cb85c']});
			}else{
				layer.tips('两次密码不一致', this,{ tips: [2, '#e60012']});
			}
		}
	});
	/**检测用户名是否存在*/
	$("#B-name").blur(function() {
		if($.trim($(this).val()).length <= 0) {
			layer.tips('请输入厂家名', this,{ tips: [2, '#f0ad4e']});
		} else {
			var status = Fa('/merchant/Register/checkUser', 'userName=' + $(this).val());
			if (status == 4000) {
				 layer.tips('OK！', this,{ tips: [2, '#5cb85c']});
			} else if (status == 4004) {
				layer.tips('该用户已存在', this,{ tips: [2, '#e60012']});
			}
		}
	});
	/**检测用户名是否存在*/
	$("#G-name").blur(function() {
		if($.trim($(this).val()).length <= 0) {
			layer.tips('请输入集团名', this,{ tips: [2, '#f0ad4e']});
		} else {
			var status = Fa('/merchant/Register/checkUser', 'userName=' + $(this).val());
			if (status == 4000) {
				 layer.tips('OK！', this,{ tips: [2, '#5cb85c']});
			} else if (status == 4004) {
				layer.tips('该用户已存在', this,{ tips: [2, '#e60012']});
			}
		}
	});
	/**检测用户名是否存在*/
	$("#M-name").blur(function() {
		if($.trim($(this).val()).length <= 0) {
			layer.tips('请输入门店名', this,{ tips: [2, '#f0ad4e']});
		} else {
			var status = Fa('/merchant/Register/checkUser', 'userName=' + $(this).val());
			if (status == 4000) {
				 layer.tips('OK！', this,{ tips: [2, '#5cb85c']});
			} else if (status == 4004) {
				layer.tips('该用户已存在', this,{ tips: [2, '#e60012']});
			}
		}
	});
	/**设置默认区域*/
	setArea(1,{},'city1');
	setArea(1,{},'city2');
	setArea(1,{},'city3');
	/**设置营业时间*/
	$("#startDiv ul li").click(function(){
		$("#startHidden").val($(this).text());
		$("#startTime").text($(this).text());
		statusM['MstartTime']=true;
	});
	$("#endDiv ul li").click(function(){
		$("#endHidden").val($(this).text());
		$("#endTime").text($(this).text());
		statusM['MendTime']=true;
	});
	/**提交信息*/
	$("#submit").click(function(){
		var submitStatus=true;
		if($("#password").val()==$("#username").val()){
			layer.msg("密码和用户名不能重复", {icon:2,time: 2000},function(){});
			return;
		}
		if($('.XieYi :input[type="checkbox"]').is(':checked')){
			statusM['hasSigning']=true;
			statusG['hasSigning']=true;
			statusB['hasSigning']=true;
		}else{
			layer.msg('请勾选服务协议', {icon:2,time: 2000},function(){});
		}
		if($("#isCompany").val()=='0'){
			for(var key in statusG ){ if(!statusG[key]){ submitStatus=false; layer.msg(errorG[key], {icon:2,time: 2000},function(){}); break ;return; } }
		}else if($("#isCompany").val()=='1'){
			var that= $('.radio-css span :input[type="checkbox"]');
			var thisStatus=true;;
			$.each(that,function(index,item){if($(item).is(':checked')) thisStatus=true;});
			if(!thisStatus){ layer.msg('请选择服务项目', {icon:2,time: 2000},function(){}); return;
			}else{
				statusM['Mservice']=true;
			}
			for(var key in statusM ){ if(!statusM[key]){ submitStatus=false; layer.msg(errorM[key], {icon:2,time: 2000},function(){}); break ;return;  } }
		}else if($("#isCompany").val()=='3'){
			for(var key in statusB ){ if(!statusB[key]){ submitStatus=false; layer.msg(errorB[key], {icon:2,time: 2000},function(){}); break ;return; } }
		}
		submitStatus && $("#Formz").submit();
	});
});
/**检测用户是否输入*/
function checkValue(that,type,Aoc,title){
	if($.trim($(that).val()).length <= 0){
		layer.tips($(that).attr('placeholder'),that,{ tips: [2, '#f0ad4e']});
	}else{
		if(type==1){
			if(/^\d+$/.test($(that).val())){
				if($(that).val()<=0){
					layer.tips('不能小于0！', that,{ tips: [2, '#e60012']});
				}else{
					if(Aoc=='M') statusM[title]=true;
					layer.tips('OK！',that,{ tips: [2, '#5cb85c']});
				}
			}else{
				layer.tips('请输入大于零正整数', that,{ tips: [2, '#e60012']});
			}
		}else{
			if(Aoc=='A'){statusG[title]=true;statusM[title]=true;statusB[title]=true;}
			if(Aoc=='B') statusB[title]=true;
			if(Aoc=='M') statusM[title]=true;
			if(Aoc=='G') statusG[title]=true;
			layer.tips('OK！', that,{ tips: [2, '#5cb85c']});
		}
	}
}
/**获取品牌数据方法*/
function setBrand(that,div){
	if($.trim($(that).val()).length >= 0){
		var brand=eval('(' + Fa('/merchant/Register/getBrand', 'brandId='+$(that).val()) + ')');
		$("#"+div +" option:not(:first)").remove();
		$.each(brand,function(index,item){
			$("#"+div).append('<option value="'+item.id+'">'+item.name+'</option>');
		});
	}
}
/**获取区域数据方法*/
function setArea(type,that,div){
	if(type==1){
		var brand=eval('(' + Fa('/merchant/Register/getArea', 'areaId=0') + ')');
			$("#"+div +" option:not(:first)").remove();
			$.each(brand,function(index,item){
				$("#"+div).append('<option value="'+item.id+'">'+item.name+'</option>');
			});
	}else{
		if($.trim($(that).val()).length >= 0){
			var brand=eval('(' + Fa('/merchant/Register/getArea', 'areaId='+$(that).val()) + ')');
			$("#"+div +" option:not(:first)").remove();
			$.each(brand,function(index,item){
				$("#"+div).append('<option value="'+item.id+'">'+item.name+'</option>');
			});
		}	
	}
}
/**设置二级选择项*/
function setSelect(that,Aoc,title){
	if($.trim($(that).val()).length <= 0){
		layer.tips("请选择该选项",that,{ tips: [2, '#f0ad4e']});
	}else{
			if(Aoc=='G')  statusG[title]=true;
			if(Aoc=='B')  statusB[title]=true;
			if(Aoc=='M') statusM[title]=true;
			layer.tips('OK！', that,{ tips: [2, '#5cb85c']});
	}
}
/**异步上传照片*/
function Fimg(that,img,hide,Aoc,title){
	 $('#'+img).parent().css({"background":"#FFF","border":"1px solid #ddd"});
	 $('#'+img).attr('src','http://www.51hyc.com/Public/images/Approve/Dong.gif');
	  var formdata = new FormData();  var v_this = $(that); var fileObj = v_this.get(0).files; 
	  formdata.append("image", fileObj[0]);	  
	  formdata.append("name", "image");
	  $.ajax({url : U+'index.php/merchant/Register/addPic', type : 'POST', data : formdata,cache: false,processData: false,contentType: false,dataType : "json",
				 success : function(data){if(Aoc=='G') statusG[title]=true;if(Aoc=='M') statusM[title]=true;$('#'+img).attr('src','upload/merchant/images'+data.image.url);$('#'+hide).val('images'+data.image.url);}}); 
}