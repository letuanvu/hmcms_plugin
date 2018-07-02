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
    $vesion         = hm_post('vesion', FALSE);
    if (!is_array($product_option)) {
        parse_str($product_option, $product_option);
    }

    if (!is_array($_SESSION['hmecart'])) {
        $_SESSION['hmecart'] = array();
    }

    if (!is_numeric($quantity)) {
        $quantity = 1;
    }

    if (isset_content_id($pid)) {

        switch ($action) {
            case 'add':
                $_SESSION['hmecart'][$pid]                = $quantity;
                $_SESSION['hmecart_product_option'][$pid] = $product_option;
                $_SESSION['vesion'][$pid]                 = $vesion;
                break;
            case 'remove':
                if (isset($_SESSION['hmecart'][$pid])) {
                    unset($_SESSION['hmecart'][$pid]);
                }
                if (isset($_SESSION['hmecart_product_option'][$pid])) {
                    unset($_SESSION['hmecart_product_option'][$pid]);
                }
                if (isset($_SESSION['vesion'][$pid])) {
                    unset($_SESSION['vesion'][$pid]);
                }
                if (isset($_SESSION['version_name'][$pid])) {
                    unset($_SESSION['version_name'][$pid]);
                }
                if (isset($_SESSION['version_price'][$pid])) {
                    unset($_SESSION['version_price'][$pid]);
                }
                break;
        }


        $hmecart       = $_SESSION['hmecart'];
        $total_product = sizeof($hmecart);
        $total_price   = 0;
        foreach ($hmecart as $pid => $qty) {
            if ($vesion != 0 && is_numeric($vesion)) {
                $version_names  = get_con_val('name=version_name&id=' . $pid);
                $version_names  = json_decode($version_names, TRUE);
                $version_prices = get_con_val('name=version_price&id=' . $pid);
                $version_prices = json_decode($version_prices, TRUE);
                if (is_array($version_names)) {
                    foreach ($version_names as $line => $version_name) {
                        $price                           = $version_prices[$line];
                        $_SESSION['version_name'][$pid]  = $version_name;
                        $_SESSION['version_price'][$pid] = $price;
                    }
                }

            } else {
                $price = get_con_val("name=price&id=$pid");
                $_SESSION['price'][$pid];
            }
            $price       = $price * $qty;
            $total_price = $total_price + $price;
        }

        $total_price_num   = number_format($total_price);
        $total_product_num = number_format($total_product);

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
