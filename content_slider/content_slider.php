<?php
/*
Plugin Name: Slider cho nội dung;
Description: Tạo một slider ảnh đi kèm với nội dung;
Version: 1.0;
Version Number: 1;
*/

/* 
Đăng ký trang cài đặt cho plugin
*/
$args=array(
	'label'=>'Slider cho nội dung',
	'key'=>'content_slider_setting',
	'function'=>'content_slider_setting',
	'function_input'=>array(),
	'child_of'=>FALSE,
);
register_admin_setting_page($args);
function content_slider_setting(){
	
	if(isset($_POST['save_setting'])){
		
		foreach($_POST as $key => $value){
			
			$args = array(
							'section'=>'content_slider',
							'key'=>$key,
							'value'=>$value,
						);
			
			set_option($args);
			
		}
	
	}
	
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/content_slider/admincp/setting.php');
}


/* 
Tạo content box
*/

$run = hm_get('run','');
if($run == 'content.php'){
	
	$action = hm_get('action');
	$display_box = FALSE;
	
	if($action == 'add'){
		$key = hm_get('key');
		$include = get_option( array('section'=>'content_slider','key'=>'include_content_'.$key) );
		if($include == 'yes'){
			$display_box = TRUE;
		}
	}elseif($action == 'edit'){
		$id = hm_get('id');
		$content_data = content_data_by_id($id);
		$key = $content_data['content']->key;
		$include = get_option( array('section'=>'content_slider','key'=>'include_content_'.$key) );
		if($include == 'yes'){
			$display_box = TRUE;
		}
	}
	if($display_box){
		$args=array(
			'label'=>'Slider ảnh',
			'position'=>'left',
			'function'=>'content_slider_box',
		);
		register_content_box($args);
		function content_slider_box(){
			$action = hm_get('action');
			if($action == 'add'){
				hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/content_slider/admincp/content_slider_box_add.php');
			}elseif($action == 'edit'){
				hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/content_slider/admincp/content_slider_box_edit.php');
			}
		}
	}
}


/* 
Lệnh gọi từ giao diện
*/
function content_slider(){
	$id = get_id();
	$content_slider_image = get_con_val(array('name'=>'content_slider_image','id'=>$id));
	$content_slider_image = json_decode($content_slider_image,TRUE);
	$content_slider_title = get_con_val(array('name'=>'content_slider_title','id'=>$id));
	$content_slider_title = json_decode($content_slider_title,TRUE);
	$content_slider_description = get_con_val(array('name'=>'content_slider_description','id'=>$id));
	$content_slider_description = json_decode($content_slider_description,TRUE);
	$content_slider_link = get_con_val(array('name'=>'content_slider_link','id'=>$id));
	$content_slider_link = json_decode($content_slider_link,TRUE);
	
	if(is_array($content_slider_image)){
	
		$jquery_plugin = get_option( array('section'=>'content_slider','key'=>'jquery_plugin','default_value'=>'galleria') );
		if($jquery_plugin == 'galleria'){
		
			$galleria_height = get_con_val(array('name'=>'galleria_height','id'=>$id));
			if(!is_numeric($galleria_height) OR $galleria_height==0){
				$galleria_height = get_option( array('section'=>'content_slider','key'=>'galleria_height','default_value'=>'600') );
			}
			
			echo '<div id="cts_galleria">'."\n\r";
			foreach($content_slider_image as $slide_key => $slide_img){
				

			echo '	<a href="'.get_file_url($slide_img).'">'."\n\r";
			echo '		<img '."\n\r";
			echo '			src="'.get_file_url($slide_img).'",'."\n\r";
			echo '			data-big="'.get_file_url($slide_img).'"'."\n\r";
			echo '			data-title="'.$content_slider_title[$slide_key].'"'."\n\r";
			echo '			data-description="'.$content_slider_description[$slide_key].'"'."\n\r";
			echo '			data-link ="'.$content_slider_link[$slide_key].'"'."\n\r";
			echo '		>'."\n\r";
			echo '	</a>'."\n\r";
				
			}
			echo '</div>'."\n\r";
			
			echo '<style>#cts_galleria{height:'.$galleria_height.'px}</style>';
			echo '<script>'."\n\r";
			echo '$(function() {'."\n\r";
			echo '    Galleria.loadTheme("'.BASE_URL.HM_PLUGIN_DIR.'/content_slider/asset/galleria/themes/classic/galleria.classic.min.js");'."\n\r";
			echo '    Galleria.run("#cts_galleria");'."\n\r";
			echo '});'."\n\r";
			echo ' </script>'."\n\r";
		
		}elseif($jquery_plugin == 'fancybox'){
			
			
			echo '<div id="cts_fancybox">'."\n\r";
			foreach($content_slider_image as $slide_key => $slide_img){
				

			echo '	<a data-fancybox="cts_fancybox" href="'.get_file_url($slide_img).'" class="cts_fancybox_item">'."\n\r";
			echo '		<img '."\n\r";
			echo '			src="'.get_file_url($slide_img).'",'."\n\r";
			echo '			data-big="'.get_file_url($slide_img).'"'."\n\r";
			echo '			title="'.$content_slider_title[$slide_key].'"'."\n\r";
			echo '			data-description="'.$content_slider_description[$slide_key].'"'."\n\r";
			echo '			data-link ="'.$content_slider_link[$slide_key].'"'."\n\r";
			echo '		>'."\n\r";
			echo '	</a>'."\n\r";
				
			}
			echo '</div>'."\n\r";
			
			echo '<script>'."\n\r";
			echo '$(function() {'."\n\r";
			echo '$("a.cts_fancybox_item").fancybox({'."\n\r";
			$default =  "'transitionIn'	:	'elastic', "."\n".
						"'transitionOut'	:	'elastic', "."\n".
						"'speedIn'		:	600, "."\n".
						"'speedOut'	:	200, "."\n".
						"'overlayShow'	:	false "."\n";
			echo get_option( array('section'=>'content_slider','key'=>'fancybox_setting','default_value'=>$default) );
			echo '});'."\n\r";
			echo '});'."\n\r";
			echo ' </script>'."\n\r";
			
		}
	
	}
	
}

/*
asset 
*/
register_action('after_hm_head','content_slider_display_asset');
function content_slider_display_asset(){
	
	echo '<!-- Plugin content slider -->'."\n\r";
	$jquery_plugin = get_option( array('section'=>'content_slider','key'=>'jquery_plugin','default_value'=>'galleria') );
	if($jquery_plugin == 'galleria'){
		echo '<script type="text/javascript" src="'.BASE_URL.HM_PLUGIN_DIR.'/content_slider/asset/galleria/galleria-1.5.6.min.js" charset="UTF-8"></script>'."\n\r";
	}elseif($jquery_plugin == 'fancybox'){
		echo '<link rel="stylesheet" href="'.BASE_URL.HM_PLUGIN_DIR.'/content_slider/asset/fancybox/jquery.fancybox.min.css" type="text/css" media="screen" />';
		echo '<script type="text/javascript" src="'.BASE_URL.HM_PLUGIN_DIR.'/content_slider/asset/fancybox/jquery.fancybox.min.js" charset="UTF-8"></script>'."\n\r";
	}
}

?>