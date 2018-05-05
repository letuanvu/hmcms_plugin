<?php

function hme_total_price() {
    $total_price = 0;
    if (isset($_SESSION['hmecart'])) {
        if (!is_array($_SESSION['hmecart'])) {
            $_SESSION['hmecart'] = array();
        }
        $hmecart = $_SESSION['hmecart'];
        foreach ($hmecart as $pid => $qty) {
            $price       = get_con_val("name=price&id=$pid");
            $price       = $price * $qty;
            $total_price = $total_price + $price;
        }
    }
    return $total_price;
}

function hme_total_product() {
    $total_product = 0;
    if (isset($_SESSION['hmecart'])) {
        if (!is_array($_SESSION['hmecart'])) {
            $_SESSION['hmecart'] = array();
        }
        $total_product = sizeof($_SESSION['hmecart']);
    }
    return $total_product;
}

function hme_in_cart($pid) {
    if (!isset($_SESSION['hmecart'])) {
        $_SESSION['hmecart'] = array();
    }
    if (isset($_SESSION['hmecart'][$pid])) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function hme_cart() {

    if (isset($_SESSION['hmecart']) AND is_array($_SESSION['hmecart'])) {
        if (sizeof($_SESSION['hmecart']) > 0) {
            return $_SESSION['hmecart'];
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }

}

/*
Gửi đơn hàng
*/
function hme_submit_cart() {
    if (isset($_SESSION['hmecart']) AND is_array($_SESSION['hmecart'])) {

        /** hme_order */
        $hmdb      = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
        $tableName = DB_PREFIX . "hme_order";

        $name           = hm_post('name', hme_lang('no_declaration'), FALSE);
        $email          = hm_post('email', hme_lang('no_declaration'), FALSE);
        $mobile         = hm_post('mobile', hme_lang('no_declaration'), FALSE);
        $address        = hm_post('address', hme_lang('no_declaration'), FALSE);
        $payment_method = hm_post('payment_method', hme_lang('no_declaration'), FALSE);
        $ship_method    = hm_post('ship_method', hme_lang('no_declaration'), FALSE);
        $subject        = hm_post('subject', hme_lang('no_declaration'), FALSE);
        $message        = hm_post('message', hme_lang('no_declaration'), FALSE);
        $status         = 'not_process';
        $time           = time();

        $customer_id = '0';
        if (hme_customer_logined()) {
            $customer_id = $_SESSION['customer']->id;
        }

        $values                   = array();
        $values["name"]           = MySQL::SQLValue($name);
        $values["email"]          = MySQL::SQLValue($email);
        $values["mobile"]         = MySQL::SQLValue($mobile);
        $values["address"]        = MySQL::SQLValue($address);
        $values["payment_method"] = MySQL::SQLValue($payment_method);
        $values["ship_method"]    = MySQL::SQLValue($ship_method);
        $values["subject"]        = MySQL::SQLValue($subject);
        $values["message"]        = MySQL::SQLValue($message);
        $values["status"]         = MySQL::SQLValue($status);
        $values["time"]           = MySQL::SQLValue($time);
        $values["customer_id"]    = MySQL::SQLValue($customer_id);

        $letter_content = '';
        $letter_content .= '<p>' . hme_lang('customer_name') . ': ' . $name . '</p>';
        $letter_content .= '<p>' . hme_lang('email') . ': ' . $email . '</p>';
        $letter_content .= '<p>' . hme_lang('phone_number') . ': ' . $mobile . '</p>';
        $letter_content .= '<p>' . hme_lang('address') . ': ' . $address . '</p>';
        $letter_content .= '<p>' . hme_lang('payment_method') . ': ' . $payment_method . '</p>';
        $letter_content .= '<p>' . hme_lang('ship_method') . ': ' . $ship_method . '</p>';
        $letter_content .= '<p>' . hme_lang('title') . ': ' . $subject . '</p>';
        $letter_content .= '<p>' . hme_lang('message') . ': ' . $message . '</p>';
        $letter_content .= '<p>' . hme_lang('sent_date') . ': ' . date('d-m-Y h:i:s', $time) . '</p>';

        $insert_id = $hmdb->InsertRow($tableName, $values);
        if (is_numeric($insert_id)) {

            /** field */
            $_POST['customer_id'] = $customer_id;
            $tableName            = DB_PREFIX . 'field';
            foreach ($_POST as $post_key => $post_val) {
                if (is_array($post_val)) {
                    $post_val = hm_json_encode($post_val);
                }
                $values                = array();
                $values["name"]        = MySQL::SQLValue($post_key);
                $values["val"]         = MySQL::SQLValue($post_val);
                $values["object_id"]   = MySQL::SQLValue($insert_id, MySQL::SQLVALUE_NUMBER);
                $values["object_type"] = MySQL::SQLValue('hme_order');
                $hmdb->InsertRow($tableName, $values);
            }

            $letter_content .= '<table>';
            $letter_content .= '<tr>';
            $letter_content .= '<td>' . hme_lang('product') . '<td>';
            $letter_content .= '<td>' . hme_lang('unit_price') . '<td>';
            $letter_content .= '<td>' . hme_lang('quantity') . '<td>';
            $letter_content .= '<td>' . hme_lang('total_amount') . '<td>';
            $letter_content .= '</tr>';

            /** hme_order_item */
            $cart       = $_SESSION['hmecart'];
            $tableName  = DB_PREFIX . "hme_order_item";
            $cart_total = 0;
            foreach ($cart as $pid => $qty) {
                $name  = get_con_val("name=name&id=$pid");
                $price = get_con_val("name=price&id=$pid");

                $values                  = array();
                $values["order_id"]      = MySQL::SQLValue($insert_id);
                $values["product_id"]    = MySQL::SQLValue($pid);
                $values["product_name"]  = MySQL::SQLValue($name);
                $values["product_price"] = MySQL::SQLValue($price);
                $values["qty"]           = MySQL::SQLValue($qty);

                $product_option = array();
                if (isset($_SESSION['hmecart_product_option'][$pid])) {
                    $product_option = json_encode($_SESSION['hmecart_product_option'][$pid]);
                }

                $values["product_option"] = MySQL::SQLValue($product_option);

                $hmdb->InsertRow($tableName, $values);

                $p_total    = $price * $qty;
                $cart_total = $cart_total + $p_total;
                $letter_content .= '<tr>';
                $letter_content .= '<td>' . $name . '<td>';
                $letter_content .= '<td>' . number_format($price) . '<td>';
                $letter_content .= '<td>' . $qty . '<td>';
                $letter_content .= '<td>' . number_format($p_total) . '<td>';
                $letter_content .= '</tr>';
            }
            unset($_SESSION['hmecart']);
            $letter_content .= '</table>';
            $letter_content .= '<p>' . hme_lang('total_order_amount') . ': ' . number_format($cart_total) . '</p>';

            $noti_email = get_option(array(
                'section' => 'hme',
                'key' => 'noti_email',
                'default_value' => ''
            ));
            $ex         = explode(',', $noti_email);
            foreach ($ex as $mail) {
                $mail = trim($mail);
                hm_mail($mail, hme_lang('order_notification'), $letter_content);
            }
            return array(
                'type' => 'success',
                'insert_id' => $insert_id
            );
        } else {
            return array(
                'type' => 'error',
                'mes' => hme_lang('error_adding_order_please_try_again')
            );
        }
    } else {
        return array(
            'type' => 'error',
            'mes' => hme_lang('you_can_not_send_an_order_without_the_product_in_the_cart')
        );
    }
}

/*
Khách hàng đăng nhập
*/
function hme_customer_login() {

    $args             = array();
    $args['email']    = hm_post('email', '', FALSE);
    $args['password'] = hm_post('password', '', FALSE);

    return hme_customer_login_action($args);

}

function hme_customer_login_action($args) {

    $defaults = array(
        'email' => '',
        'password' => ''
    );
    $args     = hm_parse_args($args, $defaults);

    $email    = $args['email'];
    $password = $args['password'];

    /** hme_customer */
    $hmdb      = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $tableName = DB_PREFIX . "hme_customer";

    $whereArray = array(
        'email' => MySQL::SQLValue($email)
    );
    $hmdb->SelectRows($tableName, $whereArray);
    if ($hmdb->HasRecords()) {

        $row             = $hmdb->Row();
        $password_db     = $row->password;
        $id              = $row->id;
        $password_encode = md5($password);

        if ($password_encode == $password_db) {

            $time       = time();
            $ip         = hm_ip();
            $values     = array(
                'last_login_time' => MySQL::SQLValue($time),
                'ip' => MySQL::SQLValue($ip)
            );
            $whereArray = array(
                'id' => $id
            );
            $hmdb->UpdateRows($tableName, $values, $whereArray);

            $_SESSION['customer'] = $row;

            return array(
                'type' => 'success',
                'mes' => hme_lang('logged_in_successfully'),
                'id' => $id
            );

        } else {
            return array(
                'type' => 'error',
                'mes' => hme_lang('wrong_password')
            );
        }

    } else {
        return array(
            'type' => 'error',
            'mes' => hme_lang('this_email_is_not_registered_account')
        );
    }
}

/*
Khách hàng đăng ký
*/
function hme_customer_register() {

    $args                   = array();
    $args['name']           = hm_post('name', '', FALSE);
    $args['email']          = hm_post('email', '', FALSE);
    $args['mobile']         = hm_post('mobile', '', FALSE);
    $args['password']       = hm_post('password', '', FALSE);
    $args['password_again'] = hm_post('password_again', '', FALSE);

    return hme_customer_register_action($args);

}

function hme_customer_register_action($args) {

    $defaults = array(
        'name' => '',
        'password' => '',
        'password_again' => '',
        'email' => '',
        'mobile' => '',
        'customer_group' => '0',
        'note' => '',
        'user_id' => '0',
        'discount' => '0',
        'discount_type' => 'none',
        'activation_code' => '',
        'register_time' => time(),
        'last_login_time' => time(),
        'id_update' => ''
    );
    $args     = hm_parse_args($args, $defaults);

    /** hme_customer */
    $hmdb      = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $tableName = DB_PREFIX . "hme_customer";

    $name            = $args['name'];
    $password        = $args['password'];
    $password_again  = $args['password_again'];
    $email           = $args['email'];
    $mobile          = $args['mobile'];
    $customer_group  = $args['customer_group'];
    $note            = $args['note'];
    $user_id         = $args['user_id'];
    $discount        = $args['discount'];
    $discount_type   = $args['discount_type'];
    $activation_code = $args['activation_code'];
    $register_time   = $args['register_time'];
    $last_login_time = $args['last_login_time'];
    $id_update       = $args['id_update'];

    $register_time   = $args['register_time'];
    $last_login_time = $args['last_login_time'];
    $ip              = hm_ip();

    $password_req = FALSE;
    if (is_numeric($id_update)) {
        $password_req = TRUE;
    } else {
        if ($password != '') {
            $password_req = TRUE;
        }
    }

    if ($name != '' AND $email != '' AND $mobile != '' AND $password_req != FALSE) {
        if ($password == $password_again) {

            /** check trùng email */
            $check_email = TRUE;
            if (!is_numeric($id_update)) {
                $whereArray = array(
                    'email' => MySQL::SQLValue($email)
                );
                $hmdb->SelectRows($tableName, $whereArray);
                if ($hmdb->HasRecords()) {
                    $check_email = FALSE;
                }
            }

            if ($check_email) {

                if (is_numeric($id_update)) {
                    if (trim($password) == '') {
                        $whereArray = array(
                            'id' => MySQL::SQLValue($id_update, MySQL::SQLVALUE_NUMBER)
                        );
                        $hmdb->SelectRows($tableName, $whereArray);
                        if ($hmdb->HasRecords()) {
                            $row             = $hmdb->Row();
                            $password_encode = $row->password;
                        }
                    } else {
                        $password_encode = md5($password);
                    }
                } else {
                    $password_encode = md5($password);
                }

                $values = array(
                    'name' => MySQL::SQLValue($name),
                    'password' => MySQL::SQLValue($password_encode),
                    'email' => MySQL::SQLValue($email),
                    'mobile' => MySQL::SQLValue($mobile),
                    'customer_group' => MySQL::SQLValue($customer_group),
                    'note' => MySQL::SQLValue($note),
                    'user_id' => MySQL::SQLValue($user_id),
                    'discount' => MySQL::SQLValue($discount),
                    'discount_type' => MySQL::SQLValue($discount_type),
                    'activation_code' => MySQL::SQLValue($activation_code),
                    'register_time' => MySQL::SQLValue($register_time),
                    'last_login_time' => MySQL::SQLValue($last_login_time),
                    'ip' => MySQL::SQLValue($ip)
                );

                if (is_numeric($id_update)) {
                    $whereArray = array(
                        'id' => $id_update
                    );
                    $hmdb->AutoInsertUpdate($tableName, $values, $whereArray);
                    $insert_id = $id_update;
                } else {
                    $insert_id = $hmdb->InsertRow($tableName, $values);
                }

                /** login */
                hme_customer_login(array(
                    'email' => $email,
                    'password' => $password
                ));

                if (is_numeric($id_update)) {
                    $mes = hme_lang('account_updated');
                } else {
                    $mes = hme_lang('account_registration_successful');
                }

                return array(
                    'type' => 'success',
                    'mes' => $mes,
                    'insert_id' => $insert_id
                );


            } else {
                return array(
                    'type' => 'error',
                    'mes' => hme_lang('this_email_was_used_by_another_account')
                );
            }

        } else {
            return array(
                'type' => 'error',
                'mes' => hme_lang('the_two_passwords_you_entered_do_not_match')
            );
        }
    } else {
        if (is_numeric($id_update)) {
            $mes = hme_lang('name_and_email_are_non_blank_fields');
        } else {
            $mes = hme_lang('names_email_and_passwords_are_fields_that_can_not_be_left_blank');
        }
        return array(
            'type' => 'error',
            'mes' => $mes
        );
    }
}


function hme_customer_logined() {

    $return = FALSE;

    if (isset($_SESSION['customer'])) {
        $customer = $_SESSION['customer'];
        if (property_exists($customer, 'id')) {
            $return = TRUE;
        }
    }

    return $return;

}

function hme_customer_order($status = FALSE) {

    $data = array();
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

    if (hme_customer_logined()) {
        $customer    = $_SESSION['customer'];
        $customer_id = $customer->id;
        if ($status != FALSE) {
            $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_order WHERE `status`='$status' AND `customer_id` = $customer_id ");
        } else {
            $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_order WHERE `customer_id`='$customer_id'");
        }
        if ($hmdb->HasRecords()) {
            while ($row = $hmdb->Row()) {
                $data[] = $row;
            }
        }
    }
    return $data;
}

function hme_data_order($oid = 0) {

    $data = FALSE;
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_order WHERE `id` = '$oid'");
    if ($hmdb->HasRecords()) {

        $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_order WHERE `id` = '$oid'");
        $order = $hmdb->Row();

        $order_item = array();
        $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_order_item WHERE `order_id` = '$oid'");
        while ($row = $hmdb->Row()) {
            $order_item[] = $row;
        }

        $order_field = array();
        $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "field WHERE `object_id` = '$oid' AND `object_type` = 'hme_order'");
        while ($row = $hmdb->Row()) {
            $order_field[] = $row;
        }

        $data = array(
            'order' => $order,
            'item' => $order_item,
            'field' => $order_field
        );
    }
    return $data;
}

function hme_customer_update_customer($id = FALSE) {

    if (!is_numeric($id)) {
        if (hme_customer_logined()) {
            $customer = $_SESSION['customer'];
            $id       = $customer->id;
        }
    }

    $args                   = array();
    $args['name']           = hm_post('name', '', FALSE);
    $args['email']          = hm_post('email', '', FALSE);
    $args['mobile']         = hm_post('mobile', '', FALSE);
    $args['password']       = hm_post('password', '', FALSE);
    $args['password_again'] = hm_post('password_again', '', FALSE);
    $args['id_update']      = $id;

    return hme_customer_register_action($args);

}

function hme_product_option($id = FALSE) {
    $hmdb                 = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $product_group_option = get_con_val('name=product_group_option&id=' . $id);
    $product_group_option = json_decode($product_group_option, TRUE);
    $product_option       = get_con_val('name=product_option&id=' . $id);
    $product_option       = json_decode($product_option, TRUE);
    $tableName            = DB_PREFIX . 'hme_product_option';
    if (!is_array($product_group_option)) {
        $product_group_option = array();
    }
    foreach ($product_group_option as $group_id) {
        $group_name = hme_get_option_group('name', $group_id);
        echo '<div class="hme_product_option">' . "\n\r";
        echo '  <div class="hme_product_option_title">' . $group_name . '</div>' . "\n\r";
        echo '  <div class="hme_product_option_content">' . "\n\r";

        $whereArray = array(
            'group_id' => MySQL::SQLValue($group_id, MySQL::SQLVALUE_NUMBER)
        );
        $hmdb->SelectRows($tableName, $whereArray);
        if ($hmdb->HasRecords()) {
            while ($row = $hmdb->Row()) {
                $option_id   = $row->id;
                $option_name = $row->name;
                $option_slug = $row->slug;
                $group_id    = $row->group_id;
                if (in_array($option_id, $product_option)) {
                    echo '<div class="hme_product_option_item">' . "\n\r";
                    echo '  <input type="radio" class="hme_input_product_option" data-id="' . $group_id . '" name="product_option[' . $group_id . ']" value="' . $option_id . '"><span>' . $option_name . '</span>' . "\n\r";
                    echo '</div>' . "\n\r";
                }
            }
        }

        echo '  </div>' . "\n\r";
        echo '</div>' . "\n\r";
    }
}

function hme_get_option_group($field = 'name', $id = 0) {

    $hmdb       = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $tableName  = DB_PREFIX . "hme_product_option_group";
    $whereArray = array(
        'id' => MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER)
    );
    $hmdb->SelectRows($tableName, $whereArray);
    if ($hmdb->HasRecords()) {
        $row = $hmdb->Row();
        return $row->$field;
    } else {
        return FALSE;
    }
}

function hme_get_option($field = 'name', $id = 0) {

    $hmdb       = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $tableName  = DB_PREFIX . "hme_product_option";
    $whereArray = array(
        'id' => MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER)
    );
    $hmdb->SelectRows($tableName, $whereArray);
    if ($hmdb->HasRecords()) {
        $row = $hmdb->Row();
        return $row->$field;
    } else {
        return FALSE;
    }
}

?>
