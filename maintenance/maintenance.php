<?php
/*
Plugin Name: Chế độ bảo trì;
Description: Tạo chế độ bảo trì cho website;
Version: 1.0;
Version Number: 1;
*/


/* 
Đăng ký trang plugin setting
*/
$args = [
    'label' => _('Chế độ bảo trì'),
    'key' => 'maintenance_main_setting',
    'function' => 'maintenance_main_setting',
    'child_of' => false,
];
register_admin_setting_page($args);


function maintenance_main_setting()
{

    if (isset($_POST['save_setting'])) {

        foreach ($_POST as $key => $value) {

            $args = [
                'section' => 'maintenance',
                'key' => $key,
                'value' => $value,
            ];

            set_option($args);

        }

    }
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/maintenance/layout/main_setting.php');

}


/* 
Hook action hiển thị bảo trì và ngưng chạy web
*/

register_action('before_display_view', 'show_maintenance');
function show_maintenance($args)
{

    $display_maintenance = false;
    $theme = $args['theme'];
    $on_off = get_option(['section' => 'maintenance', 'key' => 'on_off', 'default_value' => 'yes']);
    $display_for_admin = get_option(['section' => 'maintenance', 'key' => 'display_for_admin', 'default_value' => 'yes']);
    $content = get_option(['section' => 'maintenance', 'key' => 'content', 'default_value' => 'yes']);

    if ($on_off == 'yes') {
        if ($display_for_admin == 'no') {

            $display_maintenance = true;

        } else if ($display_for_admin == 'yes') {

            if (!is_null($_SESSION['admin_login'])) {
                $session_admin_login = $_SESSION['admin_login'];
                $session_admin_login = hm_decode_str($session_admin_login);
                $session_admin_login = json_decode($session_admin_login, true);
                $user_id = $session_admin_login['user_id'];
                $args_use = user_data($user_id);
                $user_role = $args_use->user_role;
                if ($user_role != '1') {
                    $display_maintenance = true;
                } else {
                    $display_maintenance = false;
                }
            } else {
                $display_maintenance = true;
            }
        }
    }

    if ($display_maintenance == true) {

        if (file_exists(BASEPATH . HM_THEME_DIR . '/' . $theme . '/maintenance.php')) {
            get_template_part('maintenance');
        } else {
            echo $content;
        }
        exit();

    } else {
        return $args;
    }


}

?>