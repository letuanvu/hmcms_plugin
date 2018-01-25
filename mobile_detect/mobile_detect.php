<?php
/*
Plugin Name: Giao diện mobile;
Description: Chọn giao diện cho mobile;
Version: 1.0;
Version Number: 1;
*/

/*
Đăng ký trang plugin setting
*/
$args=array(
	'label'=>_('Giao diện mobile'),
	'key'=>'mobile_detect_main_setting',
	'function'=>'mobile_detect_main_setting',
	'child_of'=>FALSE,
);
register_admin_setting_page($args);


function mobile_detect_main_setting(){

	if(isset($_POST['save_md_setting'])){

		foreach($_POST as $key => $value){

			$args = array(
							'section'=>'mobile_detect',
							'key'=>$key,
							'value'=>$value,
						);

			set_option($args);

		}

	}

	$available_theme = scandir(BASEPATH.HM_THEME_DIR);
	$themes = array();
	foreach($available_theme as $theme){
		if(
			( is_dir(BASEPATH.HM_THEME_DIR.'/'.$theme) )
			AND
			( is_file(BASEPATH.HM_THEME_DIR.'/'.$theme.'/init.php') )
		){
			/** lấy nội dung comment trong file */
			$source = file_get_contents( BASEPATH.HM_THEME_DIR.'/'.$theme.'/init.php' );
			$tokens = token_get_all( $source );
			$comment = array(
				T_COMMENT,
				T_DOC_COMMENT
			);

			foreach( $tokens as $token ) {

				if( in_array($token[0], $comment) ){

					$string = $token[1];
					/** get thông tin theme */

					preg_match("'Theme Name:(.*?);'si", $string, $results);
					if(isset($results[1])){
						$theme_name= $results[1];
					}

					preg_match("'Description:(.*?);'si", $string, $results);
					if(isset($results[1])){
						$theme_description= $results[1];
					}

					preg_match("'Version:(.*?);'si", $string, $results);
					if(isset($results[1])){
						$theme_version= $results[1];
					}


					$themes[$theme]=array(
											'label'=>$theme_name,
											'value'=>$theme,
										);
					unset($string);
				}

			}
		}
	}
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/mobile_detect/layout/main_setting.php',array('themes'=>$themes));

}

/** hook filter thay giao diện */
register_filter('activated_theme','change_activated_theme');
function change_activated_theme($now_theme){
	if(!defined(IN_ADMIN)){
		$domain = $_SERVER['SERVER_NAME'];
		$remote_addr = $_SERVER['REMOTE_ADDR'];
		$domain_mobile = get_option( array('section'=>'mobile_detect','key'=>'domain_mobile','default_value'=>'') );
		$domain_theme = get_option( array('section'=>'mobile_detect','key'=>'domain_theme','default_value'=>'') );
		$ip_mobile = get_option( array('section'=>'mobile_detect','key'=>'ip_mobile','default_value'=>'') );
		$ip_theme = get_option( array('section'=>'mobile_detect','key'=>'ip_theme','default_value'=>'') );
		$ip_mobile_array = explode(',',$ip_mobile);
		$ip_mobile_array = array_map("trim", $ip_mobile_array);
		if ( in_array($remote_addr,$ip_mobile_array) ){
			if(isset($_SESSION['mobile_detect_fixed_theme'])){
				return $_SESSION['mobile_detect_fixed_theme'];
			}else{
				return $ip_theme;
			}
		}elseif( ($domain == $domain_mobile) AND $domain_theme != '' ){
			if(isset($_SESSION['mobile_detect_fixed_theme'])){
				return $_SESSION['mobile_detect_fixed_theme'];
			}else{
				return $domain_theme;
			}
		}else{

			$theme = '';
			if(isset($_SESSION['mobile_detect_fixed_theme'])){
				$theme = $_SESSION['mobile_detect_fixed_theme'];
			}else{
				$detect = new Mobile_Detect;
				if ( $detect->isMobile() ) {
					$theme = get_option( array('section'=>'mobile_detect','key'=>'isMobile','default_value'=>'') );
				}
				if( $detect->isTablet() ){
					$theme = get_option( array('section'=>'mobile_detect','key'=>'isTablet','default_value'=>'') );
				}
				if( $detect->isiOS() ){
					$theme = get_option( array('section'=>'mobile_detect','key'=>'isiOS','default_value'=>'') );
				}
				if( $detect->isAndroidOS() ){
					$theme = get_option( array('section'=>'mobile_detect','key'=>'isAndroidOS','default_value'=>'') );
				}
			}

			if($theme!=''){
				return $theme;
			}else{
				return $now_theme;
			}

		}
	}
}

?>
