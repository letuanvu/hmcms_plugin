<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/express_form/asset'; ?>/style.css">
<script type="text/javascript" src="<?php echo BASE_URL.HM_PLUGIN_DIR.'/express_form/asset'; ?>/main.js" charset="UTF-8"></script>
<div class="row" >
	<div class="col-md-12">
		<h1 class="page_title"><?php echo _('Tạo form mới'); ?></h1>
	</div>
	<?php
	if(hm_get('insert_error')){
		echo '<div class="col-md-12"><div class="alert alert-danger" role="alert">Có lỗi, vui lòng thử lại</div></div>';
	}
	?>
	<form action="" method="post">
		
		<div class="col-md-12">
			<div class="row">
				<?php
					$args = array(
						'nice_name'=>'Tiêu đề form',
						'name'=>'form_name',
						'input_type'=>'text',
						'required'=>TRUE,
						'default_value'=>'',
					);
					build_input_form($args);
				?>
			</div>
			<div class="row">
				<div class="express_form_content">
						
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab1">Biểu mẫu</a></li>
						<li><a data-toggle="tab" href="#tab2">Thiết lập mail</a></li>
						<li><a data-toggle="tab" href="#tab3">Thông báo</a></li>
					</ul>
					<div class="tab-content">
						<div id="tab1" class="tab-pane fade in active">
							<div class="tab_container">
								<div class="btn-group">
									<span class="btn btn-default btn-xs popup_input" data-input-type="text">text</span>
									<span class="btn btn-default btn-xs popup_input" data-input-type="textarea">textarea</span>
									<span class="btn btn-default btn-xs popup_input" data-input-type="email">email</span>
									<span class="btn btn-default btn-xs popup_input" data-input-type="number">number</span>
									<span class="btn btn-default btn-xs popup_input" data-input-type="hidden">hidden</span>
									<span class="btn btn-default btn-xs popup_input" data-input-type="date">date</span>
									<span class="btn btn-default btn-xs popup_input" data-input-type="dropdown">dropdown</span>
									<span class="btn btn-default btn-xs insert_input_captcha" data-input-type="captcha">captcha</span>
									<span class="btn btn-default btn-xs insert_input_submit" data-input-type="submit">submit</span>
								</div>
								<div class="express_form_description">
									<p>Các biểu mẫu được thể hiện dưới dạng shortcode, bạn có thể tự viết thêm HTML vào template dưới đây</p>
								</div>
								<div class="express_form_template">
									<textarea name="form_template"></textarea>
								</div>
							</div>
						</div>
						<div id="tab2" class="tab-pane fade">
							<div class="tab_container">
								<?php
									$args = array(
										'nice_name'=>'Email nhận thông báo',
										'name'=>'form_email_address',
										'input_type'=>'text',
										'default_value'=>get_option( array('section'=>'system_setting','key'=>'admin_email','default_value'=>'admin@'.$_SERVER['SERVER_NAME']) ),
									);
									build_input_form($args);
									
									$args = array(
										'nice_name'=>'Tiêu đề email',
										'name'=>'form_email_subject',
										'input_type'=>'text',
									);
									build_input_form($args);
									
									$args = array(
										'nice_name'=>'Nội dung email',
										'name'=>'form_email_content',
										'input_type'=>'textarea',
									);
									build_input_form($args);
								?>
							</div>
						</div>
						<div id="tab3" class="tab-pane fade">
							<div class="tab_container">
								<?php
									$args = array(
										'nice_name'=>'Vị trí thông báo',
										'name'=>'form_noti_message_location',
										'input_type'=>'select',
										'default_value'=>'bottom',
										'input_option' => array(
															array(
																'value' => 'top',
																'label' => 'Bên trên from'
															),
															array(
																'value' => 'bottom',
																'label' => 'Bên dưới from'
															),
															array(
																'value' => 'alert',
																'label' => 'Alert'
															),
														),
									);
									build_input_form($args);
								
									$args = array(
										'nice_name'=>'Gửi form thành công',
										'name'=>'form_submit_success_message',
										'input_type'=>'text',
										'default_value'=>'Thông điệp của bạn đã được gửi',
									);
									build_input_form($args);
									
									$args = array(
										'nice_name'=>'Gửi form thất bại',
										'name'=>'form_submit_error_message',
										'input_type'=>'text',
										'default_value'=>'Có lỗi xảy ra, vui lòng thử lại',
									);
									build_input_form($args);
									
									$args = array(
										'nice_name'=>'Sai mã captcha',
										'name'=>'captcha_error_message',
										'input_type'=>'text',
										'default_value'=>'Bạn nhập sai mã captcha',
									);
									build_input_form($args);
							
								?>
							</div>
						</div>
					</div>
						
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<input type="submit" class="btn btn-primary" name="submit" value="Tạo form">
			</div>
		</div>
	</form>
	<?php
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/input_popup/text.php');
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/input_popup/textarea.php');
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/input_popup/email.php');
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/input_popup/number.php');
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/input_popup/hidden.php');
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/input_popup/date.php');
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/input_popup/dropdown.php');
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/input_popup/file.php');
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/input_popup/captcha.php');
	?>
</div>