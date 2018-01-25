<div class="row" >
	<div class="col-md-12">
		<h1 class="page_title"><?php echo _('Cài đặt Popup'); ?></h1>
	</div>
	<form action="" method="post">
		
		
		<div class="col-md-3">
			<div class="row dashboard_box">
				<div class="list-form-input">
					<?php
						$args = array(
							'nice_name'=>'Bật tắt',
							'name'=>'active',
							'input_type'=>'select',
							'input_option'=>array(
													array('value'=>'yes','label'=>'Bật'),
													array('value'=>'no','label'=>'Không'),
												),
							'default_value'=>get_option( array('section'=>'custombox','key'=>'active','default_value'=>'yes') ),
						);
						build_input_form($args);
					?>
				</div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="row dashboard_box">
				<div class="list-form-input">
					<?php
						$args = array(
							'nice_name'=>'Hiển thị ở',
							'name'=>'display_on',
							'input_type'=>'select',
							'input_option'=>array(
													array('value'=>'home','label'=>'Trang chủ'),
													array('value'=>'all','label'=>'Mọi trang'),
												),
							'default_value'=>get_option( array('section'=>'custombox','key'=>'display_on','default_value'=>'home') ),
						);
						build_input_form($args);
					?>
				</div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="row dashboard_box">
				<div class="list-form-input">
					<?php
						$args = array(
							'nice_name'=>'Lặp lại',
							'name'=>'display_repeat',
							'input_type'=>'select',
							'input_option'=>array(
													array('value'=>'once','label'=>'Chỉ một lần'),
													array('value'=>'always','label'=>'Luôn luôn'),
												),
							'default_value'=>get_option( array('section'=>'custombox','key'=>'display_repeat','default_value'=>'always') ),
						);
						build_input_form($args);
					?>
				</div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="row dashboard_box">
				<div class="list-form-input">
					<?php
						$args = array(
							'nice_name'=>'Hiệu ứng',
							'name'=>'effects',
							'input_type'=>'select',
							'input_option'=>array(
													array('value'=>'fadein','label'=>'Fadein'),
													array('value'=>'slide','label'=>'Slide'),
													array('value'=>'newspaper','label'=>'Newspaper'),
													array('value'=>'fall','label'=>'Fall'),
													array('value'=>'sidefall','label'=>'Sidefall'),
													array('value'=>'blur','label'=>'Blur'),
													array('value'=>'flip','label'=>'Flip'),
													array('value'=>'sign','label'=>'Sign'),
													array('value'=>'superscaled','label'=>'Superscaled'),
													array('value'=>'slit','label'=>'Slit'),
													array('value'=>'corner','label'=>'Corner'),
													array('value'=>'slidetogether','label'=>'Slidetogether'),
													array('value'=>'scale','label'=>'Scale'),
													array('value'=>'door','label'=>'Door'),
													array('value'=>'push','label'=>'Push'),
													array('value'=>'contentscale','label'=>'Contentscale'),
													array('value'=>'swell','label'=>'Swell'),
													array('value'=>'rotatedown','label'=>'Rotatedown'),
													array('value'=>'flash','label'=>'Flash'),
												),
							'default_value'=>get_option( array('section'=>'custombox','key'=>'effects','default_value'=>'fadein') ),
						);
						build_input_form($args);
					?>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="row dashboard_box">
				<?php
					$args = array(
						'nice_name'=>'Nội dung popup',
						'name'=>'popup_content',
						'input_type'=>'editor',
						'required'=>FALSE,
						'default_value'=>get_option( array('section'=>'custombox','key'=>'popup_content','default_value'=>'') ),
					);
					build_input_form($args);
				?>
			</div>	
		</div>
		
		<div class="col-md-12">
			<div class="form-group"> 
				<button name="save_setting" type="submit" class="btn btn-primary"><?php echo _('Lưu cài đặt'); ?></button>
			</div>
		</div>
		
	</form>
</div>