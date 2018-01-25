<?php
/*
Plugin Name: Banber hai bên;
Description: Tạo banner chạy dọc hai bên website;
Version: 1;
Version Number: 1;
*/

/* 
Đăng ký trang cài đặt cho plugin
*/
$args=array(
	'label'=>'Banber hai bên',
	'key'=>'float_banner_setting',
	'function'=>'float_banner_setting',
	'function_input'=>array(),
	'child_of'=>FALSE,
);
register_admin_setting_page($args);
function float_banner_setting(){
	
	if(isset($_POST['save_setting'])){
		
		foreach($_POST as $key => $value){
			
			$args = array(
							'section'=>'float_banner',
							'key'=>$key,
							'value'=>$value,
						);
			
			set_option($args);
			
		}
	
	}
	
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/float_banner/admincp/setting.php');
}



/** hook action hiển thị banner */
register_action('before_hm_footer','float_banner_display');
function float_banner_display(){
	
	$site_wrapper_width = get_option( array('section'=>'float_banner','key'=>'site_wrapper_width','default_value'=>'1170') );
	$banner_left_width = get_option( array('section'=>'float_banner','key'=>'banner_left_width','default_value'=>'100') );
	$banner_right_width = get_option( array('section'=>'float_banner','key'=>'banner_right_width','default_value'=>'100') );
	$banner_margin_top = get_option( array('section'=>'float_banner','key'=>'banner_margin_top','default_value'=>'0') );
	$banner_margin_bottom = get_option( array('section'=>'float_banner','key'=>'banner_margin_bottom','default_value'=>'0') );
	$banner_left = get_option( array('section'=>'float_banner','key'=>'banner_left') );
	$banner_right = get_option( array('section'=>'float_banner','key'=>'banner_right') );
	
	echo '<div id="SiteLeft" style="display: none">
            <div class="ban_scroll" id="ban_left" style="width: '.$banner_left_width.'px">
                <div class="item">
					'.$banner_left.'
				</div>
			</div>
		</div>';
	echo '<div id="SiteRight" style="display: none">
            <div class="ban_scroll" id="ban_right" style="width: '.$banner_right_width.'px">
                <div class="item">
					'.$banner_right.'
				</div>
			</div>
		</div>';
		
	echo '<script>
		$(document).ready(function () {
			$("#SiteLeft").show();
			$("#SiteRight").show();
			var positionQuery = \'.ban_scroll .item\';
			if (positionQuery.length > 0) {

				var bodywidth = '.$site_wrapper_width.'; 
				var widthleft = $(\'#SiteLeft .ban_scroll\').width();
				var widthright = $(\'#SiteRight .ban_scroll\').width();
				var xright = (($(document).width() - bodywidth) / 2) + bodywidth;
				var xleft = (($(document).width() - bodywidth) / 2) - widthleft;

				$(window).scroll(function () {
					rePosition();
				});

				$(window).resize(function () {
					rePosition();
				});

				function rePosition() {
					if ($(document.body).width() < bodywidth + widthleft + widthright) {
						$(\'.ban_scroll\').css(\'display\', \'none\');
						return;
					} else {
						$(\'.ban_scroll\').css(\'display\', \'block\');
					}

					xright = (($(document.body).width() - 0 - bodywidth) / 2) + bodywidth + 10;

					if (widthleft == null) {
						xleft = (($(document.body).width() - 0 - bodywidth) / 2) - widthright - 10;
					} else {
						xleft = (($(document.body).width() - 0 - bodywidth) / 2) - widthleft - 10;
					}
					var $toadoOld = 0;
					var $toadoCurr = $(window).scrollTop();

					var heightFromTop = 0;
					var fixPos = '.$banner_margin_top.';
					var newtop = 0;
					var botPos = $(document).height() - $(".ban_scroll").height() - '.$banner_margin_bottom.';
					if ($toadoCurr < fixPos) {
						newtop = fixPos - $toadoCurr;
					}
					else if ($toadoCurr >= botPos) {
						newtop = 246;
					}
					else {
						newtop = 0;
					}


					if ($(\'#SiteLeft .ban_scroll .item\').length != 0) {
						if ($toadoCurr >= botPos) {
							$(\'#SiteLeft .ban_scroll\').css({ \'position\': \'fixed\', \'bottom\': newtop, \'top\': \'\', \'left\': xleft });
						}
						else {
							$(\'#SiteLeft .ban_scroll\').css({ \'position\': \'fixed\', \'top\': newtop, bottom: \'\', \'left\': xleft });
						}

					}
					if ($(\'#SiteRight .ban_scroll .item\').length != 0) {
						if ($toadoCurr >= botPos) {
							$(\'#SiteRight .ban_scroll\').css({ \'position\': \'fixed\', \'bottom\': newtop, \'top\': \'\', \'right\': xleft });
						}
						else {
							$(\'#SiteRight .ban_scroll\').css({ \'position\': \'fixed\', \'top\': newtop, \'bottom\': \'\', \'right\': xleft });
						}
					}

					$toadoOld = $toadoCurr;
				}

				rePosition();
			}

		});
		</script>';	
	
}
?>