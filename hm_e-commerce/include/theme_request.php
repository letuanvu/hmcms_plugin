<?php
/* 
Đăng ký trang ajax cho vào giỏ
*/
register_request('ajaxcart','hme_ajaxcart');
function hme_ajaxcart(){
	$pid = hm_post('id',FALSE);
	$quantity = hm_post('quantity',FALSE);
	$action = hm_post('action',FALSE);
	$product_option = hm_post('product_option',FALSE);
	if(!is_array($product_option)){
		parse_str($product_option, $product_option);
	}
	
	
	if(!is_array($_SESSION['hmecart'])){$_SESSION['hmecart']=array();}
	
	if(!is_numeric($quantity)){$quantity=1;}
	
	if(isset_content_id($pid)){
		
		switch ($action) {
			case 'add':
				$_SESSION['hmecart'][$pid] = $quantity;
				$_SESSION['hmecart_product_option'][$pid] = $product_option;
			break;
			case 'remove':
				if(isset($_SESSION['hmecart'][$pid])){
					unset($_SESSION['hmecart'][$pid]);
				}
				if(isset($_SESSION['hmecart_product_option'][$pid])){
					unset($_SESSION['hmecart_product_option'][$pid]);
				}
			break;
		}
		
		
		$hmecart = $_SESSION['hmecart'];
		$total_product = sizeof($hmecart);
		$total_price = 0;
		foreach($hmecart as $pid => $qty){
			$price = get_con_val("name=price&id=$pid");
			$price = $price * $qty;
			$total_price = $total_price + $price;
		}
		
		$total_price_num = number_format($total_price);
		$total_product_num = number_format($total_product);
		
		echo json_encode(
				array(
					'status' => 'success',
					'total_price' => $total_price,
					'total_product' => $total_product,
					'total_price_num' => $total_price_num,
					'total_product_num' => $total_product_num,
				)
			);
	}else{
		echo json_encode(
				array(
					'status' => 'error',
					'mes' => 'invalid id',
				)
			);
	}
	
}
?>