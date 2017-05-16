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
	$("#startimg").attr("src","static/wechat/images/Basics/startshow.jpg");
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
		"background":"url(static/wechat/images/Basics/back.png) center center /100% 42px no-repeat no-repeat",
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
	 "opacity":"0.6",
	 "background":"#fff",
	   "border-bottom":"1px dashed  #ccc",
	   "margin-bottom":"1px"
	});
   $(".allLiCss").css({
	   "float":"left",
	   "font-family":"隶书",
	   "font-size":"16px",
	   "color":"#000",
	   "text-indent":"12px",

   });
   $("#voca").css({
	   "border-bottom":"2px solid #ccc"
   });
  $(".shortSelectCss").css({
	  "float":"left",
	  "font-size":"12px",
	  "color":"#333",
	  "text-indent":"24px",
	  "color":"#333"
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
	$("body").css({"background":"url(static/wechat/images/Basics/main.jpg) center center/100% 100% no-repeat","overflow-y":"hidden","height":$(window).height()+"px"});
	$("ul").css({"list-style":"none"}); 
	$("#content").css({"position":"relative"});
	$("#sayHi").css({
		"text-indent":"24px",
		"line-height":"24px",
		"font-family":"隶书",
		"height":"220px",
		"text-align":"center",
		"line-height":"120px",
		"margin-top":"20px",
		"background":"url(static/wechat/images/Basics/wen.png) center center no-repeat",
		"background-size": "86% 100%",
		"font-size":"42px",
		"color":"#333",
	});
	$("#car2").css({
		"margin-top":"10px",
		"width":$(window).width()+"px",
		"border-top":"2px solid #ccc"
	});
	$("#quest").css({
		"padding-left":"5%",
		"padding-right":"5%",
		"font-family":"隶书",
	
	});

	$("body").css({"background":"url(static/wechat/images/Basics/main.jpg) no-repeat","overflow-y":"hidden","height":$(document).height()+"px",
		"background-attachment":" fixed"
		});

}
$("#quest").click(function(){

		$("#quest").css({
			"opacity":"0.6"
		});
});
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
		"width":"300px",
		"background":"url(static/wechat/images/Basics/button.png)  center center no-repeat",
		"text-align":"center",
		"margin":"40px auto 10px",
		"border-radius":"9px"
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
		 "background":"url(static/wechat/images/Basics/main.jpg) center center/100% 100% no-repeat",
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
		"background":"url(static/wechat/images/Basics/back.png) center center /100% 42px no-repeat",
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
		"background":"url(static/wechat/images/Basics/back.png) center center /100% 42px no-repeat",
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
	  "margin-bottom":"35px",
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
		 "background":"url(static/wechat/images/Basics/main.jpg) center center/100% 100% no-repeat",
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
		"margin-top":"0px"
	});
	$(".moduleLiCssi").css({
		"display":"block",
		"float":"left",
		"width":"33%",
	    "line-height":"21px",
		"height":"135px",
		"margin-top":"12px",
		"text-align":"center",
		"font-family":"隶书",
		"color":"#333"
	});
	$("#timeff").css({
		"margin-left":"17%"
	});
	$(".setLefts").css({"margin-left":"17%"});
	$(".moduleLabelCss").css({
			"display":"block",
			"width":"85px",
			"height":"95px",
			"margin":"0 auto",
		
	});
  $(".moduleLabelCss span").css({
	  "position":"relative",
	  "top":"52px"
	});
    $('.backResultCode').css({
			"padding-top":"25px",
			"padding-bottom":"25px",
			"height":"150px",
			"margin-top":"24px"
		})
	$('.backResultCode p').css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"13px",
			"margin":"0",
			"line-height":"16px",
			"margin-right":"91px",
			"margin-top":"25px"
	});
	$('.backResultCode wxsjss').css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"13px",
			"margin":"0",
			"line-height":"16px",
			"margin-right":"91px",
			"margin-top":"25px"
	});
		$(".backResultCode  #wxsjpp").css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"13px",
			"margin":"0",
			"line-height":"16px",
			"margin-right":"93px"
			});	
			$(".backResultCode  #wxjpss").css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"13px",
			"line-height":"16px",
			"margin-right":"0px",
			"margin-left":"100px"
			});	
			
			$(".backResultCode  #wxjgpp").css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"13px",
			"margin-top":"5px",
			"margin-right":"0px",
			"line-height":"16px",
			"margin-left":"124px"
			});	
				$(".backResultCode  #wxzlss").css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"13px",
			"line-height":"16px",
			"margin-top":"20px",
			"margin-right":"0px",
			"margin-left":"122px"
			});	
			
			$(".backResultCode  #wxzlpp").css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"13px",
			"margin-top":"0px",
			"margin-right":"0px",
			"line-height":"16px",
			"margin-left":"130px"
			});	
			
					$(".backResultCode  #fwssss").css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"13px",
			"line-height":"16px",
			"margin-right":"0px",
			"margin-left":"107px"
			});	
			
			$(".backResultCode  #fwsspp").css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"13px",
			"margin-top":"5px",
			"margin-right":"0px",
			"line-height":"16px",
			"margin-left":"136px"
			});	
			
			$(".backResultCode  #fwgwss").css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"13px",
			"line-height":"16px",
			"margin-right":"0px",
			"margin-left":"80px"
			});	
			
			$(".backResultCode  #fwgwpp").css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"font-size":"13px",
			"margin-top":"5px",
			"margin-right":"0px",
			"line-height":"16px",
			"margin-left":"100px"
			});	
			$(".gzcc").css({
			"text-align":"center",
			"font-family":"隶书",
			"color":"#333",
			"width":"90%",
			"font-size":"18px",
			"margin":"0 auto",
			"margin-top":"20px",
			"line-height":"30px",
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
			
		  "margin":"0 auto",
		  "margin-top":"15px",
		  "margin-bottom":"30px",
		  "text-align":"center",
		  "line-height":"120px",
		  "font-size":"22px"
	 });
 }
 /**设置结束文本css*/
 function setFinishTextCss(){
	$(".finishText").css({
		"display":"block",
		"width":"240px",
		"background":"url(static/wechat/images/Basics/buttons.png)  center center no-repeat",
		"text-align":"center",
		"line-height":"40px",
		"font-size":"20px",
	    "opacity":"0.50",
		"margin":"0 auto",
		
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
		"background":"url(static/wechat/images/Basics/buttons.png)  center center no-repeat",
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
		"background":"url(static/wechat/images/Basics/back.png) center center /100% 42px no-repeat",
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
		"width":"100%",

		"margin-bottom":"8px",
		"color":"#333",
		"font-family":"隶书",
		"text-align":"center",
	});
		$("#thanks").css({
		"height":($(window).width()*0.7)+"px",
		"margin-top":"55px",
		"width":($(window).width()*0.9)+"px",
		"margin-left":"5%",
		"margin-bottom":"20px",
	});

	
	 $(".operatori").css({
	  "display":"block",
	  "width":"100%",
	  "font-family":"隶书",
	  "height":"60px",
	  "margin":"0 auto",
	  "margin-bottom":"12px",
	  "text-align":"center",
	  "line-height":"80px",
	  "font-size":"22px"
 });
 
 	 $("#ope").css({
	  "display":"block",
	  "width":"100%",
	  "font-family":"隶书",
	  "height":"120px",
	  "margin":"0 auto",
	  "margin-bottom":"12px"
 });
  	 $("#wawa").css({
	  "display":"block",
	  "width":"30%",
	
	  "height":"95px",
	  "margin":"10px auto", 
 });
   	 $("#choice").css({
	  "display":"block",
	  "width":($(window).width()*0.66)+"px",
	  "margin":"0 auto",
	  "padding-top":($(window).width()*0.45)+"px",
 });
    	 $("#choice a").css({
		  "display":"block",
		  "background":"#6FE4FB",
		  "margin":"0 auto",
		  "padding":"14px 45px",
		  "color":"#fff",
		  "float":"left",
		  "border-radius":"4px",
		  "text-decoration":"none"
 });
     	 $("#not").css({
	  "display":"block",
	  "color":"#686868",
	  "background":"#fff",
	  "border":"1px solid #686868",
	  "border-radius":"4px",
	  "margin-left":"10px"
	  
 });
     	 $("#contact").css({
	  "display":"block",
	  "width":"90%",
	  "height":"40%",
	  "margin-top":"40px",
	  "margin-bottom":"40px",
	  "margin-left":"3%"
 });
      	 $("#youname").css({
	  "display":"block",
	  "width":"80%",
	  "height":"40px",
	  "border":"2px solid #ccc",
	  "line-height":"40px",
	  "margin-left":"10%",
	   "border-radius":"4px",
	   "background":"#fff",
	   "color":"#000"
 });
		$("#youname span").css({
			"margin-left":"5px",
			"font-size":"16px",
			"letter-spacing": "2px",
			"font-weight ":"bold "
		});
		      	 $("#youphone").css({
	  "display":"block",
	  "width":"80%",
	  "height":"40px",
	  "border":"2px solid #ccc",
	  "line-height":"40px",
	  "margin-left":"10%",
	   "border-radius":"4px",
	   "margin-top":"10px",
	   "background":"#fff",
	   "'opacity":"0.6"
 });
 		$("#youphone span").css({
			"margin-left":"5px",
			"font-size":"16px",
			"letter-spacing": "2px",
			"font-weight ":"bold "
		});
		 		$("#but").css({
			  "display":"block",
	  "width":"90%",
	  "height":"50px",
		"background":"#3399FF",
	  "line-height":"50px",
	  "margin-left":"5%",
	   "border-radius":"5px",
	   "margin-top":"30px",
	   "text-align":"center",
	   "color":"#fff",
	   "font-weight ":"bold "
		});
			$("#youphone input").css({ 
					  "width":"45%",
					  "height":"30px",
					  "letter-spacing":"2px",
					"font-size":"16px",
					  "line-height":"30px",
					  "margin-left":"10px",
					"border":"none",
					
		});
					$("#youname input").css({
						"font-size":"16px",
					  "width":"45%",
					  "height":"30px",
					   "letter-spacing":"2px",
					  "line-height":"30px",
					  "margin-left":"10px",
					"border":"none",
					
		});
 }