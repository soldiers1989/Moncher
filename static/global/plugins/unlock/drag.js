/* 
 * drag 1.0
 * create by tony@jentian.com
 * date 2015-08-18
 * 拖动滑块
 */
(function($){
    $.fn.drag=function(f){
        var x, drag = this, isMove = false;
        //添加背景，文字，滑块
        var html = '<div class="drag_bg"></div>'+ '<div class="drag_text" onselectstart="return false;" unselectable="on">拖动滑块验证</div>'+ '<div class="handler handler_bg"></div>';
        this.append(html);
        /**集体赋值*/
        var handler = drag.find('.handler'),	drag_bg = drag.find('.drag_bg'), 	text = drag.find('.drag_text');
        /**滑动的最大位置*/
        var maxWidth = drag.width() - handler.width();
        /**按下鼠标时启动滑动*/
        handler.mousedown(function(e){isMove = true; x= e.pageX - parseInt(handler.css('left'), 10);});
        /**当鼠标滑动时*/
        $(document).mousemove(function(e){
            var _x = e.pageX - x;
            /**移动距离大于0小于最大间距，滑块x轴位置等于鼠标移动距离*/
            isMove  &&  ((( _x > 0  && _x < maxWidth) && (handler.css({'left': _x}) && drag_bg.css({'width': _x})))  || (_x >= maxWidth && end()));
        }).mouseup(function(e){
            isMove = false;
            var _x = e.pageX - x;
            /**移动距离小于最大间距，滑动块恢复原位*/
            _x < maxWidth  && (handler.css({'left': 0})  &&  drag_bg.css({'width': 0}));
        });
        /**验证成功事件*/
        function end(){
        	var status=f();
        	if(status){
                handler.removeClass('handler_bg').addClass('handler_ok_bg');text.text('验证通过');drag.css({'color': '#fff'});isMove = false;
                handler.unbind('mousedown');$(document).unbind('mousemove');$(document).unbind('mouseup');
        	}else{
	            handler.removeClass('handler_ok_bg').addClass('handler_bg');text.text('验证失败');drag.css({'color': '#323232'});isMove = false;
	        	handler.css({'left': 0})  &&  drag_bg.css({'width': 0});
        	}
        }
    };
})(jQuery);


