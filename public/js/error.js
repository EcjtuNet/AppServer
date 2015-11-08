$(document).ready(function(){
	$(document).mousemove(function(event) {
        x_offset = event.pageX - $(document).width()/2;
        y_offset = event.pageY - $(document).height()/2;
        $("img.logo").each(function( index ) {
                  $(this).css('top', y_offset/parseFloat($(this).attr('data-move')));
                  $(this).css('left', x_offset/parseFloat($(this).attr('data-move')));
        });
    });

    var list = ['日新网手机客户端', '请在技术人员指导下食用'];
    var i = 0;
    setInterval(function() {
    	i = i==0? 1:0;
    	document.title = list[i];
    }, 2000);
});