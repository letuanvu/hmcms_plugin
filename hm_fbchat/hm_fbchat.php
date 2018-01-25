<?php
/*
Plugin Name: Facebook Chat;
Description: Thêm ô hỗ trợ trực truyến sử dụng facebook chat;
Version: 1.0;
Version Number: 1;
*/

/* 
Đăng ký trang plugin setting
*/
$args=array(
	'label'=>'Facebook Chat',
	'key'=>'hm_fbchat_main_setting',
	'function'=>'hm_fbchat_main_setting',
	'function_input'=>array(),
	'child_of'=>FALSE,
);
register_admin_setting_page($args);
function hm_fbchat_main_setting(){
	
	if(isset($_POST['save_fbchat_setting'])){
		
		foreach($_POST as $key => $value){
			
			$args = array(
							'section'=>'hm_fbchat',
							'key'=>$key,
							'value'=>$value,
						);
			
			set_option($args);
			
		}
	
	}
	
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_fbchat/layout/main_setting.php');
}

register_action('after_hm_head','hm_fbchat_fbroot');
function hm_fbchat_fbroot(){
	
	$auto_popup = get_option( array('section'=>'hm_fbchat','key'=>'auto_popup','default_value'=>'yes') );
	$auto_popup_delay = get_option( array('section'=>'hm_fbchat','key'=>'auto_popup_delay','default_value'=>'yes') );
	$auto_popup_delay = round($auto_popup_delay*1000);
	echo '	<link rel="stylesheet" type="text/css" href="'.SITE_URL.FOLDER_PATH.'/'.HM_PLUGIN_DIR.'/hm_fbchat/asset/fbchat.css">'."\n\r";
	echo '	<script>
			function fchat()	{
					var tchat= document.getElementById("tchat").value;
					if(tchat==0 || tchat==\'0\')
					{                
						document.getElementById("fchat").style.display = "block";
						document.getElementById("tchat").value=1;
					}else{
						document.getElementById("fchat").style.display = "none";
						document.getElementById("tchat").value=0;
					}             
			}';
			if($auto_popup=='yes'){
				echo 'setTimeout(function() {document.getElementById("fchat").style.display = "block";}, '.$auto_popup_delay.');';
			}
	echo '</script>'."\n\r";
}


/* 
Hook action để hiển thị khung chat
*/
register_action('after_hm_footer','hm_fbchat_chatbox');
function hm_fbchat_chatbox(){
	
	$background = get_option( array('section'=>'hm_fbchat','key'=>'background','default_value'=>'#0065BF') );
	$boxtitle = get_option( array('section'=>'hm_fbchat','key'=>'boxtitle','default_value'=>'Hỗ trợ trực tuyến') );
	$fanpage = get_option( array('section'=>'hm_fbchat','key'=>'fanpage','default_value'=>'') );
	
	echo 	'<style>
				#cfacebook a.chat_fb{
					background-color: '.$background.';
				}
			</style>';
	
	echo '	<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, \'script\', \'facebook-jssdk\'));</script>';
			
	echo '	<div id="cfacebook">
				<a href="javascript:;" class="chat_fb" onclick="javascript:fchat();"><i class="fa fa-comments"></i>'.$boxtitle.'</a>
				<div id="fchat" class="fchat">
					<div class="fb-page" data-tabs="messages" data-href="'.$fanpage.'" data-width="250" data-height="400" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"></div>
				</div>
				<input type="hidden" id="tchat" value="0"/>
			 </div>'."\n\r";
			 
}