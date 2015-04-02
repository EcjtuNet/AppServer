$(document).ready(function(){
	$(document).mousemove(function(event) {
        x_offset = event.pageX - $(document).width()/2;
        y_offset = event.pageY - $(document).height()/2;
        $("img.logo").each(function( index ) {
                  $(this).css('top', y_offset/parseFloat($(this).attr('data-move')));
                  $(this).css('left', x_offset/parseFloat($(this).attr('data-move')));
        });
    });
});