<?php
/*
Plugin Name: Hoa Mai SEO;
Description: Thêm các thông tin SEO cho content	và taxonomy;
Version: 1.1.2;
Version Number: 4;
*/


/** dùng hook action thêm js vào đầu trang admin cp */
register_action('hm_admin_head','add_hmseo_css');
function add_hmseo_css(){
	echo '<link rel="stylesheet" type="text/css" href="'.BASE_URL.HM_PLUGIN_DIR.'/hm_seo/asset/css/style.css">';
	echo '<script type="text/javascript" src="'.BASE_URL.HM_PLUGIN_DIR.'/hm_seo/asset/js/content.js"></script>';
}

/*
Tạo content box
*/
$args=array(
	'label'=>'SEO',
	'position'=>'left',
	'function'=>'seo_content_box',
);
register_content_box($args);
function seo_content_box(){
?>
	<div role="tabpanel">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#meta" aria-controls="meta" role="tab" data-toggle="tab"><?php echo _('Các thẻ meta'); ?></a></li>
		<li role="presentation"><a href="#sitemap" aria-controls="sitemap" role="tab" data-toggle="tab"><?php echo _('Sitemap'); ?></a></li>
		<li role="presentation"><a href="#open_graph_tags" aria-controls="open_graph_tags" role="tab" data-toggle="tab"><?php echo _('Open Graph tags'); ?></a></li>
		<li role="presentation"><a href="#custom_script" aria-controls="custom_script" role="tab" data-toggle="tab"><?php echo _('Mã nhúng tùy chỉnh'); ?></a></li>
	  </ul>
	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="meta">
			<?php seo_box_meta(); ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="sitemap">
			<?php seo_box_sitemap(); ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="open_graph_tags">
			<?php open_graph_tags(); ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="custom_script">
			<?php custom_script(); ?>
		</div>
	  </div>
	</div>
<?php
}
/*
Tạo ô nhập các thẻ meta
*/
function seo_box_meta(){
	$args = array(
		'nice_name'=>'Title',
		'name'=>'title',
		'input_type'=>'text',
		'required'=>FALSE,
	);
	if(hm_get('run') == 'taxonomy.php'){
		$args['default_value'] = get_tax_val(array('name'=>'title','id'=>hm_get('id')));
	}elseif(hm_get('run') == 'content.php'){
		$args['default_value'] = get_con_val(array('name'=>'title','id'=>hm_get('id')));
	}

	build_input_form($args);

	$args = array(
		'nice_name'=>'Meta description',
		'name'=>'meta_description',
		'input_type'=>'textarea',
		'required'=>FALSE,
		'description'=>'Khuyến nghị 156 ký tự',
	);
	if(hm_get('run') == 'taxonomy.php'){
		$args['default_value'] = get_tax_val(array('name'=>'meta_description','id'=>hm_get('id')));
	}elseif(hm_get('run') == 'content.php'){
		$args['default_value'] = get_con_val(array('name'=>'meta_description','id'=>hm_get('id')));
	}
	build_input_form($args);

	$args = array(
		'nice_name'=>'Meta keywords',
		'name'=>'meta_keywords',
		'input_type'=>'text',
		'required'=>FALSE,
	);
	if(hm_get('run') == 'taxonomy.php'){
		$args['default_value'] = get_tax_val(array('name'=>'meta_keywords','id'=>hm_get('id')));
	}elseif(hm_get('run') == 'content.php'){
		$args['default_value'] = get_con_val(array('name'=>'meta_keywords','id'=>hm_get('id')));
	}
	build_input_form($args);

	$args = array(
		'nice_name'=>'Meta robot',
		'name'=>'meta_robot',
		'input_type'=>'text',
		'required'=>FALSE,
	);
	if(hm_get('run') == 'taxonomy.php'){
		$args['default_value'] = get_tax_val(array('name'=>'meta_robot','id'=>hm_get('id')));
	}elseif(hm_get('run') == 'content.php'){
		$args['default_value'] = get_con_val(array('name'=>'meta_robot','id'=>hm_get('id')));
	}
	build_input_form($args);
}
/*
Xuất hiện trong sitemap ?
*/
function seo_box_sitemap(){
	/* include */
	$args = array(
		'nice_name'=>'Có trong sitemap',
		'name'=>'include_to_sitemap',
		'input_type'=>'select',
		'input_option'=>array(
								array('value'=>'yes','label'=>'Có'),
								array('value'=>'no','label'=>'Không'),
							),
	);
	if(hm_get('run') == 'taxonomy.php'){
		$args['default_value'] = get_tax_val(array('name'=>'include_to_sitemap','id'=>hm_get('id')));
	}elseif(hm_get('run') == 'content.php'){
		$args['default_value'] = get_con_val(array('name'=>'include_to_sitemap','id'=>hm_get('id')));
	}
	build_input_form($args);

	/* Change Frequency */
	$args = array(
		'nice_name'=>'Change Frequency',
		'name'=>'sitemap_change_frequency',
		'input_type'=>'select',
		'input_option'=>array(
								array('value'=>'auto','label'=>'Mặc định'),
								array('value'=>'always','label'=>'always'),
								array('value'=>'hourly','label'=>'hourly'),
								array('value'=>'daily','label'=>'daily'),
								array('value'=>'weekly','label'=>'weekly'),
								array('value'=>'monthly','label'=>'monthly'),
								array('value'=>'yearly','label'=>'yearly'),
								array('value'=>'never','label'=>'never'),
							),
	);
	if(hm_get('run') == 'taxonomy.php'){
		$args['default_value'] = get_tax_val(array('name'=>'sitemap_change_frequency','id'=>hm_get('id')));
	}elseif(hm_get('run') == 'content.php'){
		$args['default_value'] = get_con_val(array('name'=>'sitemap_change_frequency','id'=>hm_get('id')));
	}
	build_input_form($args);

	/* Priority */
	$args = array(
		'nice_name'=>'Priority',
		'name'=>'sitemap_priority',
		'input_type'=>'select',
		'input_option'=>array(
								array('value'=>'auto','label'=>'Mặc định'),
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
	);
	if(hm_get('run') == 'taxonomy.php'){
		$args['default_value'] = get_tax_val(array('name'=>'sitemap_priority','id'=>hm_get('id')));
	}elseif(hm_get('run') == 'content.php'){
		$args['default_value'] = get_con_val(array('name'=>'sitemap_priority','id'=>hm_get('id')));
	}
	build_input_form($args);
}
/*
Tạo taxonomy box
*/
$args=array(
	'label'=>'SEO',
	'position'=>'left',
	'function'=>'seo_taxonomy_box',
);
register_taxonomy_box($args);
function seo_taxonomy_box(){
?>
	<div role="tabpanel">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#meta" aria-controls="meta" role="tab" data-toggle="tab"><?php echo _('Các thẻ meta'); ?></a></li>
		<li role="presentation"><a href="#sitemap" aria-controls="sitemap" role="tab" data-toggle="tab"><?php echo _('Sitemap'); ?></a></li>
		<li role="presentation"><a href="#open_graph_tags" aria-controls="open_graph_tags" role="tab" data-toggle="tab"><?php echo _('Open Graph tags'); ?></a></li>
		<li role="presentation"><a href="#custom_script" aria-controls="custom_script" role="tab" data-toggle="tab"><?php echo _('Mã nhúng tùy chỉnh'); ?></a></li>
	 </ul>
	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="meta">
			<?php seo_box_meta(); ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="sitemap">
			<?php seo_box_sitemap(); ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="open_graph_tags">
			<?php open_graph_tags(); ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="custom_script">
			<?php custom_script(); ?>
		</div>
	  </div>
	</div>
<?php
}
/*
Đăng ký trang plugin setting
*/
$args=array(
	'label'=>'SEO',
	'key'=>'hm_seo_main_setting',
	'function'=>'hm_seo_main_setting',
	'function_input'=>array(),
	'child_of'=>FALSE,
);
register_admin_setting_page($args);
function hm_seo_main_setting(){

	if(isset($_POST['save_seo_setting'])){

		foreach($_POST as $key => $value){

			$args = array(
							'section'=>'hm_seo',
							'key'=>$key,
							'value'=>$value,
						);

			set_option($args);

		}

	}

	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_seo/layout/main_setting.php');
}



/** Tạo content box để lưu meta og */
function open_graph_tags(){


	/* og:type */
	$args = array(
		'nice_name'=>'OG Type',
		'name'=>'ogtype',
		'input_type'=>'text',
		'required'=>FALSE,
	);
	if(hm_get('run') == 'taxonomy.php'){
		if(hm_get('action') == 'add'){
			$args['default_value'] = 'article:section';
		}else{
			$args['default_value'] = get_tax_val(array('name'=>'ogtype','id'=>hm_get('id')));
		}
	}elseif(hm_get('run') == 'content.php'){
		if(hm_get('action') == 'add'){
			$args['default_value'] = 'article';
		}else{
			$args['default_value'] = get_con_val(array('name'=>'ogtype','id'=>hm_get('id')));
		}
	}
	build_input_form($args);

	/* og:locale */
	$args = array(
		'nice_name'=>'OG Locale',
		'name'=>'oglocale',
		'input_type'=>'text',
		'required'=>FALSE,
	);
	if(hm_get('run') == 'taxonomy.php'){
		if(hm_get('action') == 'add'){
			$args['default_value'] = LANG;
		}else{
			$args['default_value'] = get_tax_val(array('name'=>'oglocale','id'=>hm_get('id')));
		}
	}elseif(hm_get('run') == 'content.php'){
		if(hm_get('action') == 'add'){
			$args['default_value'] = LANG;
		}else{
			$args['default_value'] = get_con_val(array('name'=>'oglocale','id'=>hm_get('id')));
		}
	}
	build_input_form($args);

	/* og:title */
	$args = array(
		'nice_name'=>'OG Title',
		'name'=>'ogtitle',
		'input_type'=>'text',
		'required'=>FALSE,
	);
	if(hm_get('run') == 'taxonomy.php'){
		if(hm_get('action') == 'edit'){
			$args['default_value'] = get_primary_tax_val(hm_get('id'));
		}
	}elseif(hm_get('run') == 'content.php'){
		if(hm_get('action') == 'edit'){
			$args['default_value'] = get_primary_con_val(hm_get('id'));
		}
	}

	build_input_form($args);

	/* og:description */
	$args = array(
		'nice_name'=>'OG Description',
		'name'=>'ogdescription',
		'input_type'=>'textarea',
		'required'=>FALSE,
	);
	if(hm_get('run') == 'taxonomy.php'){
		if(hm_get('action') == 'edit'){
			$args['default_value'] = get_tax_val(array('name'=>'ogdescription','id'=>hm_get('id')));
		}
	}elseif(hm_get('run') == 'content.php'){
		if(hm_get('action') == 'edit'){
			$args['default_value'] = get_con_val(array('name'=>'ogdescription','id'=>hm_get('id')));
		}
	}

	build_input_form($args);

	/* og:image */
	$args = array(
		'name'=>'ogimage',
		'label'=>'Chọn ảnh đại diện khi share',
		'imageonly'=>TRUE,
	);
	if(hm_get('run') == 'taxonomy.php'){
		if(hm_get('action') == 'edit'){
			$args['default_value'] = get_tax_val(array('name'=>'ogimage','id'=>hm_get('id')));
		}
	}elseif(hm_get('run') == 'content.php'){
		if(hm_get('action') == 'edit'){
			$args['default_value'] = get_con_val(array('name'=>'ogimage','id'=>hm_get('id')));
		}
	}
	media_file_input($args);

	/** facebook check */
	if(hm_get('action') == 'edit'){
		if(hm_get('run') == 'taxonomy.php'){
			$link = request_uri( array('type'=>'taxonomy','id'=>hm_get('id')) );
		}elseif(hm_get('run') == 'content.php'){
			$link = request_uri( array('type'=>'content','id'=>hm_get('id')) );
		}
		echo '<div class="form-group hm-form-group" data-input-name="ogimage_debug" data-order="0">';
		echo '<p class="ogimage_debug"><a href="https://developers.facebook.com/tools/debug/sharing/?q='.$link.'" target="_blank">Trình gỡ lỗi chia sẻ - Facebook</a></p>';
		echo '</div>';
	}

	/* custom meta */
	$args = array(
		'nice_name'=>'Thẻ Meta tùy chỉnh',
		'name'=>'custom_meta',
		'input_type'=>'textarea',
		'required'=>FALSE,
	);
	if(hm_get('run') == 'taxonomy.php'){
		if(hm_get('action') == 'edit'){
			$args['default_value'] = get_tax_val(array('name'=>'custom_meta','id'=>hm_get('id')));
		}
	}elseif(hm_get('run') == 'content.php'){
		if(hm_get('action') == 'edit'){
			$args['default_value'] = get_con_val(array('name'=>'custom_meta','id'=>hm_get('id')));
		}
	}

	build_input_form($args);

}

/** Tạo content box để lưu custom script */
function custom_script(){

	/* custom_script_head */
	$args = array(
		'nice_name'=>'Mã nhúng trong thẻ head',
		'name'=>'custom_script_head',
		'input_type'=>'textarea',
		'required'=>FALSE,
	);
	if(hm_get('run') == 'taxonomy.php'){
		if(hm_get('action') == 'add'){
			$args['default_value'] = '';
		}else{
			$args['default_value'] = get_tax_val(array('name'=>'custom_script_head','id'=>hm_get('id')));
		}
	}elseif(hm_get('run') == 'content.php'){
		if(hm_get('action') == 'add'){
			$args['default_value'] = '';
		}else{
			$args['default_value'] = get_con_val(array('name'=>'custom_script_head','id'=>hm_get('id')));
		}
	}
	build_input_form($args);

	/* custom_script_body */
	$args = array(
		'nice_name'=>'Mã nhúng trong thẻ body',
		'name'=>'custom_script_body',
		'input_type'=>'textarea',
		'required'=>FALSE,
	);
	if(hm_get('run') == 'taxonomy.php'){
		if(hm_get('action') == 'add'){
			$args['default_value'] = '';
		}else{
			$args['default_value'] = get_tax_val(array('name'=>'custom_script_body','id'=>hm_get('id')));
		}
	}elseif(hm_get('run') == 'content.php'){
		if(hm_get('action') == 'add'){
			$args['default_value'] = '';
		}else{
			$args['default_value'] = get_con_val(array('name'=>'custom_script_body','id'=>hm_get('id')));
		}
	}
	build_input_form($args);

}


/*
Hook action để hiển thị title, meta_description, meta_keywords & meta_robot
*/
register_filter('hm_title','hm_seo_display_title');
function hm_seo_display_title($title){
	global $hmcontent;
	global $hmtaxonomy;
	$return = $title;

	$request = get_current_uri();
	$request_data = get_uri_data( array('uri'=>$request) );
	if($request == ''){
		$home_title = get_option( array('section'=>'hm_seo','key'=>'home_title') );
		if($home_title!=''){
			$return = $home_title;
		}else{
			$return = $title;
		}
	}else{
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$seo_title = get_con_val("name=title&id=".$object_id);
					if($seo_title!=''){
						$return = $seo_title;
					}else{
						$return = $title;
					}
				break;
				case 'taxonomy':
					$seo_title = get_tax_val("name=title&id=".$object_id);
					if($seo_title!=''){
						$return = $seo_title;
					}else{
						$return = $title;
					}
				break;
			}

		}else{
			$return = $title;
		}
	}

	return $return;
}


register_action('after_hm_title','hm_seo_display_meta_description');
function hm_seo_display_meta_description(){
	global $hmcontent;
	global $hmtaxonomy;
	$request = get_current_uri();
	if($request == ''){
		$description = get_option( array('section'=>'hm_seo','key'=>'home_meta_description','default_value'=>'') );
		echo '<meta name="description" content="'.trim($description).'" />'."\n\r";
	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$description = get_con_val("name=meta_description&id=".$object_id);
					echo '<meta name="description" content="'.trim($description).'" />'."\n\r";
				break;
				case 'taxonomy':
					$description = get_tax_val("name=meta_description&id=".$object_id);
					echo '<meta name="description" content="'.trim($description).'" />'."\n\r";
				break;
			}

		}else{
			return FALSE;
		}
	}

}

register_action('after_hm_title','hm_seo_display_meta_keywords');
function hm_seo_display_meta_keywords(){
	global $hmcontent;
	global $hmtaxonomy;

	$request = get_current_uri();
	if($request == ''){
		$keywords = get_option( array('section'=>'hm_seo','key'=>'home_meta_keywords','default_value'=>'') );
		echo '<meta name="keywords" content="'.trim($keywords).'" />'."\n\r";
	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$keywords = get_con_val("name=meta_keywords&id=".$object_id);
					echo '<meta name="keywords" content="'.trim($keywords).'" />'."\n\r";
				break;
				case 'taxonomy':
					$keywords = get_tax_val("name=meta_keywords&id=".$object_id);
					echo '<meta name="keywords" content="'.trim($keywords).'" />'."\n\r";
				break;
			}

		}else{
			return FALSE;
		}
	}
}


register_action('after_hm_title','hm_seo_display_published_time');
function hm_seo_display_published_time(){
	global $hmcontent;
	global $hmtaxonomy;

	$request = get_current_uri();
	if($request == ''){

	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$update_time = get_con_val("name=update_time&id=".$object_id);
					echo '<meta property="article:published_time" content="'.date('c', ($update_time)).'" />'."\n\r";
				break;
				case 'taxonomy':
					$update_time = get_tax_val("name=update_time&id=".$object_id);
					echo '<meta property="article:published_time" content="'.date('c', ($update_time)).'" />'."\n\r";
				break;
			}

		}else{
			return FALSE;
		}
	}
}

register_action('after_hm_title','hm_seo_display_meta_robot');
function hm_seo_display_meta_robot(){
	global $hmcontent;
	global $hmtaxonomy;

	$request = get_current_uri();
	if($request == ''){
		$robot = get_option( array('section'=>'hm_seo','key'=>'home_meta_robot','default_value'=>'index,follow') );
		echo '<meta name="robot" content="'.trim($robot).'" />'."\n\r";
	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$robot = get_con_val("name=meta_robot&id=".$object_id);
					echo '<meta name="robot" content="'.trim($robot).'" />'."\n\r";
				break;
				case 'taxonomy':
					$robot = get_tax_val("name=meta_robot&id=".$object_id);
					echo '<meta name="robot" content="'.trim($robot).'" />'."\n\r";
				break;
			}

		}else{
			return FALSE;
		}
	}
}

register_action('after_hm_title','hm_seo_display_custom_meta');
function hm_seo_display_custom_meta(){
	global $hmcontent;
	global $hmtaxonomy;

	$request = get_current_uri();
	if($request == ''){
		$custom_meta = get_option( array('section'=>'hm_seo','key'=>'custom_meta','default_value'=>'') );
		echo trim($custom_meta)."\n\r";
	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$custom_meta = get_con_val("name=custom_meta&id=".$object_id);
					echo trim($custom_meta)."\n\r";
				break;
				case 'taxonomy':
					$custom_meta = get_tax_val("name=custom_meta&id=".$object_id);
					echo trim($custom_meta)."\n\r";
				break;
			}

		}else{
			return FALSE;
		}
	}
}

register_action('after_hm_title','hm_seo_display_ogtype');
function hm_seo_display_ogtype(){
	global $hmcontent;
	global $hmtaxonomy;

	$request = get_current_uri();

	echo '<meta property="og:url" content="'.BASE_URL.trim($request).'" />'."\n\r";

	if($request == ''){
		$ogtype = get_option( array('section'=>'hm_seo','key'=>'ogtype','default_value'=>'') );
		echo '<meta property="og:type" content="'.trim($ogtype).'" />'."\n\r";
	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$ogtype = get_con_val("name=ogtype&id=".$object_id);
					if(trim($ogtype)==''){
						$ogtype = 'article';
					}
					echo '<meta property="og:type" content="'.trim($ogtype).'" />'."\n\r";
				break;
				case 'taxonomy':
					$ogtype = get_tax_val("name=ogtype&id=".$object_id);
					if(trim($ogtype)==''){
						$ogtype = 'article:section';
					}
					echo '<meta property="og:type" content="'.trim($ogtype).'" />'."\n\r";
				break;
			}

		}else{
			return FALSE;
		}
	}
}


register_action('after_hm_title','hm_seo_display_oglocale');
function hm_seo_display_oglocale(){
	global $hmcontent;
	global $hmtaxonomy;

	$request = get_current_uri();
	if($request == ''){
		$oglocale = get_option( array('section'=>'hm_seo','key'=>'oglocale','default_value'=>'') );
		echo '<meta property="og:locale" content="'.trim($oglocale).'" />'."\n\r";
	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$oglocale = get_con_val("name=oglocale&id=".$object_id);
					if(trim($oglocale)==''){
						$oglocale = LANG;
					}
					echo '<meta property="og:locale" content="'.trim($oglocale).'" />'."\n\r";
				break;
				case 'taxonomy':
					$oglocale = get_tax_val("name=oglocale&id=".$object_id);
					if(trim($oglocale)==''){
						$oglocale = LANG;
					}
					echo '<meta property="og:locale" content="'.trim($oglocale).'" />'."\n\r";
				break;
			}

		}else{
			return FALSE;
		}
	}
}

register_action('after_hm_title','hm_seo_display_ogtitle');
function hm_seo_display_ogtitle(){
	global $hmcontent;
	global $hmtaxonomy;

	$request = get_current_uri();
	if($request == ''){
		$ogtitle = get_option( array('section'=>'hm_seo','key'=>'ogtitle','default_value'=>'') );
		echo '<meta property="og:title" content="'.trim($ogtitle).'" />'."\n\r";
	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$ogtitle = get_con_val("name=ogtitle&id=".$object_id);
					if(trim($ogtitle=='')){
						$ogtitle = get_primary_con_val($object_id);
					}
					echo '<meta property="og:title" content="'.trim($ogtitle).'" />'."\n\r";
				break;
				case 'taxonomy':
					$ogtitle = get_tax_val("name=ogtitle&id=".$object_id);
					if(trim($ogtitle=='')){
						$ogtitle = get_primary_tax_val($object_id);
					}
					echo '<meta property="og:title" content="'.trim($ogtitle).'" />'."\n\r";
				break;
			}

		}else{
			return FALSE;
		}
	}
}

register_action('after_hm_title','hm_seo_display_ogdescription');
function hm_seo_display_ogdescription(){
	global $hmcontent;
	global $hmtaxonomy;

	$request = get_current_uri();
	if($request == ''){
		$ogdescription = get_option( array('section'=>'hm_seo','key'=>'ogdescription','default_value'=>'') );
		echo '<meta property="og:description" content="'.trim($ogdescription).'" />'."\n\r";
	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$ogdescription = get_con_val("name=ogdescription&id=".$object_id);
					echo '<meta property="og:description" content="'.trim($ogdescription).'" />'."\n\r";
				break;
				case 'taxonomy':
					$ogdescription = get_tax_val("name=ogdescription&id=".$object_id);
					echo '<meta property="og:description" content="'.trim($ogdescription).'" />'."\n\r";
				break;
			}

		}else{
			return FALSE;
		}
	}
}

register_action('after_hm_title','hm_seo_display_ogimage');
function hm_seo_display_ogimage(){
	global $hmcontent;
	global $hmtaxonomy;

	$request = get_current_uri();
	if($request == ''){
		$ogimage = get_option( array('section'=>'hm_seo','key'=>'ogimage','default_value'=>'') );
		if(is_numeric($ogimage)){
			echo '<meta property="og:image" content="'.get_file_url($ogimage).'" />'."\n\r";
		}
	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$ogimage = get_con_val("name=ogimage&id=".$object_id);
					if(!is_numeric($ogimage)){
						$ogimage = get_con_val("name=content_thumbnail&id=".$object_id);
					}
					if(is_numeric($ogimage)){
						echo '<meta property="og:image" content="'.get_file_url($ogimage).'" />'."\n\r";
					}
				break;
				case 'taxonomy':
					$ogimage = get_tax_val("name=ogimage&id=".$object_id);
					if(!is_numeric($ogimage)){
						$ogimage = get_con_val("name=taxonomy_thumbnail&id=".$object_id);
					}
					if(is_numeric($ogimage)){
						echo '<meta property="og:image" content="'.get_file_url($ogimage).'" />'."\n\r";
					}
				break;
			}

		}else{
			return FALSE;
		}
	}
}

register_action('after_hm_title','hm_seo_display_custom_script_head');
function hm_seo_display_custom_script_head(){
	global $hmcontent;
	global $hmtaxonomy;

	$request = get_current_uri();
	if($request == ''){
		$custom_script = get_option( array('section'=>'hm_seo','key'=>'custom_script_head','default_value'=>'') );
		echo trim($custom_script)."\n\r";
	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$custom_script = get_con_val("name=custom_script_head&id=".$object_id);
					echo trim($custom_script)."\n\r";
				break;
				case 'taxonomy':
					$custom_script = get_tax_val("name=custom_script_head&id=".$object_id);
					echo trim($custom_script)."\n\r";
				break;
			}

		}else{
			return FALSE;
		}
	}
}

register_action('before_hm_footer','hm_seo_display_custom_script_body');
function hm_seo_display_custom_script_body(){
	global $hmcontent;
	global $hmtaxonomy;

	$request = get_current_uri();
	if($request == ''){
		$custom_script = get_option( array('section'=>'hm_seo','key'=>'custom_script_body','default_value'=>'') );
		echo trim($custom_script)."\n\r";
	}else{
		$request_data = get_uri_data( array('uri'=>$request) );
		if( $request_data != FALSE ){

			$object_type = $request_data->object_type;
			$object_id = $request_data->object_id;

			switch ($object_type) {
				case 'content':
					$custom_script = get_con_val("name=custom_script_body&id=".$object_id);
					echo trim($custom_script)."\n\r";
				break;
				case 'taxonomy':
					$custom_script = get_tax_val("name=custom_script_body&id=".$object_id);
					echo trim($custom_script)."\n\r";
				break;
			}

		}else{
			return FALSE;
		}
	}
}


/**
 * Đăng ký request cho sitemap
*/

register_action('after_hm_title','hm_seo_head_script');
function hm_seo_head_script(){
	echo get_option( array('section'=>'hm_seo','key'=>'head_script','default_value'=>'') )."\n\r";

	/* fb:app_id */
	$fbapp_id = get_option( array('section'=>'hm_seo','key'=>'fbapp_id','default_value'=>'') );
	echo '<meta property="fb:app_id" content="'.$fbapp_id.'" />'."\n\r";
	if(is_home()){
		echo get_option( array('section'=>'hm_seo','key'=>'head_script_home','default_value'=>'') )."\n\r";
	}
}

register_action('after_hm_footer','hm_seo_footer_script');
function hm_seo_footer_script(){
	echo get_option( array('section'=>'hm_seo','key'=>'footer_script','default_value'=>'') )."\n\r";
	if(is_home()){
		echo get_option( array('section'=>'hm_seo','key'=>'footer_script_home','default_value'=>'') )."\n\r";
	}
}

/**
 * Đăng ký request cho sitemap
*/

register_request('sitemap.xml','hm_seo_sitemap',array('name'=>'Sitemap XML','menu'=>TRUE));
function hm_seo_sitemap(){
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_seo/layout/sitemap.php');
}

/**
 * Đăng ký request cho robots.txt
*/

register_request('robots.txt','hm_seo_robotstxt',array('name'=>'Robots.txt','menu'=>TRUE));
function hm_seo_robotstxt(){
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_seo/layout/robots.php');
}

?>
