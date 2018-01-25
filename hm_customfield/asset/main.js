$(document).ready(function(){
	
	$('.ajax_field_append_select').change(function(){
		
		var type = $(this).val();
		var id = $(this).attr('data-id');
		var href = '?run=ajax.php&key=hm_customfield_ajax';
		$.post(href,{action:'ajax_field_append', type:type},function(data){
			$('.ajax_field_append[data-id='+id+']').html(data);
		});

	});
	
	$('.ajax_field_type_select').change(function(){
		
		var type = $(this).val();
		var id = $(this).attr('data-id');
		var href = '?run=ajax.php&key=hm_customfield_ajax';
		$.post(href,{action:'ajax_field_type', type:type},function(data){
			$('.ajax_field_type[data-id='+id+']').html(data);
		});

	});
	
	$('.ajax_field_name').change(function(){
		
		var name = $(this).val();
		var id = $(this).attr('data-id');
		var href = '?run=ajax.php&key=hm_customfield_ajax';
		if(id=='0'){
			$.post(href,{action:'ajax_field_key', name:name},function(data){
				$('.ajax_field_key[data-id='+id+']').val(data);
			});
		}

	});	
	
	$('.ajax-del-field').click(function(){
		var id = $(this).attr('data-id');
		var href = '?run=ajax.php&key=hm_customfield_ajax';
		$.post(href,{action:'del_field', id:id},function(data){
			window.location.href = window.location.href;
		});
	});
	
});