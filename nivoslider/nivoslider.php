<?php
/*
Plugin Name: Nivo Slider;
Description: Slider ảnh sử dụng Nivo Slider;
Version: 1.0;
Version Number: 1;
*/

/*
Đăng ký trang list slider
*/
$args=array(
	'label'=>'Nivo Slider',
	'key'=>'nivoslider_sliders',
	'function'=>'nivoslider_sliders',
	'child_of'=>FALSE,
	'icon'=>'fa-picture-o',
	'admin_menu'=>TRUE,
);
register_admin_page($args);
function nivoslider_sliders(){

	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

	if(isset($_POST['add_slider'])){
		$name        	  = hm_post('name');
		$tableName        = DB_PREFIX . 'object';
		$values["name"]   = MySQL::SQLValue($name);
		$values["key"]    = MySQL::SQLValue('nivoslider');
		$values["parent"] = MySQL::SQLValue('0');
		$insert_id        = $hmdb->InsertRow($tableName, $values);
		hm_redirect(BASE_URL.HM_ADMINCP_DIR.'/?run=admin_page.php&key=nivoslider_slide_setting&id='.$insert_id);
	}

	$data = array();
	$tableName=DB_PREFIX."object";
	$whereArray=array('key'=>MySQL::SQLValue('nivoslider'));
	$hmdb->SelectRows($tableName, $whereArray, NULL, 'name', TRUE);
	if( $hmdb->HasRecords() ){
		while( $row = $hmdb->Row() ){
			$data[] = $row;
		}
	}

	hm_include(BASEPATH.HM_PLUGIN_DIR.'/nivoslider/layout/sliders.php',$data);
}

/*
Đăng ký trang xóa slider
*/
$args=array(
	'key'=>'nivoslider_slide_delete',
	'function'=>'nivoslider_slide_delete',
	'child_of'=>FALSE,
	'admin_menu'=>FALSE,
);
register_admin_page($args);
function nivoslider_slide_delete(){

	$id = hm_get('id');
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	$tableName=DB_PREFIX.'object';
	$whereArray = array (
		'id'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER),
	);
	$hmdb->DeleteRows($tableName, $whereArray);

}

/*
Đăng ký trang cài đặt slider
*/
$args=array(
	'key'=>'nivoslider_slide_setting',
	'function'=>'nivoslider_slide_setting',
	'child_of'=>FALSE,
	'admin_menu'=>FALSE,
);
register_admin_page($args);
function nivoslider_slide_setting(){

	if(isset($_POST['add_slide'])){

		$slider_id = hm_get('id');
		$image = hm_post('image');
		$link = hm_post('link');
		$target_blank = hm_post('target_blank');

		if(is_numeric($image)){

			$slider = get_option( array('section'=>'nivoslider','key'=>$slider_id.'_slides') );
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
							'section'=>'nivoslider',
							'key'=>$slider_id.'_slides',
							'value'=>$slider,
						);
			set_option($args);

		}

	}

	if(isset($_POST['nivoslider_save_config'])){
		foreach($_POST as $key => $value){

			$args = array(
							'section'=>'nivoslider',
							'key'=>$slider_id.'_'.$key,
							'value'=>$value,
						);

			set_option($args);

		}
	}

	hm_include(BASEPATH.HM_PLUGIN_DIR.'/nivoslider/layout/slide_setting.php');
}


/*
Đăng request ajax
*/
$args=array(
	'key'=>'nivoslider_ajax',
	'function'=>'nivoslider_ajax',
	'method'=>array('post'),
);
register_admin_ajax_page($args);

function nivoslider_ajax(){

	$action=hm_post('action');
	$slider_id = hm_post('slider_id');

	switch ($action) {
		case 'save_slide':

			$id = hm_post('id');
			$link = hm_post('link');
			$target_blank = hm_post('target_blank');

			$slider = get_option( array('section'=>'nivoslider','key'=>$slider_id.'_slides') );
			$slider = json_decode($slider,TRUE);
			if(isset($slider[$id])){
				$slider[$id]['link'] = $link;
				$slider[$id]['target_blank'] = $target_blank;
			}

			$slider = json_encode($slider);
			$args = array(
							'section'=>'nivoslider',
							'key'=>$slider_id.'_slides',
							'value'=>$slider,
						);
			set_option($args);

		break;
		case 'delete_slide':

			$id = hm_post('id');
			$slider = get_option( array('section'=>'nivoslider','key'=>$slider_id.'_slides') );
			$slider = json_decode($slider,TRUE);
			if(isset($slider[$id])){
				unset($slider[$id]);
			}

			$slider = json_encode($slider);
			$args = array(
							'section'=>'nivoslider',
							'key'=>$slider_id.'_slides',
							'value'=>$slider,
						);
			set_option($args);

		break;
		case 'order_slide':

			$order = hm_post('order');

			$slider = get_option( array('section'=>'nivoslider','key'=>$slider_id.'_slides') );
			$slider = json_decode($slider,TRUE);

			$new_slider = array();

			foreach($order as $id){
				if(isset($slider[$id])){
					$new_slider[$id] = $slider[$id];
				}
			}

			$new_slider = json_encode($new_slider);
			$args = array(
							'section'=>'nivoslider',
							'key'=>$slider_id.'_slides',
							'value'=>$new_slider,
						);
			set_option($args);

		break;
	}
}



/*
Hiển thị slider
*/

function nivoslider($slider_id=''){
	$slide_theme = get_option( array('section'=>'nivoslider','key'=>$slider_id.'_slide_theme','default_value'=>'hmcms') );
	$slider = get_option( array('section'=>'nivoslider','key'=>$slider_id.'_slides') );
	$slider = json_decode($slider,TRUE);
	if(!is_array($slider)){
		$slider = array();
	}
	echo '<div class="nivoslider_container slider-wrapper theme-'.$slide_theme.'">'."\n\r";
	echo '<div class="nivoslider">'."\n\r";
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
			echo '<img src="'.$src.'" alt="slider" /></li>'."\n\r";
		}else{
			echo '<a href="'.$link.'" '.$target_blank_attr.'><img src="'.$src.'" alt="slider" /></a>'."\n\r";
		}
	}
	echo '</div>'."\n\r";
	echo '</div>'."\n\r";
}

register_action('before_hm_footer','nivoslider_display_asset');
function nivoslider_display_asset(){

	$custom_script = get_option( array('section'=>'nivoslider','key'=>$slider_id.'_custom_script') );
	$slide_theme = get_option( array('section'=>'nivoslider','key'=>$slider_id.'_slide_theme','default_value'=>'hmcms') );
	$custom_script = trim($custom_script);
	if($custom_script!=''){
		echo '<!-- Plugin Nivo Slider -->'."\n\r";
		echo $custom_script;
	}else{

		echo '<!-- Plugin Nivo Slider -->'."\n\r";
		echo '<noscript id="hm-nivo-slider-deferred-styles">
				<link rel="stylesheet" type="text/css" href="'.BASE_URL.HM_PLUGIN_DIR.'/nivoslider/nivoslider/nivo-slider.css" >
				<link rel="stylesheet" type="text/css" href="'.BASE_URL.HM_PLUGIN_DIR.'/nivoslider/nivoslider/themes/'.$slide_theme.'/'.$slide_theme.'.css" >
			 </noscript>
			 <script>
				var nivo_loadDeferredStyles = function() {
				  var nivo_addStylesNode = document.getElementById("hm-nivo-slider-deferred-styles");
				  var nivo_replacement = document.createElement("div");
				  nivo_replacement.innerHTML = nivo_addStylesNode.textContent;
				  document.body.appendChild(nivo_replacement);
				  nivo_addStylesNode.parentElement.removeChild(nivo_addStylesNode);
				};
				var raf = requestAnimationFrame || mozRequestAnimationFrame || 
					webkitRequestAnimationFrame || msRequestAnimationFrame;
				if (raf){ raf(function() { window.setTimeout(nivo_loadDeferredStyles, 0); });
				}else{ window.addEventListener("load", nivo_loadDeferredStyles); }
			 </script> ';
		echo '<script src="'.BASE_URL.HM_PLUGIN_DIR.'/nivoslider/nivoslider/jquery.nivo.slider.js" charset="UTF-8"></script>'."\n\r";
		echo '<script>
				$(document).ready(function(){
					$(".nivoslider").nivoSlider({'."\n\r";
						$setting = array(
								'effect' => 'random',
								'slices' => '15',
								'boxCols' => '8',
								'boxRows' => '4',
								'animSpeed' => '500',
								'pauseTime' => '3000',
								'startSlide' => '0',
								'directionNav' => 'true',
								'controlNav' => 'true',
								'controlNavThumbs' => 'false',
								'pauseOnHover' => 'true',
								'manualAdvance' => 'false',
								'prevText' => 'Prev',
								'nextText' => 'Next',
								'randomStart' => 'false'
							);
					foreach($setting as $op_key => $op_val){
						$default_value = get_option( array('section'=>'nivoslider','key'=>$slider_id.'_'.$op_key) );
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
