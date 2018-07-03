jQuery(document).ready(function($){
 	
 	$(".dashicons-set div.dashicons").click(function () {

        var before_content = $(this).data('before');
        $(".dashicons-set div.dashicons").removeClass('selected');
	    $(this).addClass('selected');
	    $('#selected_icon').val(before_content);

    });
});