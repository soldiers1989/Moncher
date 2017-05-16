/**异步请求数据方法*/
function Fa(url,data){
	var message;
	$.ajax({type: "POST",url: U+'index.php'+url,async: false,
			  data: data,success:function(msg){message=msg;}
	});
	return message;
}
jQuery(document).ready(function(){
	jQuery('.skillbar').each(function(){
		jQuery(this).find('.skillbar-bar').animate({
			width:jQuery(this).attr('data-percent')
		},2000);
	});
});