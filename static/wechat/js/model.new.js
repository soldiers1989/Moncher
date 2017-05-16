/**获取试题以及选项*/
function getAlls(id,qid,vid){
	var we; 
	$.ajax({type: "GET", url: $('base').attr('href')+"collection/WeChat/getQuestionOne", async: false,
				   data: "id="+id+"&qid="+qid+"&vid="+vid,success:function(msg){we=msg;}});
	return we;
}
/**获取车品牌*/
function getCarBrand(){
	var carBrandList;
	$.ajax({type: "POST",url: $('base').attr('href')+"collection/WeChat/getBrand", async: false,
					data: "brandid=0",success:function(cb){carBrandList=cb;}});
	return carBrandList;
}
/**获取车类型*/
function getCarType(cbid){
	var carTypeList;
	$.ajax({type: "POST",url: $('base').attr('href')+"collection/WeChat/getBrand", async: false,
					data: "brandid="+cbid,success:function(ct){carTypeList=ct;}});
	return carTypeList;
}