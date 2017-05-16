/**启动控制器*/
function action(){
/*选择车主性别*/
$("#sexid1").on("click",function(){setSexCss('sexid1');});
/*勾选车主性别*/
$("#sexid3 li").on("click",function(){
	$("#sexid2").css("display","none");
	$("#sexid3").css("display","none");
	$("#sexid5")[0].innerHTML=$(this)[0].innerHTML;
	$("#sex").val($(this).attr("sexv"));
});	
/**点击车型创建品牌*/
$("#car2").click(function(){
	createCarBrand();
	$("#car1").css({"display":"block","background":"url(static/wechat/images/Three/info.png) center center/100% 100% no-repeat","font-family":"微软雅黑"});
	$("#car1").css("height",$("#car1-1 ul").height());
	$("#car1").css("z-index","992");
	$("#car1-1").css("height",$("#car1-1 ul").height());
	$("#car1-7").css("height",$(window).height()); 
});
/*点击进入程序*/
$("#questlogin").on("click",function(){indexShow();});
}
/**创建车辆品牌*/
function createCarBrand(){ 
		var brand=eval('(' + getCarBrand() + ')');
		 $("#car1-1 ul")[0].innerHTML='';
		 $("#car1-7").css({"display":"block"});
		for(var key in brand){
			$("#car1-7 ul").append("<li bcode='"+key+"'>"+key+"</li>");
			$("#car1-7 ul li").css({"width":"100%","text-align":"center","margin-top":"8px","color":"#333"});
			$("#car1-1 ul").append("<div id='brandCode"+key+"' style='height:40px;line-height:40px;border-bottom:1px solid #FFF;color:#FFF;font-size:18px;text-indent:12px;'>"+key+"</div>");
			$.each(brand[key],function(fn,brandData){
				$("#car1-1 ul").append("<li carv1='"+brandData.id+"'  rank='"+brandData.rank+"' style='height:40px;line-height:40px;border-bottom:1px solid #FFF;'>"+
															"<span style='display:block;float:left;width:40px;'>&nbsp;&nbsp;"+
															"<img src='"+brandData.logo+"' style='height:25px;width:25px;position:relative;top:8px;'></span>"+
															"<span style='display:block;float:left;font-size:16px;color:#333;'>&nbsp;&nbsp;"+(brandData.name).substr(0, 10)+"</span>"+
															"<div style='clear:both;'></div>"+
															"</li>");
			 });			
		}
		$("#car1-7 ul li").click(function(){
			$(document).scrollTop($("#brandCode"+$(this).attr('bcode')).offset().top);
		});
		clickCreateCarType();
}
/**点击创建汽车品牌车型*/
function clickCreateCarType(){
	$("#car1-1 li").click(function(){
		createCarType($(this).attr("carv1"));
		jsonData.brandId=$(this).attr("carv1");
		jsonData.rank=$(this).attr("rank");
	 });
}
 /**创建车辆分类*/ 
function createCarType(cbid){
	$(document).scrollTop(0);
	var typeList=eval('(' + getCarType(cbid) + ')');
	$("#car1").css("height",$("#questmain").height()+30+"px");
	$("#car1-1").css({"width":"100%","height":$("#questmain").height()+30+"px"});
	$("#car1-7").css({"display":"none"});
	$("#car1-1 ul").css("height",$("#questmain").height()+30+"px");
	$("#car1-1 ul")[0].innerHTML='';
	if(typeList.length>0){
		$.each(typeList,function(fn,typeData){
			$("#car1-1 ul").append(
				"<li carv2='"+typeData.id+"' style='height:40px;line-height:40px;font-size:16px;color:#333;border-bottom:1px solid #FFF;'>"+
				"&nbsp;&nbsp;"+typeData.name+"</li>"
			);
		}); 
		$("#car1-1 li:first").css({"background":"#FFF","opacity":"0.382","color":"#000"});
		$("#car1-1 ul li").click(function(){
		   $(this).css({"background":"#FFF","opacity":"0.382","color":"#000"});
			$("#car3")[0].innerHTML=$.trim($(this).text());
			$("#carid").val($(this).attr("carv2")); 
			$("#car1").css("display","none");
		});
	}
}
/**创建试题答案*/
function  setOptions(we){
	var answerList=we.options;
	var answerItem='';
	$.each(answerList,function(fn,answerData){
		if(we.we.type=="1"){/**单选*/ 
		answerItem=answerItem+"<li><input  type='radio'  name='radioResult'  value='"+answerData.id+"'  textlog='"+answerData.type+"' sonflag='"+
						  answerData.labels+"' parentid='"+we.we.id+"' id='option"+answerData.id+"'/>&nbsp<label for='option"+answerData.id+"'>"+answerData.name+"</label><div style='clear: both;'></div></li>";
		}else if(we.we.type=="2"){/**多选*/
		answerItem=answerItem+"<li><input type='checkbox'  name='checkboxResult' value='"+answerData.id+"'  sonflag='"+
						  answerData.labels+"' parentid='"+we.we.id+"' id='option"+answerData.id+"'/>&nbsp<label for='option"+answerData.id+"'>"+answerData.name+"</label><div style='clear: both;'></div></li>";
		}else if(we.we.type=="3"){/**填空*/
		answerItem=answerItem+"<textarea id='textareaResult'  valueId='"+answerData.id+"'  sonflag='"+answerData.labels+"' parentid='"+we.we.id+ 
			  "' style='width:98%;height:80px;font-size:16px;color:#333;font-family:微软雅黑;border:1px solid #FFF;margin-top:1px;'>.</textarea>"; 
		}
	});
	return answerItem;
}
/**创建一级试题*/
function createQuestion(we){
	$("#questmain")[0].innerHTML='';
	infoId=we.we.id;
	var index,mainRoom,buttonText,imgurl;
	imgurl=we.we.index==1?'operator'+[92,93,94,95,96][findModuleInfo(jsonData.questionnaireId)]+'.png':'operators'+[92,93,94,95,96][findModuleInfo(jsonData.questionnaireId)]+'.png';
	if(we.we.index>0){
		index=we.we.index;buttonText='下一题';
	}else{
		index=we.we.index*-1;submitStatus=true;buttonText='提交结果';
	}
	$("#questmain").append('<div class="goBack" onclick="javascript:indexShow();"></div>');
	$("#questmain").append("<div id='operator' class='operator'><img src='static/wechat/images/Three/"+imgurl+"'  height='150' style='display:block;margin:0 auto;'></img></div>");
	mainRoom="<div class='mainRoomCss'><ul id='quest'>"+
						  "<li  id='quest-1' >"+we.we.name+"<input type='hidden' name='answerid'  questype='"+we.we.type+"'  value='"+ we.we.id+"'/></li>"+
						  "<li  id='quest-2' ><ul>"+setOptions(we)+"</ul></li>"+
						  "</ul></div>";
	$("#questmain").append(mainRoom);
	$("#questmain").append('<div id="button" class="button"><div id="button-1" class="button-1"><a  id="button-2" class="button-2" href="javascript:void(0);" onclick="nextToQuestion()">'+buttonText+'</a></div></div>');
	setHeaderCss();
	setQuestionCss();
	setOptionCss();
	buttonClass();
}
/**保存基础信息*/
function baseInfo(validStatus){
	var baseMess={"carid":'请选择您的车型',"sex":'请选择性别',"ageHidden":'请选择年龄范围',"yearHidden":'请选择购车年限',"moneHidden":'请选择年输入范围',"educHidden":'请选择学历信息',"vocaHidden":'请选择职业类别'};
	for(var key  in  baseMess ){
		if($.trim($("#"+key).val()).length<=0){
			validStatus=false;
			message=baseMess[key];
			break;
		}
	}
	return validStatus;
}
/**检测题题*/
function checkContentWithValid(){
	var validStatus=true;
	if(!checkStatus){ 
	//--判断基础信息是否填写完整
	 validStatus=baseInfo(validStatus);
	 if(validStatus) startTime(validStatus);
	}else if(checkStatus&&!submitStatus){
	 validStatus=nextTo(validStatus);
	}else if(checkStatus&&submitStatus){
	 validStatus=nextTo(validStatus);
	}
	return validStatus; 
}
/**筛选题判断*/
function excQuestType(excanswer){
	if($(excanswer).attr("sonflag")=='1') alert('您暂不符合我们的调研范围，谢谢参与！'); window.location.reload();
}
/**判断是否勾选*/
function nextTo(validStatus){
	var box=false;
	var questype=$("#quest-1 input").attr("questype");
	if(questype=="3"){/*检测填空题*/
		valueId=-1;
		if($.trim($('#textareaResult').val()).length<=0){
			validStatus=false;
		}else{
			if($.trim(answJosnData).length<=0){
			    answJosnData='{"id":"'+$('#textareaResult').attr("valueId")+'","parentid":"'+$('#textareaResult').attr("parentid")+'","value":"'+$('#textareaResult').val()+'"}';
			}else{
				answJosnData=answJosnData+',{"id":"'+$('#textareaResult').attr("valueId")+'","parentid":"'+$('#textareaResult').attr("parentid")+'","value":"'+$('#textareaResult').val()+'"}';
		    }  
		}
	}else if(questype=="2"){/*检测多选题*/
		valueId=-1;
	    $.each($("#quest-2  input[name='checkboxResult']:checkbox"),function(fn,item){
			if($(item)[0].checked){
				box=true;
				if($.trim(answJosnData).length<=0){
					answJosnData='{"id":"'+$(item).val()+'","parentid":"'+$(item).attr("parentid")+'","value":"1"}';
				}else{
					answJosnData=answJosnData+',{"id":"'+$(item).val()+'","parentid":"'+$(item).attr("parentid")+'","value":"1"}';
				}  
			 }
		});
	if(!box) validStatus=false; 
	}else if (questype=="1"){/*检测单选题*/
		if($.trim($('#quest-2 input:radio[name="radioResult"]:checked').val()).length<=0){
			validStatus=false;
		}else{
			if($.trim(answJosnData).length<=0){
			    answJosnData='{"id":"'+$('#quest-2 input:radio[name="radioResult"]:checked').val()+'","parentid":"'+$('#quest-2 input:radio[name="radioResult"]:checked').attr("parentid")+'","value":"1"}';
			}else{
				answJosnData=answJosnData+',{"id":"'+$('#quest-2 input:radio[name="radioResult"]:checked').val()+'","parentid":"'+$('#quest-2 input:radio[name="radioResult"]:checked').attr("parentid")+'","value":"1"}';
		    }  
		} 
	    valueId=$('#quest-2 input[name="radioResult"]:checked').val();
	}	
	return validStatus;
}
/**执行下一题*/
function nextToQuestion(){  
	if(checkContentWithValid()){
		if(submitStatus) {submitAnswer(); return ; }
		if(checkid){createQuestion(eval('(' + getAlls(questionid,infoId,valueId) + ')'));} 
	}else{
		if(message=="") alert("请您将信息填写完整或选择相应的答案！"); else alert(message); 
	} 
}
/**退出提醒页面*/
function dieMessage(){confirm("确认结束本次调研？")  &&   window.location.reload();}
/**提交答案方法*/
function submitAnswer(){
	jsonData.endTime=getNowFormatDate();
	$.ajax({
	   type: "POST",  url:$('base').attr('href')+"collection/WeChat/added",  async: false,
	   data:{"userdata":JSON.stringify(jsonData),"answdata":"["+answJosnData+"]"},
	   success:function(json){
			answJosnData="";
			jsonData=eval('(' + json + ')');
			$('#questmain,#wechatbg').css('display','none');$('#readshow')[0].innerHTML='';$('#readshow').css('display','block');
			submitStatus=false;
			makeReadShow(jsonData['questionnaireId'],jsonData['resultScore'],jsonData['resultAllScore']);
		}
	});
}
/**首页点击方法*/
function indexShow(){
	$("#questlogin,#endIndex,#leadshow,#endshow,#countshow,#questmain").css("display","none");
	if(jsonData.historyScore.length>0){
		checkStatus=true;
		$('#readshow')[0].innerHTML='';
		$('#sayHi,#backcode,#questmain').css('display','none');
		$('#readshow').css('display','block');
		makeReadShow(0,5,5);
	}else{
		var status=jsonData.questionnaireId>0;
		jsonData.questionnaireId=0;
	    status ?makeReadShow(0,5,5):$('#questmain').css('display','block');
	}
}
/**获取当前时间*/
function getNowFormatDate(){
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9){month = "0" + month;}
    if (strDate >= 0 && strDate <= 9){strDate = "0" + strDate;}
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate+ " " + date.getHours() + seperator2 + date.getMinutes()+ seperator2 + date.getSeconds();
    return currentdate;
} 
/**保存基础信息*/
function startTime(validStatus){
 if (validStatus){ 
	userJosnData="";
	answJosnData=""; 
	checkStatus=true;
	jsonData.age=$("#ageHidden").val();
	jsonData.sex=$("#ageHidden").val();
	jsonData.carId=$("#carid").val();
	jsonData.year=$("#yearHidden").val();
	jsonData.vocation=$("#vocaHidden").val();
	jsonData.money=$("#moneHidden").val();
	jsonData.education=$("#educHidden").val();
	//jsonData.latitude,json.longitude;
	if($("#sex").val()==1){sexcode=5;}else if($("#sex").val()==2){sexcode=6;}
	$('#sayHi,#backcode,#questmain').css('display','none');
	$("#readshow")[0].innerHTML='';
	makeReadShow(0,5,5);
	}
}
/**执行引导模块*/
function leadOpen(){
	$("body").css("background","url(static/wechat/images/Three/ques.jpg) repeat-y");
	$("body div").css("display","none");$('#questmain').css({'display':'block'});
	checkid=true;
	createQuestion(eval('(' + getAlls(questionid,0,0) + ')'));
}
/**执行答题模块*/
function openOne(questid){
	checkid=false;
	questionid=questid;
	$("body div").css("display","none");
	$('#readshow').css('display','none');
	$('#leadshow').css('display','block');
    jsonData.beginTime=getNowFormatDate();
	jsonData.questionnaireId=questid;
	findModuleInfo(questid);
	makeLeadShow(questid);
	return;
}
/**生成选择文本*/
function toLabels(thinkStr){
	thinkStr='<ul class="moduleUlCss">';
	var tree={"服务顾问":'<span>兵将<br/>实力</span>',"服务设施":'<span>粮草<br/>辎重</span>',"维修质量":'<span>战力<br/>技能</span>',"维修时间":'<span>攻城<br/>效率</span>',"维修价格":'<span>赋税<br/>征收</span>'};
	for(var i=0;i<jsonData.models.length;i++){
		 if(!history(jsonData.models[i]['questionnaireId'])){
			thinkStr+='<li class="moduleLiCssi" style="position:relative;'+(i==3?'margin-left:16.6%;':'')+'"><label  for="radio1"  id="label'+jsonData.models[i]['questionnaireId']+'" class="moduleLabelCss" style="background:url(static/wechat/images/Three/modeli.png) center center /104px 104px no-repeat;" 	thinkId="'+jsonData.models[i]['questionnaireId']+'">'+tree[jsonData.models[i]['title']]+'</label ><div style="width:100%;text-align:center;position:absolute;top:90px; color:#0C0F02;font-family:隶书;letter-spacing:5px;font-weight:bold;">'+jsonData.models[i]['title']+'</div></li>';
		}else{
			thinkStr+='<li class="moduleLiCssi" style="position:relative;'+(i==3?'margin-left:16.6%;':'')+'"><label for="radio1"  id="label'+jsonData.models[i]['questionnaireId']+'" class="moduleLabelCss" style="background:url(static/wechat/images/Three/model.png)  center center /104px 104px no-repeat;" 		thinkId="'+jsonData.models[i]['questionnaireId']+'">'+tree[jsonData.models[i]['title']]+'</label ><div style="width:100%;text-align:center;position:absolute;top:90px;color:#0C0F02;font-family:隶书;letter-spacing:5px;font-weight:bold;">'+jsonData.models[i]['title']+'</div></li>';
		} 
	}
	thinkStr+='<li style="clear:both"></li></ul>';
	return thinkStr;
}
/**传入ID判断历史是否存在*/
function history(questionnaireId){
    var status=true;
	if (jsonData.historyScore.length<=0) return true;
	for(var i=0;i<jsonData.historyScore.length;i++){
		if(questionnaireId==jsonData.historyScore[i]['questionnaireId']){
			status=false;
			break;
		}
	}
	return status;
}
/**传入获取问卷内容*/
function findModuleInfo(questionnaireId){
	for(var i=0;i<jsonData.models.length;i++){
		if(questionnaireId==jsonData.models[i]['questionnaireId']){
			jsonData.moduleId=jsonData.models[i]['moduleId'];
			jsonData.moduleTitle=jsonData.models[i]['title'];
			jsonData.primitive=jsonData.models[i]['weight'];
			return i;
		}
	}
}
/**移除点击样式*/
function removeClick(){
	for(var i=0;i<jsonData.models.length;i++){
		var  id=jsonData.models[i]['questionnaireId'];
		 !history(id) ? $("#label"+id).off("click"):$("#label"+id).on("click",function(){openOne($(this).attr('thinkId'));});
    }
}
/**生成引导页面*/
function makeLeadShow(questid){
	$("#leadshow")[0].innerHTML='';
	$("#leadshow").append('<div onclick="javascript:indexShow();" class="goBacki"></div>');
	for(var i=0;i<jsonData.models.length;i++){
		questid== jsonData.models[i]['questionnaireId'] && $("#leadshow").append('<img  id="leadshowImg"src="static/wechat/images/Three/O'+(i+1)+'.jpg" width="100%" style="display:block;"/>');
	}
	$("#leadshowImg").click(function(){leadOpen();});
	setMakeLeadCss();
}
/**生成基础信息*/
function makeReadShow(showIndex,messArray1,messArray2){
	var index;
	$("body div").css("display","none");
	$("#readshow").css({"display":"block","background":"url(static/wechat/images/Three/main.jpg) left center/100% 100% no-repeat"});
	$("#readshow")[0].innerHTML='';
	$("#readshow").append('<div onclick="javascript:dieMessage();" class="goBackii"></div>');
	setHeaderCss();
	if(showIndex==0){
	    $("#readshow").append("<div id='operator' class='operatori'>以材试之</div>");
		$("#readshow").append('<div id="checkText" class="checkText">您是我军第<span style="color:#EF7521;font-size:24px;font-weight:bold;">'+jsonData.size+'</span>位诸葛军师，请选择您擅长的模块给予主公指点：<br /></div>');
		setCheckText();
	}else{
		var resultText="<p>诸葛军师，您对我军<span style='color:red;'>"+jsonData.moduleTitle+"</span>的<br />评分为:<span>"+messArray1+"</span></p>"+
								  "<p>“诸葛军师团”，对我军<span style='color:red;'>"+jsonData.moduleTitle+"</span>的<br />综合评分为:<span>"+messArray2+"</span></p>"+
								  "<p style='margin:0;text-align:center;'>【<span style='font-weight:bold;color:red;'>"+jsonData.moduleTitle+"</span>&nbsp满分100分】</p>";
		 resultText+=["","<p><span style='color:red;text-align:center;'>听君一言，茅塞顿开<br />军师请继续指教</span></p>",
								"<p><span style='color:red;text-align:center;'>听闻军师之高见，令备折服<br />军师请继续指教</span></p>",
								"<p><span style='color:red;text-align:center;'>军师之才果然非同反响<br/>令备拔云见日<br />军师请继续指教</span></p>",
								"<p><span style='color:red;text-align:center;'>军师有经天纬地之才<br/>包揽乾坤之志<br />军师请继续指教</span></p>"][jsonData.historyScore.length];
		$("#readshow").append('<div class="backResultCode">'+resultText+'</div>');
	}
	var  thinkStr;
	if(jsonData.historyScore.length<=0){
		$("#readshow").append(toLabels(thinkStr));
		removeClick();
	}else if(jsonData.historyScore.length>=5){
		countShow();
	}else if(jsonData.historyScore.length<5   &&  jsonData.historyScore.length>0 ){
		$("#readshow").append(toLabels(thinkStr));
		removeClick();
	}
	setModuleUlCss();setFinishTextCss();$("#readshow").css("height",$(document).height());
}
/**结束统计页面*/
function countShow(){
	$("#countshow")[0].innerHTML='';
	$("body div").css("display","none");
	$("#countshow").css({"display":"block","margin":"0","padding":"0px","background":"url(static/wechat/images/Three/main.jpg) left center/100% 100% no-repeat"});
	var imgurl='operator'+sexcode+'.png';
	var youself='';
	for(var i=0;i<jsonData.historyScore.length;i++){
		youself+="<p>您对我军<span style='color:#EF7521;'>"+jsonData.historyScore[i]['title']+"</span>的评分为:"+jsonData.historyScore[i]['score']+"分</span></p>";
	}
	$("#countshow").append('<div onclick="javascript:indexShow();" class="goBackii"></div>');
	$("#countshow").append("<div id='operator' class='operatori'>功成名就</div>");
	$("#countshow").append('<div id="countShowCase">'+youself+'</div>');
	$("#countshow").append('<div class="countText"><a  href="javascript:toLinkUrl();"  style="color:#333;">感谢参与</a></div>');
	setCountTextCss(); setHeaderCss(); setCountShowCss();
}