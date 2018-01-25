<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/datatables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/custom.css">
<div class="col-md-12">
	<form action="" method="post">
		
		<div class="col-md-12">
			<p class="page_action"><?php echo hme_lang('edit_product_attributes'); ?></p>
			<div class="row dashboard_box">
				<div class="list-form-input">
					<div class="col-md-9">
					<?php
						$args = array(
							'nice_name'=>'Tên nhóm thuộc tính',
							'name'=>'group_name',
							'input_type'=>'text',
							'required'=>FALSE,
							'addClass'=>'quick_save_option_group_name',
							'default_value'=>$data['data_group']->name,
						);
						build_input_form($args);
					?>
					</div>
					<div class="group_isset_option_panel">
						<ul>
						<?php
						foreach($data['data_option'] as $option){
							echo '<li class="isset_option isset_option_'.$option->id.'">';
							if(is_numeric($option->option_image)){
							echo '	<img class="option_image" src="'.get_file_url($option->option_image).'" >';
							}
							echo '	<input class="quick_save_option_name" data-id="'.$option->id.'" value="'.$option->name.'" >
									<button type="button" data-id="'.$option->id.'" class="quick_delete_option btn btn-danger btn-xs pull-right">Xóa</button>
								  </li>';
						}
						?>
						</ul>
					</div>
					<div class="group_add_option_panel">
						<div class="row">
							<div class="col-md-6">
								<?php
								$args = array(
									'nice_name'=>'Tên thuộc tính',
									'name'=>'option_name',
									'input_type'=>'text',
								);
								build_input_form($args);
								?>
							</div>
							<div class="col-md-3">
								<?php
								$args = array(
									'nice_name'=>'Ảnh thuộc tính',
									'name'=>'option_image',
									'input_type'=>'image',
								);
								build_input_form($args);
								?>
							</div>
							<div class="col-md-3">
								<div class="form-group"> 
									<div class="form-group-handle"></div><label for="field_append">Hành động</label>
									<button name="add_option" type="submit" class="form-control btn btn-info"><?php echo _('Thêm thuộc tính'); ?></button>
								</div>
							</div>
						</div>
					</div>
					
					
				</div>
			</div>
		</div>

	</form>
</div>
<script>
$(document).ready(function () {
	$('.quick_save_option_group_name').change(function(){
		var id = '<?php echo hm_get('id'); ?>';
		var value = $(this).val();
		var href = '?run=ajax.php&key=hme_ajax';
		$.post(href,{action:'save_option_group_name',id:id,value:value},function(data){
			$.notify('Đã lưu tên mới cho nhóm', { globalPosition: 'top right',className: 'success' } );
		});
	});
	$('.quick_save_option_name').change(function(){
		var id = $(this).attr('data-id');
		var value = $(this).val();
		var href = '?run=ajax.php&key=hme_ajax';
		$.post(href,{action:'save_option_name',id:id,value:value},function(data){
			$.notify('Đã lưu tên mới cho thuộc tính', { globalPosition: 'top right',className: 'success' } );
		});
	});
	$('.quick_delete_option').click(function(){
		var id = $(this).attr('data-id');
		var href = '?run=ajax.php&key=hme_ajax';
		$.post(href,{action:'delete_option',id:id},function(data){
			$('.isset_option_'+id).remove();
			$.notify('Đã xóa thuộc tính', { globalPosition: 'top right',className: 'success' } );
		});
	});


});
</script>