$(document).ready(function(){
	$('#meta_description').keyup(function(){
		var content = $(this).val();
		var content_length = content.length;
		$(this).parents('.hm-form-group').find('.input_description').text('Độ dài '+content_length+' ký tự (khuyến nghị 156 ký tự)');
	});
});