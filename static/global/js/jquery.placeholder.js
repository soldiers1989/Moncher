/** jQuery placeholder, fix for IE6,7,8,9*/
var  Placeholder= {
    /**检测是否存在placeholder*/
    _check : function(){
        return 'placeholder' in document.createElement('input');
    },
    /**初始化placeholder*/
    init : function(){
    	!this._check() && this.fix();
    },
    /**修复placeholder*/
    fix : function(){
        jQuery(':input[placeholder]').each(function(index, element){
            var self = $(this), txt = self.attr('placeholder');
            self.wrap($('<div></div>').css({position:'relative', zoom:'1', border:'none', background:'none', padding:'none', margin:'none'}));
            var pos = self.position(), h = self.outerHeight(true), paddingleft = self.css('padding-left');
            var holder = $('<span></span>').text(txt).css({position:'absolute', left:pos.left, top:pos.top, height:h,paddingTop:'8px', paddingLeft:'0px', color:'#999',textIndent:'12px',fontFamily:"微软雅黑"}).appendTo(self.parent());
            self.focusin(function(e){ holder.hide();}).focusout(function(e) { !self.val() && holder.show();});
            holder.click(function(e) { holder.hide();self.focus();});
        });
    }
};