<div class="row" >
	<div class="col-md-12">
		<h1 class="page_title"><?php echo _('Cài đặt bình luận FaceBook'); ?></h1>
	</div>
	<form action="" method="post">
		
		
		<div class="col-md-6">
			<div class="row admin_mainbar_box">
				<div class="list-form-input">
					<?php
						$args = array(
							'nice_name'=>'Số bình luận mặc định',
							'name'=>'number_cmt',
							'input_type'=>'number',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_fbcmt','key'=>'number_cmt','default_value'=>'5') ),
						);
						build_input_form($args);
						
						$args = array(
							'nice_name'=>'Facebook AppID',
							'name'=>'appid',
							'input_type'=>'text',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_fbcmt','key'=>'appid','default_value'=>'') ),
						);
						build_input_form($args);
						
					?>
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="row admin_mainbar_box">
				<div class="list-form-input">
					<?php
						global $hmcontent;
						foreach($hmcontent->hmcontent as $content){
							
							$content_field = $content['content_field'];
							$args = array(
								'nice_name'=>'Vị trí hiển thị áp dụng cho '.$content['content_name'],
								'name'=>'location_'.$content['content_key'],
								'input_type'=>'select',
								'input_option'=>array(
														array('value'=>'hidden','label'=>'Không hiển thị'),
													),
								'default_value'=>get_option( array('section'=>'hm_fbcmt','key'=>'location_'.$content['content_key'],'default_value'=>'') ),
							);
							foreach($content_field as $field){
								$args['input_option'][] = array('value'=>$field['name'],'label'=>$field['nice_name']);
							}
							build_input_form($args);
							
						}
					?>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="form-group"> 
				<button name="save_fbcmt_setting" type="submit" class="btn btn-primary"><?php echo _('Lưu cài đặt'); ?></button>
			</div>
		</div>
		
	</form>
</div>