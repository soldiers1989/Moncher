/**启动页面样式设定*/
function setStartCss(){
	$("#questlogin").css({
		"display":"block",
		"position":"absolute",
		"width":"100%",
		"height":"100%"
	});
	$("#startimg").css({
		"display":"block",
		"z-index":"980"
	});
	$("#startimg").attr("src","static/wechat/images/Three/startshow.jpg");
	$('#startimg').height($(window).height());	
}
/**设置切换页面css*/
function setChangeCss(){
	$(".changeCssi").css({
	    "display":"none",
		"position":"absolute",
		"width":"100%",
		"height":"100%",
		"z-index":"980",
		"margin":"0 auto"
	});
	$(".changeCssii").css({
	    "display":"none",
		"position":"absolute",
		"width":"100%",
		"height":"100%",
		"margin":"0 auto"
	});
}
/**设置返回按钮css*/
function setBackCodeCss(){
	$("#backcode").css({
		"display":"block",
		"background":"url(static/wechat/images/Three/back.png) center center /100% 42px no-repeat no-repeat",
		"width":"100%",
		"height":"42px",
		"text-align":"center",
		"line-height":"42px",
		"font-size":"16px",
		"text-align":"left",
		"text-indent":"4px",
		"line-height":"42px",
		"color":"#FFF"
	});
}
/**设置基本信息css*/
function setInfoCss(){
	$(".infoCssi").css({
      "height":"42px",
	  "width":"100%",
	  "line-height":"42px",
	  "background":"url(static/wechat/images/Three/kuang.png)  90px center /200px  36px  no-repeat",
	});
   $(".allLiCss").css({
	   "float":"left",
	   "font-family":"隶书",
	   "font-size":"20px",
	   "color":"#333",
   });
  $(".shortSelectCss").css({
	  "float":"left",
	  "font-size":"12px",
	  "color":"#333",
	  "text-indent":"24px",
	  "color":"#FFF"
  });
  $(".longTextCss").css({
	  "width":"80%",
	  "height":"30px",
	  "border":"0px solid #482403",
	  "font-size":"12px",
	  "color":"#FFF",
	  "margin-left":"20px",
	  "margin-top":"6px",
	  "background":"#482403"
  });
   $(".shortTextCss").css({
	  "height":"30px",
	  "border":"0px solid #FFF",
	  "font-size":"12px",
	  "color":"#333",
	  "background":"FFF"
  });
}
/**基础样式设定*/
function baseCss(){
	$("*").css({"margin":"0px","padding":"0px"});	
	$("a").css({"text-decoration":"none"});
	$("body").css({"background":"url(static/wechat/images/Three/info.png) center center/100% 100% no-repeat","overflow-y":"hidden","height":$(window).height()+"px"});
	$("ul").css({"list-style":"none"}); 
	$("#content").css({"position":"relative"});
	$("#sayHi").css({
		"text-indent":"24px",
		"line-height":"24px",
		"font-family":"隶书",
		"height":"120px",
		"text-align":"center",
		"line-height":"120px",
		"background":"url(static/wechat/images/Three/wen.png) center center no-repeat",
		"font-size":"42px",
		"color":"#333",
	});
	$("#quest").css({
		"padding-left":"5%",
		"padding-right":"5%",
		"font-family":"隶书"
	});
}
/**按钮基础样式*/
function buttonClass(){
	$(".button").css({
		"height":"60px",
		"line-height":"60px",
		"position":"relative",
		"top":"5px"
	});
	$(".button-1").css({
		"height":"50px",
		"line-height":"50px",
		"width":"240px",
		"background":"url(static/wechat/images/Three/button.png)  center center no-repeat",
		"text-align":"center",
		"margin":"0 auto"
	});
	$(".button-2").css({
		"color":"#FFF",
		"display":"block",
		"font-family":"隶书",
		"text-decoration":"none",
		"font-size":"20px"
	});
}
/**选择控件CSS*/
function radioCss(div){
	var height=$(document).height();
	$("#"+div+"Div").css({
		"display":"block",
		"width":"100%",
		"height":height+"px",
		"position":"absolute",
		"top":"0px",
		"left":"0px",
		"z-index":"990",
		"background":"#333",
		"opacity":"0.618"
	});
	$("#"+div+"Son").css({
		"display":"block",
		"width":"100%",
		"position":"absolute",
		 "background":"url(static/wechat/images/Three/info.png) center center/100% 100% no-repeat",
		"left":"0px",
		"z-index":"991"
	});
	$("#"+div+"Son").css("top",(height-$("#"+div+"Son").height())/2+"px");
	$("#"+div+"Son li").click(function(){
		$("#"+div+"Div").css("display","none");
		$("#"+div+"Son").css("display","none");
		$("#"+div+"Box")[0].innerHTML=$(this)[0].innerHTML.substring(0,10);
		$("#"+div+"Hidden").val($(this)[0].innerHTML);
	});	
}
/**设置题目css*/
function setQuestionCss(){
	$("#quest").css({
		"list-style":"none",
		"margin":"0",
		"padding":"0"
	});
	$("#quest-1").css({
	"padding-left":"1.5%",
	"padding-right":"1.5%",
	"padding-bottom":"5px",
	"font-size":"18px",
	"font-family":"微软雅黑",
	"color":"#333"
    }); 
}
/**设置选项css*/
function setOptionCss(){
	$("#quest-2").css({
		"padding-left":"1.5%",
		"padding-right":"1.5%"
	});
	$("#quest-2 ul").css({
		"background":"#FFF",
		"opacity":"0.618",
		"border":"1px solid #bd9a54",
		"list-style":"none",
		"width":"100%",
		"-moz-border-radius":"5px",
		" -webkit-border-radius":"5px",
		"border-radius":"5px",
		"margin":"0px",
		"padding":"0px"
	});
	$("#quest-2 li").css({
		"padding-top":"10px",
		"padding-left":"8px",
		"padding-bottom":"10px",
		"font-size":"16px",
		"font-family":"微软雅黑",
		"border-top":"1px solid #bd9a54"
	});
	$("#quest-2 li:first").css("border-top","0px"); 
	$("#quest-2 li label").css({"display":"block","width":"90%","float":"left"}); 
	$("#quest-2 li input:radio").css("float","left");
	$("#quest-2 li input:checkbox").css("float","left");
}
/**设置操作员css*/
function setHeaderCss(){
	$(".goBack").css({
		"display":"block",
		"background":"url(static/wechat/images/Three/goback.png) center center /100% 42px no-repeat",
		"width":"100%",
		"height":"42px",
		"font-size":"16px",
		"text-align":"left",
		"text-indent":"4px",
		"line-height":"42px",
		"color":"#FFF"
	});
	$(".goBackii").css({
		"display":"block",
		"background":"url(static/wechat/images/Three/back.png) center center /100% 42px no-repeat",
		"width":"100%",
		"height":"42px",
		"font-size":"16px",
		"text-align":"left",
		"text-indent":"4px",
		"line-height":"42px",
		"color":"#FFF"
	});
 $(".operator").css({
	  "display":"block",
	  "width":"100%",
	  "height":"150px",
	  "margin-top":"12px",
	  "margin-bottom":"12px",
	  "border":"0px solid #FFF",
 });
$(".userText").css({
	"font-size":"14px",
	"text-align":"center",
	"color":"#666",
	"margin-bottom":"12px"
});
}
 /**设置选项的css*/
  function setSelectCss(){
 	 $(".selectCssi").css({
		 "height":"40px",
		 "font-size":"16px",
		 "color":"#333",
		 "text-align":"center",
		 "width":"100%",
		 "border-top":"1px solid #DDD",
		 "line-height":"40px",
		 "font-family":"隶书"
	 });
	 $(".selectCssii").css({
	 "height":"40px",
	 "font-size":"16px",
	 "color":"#333",
	 "text-align":"center",
	 "width":"100%",
	 "border-top":"1px solid #DDD",
	 "border-bottom":"1px solid #DDD",
	 "line-height":"40px",
	 "font-family":"隶书"
	 });
  }
  /**设置性别模块css*/
  function setSexCss(index){
	var height=$(document).height();
	$("#sexid2").css({
		"display":"block",
		"width":"100%",
		"height":height,
		"position":"absolute",
		"top":"0px",
		"left":"0px",
		"z-index":"990",
		"background":"#333",
		"opacity":"0.618"
	});
	$("#sexid3").css({
		"display":"block",
		"width":"100%",
		"position":"absolute",
		"top":($("#"+index).offset().top+50)+"px",
		 "background":"url(static/wechat/images/Three/info.png) center center/100% 100% no-repeat",
		"left":"0px",
		"z-index":"991"
	});
  }
 /**设置汽车模块css*/
 function setBrandCss(){
	$(".cariLiCss").css({
	"height":"40px",
	"line-height":"40px",
	"border-bottom":
	"1px solid #FFF"
	});
	$(".cariLiSpanCss").css({
	"display":"block",
	"float":"left",
	"width":"40px"
	});
	$(".cariLiSpaniCss").css({
	"display":"block",
	"float":"left",
	"font-size":"16px",
	"color":"#333"
	});
	$(".cariLiImgCss").css({
	"height":"25px",
	"width":"25px",
	"position":"relative",
	"top":"8px"
	});
 }
 /**设置车型模块css*/
 function setCarTypeCss(){
	$("#car1-2 ul li").css({
		"height":"40px",
		"line-height":"40px",
		"font-size":"16px",
		"color":"#333",
		"border-bottom":"1px solid #FFF"
	});
	$("#car1-2 li:first").css("background","#F0F0F0");
 }
 /**点击汽车品牌css*/
 function setClickCarCss(){
	$("#car1").css({
		"display":"block",
		"height":$(window).height(),
		"z-index":"990",
		"position":"absolute",
		"top":"0px",
		"left":"0px",
		"width":"100%",
		"background":"#fff"
		});
	$("#car1-1").css({
		"background":"#F0F0F0",
		"height":$(window).height(),
		"width":"44%",
		"float":"left",
		"border-right":"1px solid #FFF",
		"overflow-y":"auto"
		})
	$("#car1-2").css({
		"background":"#F8F8F8",
		"height":$(window).height(),
		 "width":"54.5%",
		 "float":"left",
		 "overflow-y":"auto"
	});	
 }
 /**设置问卷模块css*/
 function  setModuleUlCss(){
	$(".moduleUlCss").css({
		"display":"block",
		"list-style":"none",
		"color":"#333",
		"position":"relative",
		"font-size":"16px",
		"font-family":"微软雅黑",
		"padding":"0 5%",
		"margin":"0",
		"margin-top":"6px"
	});
	$(".moduleLiCssi").css({
		"display":"block",
		"float":"left",
		"width":"33%",
	    "line-height":"18px",
		"height":"110px",
		"text-align":"center",
		"font-family":"隶书",
		"color":"#FFF"
	});
	$(".setLefts").css({"margin-left":"17%"});
	$(".moduleLabelCss").css({
			"display":"block",
			"width":"90px",
			"height":"104px",
			"margin":"0 auto",
	});
  $(".moduleLabelCss span").css({
	  "position":"relative",
	  "top":"32px"
	});
    $('.backResultCode').css({
			"padding-top":"24px",
			"padding-bottom":"12px",
		})
	$('.backResultCode p').css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"18px",
			"margin":"0",
			"line-height":"30px"
	});
		$('.clickToCode').css({
			"padding-top":"12px",
			"padding-bottom":"12px",
			"width":"100%"
		});
		$('.clickToCode p').css({
			"margin":"0",
			"text-align":"center",
			"font-size":"18px",
			"color":"#333",
			"font-weight":"bold",
			"font-family":"微软雅黑"
		});
	$('.clickToCode ul').css({
		"list-style":"none",
		"width":"30%",
		"padding":"0",
		"margin":"12px auto",
	});
	$('.clickToCode ul li').css({
		"color":"#EF7521",
		"float":"left",
		"width":"33.3%",
		"height":"50px",
		"font-size":"24px",
		"text-align":"center",
	})
 }
 /**设置选择文本css*/
 function setCheckText(){
	$(".checkText").css({
		"font-size":"14px",
		"padding":"0 7%",
		"font-size":"18px",
		"color":"#333",
		"text-align":"left",
		"text-indent":"24px",
		"line-height":"30px",
		"font-family":"隶书"
	});
	 $(".operatori").css({
		  "display":"block",
		  "width":"100%",
		  "font-family":"隶书",
		  "height":"120px",
		  "background":"url(static/wechat/images/Three/wen.png) center center no-repeat",
		  "margin":"0 auto",
		  "margin-bottom":"12px",
		  "text-align":"center",
		  "line-height":"120px",
		  "font-size":"48px"
	 });
 }
 /**设置结束文本css*/
 function setFinishTextCss(){
	$(".finishText").css({
		"display":"block",
		"width":"240px",
		"background":"url(static/wechat/images/Three/button.png)  center center no-repeat",
		"text-align":"center",
		"line-height":"50px",
		"font-size":"20px",
	    "opacity":"0.50",
		"margin":"0 auto",
		"margin-top":"20px",
		"font-family":"隶书"
	});
	$(".finishText a").css({
	   "text-decoration":"none",
	   "color":"#FFF"
	});
 }
 /**设置结束文本css*/
 function setCountTextCss(){
	$(".countText").css({
		"display":"block",
		"width":"240px",
		"background":"url(static/wechat/images/Three/button.png)  center center no-repeat",
		"position":"absolute",
		"text-align":"center",
		"z-index":"982",
		"line-height":"50px",
		"font-size":"18px",
		"left":($(window).width()-240)/2+"px",
		"font-family":"隶书",
		"top":($(window).height()-60)+"px"
	});	
	$(".countText a").css({
	   "text-decoration":"none",
	   "color":"#FFF"
	});	
 }
 /**设置引导页面css*/
 function setMakeLeadCss(){
	$(".goBacki").css({
		"display":"block",
		"z-index":"982",
		"position":"absolute",
		"top":"0px",
		"left":"0px",
		"background":"url(static/wechat/images/Three/back.png) center center /100% 42px no-repeat",
		"width":"100%",
		"height":"42px",
		"font-size":"16px",
		"text-align":"left",
		"text-indent":"4px",
		"line-height":"42px",
		"color":"#FFF" 
	});
	$('#leadshowImg').css({"margin-top":"28px","width":$(window).width()+"px","height":($(window).height()-28)+"px"});
 }
 /**设置统计页面css*/
 function setCountShowCss(){
	$("#countShowCase p").css({
		"font-size":"18px",
		"margin":"0",
		"padding":"0",
		"width":"96%",

		"margin-bottom":"8px",
		"color":"#333",
		"font-family":"隶书",
		"text-align":"center",
	});
	 $(".operatori").css({
	  "display":"block",
	  "width":"100%",
	  "font-family":"隶书",
	  "height":"120px",
	  "background":"url(static/wechat/images/Three/wen.png) center center no-repeat",
	  "margin":"0 auto",
	  "margin-bottom":"12px",
	  "text-align":"center",
	  "line-height":"120px",
	  "font-size":"48px"
 });
 }