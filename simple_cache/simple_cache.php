<?php
/*
Plugin Name: Simple Cache;
Description: Tạo cache đơn giản cho website;
Version: 1.0;
Version Number: 1;
*/

/** Tạo forder cache */
$cache_dir = BASEPATH . HM_CONTENT_DIR . '/uploads/simple_cache';
if (!file_exists($cache_dir)) {
    mkdir($cache_dir, 0777);
}

/** dùng hook action tạo cache trước khi load template */
register_action('before_load_main_template_file', 'ob_start_file_cache');
function ob_start_file_cache()
{

    if (!is_admin_login() AND !is_404()) {

        $theme = activated_theme();
        $request_slug = md5($_SERVER['REQUEST_URI']) . get_current_uri();
        $cache_file = $theme . '_' . $request_slug;
        $cache_file = str_replace('/', '-', $cache_file);
        $cache_dir = BASEPATH . HM_CONTENT_DIR . '/uploads/simple_cache';
        $cache_file_local = $cache_dir . '/' . $cache_file;
        $cache_time = 18000;

        if (file_exists($cache_file_local) && time() - $cache_time < filemtime($cache_file_local)) {
            include($cache_file_local);
            exit();
        } else {
            ob_start();
        }

    }

}

/** dùng hook action tạo cache sau khi load template */
register_action('after_load_main_template_file', 'ob_end_flush_file_cache');
function ob_end_flush_file_cache()
{
    if (!is_admin_login() AND !is_404()) {

        $theme = activated_theme();
        $request_slug = md5($_SERVER['REQUEST_URI']) . get_current_uri();
        $cache_file = $theme . '_' . $request_slug;
        $cache_file = str_replace('/', '-', $cache_file);
        $cache_dir = BASEPATH . HM_CONTENT_DIR . '/uploads/simple_cache';
        $cache_file_local = $cache_dir . '/' . $cache_file;

        $cached = fopen($cache_file_local, 'w');
        $ob_get_contents = ob_get_contents();
        $ob_get_contents = preg_replace('/\s+/', ' ', $ob_get_contents);
        $ob_get_contents = $ob_get_contents . "\n\r<!-- Simple Cache, generated " . date('d-m-Y / H:i:s') . " -->\n\r";
        fwrite($cached, $ob_get_contents);
        fclose($cached);
        ob_end_flush();

    }

}

/* 
Đăng ký trang plugin setting
*/
$args = [
    'label' => 'Xóa Cache',
    'key' => 'simple_cache_empty_cache',
    'function' => 'simple_cache_empty_cache',
    'function_input' => [],
    'child_of' => false,
];
register_admin_setting_page($args);
function simple_cache_empty_cache()
{

    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/simple_cache/layout/empty_cache.php');

}

?>