<?php

/*
Register show order page
*/
$args = array(
    'label' => hme_lang('purchase_order'),
    'admin_menu' => TRUE,
    'key' => 'hm_ecommerce_show_order',
    'function' => 'hm_ecommerce_show_order',
    'icon' => 'fa-cart-plus',
    'child_of' => FALSE
);
register_admin_page($args);

function hm_ecommerce_show_order() {

    $hmdb   = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $status = hm_get('status');
    $data   = array();
    if ($status != NULL) {
        $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_order WHERE `status`='$status' ");
    } else {
        $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_order ");
    }
    if ($hmdb->HasRecords()) {
        while ($row = $hmdb->Row()) {
            $data[] = $row;
        }
        hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_e-commerce/layout/show_order.php', $data);
    } else {
        hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_e-commerce/layout/show_order_null.php', $data);
    }
}


/*
Register edit order page
*/
$args = array(
    'label' => hme_lang('order_details'),
    'admin_menu' => FALSE,
    'key' => 'hm_ecommerce_edit_order',
    'function' => 'hm_ecommerce_edit_order',
    'icon' => 'fa-cart-plus',
    'child_of' => FALSE
);
register_admin_page($args);

function hm_ecommerce_edit_order() {

    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    switch (hm_get('action')) {
        case 'edit':
            $oid = hm_get('id', 0);
            $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_order WHERE `id` = '$oid'");
            if ($hmdb->HasRecords()) {

                if (isset($_POST['save_order_setting'])) {

                    $status = hm_post('status');

                    $tableName        = DB_PREFIX . 'hme_order';
                    $values["status"] = MySQL::SQLValue($status);
                    $whereArray       = array(
                        'id' => MySQL::SQLValue($oid)
                    );
                    $hmdb->UpdateRows($tableName, $values, $whereArray);

                    foreach ($_POST as $post_key => $post_val) {

                        if (is_array($post_val)) {
                            $post_val = hm_json_encode($post_val);
                        }

                        $tableName             = DB_PREFIX . 'field';
                        $whereArray            = array(
                            'id' => MySQL::SQLValue($oid)
                        );
                        $values                = array();
                        $values["name"]        = MySQL::SQLValue($post_key);
                        $values["val"]         = MySQL::SQLValue($post_val);
                        $values["object_id"]   = MySQL::SQLValue($oid, MySQL::SQLVALUE_NUMBER);
                        $values["object_type"] = MySQL::SQLValue('hme_order');
                        $hmdb->AutoInsertUpdate($tableName, $values, $whereArray);
                    }

                }

                /** get order data */
                $tableName  = DB_PREFIX . "hme_order";
                $whereArray = array(
                    'id' => MySQL::SQLValue($oid, MySQL::SQLVALUE_NUMBER)
                );
                $hmdb->SelectRows($tableName, $whereArray);
                if ($hmdb->HasRecords()) {
                    $order = $hmdb->Row();
                    $hmdb->Release();
                }

                /** get order item data */
                $tableName  = DB_PREFIX . "hme_order_item";
                $whereArray = array(
                    'order_id' => MySQL::SQLValue($oid, MySQL::SQLVALUE_NUMBER)
                );
                $hmdb->SelectRows($tableName, $whereArray);
                $order_item = array();
                if ($hmdb->HasRecords()) {
                    while ($row = $hmdb->Row()) {
                        $order_item[] = $row;
                    }
                    $hmdb->Release();
                }

                /** get order field data */
                $tableName  = DB_PREFIX . "field";
                $whereArray = array(
                    'object_id' => MySQL::SQLValue($oid, MySQL::SQLVALUE_NUMBER),
                    'object_type' => MySQL::SQLValue('hme_order')
                );
                $hmdb->SelectRows($tableName, $whereArray);
                $order_field = array();
                if ($hmdb->HasRecords()) {
                    while ($row = $hmdb->Row()) {
                        $order_field[$row->name] = $row->val;
                    }
                    $hmdb->Release();
                }


                hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_e-commerce/layout/edit_order.php', array(
                    'order' => $order,
                    'order_item' => $order_item,
                    'order_field' => $order_field
                ));
            } else {
                echo '<div class="alert alert-danger" role="alert">' . hme_lang('orders_do_not_exist') . '</div>';
            }
            break;
        case 'delete':
            $oid = hm_get('id', 0);
            $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_order WHERE `id` = '$oid'");
            if ($hmdb->HasRecords()) {

                if (isset($_POST['delete_order'])) {

                    $oid = hm_post('id');

                    $tableName  = DB_PREFIX . 'hme_order';
                    $whereArray = array(
                        'id' => MySQL::SQLValue($oid)
                    );
                    $hmdb->DeleteRows($tableName, $whereArray);

                    $tableName  = DB_PREFIX . 'hme_order_item';
                    $whereArray = array(
                        'order_id' => MySQL::SQLValue($oid)
                    );
                    $hmdb->DeleteRows($tableName, $whereArray);

                    $tableName  = DB_PREFIX . 'field';
                    $whereArray = array(
                        'object_id' => MySQL::SQLValue($oid),
                        'object_type' => MySQL::SQLValue('hme_order')
                    );
                    $hmdb->DeleteRows($tableName, $whereArray);

                    $url = BASE_URL . HM_ADMINCP_DIR . '/?run=admin_page.php&key=hm_ecommerce_show_order';
                    echo '<meta http-equiv="refresh" content="0;' . $url . '">';
                    exit();

                }

                /** get order data */
                $tableName  = DB_PREFIX . "hme_order";
                $whereArray = array(
                    'id' => MySQL::SQLValue($oid, MySQL::SQLVALUE_NUMBER)
                );
                $hmdb->SelectRows($tableName, $whereArray);
                if ($hmdb->HasRecords()) {
                    $order = $hmdb->Row();
                    $hmdb->Release();
                }

                /** get order item data */
                $tableName  = DB_PREFIX . "hme_order_item";
                $whereArray = array(
                    'order_id' => MySQL::SQLValue($oid, MySQL::SQLVALUE_NUMBER)
                );
                $hmdb->SelectRows($tableName, $whereArray);
                $order_item = array();
                if ($hmdb->HasRecords()) {
                    while ($row = $hmdb->Row()) {
                        $order_item[] = $row;
                    }
                    $hmdb->Release();
                }

                /** get order field data */
                $tableName  = DB_PREFIX . "field";
                $whereArray = array(
                    'object_id' => MySQL::SQLValue($oid, MySQL::SQLVALUE_NUMBER),
                    'object_type' => MySQL::SQLValue('hme_order')
                );
                $hmdb->SelectRows($tableName, $whereArray);
                $order_field = array();
                if ($hmdb->HasRecords()) {
                    while ($row = $hmdb->Row()) {
                        $order_field[$row->name] = $row->val;
                    }
                    $hmdb->Release();
                }

                hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_e-commerce/layout/delete_order.php', array(
                    'customer' => $customer,
                    'order_item' => $order_item,
                    'order_field' => $order_field
                ));
            } else {
                echo '<div class="alert alert-danger" role="alert">' . hme_lang('orders_do_not_exist') . '</div>';
            }
            break;
    }
}
?>
