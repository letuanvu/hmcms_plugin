$(document).ready(function(){
	
	$('.nivoslider_config_bar').perfectScrollbar();
	
	$('.quick_save_slide').click(function(){
		var id = $(this).attr('data-id');
		var slider_id = $(this).attr('data-slider_id');
		var link = $('.list_slides_content .link_'+id).val();
		var target_blank = $('.list_slides_content .target_blank_'+id).val();
		var href = '?run=ajax.php&key=nivoslider_ajax';
		$.post(href,{action:'save_slide',id:id,slider_id:slider_id,link:link,target_blank:target_blank},function(data){
			$.notify('Đã lưu chỉnh sửa', { globalPosition: 'top right',className: 'success' } );
		});
	});
	
	$('.quick_delete_slide').click(function(){
		var id = $(this).attr('data-id');
		var slider_id = $(this).attr('data-slider_id');
		var href = '?run=ajax.php&key=nivoslider_ajax';
		$.post(href,{action:'delete_slide',id:id,slider_id:slider_id},function(data){
			$('.list_slides_content tr[data-id='+id+']').remove();
			$.notify('Đã xóa slide', { globalPosition: 'top right',className: 'success' } );
		});
	});
	
	//sortable list content
	$( ".list_slides_content" ).sortable({
		
	});
	$(".list_slides_content").on('sortupdate',function(){ 
		var order = [];
		var slider_id = $(".list_slides_content").find('.quick_save_slide').attr('data-slider_id');
		$('.list_slides_content tr').each(function(index){ 
			var id = $(this).attr('data-id');
			order.push(id);
		});
		var href = '?run=ajax.php&key=nivoslider_ajax';
		$.post(href,{action:'order_slide',order:order,slider_id:slider_id},function(data){
			$.notify('Đã lưu thứ tự slide', { globalPosition: 'top right',className: 'success' } );
		});
	});
	
});