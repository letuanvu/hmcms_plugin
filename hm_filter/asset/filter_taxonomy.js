$(document).ready(function(){
	
	var number_order = 1;
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    };
    $(".filter_step_1_pad").sortable({
        helper: fixHelperModified,
		placeholder: "filter_value_line_highlight",
    }).disableSelection();
	$('.filter_step_1_pad').on('sortupdate',function(){ 
		var href = '?run=ajax.php&key=hm_filter_ajax';
		$('.filter_step_1_pad input.filter_number_order').each(function(index){
			$(this).val(index+1);
			var number_order = $(this).val();
			var id = $(this).attr('data-id');
			$.post( href, { action:'sort_group',id:id,number_order:number_order }, function( data ) {
				
			});
		});
	});
	
	 $(".filter_step_2_pad").sortable({
        helper: fixHelperModified,
		placeholder: "filter_value_line_highlight",
    }).disableSelection();
	$('.filter_step_2_pad').on('sortupdate',function(){ 
		var href = '?run=ajax.php&key=hm_filter_ajax';
		$('.filter_step_2_pad input.filter_option_taxonomy_number_order').each(function(index){
			$(this).val(index+1);
			var number_order = $(this).val();
			var id = $(this).attr('data-id');
			$.post( href, { action:'sort_group_option',id:id,number_order:number_order }, function( data ) {
				
			});
		});
	});
	
	$(document).on('click', 'span.filter_group_taxonomy_value_submit', function(){
		
		var id = $(this).attr('data-id');
		var val = $('input.filter_group_taxonomy_value_input').val();
		var href = '?run=ajax.php&key=hm_filter_ajax';
		$('.filter_step_1_pad').html('Đang xử lý dữ liệu ...');	
		$.post( href, { action:'add_group',id:id,val:val }, function( data ) {
			$('.filter_step_1_pad').html(data);	
			$('input.filter_group_taxonomy_value_input').val('');
		});
		
	});
	
	$(document).on('click', 'b.remove_filter_group_taxonomy', function(){
		
		var id = $(this).attr('data-id');
		var r = confirm("Bạn có chắc muốn xóa nhóm lọc này và toàn bộ lựa chọn trong nó không ?, sau khi xóa không thể phục hồi lại được");
		if (r == true) {
			var href = '?run=ajax.php&key=hm_filter_ajax';
			$.post( href, { action:'del_group',id:id }, function( data ) {
				$('.filter_step_1_pad .filter_value_line_'+id).remove();
				$('.filter_step_2_pad').html('');	
			});
		}
		
	});
	
	$(document).on('change', '.edit_filter_group_taxonomy', function(){
		
		var id = $(this).attr('data-id');
		var old_name = $('.filter_group_taxonomy[data-id='+id+']').attr('data-label');
		var new_name = $(this).val();
		if (new_name != null) {
			var href = '?run=ajax.php&key=hm_filter_ajax';
			$.post( href, { action:'edit_group',id:id,new_name:new_name }, function( data ) {
				$.notify('Đã lưu tên nhóm lọc', { globalPosition: 'top right',className: 'success' } );
			});
		}
		
	});
	
	$(document).on('change', '.edit_filter_group_taxonomy_input_type', function(){
		
		var id = $(this).attr('data-id');
		var type = $(this).val();
		var href = '?run=ajax.php&key=hm_filter_ajax';
		$.post( href, { action:'edit_group_input_type',id:id,type:type }, function( data ) {
			$.notify('Đã đổi hình thức chọn', { globalPosition: 'top right',className: 'success' } );
		});
		
	});
	
	$(document).on('change', '.edit_filter_option_taxonomy', function(){
		
		var id = $(this).attr('data-id');
		var old_name = $('.filter_option_taxonomy[data-id='+id+']').attr('data-label');
		var new_name = $(this).val();
		if (new_name != null) {
			$.notify('Đang cập nhật lại dữ liệu', { globalPosition: 'top right',className: 'warning' } );
			var href = '?run=ajax.php&key=hm_filter_ajax';
			$.post( href, { action:'edit_group_option',id:id,new_name:new_name }, function( data ) {
				$.notify('Đã lưu tên option', { globalPosition: 'top right',className: 'success' } );
			});
		}
		
	});
	
	$(document).on('click', 'span.filter_group_taxonomy', function(){

		var id = $(this).attr('data-id');
		var href = '?run=ajax.php&key=hm_filter_ajax';
		$('.filter_step_2_pad').html('Đang xử lý dữ liệu ...');	
		$.post( href, { action:'group_option_list',id:id }, function( data ) {
			$('.filter_step_2_pad').html(data);	
		});
		
	});
	
	$(document).on('click', 'span.filter_option_taxonomy_value_submit', function(){
		
		var id = $(this).attr('data-id');
		var val = $('input.filter_option_taxonomy_value_input').val();
		var href = '?run=ajax.php&key=hm_filter_ajax';
		$('.filter_step_2_pad').html('Đang xử lý dữ liệu ...');	
		$.post( href, { action:'group_option_add',id:id, val:val }, function( data ) {
			$('.filter_step_2_pad').html(data);	
		});
		
	});
	
	
	$(document).on('click', 'b.remove_filter_option_taxonomy', function(){
		
		var id = $(this).attr('data-id');
		var r = confirm("Bạn có chắc muốn xóa lựa chọn này không ?, sau khi xóa không thể phục hồi lại được");
		if (r == true) {
			var href = '?run=ajax.php&key=hm_filter_ajax';
			$.post( href, { action:'del_group_option',id:id }, function( data ) {
				$('.filter_option_taxonomy_value_line_'+id).remove();
			});
		}
		
	});
	
	$(document).on('click', '.ajaxFormTaxonomyAdd button[name=submit]', function(){
		$('.filter_step_1_pad').html('');	
		$('.filter_step_2_pad').html('');	
	});
	
	$(document).on('click', 'ul.taxonomy_list.tree input', function(){
		$('.ajax_filter_content').html('');
		var sThisVal = '';
		$('ul.taxonomy_list.tree input').each(function () {
			var sThisVal = (this.checked ? $(this).val() : "");
			if(sThisVal != ''){
				var href = '?run=ajax.php&key=hm_filter_ajax';
				$.post( href, { action:'filter_content',id:sThisVal }, function( data ) {
					$('.ajax_filter_content').append(data);
				});
			}
		});
	});
	
});