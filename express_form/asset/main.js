var reset_field = function(input_type){
	$('.express_form_popup_'+input_type+' input[type=text]').val('');
	$('.express_form_popup_'+input_type+' input[type=email]').val('');
	$('.express_form_popup_'+input_type+' input[type=number]').val('');
	$('.express_form_popup_'+input_type+' input[type=password]').val('');
	$('.express_form_popup_'+input_type+' input[type=checkbox]').prop('checked', false); 
	$('.express_form_popup_'+input_type+' input[type=radio]').prop('checked', false); 
	$('.express_form_popup_'+input_type+' textarea').val('');
	$('.express_form_popup_'+input_type+' .note-editable').html('');
	$('.express_form_popup_'+input_type+' .preview_media_file').html('');
}
$(document).ready(function(){
	$(document).on('click', '.close_form_popup', function(){
		var input = $(this).attr('data-input-type');
		$('.popup_overlay').hide();
		$('.express_form_popup').hide();
	});
	$(document).on('click', '.popup_input', function(){
		var input = $(this).attr('data-input-type');
		$('.popup_overlay').show();
		$('.express_form_popup_'+input).show();
	});
	$(document).on('click', '.insert_input_captcha', function(){
		var line = 'captcha'+"\n"+'[shortcode=express_form&type=captcha'+"]\n";
		var old_val = $('.express_form_template textarea').val();
		$('.express_form_template textarea').val(old_val+line);
	});
	$(document).on('click', '.insert_input_submit', function(){
		var line = '[shortcode=express_form&type=submit&value=Gửi'+"]\n";
		var old_val = $('.express_form_template textarea').val();
		$('.express_form_template textarea').val(old_val+line);
	});
	$(document).on('click', '.popup_overlay', function(){
		$('.popup_overlay').hide();
		$('.express_form_popup').hide();
	});
	$(document).on('click', '.ajax-remove-form-contact', function(){
		var r = confirm("Bạn có chắc không?");
		if (r == true) {
			var href = $(this).attr('data-href');
			$.post( href, function( data ) {
				window.location.href = window.location.href;
			});
		}
	});
	$(document).on('click', '.ajax-remove-form', function(){
		var r = confirm("Bạn có chắc không?");
		if (r == true) {
			var href = $(this).attr('data-href');
			$.post( href, function( data ) {
				window.location.href = window.location.href;
			});
		}
	});
});