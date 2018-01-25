$(document).ready(function(){
	$('.product_option_group_item input').click(function(){
		$('.product_option_list_content').text('Đang làm mới dữ liệu ...');
		var allVals = [];
		$('.product_option_group_item input:checked').each(function() {
			allVals.push($(this).val());
		});
		var href = '?run=ajax.php&key=hme_ajax';
		var content = $('.product_option_group_list').attr('data-id');
		$.post(href,{action:'load_option_checkbox_list',id:allVals,content:content},function(data){
			$('.product_option_list_content').html(data);
		});
	});
});