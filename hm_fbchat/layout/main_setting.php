<div class="row" >
	<div class="col-md-12">
		<h1 class="page_title"><?php echo _('Cài đặt Chat FaceBook'); ?></h1>
	</div>
	<form action="" method="post">
		
		
		<div class="col-md-6">
			<div class="row admin_mainbar_box">
				<div class="list-form-input">
					<?php
						$args = array(
							'nice_name'=>'Tên khung chat',
							'name'=>'boxtitle',
							'input_type'=>'text',
							'required'=>TRUE,
							'default_value'=>get_option( array('section'=>'hm_fbchat','key'=>'boxtitle','default_value'=>'Hỗ trợ trực tuyến') ),
						);
						build_input_form($args);
						
						$args = array(
							'nice_name'=>'Link Fanpage FaceBook',
							'name'=>'fanpage',
							'input_type'=>'text',
							'required'=>TRUE,
							'default_value'=>get_option( array('section'=>'hm_fbchat','key'=>'fanpage','default_value'=>'') ),
						);
						build_input_form($args);
						
						$args = array(
							'nice_name'=>'Tự động bật lên',
							'name'=>'auto_popup',
							'input_type'=>'select',
							'input_option'=>array(
													array('value'=>'yes','label'=>'Có'),
													array('value'=>'no','label'=>'Không'),
												),
							'default_value'=>get_option( array('section'=>'hm_fbchat','key'=>'auto_popup','default_value'=>'yes') ),
						);
						build_input_form($args);
						
						$args = array(
							'nice_name'=>'Bật lên sau (giây)',
							'name'=>'auto_popup_delay',
							'input_type'=>'number',
							'required'=>TRUE,
							'default_value'=>get_option( array('section'=>'hm_fbchat','key'=>'auto_popup_delay','default_value'=>'5') ),
						);
						build_input_form($args);
						
						$background = get_option( array('section'=>'hm_fbchat','key'=>'background','default_value'=>'#0065BF') );
					?>
					<div class="form-group" data-input-name="background" data-order="0">
						<div class="form-group-handle"></div>	<label for="background">Màu khung chat</label>
						<input required="" name="background" type="color" class="form-control " id="background" placeholder="" value="<?php echo $background; ?>">
					</div>
				</div>
			</div>
		</div>
		
		
		
		<div class="col-md-12">
			<div class="form-group"> 
				<button name="save_fbchat_setting" type="submit" class="btn btn-primary"><?php echo _('Lưu cài đặt'); ?></button>
			</div>
		</div>
		
	</form>
</div>