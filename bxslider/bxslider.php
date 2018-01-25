<?php
/*
Plugin Name: bxSlider;
Description: Slider ảnh sử dụng bxSlider;
Version: 1.1;
Version Number: 2;
*/

/* 
Đăng ký trang plugin setting
*/
$args=array(
	'label'=>'bxSlider',
	'key'=>'bxslider_main_setting',
	'function'=>'bxslider_main_setting',
	'function_input'=>array(),
	'child_of'=>FALSE,
);
register_admin_setting_page($args);
function bxslider_main_setting(){
	
	if(isset($_POST['add_slider'])){
		
		$image = hm_post('image');
		$link = hm_post('link');
		$target_blank = hm_post('target_blank');
		
		if(is_numeric($image)){
		
			$slider = get_option( array('section'=>'bxslider','key'=>'slides') );
			$slider = json_decode($slider,TRUE);
			if(!is_array($slider)){
				$slider = array();
			}
			if(sizeof($slider) > 1){
				$bigest = max(array_keys($slider));
			}else{
				foreach($slider as $key => $val){
					$bigest = $key;
				}
			}
			$new_order = $bigest+1;
			$slider[$new_order] = array('image'=>$image,'link'=>$link,'target_blank'=>$target_blank);
			$slider = json_encode($slider);
			$args = array(
							'section'=>'bxslider',
							'key'=>'slides',
							'value'=>$slider,
						);
			set_option($args);
			
		}
		
	}
	
	if(isset($_POST['bxslider_save_config'])){
		foreach($_POST as $key => $value){
			
			$args = array(
							'section'=>'bxslider',
							'key'=>$key,
							'value'=>$value,
						);
			
			set_option($args);
			
		}
	}
	
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/bxslider/layout/main_setting.php');
}


/* 
Đăng request ajax
*/
$args=array(
	'key'=>'bxslider_ajax',
	'function'=>'bxslider_ajax',
	'method'=>array('post'),
);
register_admin_ajax_page($args);

function bxslider_ajax(){

	$action=hm_post('action');

	switch ($action) {
		case 'save_slide':
			
			$id = hm_post('id');
			$link = hm_post('link');
			$target_blank = hm_post('target_blank');
			
			$slider = get_option( array('section'=>'bxslider','key'=>'slides') );
			$slider = json_decode($slider,TRUE);
			if(isset($slider[$id])){
				$slider[$id]['link'] = $link;
				$slider[$id]['target_blank'] = $target_blank;
			}
			
			$slider = json_encode($slider);
			$args = array(
							'section'=>'bxslider',
							'key'=>'slides',
							'value'=>$slider,
						);
			set_option($args);
			
		break;	
		case 'delete_slide':
			
			$id = hm_post('id');
			$slider = get_option( array('section'=>'bxslider','key'=>'slides') );
			$slider = json_decode($slider,TRUE);
			if(isset($slider[$id])){
				unset($slider[$id]);
			}
			
			$slider = json_encode($slider);
			$args = array(
							'section'=>'bxslider',
							'key'=>'slides',
							'value'=>$slider,
						);
			set_option($args);
			
		break;	
		case 'order_slide':
			
			$order = hm_post('order');
			
			$slider = get_option( array('section'=>'bxslider','key'=>'slides') );
			$slider = json_decode($slider,TRUE);
			
			$new_slider = array();
			
			foreach($order as $id){
				if(isset($slider[$id])){
					$new_slider[$id] = $slider[$id];
				}
			}
			
			$new_slider = json_encode($new_slider);
			$args = array(
							'section'=>'bxslider',
							'key'=>'slides',
							'value'=>$new_slider,
						);
			set_option($args);
			
		break;
	}
}



/*
Hiển thị slider
*/

function bxslider(){
	$slider = get_option( array('section'=>'bxslider','key'=>'slides') );
	$slider = json_decode($slider,TRUE);
	if(!is_array($slider)){
		$slider = array();
	}
	echo '<div class="bxslider_container">'."\n\r";
	echo '<ul class="bxslider">'."\n\r";
	foreach($slider as $key => $item){
		$image = $item['image'];
		$link = $item['link'];
		$target_blank = $item['target_blank'];
		$target_blank_attr = '';
		if($target_blank == 1){
			$target_blank_attr = 'target="_blank"';
		}
		$src = get_file_url($image);
		if($link==''){
			echo '<li><img src="'.$src.'" /></li>';
		}else{
			echo '<li><a href="'.$link.'" '.$target_blank_attr.'><img src="'.$src.'" /></a></li>';
		}
	}
	echo '</ul>'."\n\r";
	echo '</div>'."\n\r";
}

register_action('after_hm_head','bxslider_display_asset');
function bxslider_display_asset(){
	
	$custom_script = get_option( array('section'=>'bxslider','key'=>'custom_script') );
	$custom_script = trim($custom_script);
	if($custom_script!=''){
		echo '<!-- Plugin bxSlider -->'."\n\r";
		echo $custom_script;
	}else{
	
		echo '<!-- Plugin bxSlider -->'."\n\r";
		echo '<link rel="stylesheet" type="text/css" href="'.BASE_URL.HM_PLUGIN_DIR.'/bxslider/bxslider/jquery.bxslider.css">'."\n\r";
		echo '<script type="text/javascript" src="'.BASE_URL.HM_PLUGIN_DIR.'/bxslider/bxslider/jquery.bxslider.min.js" charset="UTF-8"></script>'."\n\r";
		echo '<script>
				$(document).ready(function(){
					$(".bxslider").bxSlider({'."\n\r";
					
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
			if(is_numeric($default_value) OR $default_value == 'true' OR $default_value == 'false'){
				echo '"'.$op_key.'":'.$default_value.','."\n\r";
			}else{
				echo '"'.$op_key.'":"'.$default_value.'",'."\n\r";
			}
		}
					
		echo '		});
				});
			  </script>'."\n\r";
			  
	}
}
?>