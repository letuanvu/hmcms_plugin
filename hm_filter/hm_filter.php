<?php
/*
Plugin Name: Bộ lọc;
Description: Lọc nội dung theo các tiêu chí do bạn tự cài đặt;
Version: 1.3;
Version Number: 4;
*/

/** Tạo các table cần thiết cho kiểu lọc danh mục */
$hmdb   = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
$result = $hmdb->GetTables();

$tableName = DB_PREFIX . "filter_group_taxonomy";
if (!in_array($tableName, $result)) {
  $sql = "
  CREATE TABLE IF NOT EXISTS `" . $tableName . "` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `taxonomy_id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `type` varchar(255) NOT NULL,
    `input_type` varchar(255) NOT NULL,
    `number_order` int(11) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  ";
  $hmdb->Query($sql);
}

$tableName = DB_PREFIX . "filter_option_taxonomy";
if (!in_array($tableName, $result)) {
  $sql = "
  CREATE TABLE IF NOT EXISTS `" . $tableName . "` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `filter_group_taxonomy` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `type` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `number_order` int(11) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  ";
  $hmdb->Query($sql);
}


/** Tạo các table cần thiết cho kiểu lọc content type */
$hmdb   = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
$result = $hmdb->GetTables();

$tableName = DB_PREFIX . "filter_group_content";
if (!in_array($tableName, $result)) {
  $sql = "
  CREATE TABLE IF NOT EXISTS `" . $tableName . "` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `content_key` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `type` varchar(255) NOT NULL,
    `input_type` varchar(255) NOT NULL,
    `number_order` int(11) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  ";
  $hmdb->Query($sql);
}

$tableName = DB_PREFIX . "filter_option_content";
if (!in_array($tableName, $result)) {
  $sql = "
  CREATE TABLE IF NOT EXISTS `" . $tableName . "` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `filter_group_taxonomy` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `type` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `number_order` int(11) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  ";
  $hmdb->Query($sql);
}



/** load file xử lý theo kiểu lọc */
$filter_type = get_option(array(
    'section' => 'hm_filter',
    'key' => 'filter_type',
    'default_value' => 'taxonomy'
));
switch ($filter_type) {
    case 'taxonomy':
        hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_filter/taxonomy.php');
        register_action('hm_admin_head', 'hm_filter_asset');
        function hm_filter_asset() {
            echo '<script src="' . PLUGIN_URI . 'hm_filter/asset/filter_taxonomy.js"></script>';
            echo '<link href="' . PLUGIN_URI . 'hm_filter/asset/filter_taxonomy.css" rel="stylesheet" type="text/css" />';
        }
        break;
    case 'content':
        hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_filter/content.php');
        register_action('hm_admin_head', 'hm_filter_asset');
        function hm_filter_asset() {
            echo '<script src="' . PLUGIN_URI . 'hm_filter/asset/filter_content.js"></script>';
            echo '<link href="' . PLUGIN_URI . 'hm_filter/asset/filter_content.css" rel="stylesheet" type="text/css" />';
        }
        break;
}

/*
Tạo trang cài đặt
*/
$args = array(
    'label' => 'Bộ lọc',
    'key' => 'hm_filter_setting',
    'function' => 'hm_filter_setting',
    'function_input' => array(),
    'child_of' => FALSE
);
register_admin_setting_page($args);
function hm_filter_setting() {
    if (isset($_POST['submit'])) {
        foreach ($_POST as $key => $value) {
            $args = array(
                'section' => 'hm_filter',
                'key' => $key,
                'value' => $value
            );
            set_option($args);
        }
    }
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_filter/admincp/setting.php');
}


/** hiển thị asset ở giao diện */
register_action('before_hm_footer', 'filter_display_asset');
function filter_display_asset() {
    echo '<!-- Plugin Bộ lọc -->' . "\n\r";
    echo '<link rel="stylesheet" type="text/css" href="' . BASE_URL . HM_PLUGIN_DIR . '/hm_filter/asset/theme.css">' . "\n\r";
    echo '<script src="' . BASE_URL . HM_PLUGIN_DIR . '/hm_filter/asset/theme.js" charset="UTF-8"></script>' . "\n\r";
}

?>
