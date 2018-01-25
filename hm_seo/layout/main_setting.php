<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_seo/asset/css'; ?>/style.css">
<div class="row" >
	<div class="col-md-12">
		<h1 class="page_title"><?php echo _('Cài đặt SEO'); ?></h1>
	</div>
	<form action="" method="post">
		<div class="col-md-6">
			<p class="page_action"><?php echo _('Giá trị sitemap mặc định cho nội dung'); ?></p>
			<div class="row dashboard_box">
				<div class="list-form-input">
					<?php
						/* include */
						$args = array(
							'nice_name'=>'Có trong sitemap',
							'name'=>'content_include_to_sitemap',
							'input_type'=>'select',
							'input_option'=>array(
													array('value'=>'yes','label'=>'Có'),
													array('value'=>'no','label'=>'Không'),
												),
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'content_include_to_sitemap','default_value'=>'yes') ),
						);
						build_input_form($args);

						/* Change Frequency */
						$args = array(
							'nice_name'=>'Change Frequency',
							'name'=>'content_sitemap_change_frequency',
							'input_type'=>'select',
							'input_option'=>array(
													array('value'=>'always','label'=>'always'),
													array('value'=>'hourly','label'=>'hourly'),
													array('value'=>'daily','label'=>'daily'),
													array('value'=>'weekly','label'=>'weekly'),
													array('value'=>'monthly','label'=>'monthly'),
													array('value'=>'yearly','label'=>'yearly'),
													array('value'=>'never','label'=>'never'),
												),
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'content_sitemap_change_frequency','default_value'=>'daily') ),
						);
						build_input_form($args);

						/* Priority */
						$args = array(
							'nice_name'=>'Priority',
							'name'=>'content_sitemap_priority',
							'input_type'=>'select',
							'input_option'=>array(
													array('value'=>'0.0','label'=>'0.0'),
													array('value'=>'0.1','label'=>'0.1'),
													array('value'=>'0.2','label'=>'0.2'),
													array('value'=>'0.3','label'=>'0.3'),
													array('value'=>'0.4','label'=>'0.4'),
													array('value'=>'0.5','label'=>'0.5'),
													array('value'=>'0.6','label'=>'0.6'),
													array('value'=>'0.7','label'=>'0.7'),
													array('value'=>'0.8','label'=>'0.8'),
													array('value'=>'0.9','label'=>'0.9'),
													array('value'=>'1.0','label'=>'1.0'),
												),
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'content_sitemap_priority','default_value'=>'0.6') ),
						);
						build_input_form($args);

					?>
				</div>
			</div>
		</div>


		<div class="col-md-6">
			<p class="page_action"><?php echo _('Giá trị sitemap mặc định cho phân loại'); ?></p>
			<div class="row dashboard_box">
				<div class="list-form-input">
					<?php
						/* include */
						$args = array(
							'nice_name'=>'Có trong sitemap',
							'name'=>'taxonomy_include_to_sitemap',
							'input_type'=>'select',
							'input_option'=>array(
													array('value'=>'yes','label'=>'Có'),
													array('value'=>'no','label'=>'Không'),
												),
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'taxonomy_include_to_sitemap','default_value'=>'yes') ),
						);
						build_input_form($args);

						/* Change Frequency */
						$args = array(
							'nice_name'=>'Change Frequency',
							'name'=>'taxonomy_sitemap_change_frequency',
							'input_type'=>'select',
							'input_option'=>array(
													array('value'=>'always','label'=>'always'),
													array('value'=>'hourly','label'=>'hourly'),
													array('value'=>'daily','label'=>'daily'),
													array('value'=>'weekly','label'=>'weekly'),
													array('value'=>'monthly','label'=>'monthly'),
													array('value'=>'yearly','label'=>'yearly'),
													array('value'=>'never','label'=>'never'),
												),
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'taxonomy_sitemap_change_frequency','default_value'=>'daily') ),
						);
						build_input_form($args);

						/* Priority */
						$args = array(
							'nice_name'=>'Priority',
							'name'=>'taxonomy_sitemap_priority',
							'input_type'=>'select',
							'input_option'=>array(
													array('value'=>'0.0','label'=>'0.0'),
													array('value'=>'0.1','label'=>'0.1'),
													array('value'=>'0.2','label'=>'0.2'),
													array('value'=>'0.3','label'=>'0.3'),
													array('value'=>'0.4','label'=>'0.4'),
													array('value'=>'0.5','label'=>'0.5'),
													array('value'=>'0.6','label'=>'0.6'),
													array('value'=>'0.7','label'=>'0.7'),
													array('value'=>'0.8','label'=>'0.8'),
													array('value'=>'0.9','label'=>'0.9'),
													array('value'=>'1.0','label'=>'1.0'),
												),
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'taxonomy_sitemap_priority','default_value'=>'0.8') ),
						);
						build_input_form($args);

					?>
				</div>
			</div>
		</div>


		<div class="col-md-6">
			<p class="page_action"><?php echo _('Title và meta trang chủ'); ?></p>
			<div class="row dashboard_box">
				<div class="list-form-input">
					<?php
						$args = array(
							'nice_name'=>'Title',
							'name'=>'home_title',
							'input_type'=>'text',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'home_title','default_value'=>'') ),
						);
						build_input_form($args);

						$args = array(
							'nice_name'=>'Meta description',
							'name'=>'home_meta_description',
							'input_type'=>'textarea',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'home_meta_description','default_value'=>'') ),
						);
						build_input_form($args);

						$args = array(
							'nice_name'=>'Meta keywords',
							'name'=>'home_meta_keywords',
							'input_type'=>'text',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'home_meta_keywords','default_value'=>'') ),
						);
						build_input_form($args);

						$args = array(
							'nice_name'=>'Meta robot',
							'name'=>'home_meta_robot',
							'input_type'=>'text',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'home_meta_robot','default_value'=>'index,follow') ),
						);
						build_input_form($args);

						/* og:type */
						$args = array(
							'nice_name'=>'OG Type',
							'name'=>'ogtype',
							'input_type'=>'text',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'ogtype','default_value'=>'website') ),
						);
						build_input_form($args);

						/* og:locale */
						$args = array(
							'nice_name'=>'OG Locale',
							'name'=>'oglocale',
							'input_type'=>'text',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'oglocale','default_value'=>LANG) ),
						);
						build_input_form($args);

						/* fb:app_id */
						$args = array(
							'nice_name'=>'FB Appid',
							'name'=>'fbapp_id',
							'input_type'=>'text',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'fbapp_id','default_value'=>'') ),
						);
						build_input_form($args);

						/* og:title */
						$args = array(
							'nice_name'=>'OG Title',
							'name'=>'ogtitle',
							'input_type'=>'text',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'ogtitle','default_value'=>'') ),
						);
						build_input_form($args);

						/* og:description */
						$args = array(
							'nice_name'=>'OG Description',
							'name'=>'ogdescription',
							'input_type'=>'textarea',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'ogdescription','default_value'=>'') ),
						);
						build_input_form($args);

						/* og:image */
						$args = array();
						$args['name']='ogimage';
						$args['label']='Chọn ảnh đại diện khi share';
						$args['imageonly']=TRUE;
						$args['default_value']=get_option( array('section'=>'hm_seo','key'=>'ogimage','default_value'=>'') );
						media_file_input($args);

						/** facebook check */
						echo '<div class="form-group hm-form-group" data-input-name="ogimage_debug" data-order="0">';
						echo '<p class="ogimage_debug"><a href="https://developers.facebook.com/tools/debug/sharing/?q='.BASE_URL.'" target="_blank">Trình gỡ lỗi chia sẻ - Facebook</a></p>';
						echo '</div>';

						/* custom meta */
						$args = array(
							'nice_name'=>'Thẻ Meta tùy chỉnh',
							'name'=>'custom_meta',
							'input_type'=>'textarea',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'custom_meta','default_value'=>'') ),
						);
						build_input_form($args);

						/* Head script */
						$args = array(
							'nice_name'=>'Head script trang chủ',
							'name'=>'head_script_home',
							'input_type'=>'textarea',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'head_script_home','default_value'=>'') ),
						);
						build_input_form($args);


						/* Footer script */
						$args = array(
							'nice_name'=>'Footer script trang chủ',
							'name'=>'footer_script_home',
							'input_type'=>'textarea',
							'required'=>FALSE,
							'default_value'=>get_option( array('section'=>'hm_seo','key'=>'footer_script_home','default_value'=>'') ),
						);
						build_input_form($args);

					?>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<p class="page_action"><?php echo _('Nội dung robots.txt'); ?></p>
			<div class="row dashboard_box">
				<?php

					$args = array(
						'nice_name'=>'Robots.txt',
						'name'=>'robots',
						'input_type'=>'textarea',
						'required'=>FALSE,
						'default_value'=>get_option( array('section'=>'hm_seo','key'=>'robots','default_value'=>'') ),
					);
					build_input_form($args);

				?>
			</div>
		</div>

		<div class="col-md-6">
			<p class="page_action"><?php echo _('Các mã nhúng trong &lt;head&gt; ở mọi trang'); ?></p>
			<div class="row dashboard_box">
				<?php

					$args = array(
						'nice_name'=>'Head script',
						'name'=>'head_script',
						'input_type'=>'textarea',
						'required'=>FALSE,
						'default_value'=>get_option( array('section'=>'hm_seo','key'=>'head_script','default_value'=>'') ),
					);
					build_input_form($args);

				?>
			</div>
			<p class="page_action"><?php echo _('Các mã nhúng trong &lt;body&gt; ở mọi trang'); ?></p>
			<div class="row dashboard_box">
				<?php

					$args = array(
						'nice_name'=>'Footer script',
						'name'=>'footer_script',
						'input_type'=>'textarea',
						'required'=>FALSE,
						'default_value'=>get_option( array('section'=>'hm_seo','key'=>'footer_script','default_value'=>'') ),
					);
					build_input_form($args);

				?>
			</div>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<button name="save_seo_setting" type="submit" class="btn btn-primary"><?php echo _('Lưu cài đặt'); ?></button>
			</div>
		</div>

	</form>
</div>
