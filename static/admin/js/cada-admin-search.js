/**文本搜索框
 * 作者：张文晓
 * 时间：2017-02-24
 */
(function($) {
	$.fn.autocomplete = function(params) {	
		var currentSelection = -1;
		var currentProposals = [];
		params = $.extend({hints: [],placeholder: '搜索',width: 120,findId:'id',height: 16,showButton: false,buttonText: false,onSubmit: function(text){},onBlur: function(){}}, params);
		var liCss={"width":"100%","background":"#FFF","border-left":"1px dashed #ddd","border-bottom":"1px dashed  #DDD","border-right":"1px dashed #ddd",};
		var findCss={"opacity":"1","position":"absolute","width":params.width+"px","z-index":"212","display":"block","top":$(this).offset().top+30,"left":$(this).offset().left};
		var divCss={"opacity":"1","width":params.width+"px","height":"150px","overflow-y":"auto","overflow-x":"hidden"};
		var ulCss={"position":"relative","z-index":"999","width":"100%","padding":"0","background":"#FFF","list-style":"none","line-height":"30px","text-indent":"12px","margin-bottom":"0","opacity":"1","z-index":"999"};
		this.each(function() {
			var searchContainer = $('<div class="Find"></div>').css(findCss);
			var input=$(this);
			var proposals=$('<div></div>').css(divCss).css('top', input.height() + 20);
			var proposalList = $('<ul></ul>').css(ulCss);
			proposals.append(proposalList);
			input.bind("change paste keyup", function(e){
				if(e.which != 13 && e.which != 27 && e.which != 38 && e.which != 40){				
					currentProposals = [];
					currentSelection = -1;
					proposalList.empty();
					if(input.val() != ''){
						var word = "^" + input.val() + ".*";
						proposalList.empty();
						for(var test in params.hints){
							if(params.hints[test].match(word)){
								currentProposals.push(params.hints[test]);	
								var element = $('<li></li>').html(params.hints[test]).css(liCss).click(function(){$(this).css('display','none');input.val($(this).html());proposalList.empty();params.onSubmit(input.val());});
								proposalList.append(element);
							}
						}
					}
				}
			});
			input.blur(function(e){currentSelection = -1;params.onBlur();});
			searchContainer.append(proposals);		
			$('body').append(searchContainer);
		});
		return this;
	};
})(jQuery);