<?php
/*
Plugin Name: Popup;
Description: Tạo popup sử dụng custombox;
Version: 1.0;
Version Number: 1;
*/

/* 
Đăng ký trang plugin setting
*/
$args=array(
	'label'=>'Cài đặt popup',
	'key'=>'custombox_setting',
	'function'=>'custombox_setting',
	'function_input'=>array(),
	'child_of'=>FALSE,
);
register_admin_setting_page($args);
function custombox_setting(){
	
	if(isset($_POST['save_setting'])){
		
		foreach($_POST as $key => $value){
			
			$args = array(
							'section'=>'custombox',
							'key'=>$key,
							'value'=>$value,
						);
			
			set_option($args);
			
		}
	
	}
	
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/custombox/layout/main_setting.php');
}

/*
CSS & JS
*/
register_action('after_hm_head','custombox_display_asset');
function custombox_display_asset(){
	
	$active = get_option( array('section'=>'custombox','key'=>'active','default_value'=>'yes') );	
	if($active == 'yes'){
		
		$display = FALSE;
		$display_on = get_option( array('section'=>'custombox','key'=>'display_on','default_value'=>'home') );
		if($display_on == 'home'){
			if(is_home()){
				$display = TRUE;
			}
		}
		
		$display_repeat = get_option( array('section'=>'custombox','key'=>'display_repeat','default_value'=>'home') );
		if($display_repeat == 'once'){
			$session = $_SESSION['custombox'];
			if(is_numeric($session)){
				$display = FALSE;
			}else{
				$_SESSION['custombox'] = time();
				$display = TRUE;
			}
		}
		
		if($display){
			
			$effects = get_option( array('section'=>'custombox','key'=>'effects','default_value'=>'fadein') );
			
			echo '<link rel="stylesheet" type="text/css" href="'.BASE_URL.HM_PLUGIN_DIR.'/custombox/custombox/custombox.min.css">'."\n\r";
			echo '<script type="text/javascript" src="'.BASE_URL.HM_PLUGIN_DIR.'/custombox/custombox/custombox.min.js" charset="UTF-8"></script>'."\n\r";
			echo '<script type="text/javascript" src="'.BASE_URL.HM_PLUGIN_DIR.'/custombox/custombox/custombox.legacy.min.js" charset="UTF-8"></script>'."\n\r";
			echo "<script>
				$(document).ready(function(){
					var modal = new Custombox.modal({
					  content: {
						effect: '$effects',
						target: '#custombox_modal'
					  }
					});
					modal.open();
				});
				</script> \n\r";
		}
		
	}
}

/*
popup content
*/
register_action('after_hm_footer','custombox_display_popup_content');
function custombox_display_popup_content(){
	$active = get_option( array('section'=>'custombox','key'=>'active','default_value'=>'yes') );	
	if($active == 'yes'){
		
		$display = FALSE;
		$display_on = get_option( array('section'=>'custombox','key'=>'display_on','default_value'=>'home') );
		if($display_on == 'home'){
			if(is_home()){
				$display = TRUE;
			}
		}
		
		$display_repeat = get_option( array('section'=>'custombox','key'=>'display_repeat','default_value'=>'home') );
		if($display_repeat == 'once'){
			$session = $_SESSION['custombox'];
			if(is_numeric($session)){
				$display = FALSE;
			}else{
				$_SESSION['custombox'] = time();
				$display = TRUE;
			}
		}
		
		if($display){
			echo '<div id="custombox_modal" style="display:none">'."\n\r";
			echo '<div class="custombox_modal_wrapper">'."\n\r";
			$popup_content = get_option( array('section'=>'custombox','key'=>'popup_content','default_value'=>'') );
			echo do_all_shortcode_from_string($popup_content);
			echo '</div>'."\n\r";
			echo '</div>'."\n\r";
		}
	}
}
?>