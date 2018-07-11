<?php
/*
Ajax add product to cart
*/
register_request('ajaxcart', 'hme_ajaxcart');
function hme_ajaxcart() {
    $pid            = hm_post('id', FALSE);
    $quantity       = hm_post('quantity', FALSE);
    $action         = hm_post('action', FALSE);
    $product_option = hm_post('product_option', FALSE);
    $version        = hm_post('version', FALSE);
    $type           = hm_post('type', 'cart');
    /* get from sesion */
    switch ($type) {
        case 'cart':
            $session_data = $_SESSION['hmecart'];
            break;
        case 'installment':
            $session_data = $_SESSION['hmeinstallment'];
            break;
        default:
            $session_data = $_SESSION['hmecart'];
    }

    if (!is_array($product_option)) {
        parse_str($product_option, $product_option);
    }

    if (!is_array($session_data)) {
        $session_data = array();
    }

    if (!is_numeric($quantity)) {
        $quantity = 1;
    }

    if (isset_content_id($pid)) {

        /* first, reset all version name and price */
        if (isset($_SESSION['version_name'][$pid])) {
            unset($_SESSION['version_name'][$pid]);
        }
        if (isset($_SESSION['version_price'][$pid])) {
            unset($_SESSION['version_price'][$pid]);
        }

        switch ($action) {
            case 'add':
                $session_data[$pid]                       = $quantity;
                $_SESSION['hmecart_product_option'][$pid] = $product_option;
                $_SESSION['version'][$pid]                = $version;
                break;
            case 'remove':
                if (isset($session_data[$pid])) {
                    unset($session_data[$pid]);
                }
                if (isset($_SESSION['hmecart_product_option'][$pid])) {
                    unset($_SESSION['hmecart_product_option'][$pid]);
                }
                if (isset($_SESSION['version'][$pid])) {
                    unset($_SESSION['version'][$pid]);
                }
                break;
        }


        $total_product = sizeof($session_data);
        $total_price   = 0;
        foreach ($session_data as $pid => $qty) {
            $active_deal          = get_con_val("name=active_deal&id=$pid");
            $deal_start           = get_con_val("name=deal_start&id=$pid");
            $deal_end             = get_con_val("name=deal_end&id=$pid");
            $deal_start_timestamp = '';
            if ($deal_start != '') {
                $dtime                = DateTime::createFromFormat("Y/m/d H:i", $deal_start);
                $deal_start_timestamp = $dtime->getTimestamp();
            }
            $deal_end_timestamp = '';
            if ($deal_end != '') {
                $dtime              = DateTime::createFromFormat("Y/m/d H:i", $deal_end);
                $deal_end_timestamp = $dtime->getTimestamp();
            }
            if ($version != 0 && is_numeric($version)) {
                $version_names       = get_con_val('name=version_name&id=' . $pid);
                $version_names       = json_decode($version_names, TRUE);
                $version_prices      = get_con_val('name=version_price&id=' . $pid);
                $version_prices      = json_decode($version_prices, TRUE);
                $version_deal_prices = get_con_val('name=version_deal_price&id=' . $pid);
                $version_deal_prices = json_decode($version_deal_prices, TRUE);
                if (is_array($version_names)) {
                    foreach ($version_names as $line => $version_name) {
                        if($line == $version){
                            $_SESSION['version_name'][$pid] = $version_name;
                            if ($deal_start_timestamp != '' && time() > $deal_start_timestamp && time() < $deal_end_timestamp && $active_deal == 'yes') {
                                $_SESSION['version_price'][$pid] = $version_deal_prices[$line];
                            } else {
                                $_SESSION['version_price'][$pid] = $version_prices[$line];
                            }
                        }
                    }
                }

            } else {
                if ($deal_start_timestamp != '' && time() > $deal_start_timestamp && time() < $deal_end_timestamp && $active_deal == 'yes') {
                    $price = get_con_val("name=deal_price&id=$pid");
                } else {
                    $price = get_con_val("name=price&id=$pid");
                }
                $_SESSION['price'][$pid] = $price;
            }
            $price       = $price * $qty;
            $total_price = $total_price + $price;
        }

        $total_price_num   = number_format($total_price);
        $total_product_num = number_format($total_product);

        /* set to sesion */
        switch ($type) {
            case 'cart':
                $_SESSION['hmecart'] = $session_data;
                break;
            case 'installment':
                $_SESSION['hmeinstallment'] = $session_data;
                break;
            default:
                $_SESSION['hmecart'] = $session_data;
        }

        echo json_encode(array(
            'status' => 'success',
            'total_price' => $total_price,
            'total_product' => $total_product,
            'total_price_num' => $total_price_num,
            'total_product_num' => $total_product_num
        ));
    } else {
        echo json_encode(array(
            'status' => 'error',
            'mes' => 'invalid id'
        ));
    }

}
?>
