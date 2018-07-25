<?php
/*
Plugin Name: HM E-commerce;
Description: Thêm tính năng bán hàng, chỉ dùng cho giao diện có hỗ trợ;
Version: 1.3;
Version Number: 4;
*/

/** Include */
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/lang.php');
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/check_database.php');
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/con_tax.php');
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/content_box.php');
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/plugin_setting.php');
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/dashboard_box.php');
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/admincp_order.php');
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/admincp_product_option.php');
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/theme_function.php');
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/theme_request.php');
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/ajax.php');
hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/include/admincp_customer.php');

/** admin asset */
register_action('hm_admin_head','add_hme_asset');
function add_hme_asset(){
	echo '<link rel="stylesheet" type="text/css" href="'.BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset/admincp/custom.css">'."\n\r";
	echo '<script type="text/javascript" src="'.BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset/admincp/custom.js" charset="UTF-8"></script>'."\n\r";
}

?>
