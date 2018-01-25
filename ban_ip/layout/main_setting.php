<div class="row" >
	<div class="col-md-12">
		<h1 class="page_title"><?php echo _('Ban IP'); ?></h1>
	</div>
	<form action="" method="post">
		
		<div class="col-md-6">
			<div class="row admin_mainbar_box">
				<div class="list-form-input">
					<?php
						$args = array(
							'nice_name'=>'List IP, cách nhau bằng dấu phẩy',
							'name'=>'ips',
							'input_type'=>'textarea',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'ban_ip','key'=>'ips','default_value'=>'') ),
						);
						build_input_form($args);
					?>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="form-group"> 
				<button name="ban_ip_save_config" type="submit" class="btn btn-primary"><?php echo _('Lưu cài đặt'); ?></button>
			</div>
		</div>
		
	</form>
</div>