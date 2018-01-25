<div class="express_form_popup express_form_popup_dropdown">
		
	<?php
	$args = array(
		'nice_name' => 'Tên biểu mẫu',
		'handle'=> FALSE,
		'name'=>'label',
		'input_type'=>'text',
	);
	build_input_form($args);
	
	$args = array(
		'nice_name' => 'Tên biến POST',
		'handle'=> FALSE,
		'name'=>'name',
		'input_type'=>'text',
	);
	build_input_form($args);

	$args = array(
		'nice_name' => 'Giá trị mặc định',
		'handle'=> FALSE,
		'name'=>'dropdownpicker_value',
		'input_type'=>'text',
		'addClass' => 'express_form_dropdownpicker',
		'description'=>'Bạn có thể lấy theo phương thức GET hoặc POST bằng các điền vào theo cấu trúc : get|parameter hoặc post|parameter, ví dụ  get|tensanpham',
	);
	build_input_form($args);
	
	$args = array(
		'nice_name' => 'Các lựa chọn',
		'handle'=> FALSE,
		'name'=>'options',
		'input_type'=>'textarea',
		'default_value'=>'yes|Có,no|Không',
		'description'=>'
		Cấu trúc: <br> 
		Lựa chọn 1,Lựa chọn 2 = <br> 
		&lt;option&gt;Lựa chọn 1&lt;/option&gt;
		&lt;option&gt;Lựa chọn 2&lt;/option&gt; <br> 
		Hoặc: value1|Lựa chọn 1,value2|Lựa chọn 2  = <br> 
		&lt;option value="value1"&gt;Lựa chọn 1&lt;/option&gt;
		&lt;option value="value2"&gt;Lựa chọn 2&lt;/option&gt;',
	);
	build_input_form($args);
	
	$args = array(
		'nice_name' => 'Class của biểu mẫu',
		'handle'=> FALSE,
		'name'=>'class',
		'input_type'=>'text',
	);
	build_input_form($args);
	
	$args = array(
		'nice_name' => 'ID của biểu mẫu',
		'handle'=> FALSE,
		'name'=>'id',
		'input_type'=>'text',
	);
	build_input_form($args);
	?>
	<button class="btn btn-default add_form_input_dropdown">Thêm biểu mẫu vào form</button>
	<button class="btn btn-danger close_form_popup">Hủy</button>
</div>


<script>
$(document).ready(function(){
	/* input dropdown */
	$('.express_form_popup_dropdown input[name=label]').change(function(){
		var url = '?run=content_ajax.php&action=ajax_slug';
		var val = $(this).val();
		$.post( url, { val:val , accented:'false' , object:'0' }, function( data ) {
			$('.express_form_popup_dropdown input[name=name]').val(data);
		});
	});
	$('.add_form_input_dropdown').click(function(){
		
		var input_attr = '';
		var label = $('.express_form_popup_dropdown input[name=label]').val();
		var name = $('.express_form_popup_dropdown input[name=name]').val();
		var options = $('.express_form_popup_dropdown textarea[name=options]').val();
		var cssclass = $('.express_form_popup_dropdown input[name=class]').val();
		var id = $('.express_form_popup_dropdown input[name=id]').val();
		if(name!=''){
			input_attr = input_attr+'&name='+name;
		}else{
			alert('Tên biến POST không thể để trống');
			return;
		}
		if(options!=''){
			input_attr = input_attr+'&options='+options;
		}
		if(cssclass!=''){
			input_attr = input_attr+'&class='+cssclass;
		}
		if(id!=''){
			input_attr = input_attr+'&id='+id;
		}
		var line = label+"\n"+'[shortcode=express_form&type=dropdown'+input_attr+"]\n";
		var old_val = $('.express_form_template textarea').val();
		$('.express_form_template textarea').val(old_val+line);
		reset_field('dropdown');
		$('.popup_overlay').hide();
		$('.express_form_popup').hide();
	});
});
</script>