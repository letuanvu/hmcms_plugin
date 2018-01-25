<div class="row" >
	<div class="col-md-12">
		<h1 class="page_title"><?php echo _('Banner chạy dọc'); ?></h1>
	</div>
	<form action="" method="post">
		
		<div class="col-md-4">
			<div class="row dashboard_box">
				<?php
				$args = array(
					'nice_name'=>'Độ rộng thân trang',
					'name'=>'site_wrapper_width',
					'input_type'=>'number',
					'required'=>TRUE,
					'default_value'=>get_option( array('section'=>'float_banner','key'=>'site_wrapper_width','default_value'=>'1170') ),
				);
				build_input_form($args);
				?>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row dashboard_box">
				<?php
				$args = array(
					'nice_name'=>'Độ rộng quảng cáo trái',
					'name'=>'banner_left_width',
					'input_type'=>'number',
					'required'=>TRUE,
					'default_value'=>get_option( array('section'=>'float_banner','key'=>'banner_left_width','default_value'=>'100') ),
				);
				build_input_form($args);
				?>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row dashboard_box">
				<?php
				$args = array(
					'nice_name'=>'Độ rộng quảng cáo phải',
					'name'=>'banner_right_width',
					'input_type'=>'number',
					'required'=>TRUE,
					'default_value'=>get_option( array('section'=>'float_banner','key'=>'banner_right_width','default_value'=>'100') ),
				);
				build_input_form($args);
				?>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row dashboard_box">
				<?php
				$args = array(
					'nice_name'=>'Khoảng cách từ đầu trang đến vị trí banner bắt đầu chạy',
					'name'=>'banner_margin_top',
					'input_type'=>'number',
					'required'=>TRUE,
					'default_value'=>get_option( array('section'=>'float_banner','key'=>'banner_margin_top','default_value'=>'0') ),
				);
				build_input_form($args);
				?>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row dashboard_box">
				<?php
				$args = array(
					'nice_name'=>'Khoảng cách cuối trang đến vị trí banner dừng lại',
					'name'=>'banner_margin_bottom',
					'input_type'=>'number',
					'required'=>TRUE,
					'default_value'=>get_option( array('section'=>'float_banner','key'=>'banner_margin_bottom','default_value'=>'0') ),
				);
				build_input_form($args);
				?>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="row dashboard_box">
				<?php
				$args = array(
					'nice_name'=>'Nội dung bên trái',
					'name'=>'banner_left',
					'input_type'=>'editor',
					'required'=>FALSE,
					'default_value'=>get_option( array('section'=>'float_banner','key'=>'banner_left') ),
				);
				build_input_form($args);
				?>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="row dashboard_box">
				<?php
				$args = array(
					'nice_name'=>'Nội dung bên phải',
					'name'=>'banner_right',
					'input_type'=>'editor',
					'required'=>FALSE,
					'default_value'=>get_option( array('section'=>'float_banner','key'=>'banner_right') ),
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