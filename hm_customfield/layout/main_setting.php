<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL.'/'.HM_PLUGIN_DIR.'/hm_customfield/asset'; ?>/style.css">
<script type="text/javascript" src="<?php echo SITE_URL.'/'.HM_PLUGIN_DIR.'/hm_customfield/asset'; ?>/main.js" charset="UTF-8"></script>

<div class="row" >
	<div class="col-md-12">
		<h1 class="page_title"><?php echo _('Quản lý trường tùy biến'); ?></h1>
	</div>
	<?php
	if(is_array($data)){
	foreach($data as $field){
		$id = $field->id;
		$section = $field->section;
		$key = $field->key;
		$value = json_decode($field->value);
	?>
	<form action="" method="post">
		<div class="customfield_line">
			<div class="row">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<div class="col-md-2">
					<?php
					$args = array(
						'nice_name'=>'Tên trường',
						'name'=>'field_name',
						'input_type'=>'text',
						'required'=>TRUE,
						'addClass'=>'ajax_field_name',
						'addAttr'=>'data-id="'.$id.'"',
						'default_value'=>$value->field_name,
					);
					build_input_form($args);
					?>
				</div>
				<div class="col-md-2">
					<?php
					$args = array(
						'nice_name'=>'Key',
						'name'=>'field_key',
						'input_type'=>'text',
						'required'=>TRUE,
						'addClass'=>'ajax_field_key',
						'addAttr'=>'data-id="'.$id.'"',
						'default_value'=>$value->field_key,
					);
					build_input_form($args);
					?>
				</div>
				<div class="col-md-3">
					<?php
					$args = array(
						'nice_name'=>'Áp dụng cho',
						'name'=>'field_append',
						'input_type'=>'select',
						'addClass'=>'ajax_field_append_select',
						'addAttr'=>'data-id="'.$id.'"',
						'input_option'=>array(
												array('value'=>'none','label'=>'Không kích hoạt'),
												array('value'=>'content','label'=>'Kiểu nội dung'),
												array('value'=>'taxonomy','label'=>'Kiểu phân loại'),
											),
						'default_value'=>$value->field_append,
					);
					build_input_form($args);
					?>
					<div class="ajax_field_append" data-id="<?php echo $id; ?>">
						<?php
						if($value->field_append == 'content'){
							echo '<div class="form-group">'."\r\n";
							echo '	<label for="default_value">Bao gồm:</label>'."\r\n";
							hm_customfield_ajax_content('field_append_content',$value->field_append_content);
							echo '</div>'."\n\r";
						}elseif($value->field_append == 'taxonomy'){
							echo '<div class="form-group">'."\r\n";
							echo '	<label for="default_value">Bao gồm:</label>'."\r\n";
							hm_customfield_ajax_taxonomy('field_append_taxonomy',$value->field_append_taxonomy);
							echo '</div>'."\n\r";
						}
						?>
					</div>
				</div>
				<div class="col-md-3">
					<?php
					$args = array(
						'nice_name'=>'Phương thức nhập',
						'name'=>'field_type',
						'input_type'=>'select',
						'addClass'=>'ajax_field_type_select',
						'addAttr'=>'data-id="'.$id.'"',
						'input_option'=>array(
												array('value'=>'text','label'=>'Văn bản (text)'),
												array('value'=>'textarea','label'=>'Văn bản dài (textarea)'),
												array('value'=>'number','label'=>'Số (number)'),
												array('value'=>'email','label'=>'Email (email)'),
												array('value'=>'password','label'=>'Mật khẩu (password)'),
												array('value'=>'hidden','label'=>'Ẩn (hidden)'),
												array('value'=>'request_uri','label'=>'URL nội bộ (request)'),
												array('value'=>'wysiwyg','label'=>'Bộ soạn thảo (wysiwyg)'),
												array('value'=>'select','label'=>'Lựa chọn đơn (select)'),
												array('value'=>'radio','label'=>'Lựa chọn đơn (radio)'),
												array('value'=>'checkbox','label'=>'Lựa chọn nhiều (checkbox)'),
												array('value'=>'image','label'=>'Ảnh (image)'),
												array('value'=>'multiimage','label'=>'Nhiều ảnh (multiimage)'),
												array('value'=>'file','label'=>'Tệp tin (file)'),
												array('value'=>'content','label'=>'Nội dung (content)'),
												array('value'=>'taxonomy','label'=>'Phân loại (taxonomy)'),
											),
						'default_value'=>$value->field_type,
					);
					build_input_form($args);
					?>
					<div class="ajax_field_type" data-id="<?php echo $id; ?>">
						<?php 
						$has_option = array(
							'select',
							'radio',
							'checkbox',
						);
						$avanced = array(
							'content',
							'taxonomy',
						);
						$default_value='';
						if(isset($value->default_value)){
							$default_value = $value->default_value;
						}
						$data_key=array();
						if(isset($value->data_key)){
							$data_key = $value->data_key;
						}
						if(in_array($value->field_type,$has_option)){
							hm_customfield_ajax_field_type($value->field_type,$default_value,$value->input_option); 
						}elseif(in_array($value->field_type,$avanced)){
							hm_customfield_ajax_field_type($value->field_type,$default_value,$data_key); 
						}else{
							hm_customfield_ajax_field_type($value->field_type,$default_value); 
						}
						?>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group"> 
						<div class="form-group-handle"></div>
						<label for="field_append">Hành động</label>
						<div class="row">
							<button name="save_customfield_setting" type="submit" class="btn btn-success"><?php echo _('Lưu'); ?></button>
							<span class="btn btn-danger ajax-del-field" data-id="<?php echo $id; ?>"><?php echo _('Xóa'); ?></span>
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
	</form>
	<?php
	}
	}
	?>
	
		
	<form action="" method="post">
		
		<div class="customfield_line">
			<div class="row">
				<div class="col-md-2">
					<?php
					$args = array(
						'nice_name'=>'Tên trường',
						'name'=>'field_name',
						'input_type'=>'text',
						'required'=>TRUE,
						'addClass'=>'ajax_field_name',
						'addAttr'=>'data-id="0"',
					);
					build_input_form($args);
					?>
				</div>
				<div class="col-md-2">
					<?php
					$args = array(
						'nice_name'=>'Key',
						'name'=>'field_key',
						'input_type'=>'text',
						'required'=>TRUE,
						'addClass'=>'ajax_field_key',
						'addAttr'=>'data-id="0"',
					);
					build_input_form($args);
					?>
				</div>
				<div class="col-md-3">
					<?php
					$args = array(
						'nice_name'=>'Áp dụng cho',
						'name'=>'field_append',
						'input_type'=>'select',
						'addClass'=>'ajax_field_append_select',
						'addAttr'=>'data-id="0"',
						'input_option'=>array(
												array('value'=>'none','label'=>'Không kích hoạt'),
												array('value'=>'content','label'=>'Kiểu nội dung'),
												array('value'=>'taxonomy','label'=>'Kiểu phân loại'),
											),
					);
					build_input_form($args);
					?>
					<div class="ajax_field_append" data-id="0">
					
					</div>
				</div>
				<div class="col-md-3">
					<?php
					$args = array(
						'nice_name'=>'Phương thức nhập',
						'name'=>'field_type',
						'input_type'=>'select',
						'addClass'=>'ajax_field_type_select',
						'addAttr'=>'data-id="0"',
						'input_option'=>array(
												array('value'=>'text','label'=>'Văn bản (text)'),
												array('value'=>'textarea','label'=>'Văn bản dài (textarea)'),
												array('value'=>'number','label'=>'Số (number)'),
												array('value'=>'email','label'=>'Email (email)'),
												array('value'=>'password','label'=>'Mật khẩu (password)'),
												array('value'=>'hidden','label'=>'Ẩn (hidden)'),
												array('value'=>'request_uri','label'=>'URL nội bộ (request)'),
												array('value'=>'wysiwyg','label'=>'Bộ soạn thảo (wysiwyg)'),
												array('value'=>'select','label'=>'Lựa chọn đơn (select)'),
												array('value'=>'radio','label'=>'Lựa chọn đơn (radio)'),
												array('value'=>'checkbox','label'=>'Lựa chọn nhiều (checkbox)'),
												array('value'=>'image','label'=>'Ảnh (image)'),
												array('value'=>'multiimage','label'=>'Nhiều ảnh (multiimage)'),
												array('value'=>'file','label'=>'Tệp tin (file)'),
												array('value'=>'content','label'=>'Nội dung (content)'),
												array('value'=>'taxonomy','label'=>'Phân loại (taxonomy)'),
											),
					);
					build_input_form($args);
					?>
					<div class="ajax_field_type" data-id="0">
						
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group"> 
						<div class="form-group-handle"></div><label for="field_append">Hành động</label>
						<button name="save_customfield_setting" type="submit" class="form-control btn btn-info"><?php echo _('Thêm'); ?></button>
					</div>
				</div>
			</div>
		</div>
		
		
		
	</form>
</div>