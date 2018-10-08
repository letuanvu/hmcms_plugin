<?php

/*
Đăng ký trang list thuộc tính sản phẩm
*/
$product_options = get_option([
    'section' => 'hme',
    'key' => 'product_options',
    'default_value' => 'yes'
]);
if ($product_options == 'yes') {
    $args = [
        'label' => hme_lang('product_attributes'),
        'admin_menu' => true,
        'key' => 'hm_ecommerce_product_option',
        'function' => 'hm_ecommerce_product_option',
        'child_of' => 'content/product'
    ];
    register_admin_page($args);
}
function hm_ecommerce_product_option()
{
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $data = [];
    $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_product_option_group");
    while ($row = $hmdb->Row()) {
        $data[] = $row;
    }
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_e-commerce/layout/product_option.php', $data);
}

/*
Đăng ký trang tạo thuộc tính sản phẩm
*/
$args = [
    'label' => hme_lang('add_product_attributes'),
    'admin_menu' => false,
    'key' => 'hm_ecommerce_product_option_add',
    'function' => 'hm_ecommerce_product_option_add'
];
register_admin_page($args);

function hm_ecommerce_product_option_add()
{

    if (isset($_POST['add_group'])) {

        $group_name = hm_post('group_name', '');
        if ($group_name != '') {

            $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
            $tableName = DB_PREFIX . "hme_product_option_group";
            $group_slug = sanitize_title($group_name);
            $values = [];
            $values["name"] = MySQL::SQLValue($group_name);
            $values["slug"] = MySQL::SQLValue($group_slug);
            $values["key"] = MySQL::SQLValue('product');
            $values["parent"] = MySQL::SQLValue('0');
            $values["group_order"] = MySQL::SQLValue('0');
            $insert_id = $hmdb->InsertRow($tableName, $values);
            if (is_numeric($insert_id)) {
                $url = BASE_URL . HM_ADMINCP_DIR . '?run=admin_page.php&key=hm_ecommerce_product_option_edit&id=' . $insert_id;
                hm_redirect($url);
            }

        }

    }

    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_e-commerce/layout/product_option_add.php');
}

/*
Đăng ký trang sửa thuộc tính sản phẩm
*/
$args = [
    'label' => hme_lang('edit_product_attributes'),
    'admin_menu' => false,
    'key' => 'hm_ecommerce_product_option_edit',
    'function' => 'hm_ecommerce_product_option_edit'
];
register_admin_page($args);

function hm_ecommerce_product_option_edit()
{

    $id = hm_get('id');
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

    /** Thêm option */
    if (isset($_POST['add_option'])) {

        $option_name = hm_post('option_name', '');
        $option_image = hm_post('option_image', '');
        if ($option_name != '') {

            $tableName = DB_PREFIX . "hme_product_option";
            $option_slug = sanitize_title($option_name);
            $values = [];
            $values["name"] = MySQL::SQLValue($option_name);
            $values["slug"] = MySQL::SQLValue($option_slug);
            $values["option_image"] = MySQL::SQLValue($option_image);
            $values["key"] = MySQL::SQLValue('product');
            $values["parent"] = MySQL::SQLValue('0');
            $values["group_id"] = MySQL::SQLValue($id);
            $insert_id = $hmdb->InsertRow($tableName, $values);

        }

    }

    $data = [
        'data_group' => [],
        'data_option' => []
    ];

    $tableName = DB_PREFIX . "hme_product_option_group";
    $whereArray = [
        'id' => MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER)
    ];
    $hmdb->SelectRows($tableName, $whereArray);
    if ($hmdb->HasRecords()) {
        $data['data_group'] = $hmdb->Row();
    }

    $tableName = DB_PREFIX . "hme_product_option";
    $whereArray = [
        'group_id' => MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER)
    ];
    $hmdb->SelectRows($tableName, $whereArray);
    if ($hmdb->HasRecords()) {
        while ($row = $hmdb->Row()) {
            $data['data_option'][] = $row;
        }
    }

    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_e-commerce/layout/product_option_edit.php', $data);
}


/*
Đăng ký trang xóa thuộc tính sản phẩm
*/
$args = [
    'label' => hm_lang('delete_product_attributes'),
    'admin_menu' => false,
    'key' => 'hm_ecommerce_product_option_delete',
    'function' => 'hm_ecommerce_product_option_delete'
];
register_admin_page($args);

function hm_ecommerce_product_option_delete()
{

    $id = hm_get('id');
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

    $tableName = DB_PREFIX . 'hme_product_option_group';
    $whereArray = [
        'id' => MySQL::SQLValue($id)
    ];
    $hmdb->DeleteRows($tableName, $whereArray);

    $tableName = DB_PREFIX . 'hme_product_option';
    $whereArray = [
        'group_id' => MySQL::SQLValue($id)
    ];
    $hmdb->DeleteRows($tableName, $whereArray);

    $url = BASE_URL . HM_ADMINCP_DIR . '?run=admin_page.php&key=hm_ecommerce_product_option';
    hm_redirect($url);

}

?>
