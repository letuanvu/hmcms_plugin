<?php

/* 
Đăng ký trang plugin setting
*/
$args=array(
	'label'=>hme_lang('e_commercer'),
	'key'=>'hm_ecommerce_main_setting',
	'function'=>'hm_ecommerce_main_setting',
	'child_of'=>FALSE,
);
register_admin_setting_page($args);


function hm_ecommerce_main_setting(){
	
	if(isset($_POST['submit_excel'])){
		hm_ecommerce_import_excel();
	}
	if(isset($_POST['save_hme_setting'])){
		
		foreach($_POST as $key => $value){
			
			$args = array(
							'section'=>'hme',
							'key'=>$key,
							'value'=>$value,
						);
			
			set_option($args);
			
		}
	
	}
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/layout/main_setting.php');
	
}

/* 
Cập nhật sản phẩm từ excel
*/
function hm_ecommerce_import_excel(){
	
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	include (BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/PHPExcel.php');
	
	$dir = BASEPATH.HM_CONTENT_DIR.'/uploads/hm_ecommerce';
	if(!file_exists($dir)){
		mkdir($dir);
		chmod($dir,0777);
	}
	$file = $_FILES['excel'];
	$handle = new Upload($file,LANG);
	if ($handle->uploaded) {
		$handle->Process($dir);
		if ($handle->processed) {
			
			/** tạo .htaccess */
			$fp=fopen($dir.'/.htaccess','w');
			$content_htaccess='RemoveHandler .php .phtml .php3'."\n".'RemoveType .php .phtml .php3';
			fwrite($fp,$content_htaccess);
			fclose($fp);
			
			$file_info=array();
			$file_info['file_src_name'] = $handle->file_src_name;
			$file_info['file_src_name_body'] = $handle->file_src_name_body;
			$file_info['file_src_name_ext'] = $handle->file_src_name_ext;
			$file_info['file_src_mime'] = $handle->file_src_mime;
			$file_info['file_src_size'] = $handle->file_src_size;
			$file_info['file_dst_name'] = $handle->file_dst_name;
			$file_info['file_dst_name_body'] = $handle->file_dst_name_body;
			$file_info['file_dst_name_ext'] = $handle->file_dst_name_ext;
			$file_info['file_is_image'] = $handle->file_is_image;
			
			$saved_file = BASEPATH.HM_CONTENT_DIR.'/uploads/hm_ecommerce/'.$file_info['file_src_name'];
			$objPHPExcel = PHPExcel_IOFactory::load($saved_file);
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			foreach ($cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
			}
			
			foreach($arr_data as $row => $col){
				$col = array_map("trim", $col);
				$col = array_map("strip_tags", $col);
				
				$default_array = 	array(
							'A' => 0,
							'B' => 0,
							'C' => '',
							'D' => '',
							'E' => '',
							'F' => '',
							'G' => '',
						);
				$col = hm_parse_args($col,$default_array);
			
				$id = $col['A'];
				$number_order = $col['B'];
				$name = $col['C'];
				$sku = $col['D'];
				$price = $col['E'];
				$product_status = $col['F'];
				$taxonomy = $col['G'];
				
				preg_match_all('!\d+!', $number_order, $matches);
				if(isset($matches[0][0])){
					$number_order = $matches[0][0];
				}else{
					$number_order = 0;
				}
				
				preg_match_all('!\d+!', $price, $matches);
				if(isset($matches[0][0])){
					$price = $matches[0][0];
				}else{
					$price = 0;
				}
				
				if(isset_content_id($id)){
					content_update_val(
								array(
									'id'=>$id,
									'value'=>array(
										'name' => $name,
									),
								)
					);
					update_con_val(array('id'=>$id,'name'=>'number_order','value'=>$number_order));
					update_con_val(array('id'=>$id,'name'=>'sku','value'=>$sku));
					update_con_val(array('id'=>$id,'name'=>'price','value'=>$price));
					update_con_val(array('id'=>$id,'name'=>'product_status','value'=>$product_status));
					
					$ex = explode(',',$taxonomy);
					$ex = array_map("trim", $ex);
					$taxonomy_array = array();
					foreach($ex as $tax_id){
						if(isset_taxonomy_id($tax_id)){
							$taxonomy_array[] = $tax_id;
						}
					}
					
					update_con_val(array('id'=>$id,'name'=>'taxonomy','value'=>json_encode($taxonomy_array)));
					
					/** lưu relationship content - taxonomy */
					$tableName=DB_PREFIX.'relationship';
					if( isset($taxonomy_array) AND is_array($taxonomy_array) ){

						foreach ( $taxonomy_array as $taxonomy_id ){
							$values["object_id"] = MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER);
							$values["target_id"] = MySQL::SQLValue($taxonomy_id, MySQL::SQLVALUE_NUMBER);
							$values["relationship"] = MySQL::SQLValue('contax');
							$hmdb->AutoInsertUpdate($tableName, $values, $values);	unset($values);
						}
						
					}
					
					/** Gỡ bỏ contax đã bỏ chọn */
					$id_deletes = array();
					$whereArray = array (
											'object_id'=>MySQL::SQLValue($id),
											'relationship'=>MySQL::SQLValue('contax'),
										);
					$hmdb->SelectRows($tableName, $whereArray);
					if( $hmdb->HasRecords() ){
						while( $row=$hmdb->Row() ){
							$id_relationship = $row->id;
							$target_id = $row->target_id;
							if(!in_array ($target_id,$taxonomy_array) ){
								$id_deletes[] = $id_relationship;
							}
						}
					}else{
						$id_deletes = array();
					}
					foreach($id_deletes as $id_delete){
						$whereArray = array (
											'id'=>MySQL::SQLValue($id_delete, MySQL::SQLVALUE_NUMBER),
										);
						$hmdb->DeleteRows($tableName, $whereArray);
					}
					
					
				}
				
			}
			unlink($saved_file);
		}
	}
	
}


/* 
Đăng ký trang in excel
*/
register_request('hm_ecommerce_explode_excel','hm_ecommerce_explode_excel');
function hm_ecommerce_explode_excel(){
	
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	include (BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/PHPExcel.php');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0); 

	$sql = "SELECT * FROM `hm_content` WHERE `key` = 'product' AND `status` = 'public' ";
	$hmdb->Query($sql);
	
	$product_data = array();
	$product_data[0]['id'] = 'ID';
	$product_data[0]['number_order'] = 'STT';
	$product_data[0]['name'] = 'Tên';
	$product_data[0]['sku'] = 'Mã (SKU)';
	$product_data[0]['price'] = 'Giá';
	$product_data[0]['product_status'] = 'Tình trạng';
	$product_data[0]['taxonomy'] = 'ID danh mục';

	
	$i=1;
	while($row_data = $hmdb->RowArray()) {
		
		$id = $row_data['id'];
		$product_data[$i]['id'] = $row_data['id'];
		$product_data[$i]['number_order'] = get_con_val("name=number_order&id=$id");
		$product_data[$i]['name'] = get_con_val("name=name&id=$id");
		$product_data[$i]['sku'] = get_con_val("name=sku&id=$id");
		$product_data[$i]['price'] = get_con_val("name=price&id=$id");
		$product_data[$i]['product_status'] = get_con_val("name=product_status&id=$id");
		$product_taxonomy = get_con_val("name=taxonomy&id=$id");
		$product_taxonomy = json_decode($product_taxonomy,TRUE);
		$product_data[$i]['taxonomy'] = implode(',',$product_taxonomy);
		
		$i++;
	}	
	
	// read data to active sheet
	$objPHPExcel->getActiveSheet()->fromArray($product_data);
	for($col = 'A'; $col !== 'X'; $col++) {
		$objPHPExcel->getActiveSheet()
			->getColumnDimension($col)
			->setAutoSize(true);
	}
	
	$file_name = 'Danh-sach-san-pham__'.date('d-m-Y__H:i:s',time()).'.xls';
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.$file_name.'"');
	$objWriter->save('php://output');
	exit();
	
}
?>