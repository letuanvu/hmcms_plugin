<?php
/*
Plugin Name: Ban IP;
Description: Block IP truy cập;
Version: 1.0;
Version Number: 1;
*/

/* 
Đăng ký trang plugin setting
*/
$args=array(
	'label'=>'Ban IP',
	'key'=>'ban_ip_main_setting',
	'function'=>'ban_ip_main_setting',
	'function_input'=>array(),
	'child_of'=>FALSE,
);
register_admin_setting_page($args);
function ban_ip_main_setting(){
    if(isset($_POST['ban_ip_save_config'])){
		$args = array(
						'section'=>'ban_ip',
	    				'key'=>'ips',
						'value'=>$_POST['ips'],
					);
		set_option($args);
		
		$htaccess_content = file_get_contents(BASEPATH.'.htaccess');
    	preg_match("'### Ban IP Plugin(.*?)### End Ban IP Plugin'si", $htaccess_content, $res);
    	$old_deny = $res[0];
    	$new_ips = trim(strip_tags($_POST['ips']));
	    $ex = explode(',',$new_ips);
	    $ips = "\n\n";
	    $ips.= "### Ban IP Plugin"."\n";
	    $ips.= "Order Deny,Allow"."\n";
	    foreach($ex as $ip){
	     $ips.= "Deny from ".trim($ip)."\n";
	    }
	    $ips.= "### End Ban IP Plugin"."\n";
    	if($old_deny == NULL){
    	    $file = fopen(BASEPATH.'.htaccess',"a");
            fwrite($file,$ips);
            fclose($file);
    	}else{
    	    $htaccess_content = str_replace($old_deny,'',$htaccess_content);
    	    $file = fopen(BASEPATH.'.htaccess',"w");
            fwrite($file,trim($htaccess_content).$ips);
            fclose($file);
    	}
	}
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/ban_ip/layout/main_setting.php');
}



?>