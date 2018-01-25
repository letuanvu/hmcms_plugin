<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/bxslider/asset/admin'; ?>/style.css">
<script type="text/javascript" src="<?php echo BASE_URL.HM_PLUGIN_DIR.'/bxslider/asset/admin'; ?>/main.js" charset="UTF-8"></script>
<script src="<?php echo ADMIN_LAYOUT_PATH; ?>/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<link rel="stylesheet" href="<?php echo ADMIN_LAYOUT_PATH; ?>/perfect-scrollbar/perfect-scrollbar.min.css">
<div class="row">
	<div class="col-md-9">
		<?php
		$slider = get_option( array('section'=>'bxslider','key'=>'slides') );
		$slider = json_decode($slider,TRUE);
		if(!is_array($slider)){
			$slider = array();
		}
		?>
		<table class="table table-striped content_table list_slides">
			<thead>
			<tr>
				<th>Ảnh</th>
				<th>Link</th>
				<th>Mở trong tab mới</th>
				<th>Xóa</th>
			</tr>
			</thead>
			<tbody class="list_slides_content">
			<?php
			foreach($slider as $key => $item){
				$image = $item['image'];
				$link = $item['link'];
				$target_blank = $item['target_blank'];
				$src = get_file_url($image);
			?>
			<tr data-id="<?php echo $key; ?>">
				<td class="slide_img">
					<img src="<?php echo $src; ?>">
				</td>
				<td>
					<?php
					$args = array(
						'handle'=> FALSE,
						'name'=>'link',
						'addClass'=>'link_'.$key,
						'input_type'=>'text',
						'default_value'=>$link,
					);
					build_input_form($args);
					?>
				</td>
				<td>
					<?php
					$args = array(
						'handle'=> FALSE,
						'name'=>'target_blank',
						'addClass'=>'target_blank_'.$key,
						'input_type'=>'select',
						'input_option'=>array(
											array('value'=>'0','label'=>'Không'),
											array('value'=>'1','label'=>'Có'),
										),
						'default_value'=>$target_blank,
					);
					build_input_form($args);
					?>
				</td>
				<td>
				<button type="button" data-image="<?php echo $image; ?>" data-id="<?php echo $key; ?>" class="quick_save_slide btn btn-info ">Lưu</button>
				<button type="button" data-image="<?php echo $image; ?>" data-id="<?php echo $key; ?>" class="quick_delete_slide btn btn-danger ">Xóa</button>
				</td>
			</tr>
			<?php
			}
			?>
			</tbody>
		</table>

		<form action="" method="post">
			
			<div class="addslider">
				<div class="row">
					<div class="col-md-3">
						<?php
						$args = array(
							'nice_name'=>'Chọn ảnh cho slider',
							'label'=>'Chọn ảnh',
							'name'=>'image',
							'input_type'=>'image',
							'required'=>TRUE,
						);
						build_input_form($args);
						?>
					</div>
					<div class="col-md-3">
						<?php
						$args = array(
							'nice_name'=>'Link khi bấm vào',
							'name'=>'link',
							'input_type'=>'text',
						);
						build_input_form($args);
						?>
					</div>
					<div class="col-md-3">
						<?php
						$args = array(
							'nice_name'=>'Mở trong tab mới',
							'name'=>'target_blank',
							'input_type'=>'select',
							'input_option'=>array(
												array('value'=>'0','label'=>'Không'),
												array('value'=>'1','label'=>'Có'),
											),
						);
						build_input_form($args);
						?>
					</div>
					<div class="col-md-3">
						<div class="form-group"> 
							<div class="form-group-handle"></div><label for="field_append">Hành động</label>
							<button name="add_slider" type="submit" class="form-control btn btn-info"><?php echo _('Thêm ảnh vào slider'); ?></button>
						</div>
					</div>
				</div>
			</div>

		</form>
	</div>
	<div class="col-md-3">
		<form action="" method="post">
			<div class="page_action">
				Cấu hình slider
			</div>
			<div class="bxsider_config_bar">
			<?php
			$setting = array(
						'auto' => 'true',
						'pause' => '4000',
						'autoStart' => 'true',
						'autoHover' => 'false',
						'autoDelay' => '0',
						'mode' => 'horizontal',
						'speed' => '500',
						'slideMargin' => '0',
						'startSlide' => '0',
						'randomStart' => 'false',
						'responsive' => 'true',
						'useCSS' => 'true',
						'preloadImages' => 'visible',
						'touchEnabled' => 'true',
						'infiniteLoop' => 'true',
						'controls' => 'true',
					);
			foreach($setting as $op_key => $op_val){
				$default_value = get_option( array('section'=>'bxslider','key'=>$op_key) );
				if($default_value == ''){
					$default_value = $op_val;
				}
				$args = array(
					'nice_name'=>$op_key,
					'name'=>$op_key,
					'input_type'=>'text',
					'required'=>FALSE,
					'default_value'=>get_option( array('section'=>'bxslider','key'=>$op_key,'default_value'=>$default_value) ),
				);
				build_input_form($args);
			}
				$args = array(
					'nice_name'=>'Tự viết javascript',
					'name'=>'custom_script',
					'input_type'=>'textarea',
					'required'=>FALSE,
					'default_value'=>get_option( array('section'=>'bxslider','key'=>'custom_script','default_value'=>'') ),
				);
				build_input_form($args);
			?>
			</div>
			<div class="form-group"> 
				<div class="form-group-handle"></div><label for="field_append">Hành động</label>
				<button name="bxslider_save_config" type="submit" class="form-control btn btn-info"><?php echo _('Lưu cấu hình'); ?></button>
			</div>
		</form>
	</div>
</div>