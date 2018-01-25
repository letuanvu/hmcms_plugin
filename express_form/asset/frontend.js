$(document).ready(function(){
	$('[data-datepicker]').each(function() {
		var options = { dateFormat: "yy-mm-dd"};
		var additionalOptions = $(this).data("datepicker");
		jQuery.extend(options, additionalOptions);
		$(this).datepicker(options);
	});
});
var options = { 
	success:showResponse 
}; 
function showResponse(responseText, statusText, xhr, $form)  { 
	var express_form_alert = $('input[name=express_form_alert]').val();
	if(express_form_alert == '1'){
		var obj = jQuery.parseJSON( responseText );
		alert(obj.message);
	}else{
		var obj = jQuery.parseJSON( responseText );
		$('.express_form_ajax_result').html( obj.message );
	}
	if(obj.status == 'success'){
		$('.express_form_submit').hide();
		$('.express_form_captacha_img').hide();
		$('.express_form_captcha').hide();
	}
}
$(".express_form_ajax").ajaxForm(options); 