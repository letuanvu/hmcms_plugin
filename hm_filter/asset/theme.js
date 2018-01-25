$(document).ready(function(){

	$(document).on('click', '.filter_wrapper ul li input', function(){
		$(this).parents('form.filter_form').submit();
	});
	$(document).on('change', '.filter_wrapper select', function(){
		$(this).parents('form.filter_form').submit();
	});

});
