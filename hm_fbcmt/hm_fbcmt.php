<?php
/*
Plugin Name: Bình luận bằng facebook;
Description: Thêm bình luận bằng facebook cho nội dung;
Version: 1.0;
Version Number: 1;
*/
/* 
Tạo content box
*/
$args = [
    'label' => 'Bình luận Facebook',
    'position' => 'left',
    'function' => 'facebook_cmt_content_box',
];
register_content_box($args);
function facebook_cmt_content_box()
{
    fbcmt_enable();
    fbcmt_number_cmt();
}

function fbcmt_enable()
{
    $args = [
        'nice_name' => 'Hiện box bình luận facebook:',
        'name' => 'fbcmt_enable',
        'input_type' => 'select',
        'input_option' => [
            ['value' => 'yes', 'label' => 'Có'],
            ['value' => 'no', 'label' => 'Không'],
        ],
    ];
    $args['default_value'] = get_con_val(['name' => 'fbcmt_enable', 'id' => hm_get('id')]);
    build_input_form($args);
}

function fbcmt_number_cmt()
{
    $args = [
        'nice_name' => 'Số bình luận hiển thị:',
        'name' => 'fbcmt_number_cmt',
        'input_type' => 'text',
        'required' => false,
    ];
    $args['default_value'] = get_con_val(['name' => 'fbcmt_number_cmt', 'id' => hm_get('id')]);
    if (!is_numeric($args['default_value'])) {
        $args['default_value'] = 5;
    }
    build_input_form($args);
}

/*
Đăng ký trang plugin setting
*/
$args = [
    'label' => 'Bình luận Facebook',
    'key' => 'hm_fbcmt_main_setting',
    'function' => 'hm_fbcmt_main_setting',
    'function_input' => [],
    'child_of' => false,
];
register_admin_setting_page($args);
function hm_fbcmt_main_setting()
{

    if (isset($_POST['save_fbcmt_setting'])) {

        foreach ($_POST as $key => $value) {

            $args = [
                'section' => 'hm_fbcmt',
                'key' => $key,
                'value' => $value,
            ];

            set_option($args);

        }

    }

    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_fbcmt/layout/main_setting.php');
}

/*
Hook action để hiển thị meta appid
*/
register_action('after_hm_head', 'hm_fbcmt_display_meta_appid');
function hm_fbcmt_display_meta_appid()
{
    $appid = get_option(['section' => 'hm_fbcmt', 'key' => 'appid']);
    if ($appid) {
        echo '<meta property="fb:app_id" content="' . $appid . '"/>';
    }
}


/* 
Hook filter để hiển thị khung bình luận
*/
register_filter('after_get_con_val', 'fbcmt_display');
function fbcmt_display($value, $input)
{
    if (is_content()) {
        $content_id = $input['id'];
        $data = content_data_by_id($content_id);
        $content_key = $data['content']->key;
        $location = get_option(['section' => 'hm_fbcmt', 'key' => 'location_' . $content_key]);
        $fbcmt_number_cmt = get_option(['section' => 'hm_fbcmt', 'key' => 'number_cmt']);
        if (!$location) {
            $location = 'content';
        }
        if ($location != 'hidden') {

            $show_cmt_box = true;
            $url = BASE_URL . '?c=' . $content_id;

            if (isset($data['field']['fbcmt_enable'])) {
                if ($data['field']['fbcmt_enable'] == 'no') {
                    $show_cmt_box = false;
                }
            }
            if (isset($data['field']['fbcmt_number_cmt'])) {
                if (is_numeric($data['field']['fbcmt_number_cmt'])) {
                    $fbcmt_number_cmt = $data['field']['fbcmt_number_cmt'];
                }
            }
            $appid = get_option(['section' => 'hm_fbcmt', 'key' => 'appid']);
            if ($input['name'] == $location) {
                $fbcmt = '<div class="hm_fbcmt">';
                $fbcmt .= '<div id="fb-root"></div>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5&appId=' . $appid . '";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, \'script\', \'facebook-jssdk\'));</script>';
                $fbcmt .= '<div class="fb-comments" data-href="' . $url . '" data-numposts="' . $fbcmt_number_cmt . '" data-width="100%"></div>';
                $fbcmt .= '</div>';
                $value = $value . $fbcmt;
            }

        }

    }
    return $value;
}

/* 
Hiển thị theo code
*/
function fbcmt()
{

    $fbcmt = '';
    $show_cmt_box = false;
    $appid = get_option(['section' => 'hm_fbcmt', 'key' => 'appid']);

    if (is_content()) {
        $id = get_id();
        $url = BASE_URL . '?c=' . $id;
        $fbcmt_enable = get_con_val("name=fbcmt_enable&id=$id");
        if ($fbcmt_enable != 'no') {
            $show_cmt_box = true;
        }
        $fbcmt_number_cmt = get_con_val("name=fbcmt_number_cmt&id=$id");
        if (!is_numeric($fbcmt_number_cmt)) {
            $fbcmt_number_cmt = 5;
        }
    }

    if (is_taxonomy()) {
        $id = get_id();
        $url = BASE_URL . '?t=' . $id;
        $fbcmt_enable = get_tax_val("name=fbcmt_enable&id=$id");
        if ($fbcmt_enable != 'no') {
            $show_cmt_box = true;
        }
        $fbcmt_number_cmt = get_tax_val("name=fbcmt_number_cmt&id=$id");
        if (!is_numeric($fbcmt_number_cmt)) {
            $fbcmt_number_cmt = 5;
        }
    }

    if ($show_cmt_box) {
        $fbcmt = '<div class="hm_fbcmt">';
        $fbcmt .= '<div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5&appId=' . $appid . '";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, \'script\', \'facebook-jssdk\'));</script>';
        $fbcmt .= '<div class="fb-comments" data-href="' . $url . '" data-numposts="' . $fbcmt_number_cmt . '" data-width="100%"></div>';
        $fbcmt .= '</div>';
    }
    echo $fbcmt;
}

?>