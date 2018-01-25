<div class="row" >
	<div class="col-md-12">
		<h1 class="page_title"><?php echo _('Slider cho nội dung'); ?></h1>
	</div>
	<form action="" method="post">
		
		<div class="col-md-6">
			<div class="row dashboard_box">
				<div class="list-form-input">
					<?php
						global $hmcontent;
						foreach($hmcontent->hmcontent as $content){
							$content_name = $content['content_name'];
							$content_key = $content['content_key'];
							
							$args = array(
								'nice_name'=>'Áp dụng cho '.$content_name,
								'name'=>'include_content_'.$content_key,
								'input_type'=>'select',
								'input_option'=>array(
														array('value'=>'yes','label'=>'Có'),
														array('value'=>'no','label'=>'Không'),
													),
								'default_value'=>get_option( array('section'=>'content_slider','key'=>'include_content_'.$content_key,'default_value'=>'yes') ),
							);
							build_input_form($args);
							
						}
					?>
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="row dashboard_box">
				<div class="form-group"> 
					<?php
					$args = array(
						'nice_name'=>'Chọn kiểu hiển thị',
						'name'=>'jquery_plugin',
						'input_type'=>'select',
						'input_option'=>array(
												array('value'=>'galleria','label'=>'Galleria'),
												array('value'=>'fancybox','label'=>'Fancybox'),
											),
						'default_value'=>get_option( array('section'=>'content_slider','key'=>'jquery_plugin','default_value'=>'galleria') ),
					);
					build_input_form($args);
					?>
				</div>
				<div class="form-group jquery_plugin_setting jquery_plugin_galleria"> 
					<?php
					$args = array(
						'nice_name'=>'Độ cao mặc định của slider',
						'name'=>'galleria_height',
						'input_type'=>'number',
						'required'=>FALSE,
						'default_value'=>get_option( array('section'=>'content_slider','key'=>'galleria_height','default_value'=>'600') ),
					);
					build_input_form($args);
					?>
				</div>
				<div class="form-group jquery_plugin_setting jquery_plugin_fancybox" style="display:none"> 
					<?php
					$default = "'transitionIn'	:	'elastic', "."\n".
								"'transitionOut'	:	'elastic', "."\n".
								"'speedIn'		:	600, "."\n".
								"'speedOut'	:	200, "."\n".
								"'overlayShow'	:	false "."\n";
					$args = array(
						'nice_name'=>'Option fancybox',
						'name'=>'fancybox_setting',
						'input_type'=>'textarea',
						'required'=>FALSE,
						'default_value'=>get_option( array('section'=>'content_slider','key'=>'fancybox_setting','default_value'=>$default) ),
					);
					build_input_form($args);
					?>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="form-group"> 
				<button name="save_setting" type="submit" class="btn btn-primary"><?php echo _('Lưu cài đặt'); ?></button>
			</div>
		</div>
		
	</form>
</div>
<script>
$(document).ready(function(){
	var plugin = '<?php echo get_option( array('section'=>'content_slider','key'=>'jquery_plugin','default_value'=>'galleria') ); ?>';
	$('.jquery_plugin_setting').hide();
	$('.jquery_plugin_'+plugin).show();
	$('select[name=jquery_plugin]').change(function(){
		var plugin = $(this).val();
		$('.jquery_plugin_setting').hide();
		$('.jquery_plugin_'+plugin).show();
	});
});
</script>