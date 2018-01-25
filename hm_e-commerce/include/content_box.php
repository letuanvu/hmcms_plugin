<?php
/** Tạo content box để up ảnh sản phẩm */
$product_photos = get_option( array('section'=>'hme','key'=>'product_photos','default_value'=>'yes') );
if($product_photos=='yes'){
	function product_image_upload(){

		$args = array(
			'nice_name'=>hme_lang('image_product'),
			'label'=>hme_lang('add_a_product_photo'),
			'name'=>'product_image',
			'input_type'=>'multiimage',
			'required'=>FALSE,
			'imageonly'=>TRUE,
			'default_value'=>get_con_val(array('name'=>'product_image','id'=>hm_get('id')))
		);
		build_input_form($args);
		
	}	
	$args=array(
		'label'=>hme_lang('photos_of_the_product'),
		'content_key'=>'product',
		'position'=>'left',
		'function'=>'product_image_upload',
	);
	register_content_box($args);
}


/** Tạo content box thuộc tính sản phẩm */
$product_options = get_option( array('section'=>'hme','key'=>'product_options','default_value'=>'yes') );
if($product_options=='yes'){
	function product_option_panel(){
		
		$action = hm_get('action');
		$id = hm_get('id',0);

		$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
		$data = array();
		$hmdb->Query(" SELECT * FROM ".DB_PREFIX."hme_product_option_group");
		while ($row = $hmdb->Row()) {
			$data[]=$row;
		}
		
		echo '<div class="product_option_group_list" data-id="'.$id.'">';
		echo '<div class="product_option_box_title">'.hme_lang('select_the_attribute_group').'</div>';
		foreach($data as $group){
			$group_id = $group->id;
			$group_name = $group->name;
			$group_slug = $group->slug;
			
			$product_group_option = array();
			if($action == 'edit'){
				$product_group_option = get_con_val('name=product_group_option&id='.$id);
				$product_group_option = json_decode($product_group_option,TRUE);
			}
			
			echo '<div class="product_option_group_item">'."\n\r";
			if(in_array($group_id,$product_group_option)){
				echo '<input checked type="checkbox" name="product_group_option[]" value="'.$group_id.'">'.$group_name."\n\r";
			}else{
				echo '<input type="checkbox" name="product_group_option[]" value="'.$group_id.'">'.$group_name."\n\r";
			}
			echo '</div>'."\n\r";
		}
		echo '</div>';
		echo '<div class="product_option_list">';
		echo '<div class="product_option_box_title">'.hme_lang('select_attribute').'</div>';
		echo '<div class="product_option_list_content">';
			if($action == 'edit'){
				$product_group_option = get_con_val('name=product_group_option&id='.$id);
				$product_group_option = json_decode($product_group_option,TRUE);
				if(!is_array($product_group_option)){
					$product_group_option = array();
				}
				foreach($product_group_option as $group_id){
					
					$product_option = get_con_val('name=product_option&id='.$id);
					$product_option = json_decode($product_option,TRUE);
					
					$group_name = hme_get_option_group('name',$group_id);
					echo '<div class="product_option_group_widget">'."\n\r";
					echo '	<div class="product_option_group_widget_title">'.$group_name.'</div>'."\n\r";
					echo '	<div class="product_option_group_widget_content">'."\n\r";
					
					$tableName = DB_PREFIX.'hme_product_option';
					$whereArray=array('group_id'=>MySQL::SQLValue($group_id, MySQL::SQLVALUE_NUMBER));
					$hmdb->SelectRows($tableName, $whereArray);		
					if( $hmdb->HasRecords() ){
						while ($row = $hmdb->Row()) {
							$option_id = $row->id;
							$option_name = $row->name;
							$option_slug = $row->slug;
							$group_id = $row->group_id;
							echo '<div class="product_option_item">'."\n\r";
							if(is_numeric($row->option_image)){
							echo '	<img class="option_image" src="'.get_file_url($row->option_image).'" >';
							}
							if(in_array($option_id,$product_option)){
								echo '	<input checked type="checkbox" name="product_option[]" value="'.$option_id.'">'.$option_name."\n\r";
							}else{
								echo '	<input type="checkbox" name="product_option[]" value="'.$option_id.'">'.$option_name."\n\r";
							}
							echo '</div>'."\n\r";
						}
					}
					
					echo '	</div>'."\n\r";
					echo '</div>'."\n\r";
					
				}
			}
		echo '</div>';
		echo '</div>';
		
	}	
	$args=array(
		'label'=>hme_lang('product_attributes'),
		'content_key'=>'product',
		'position'=>'left',
		'function'=>'product_option_panel',
	);
	register_content_box($args);
}
?>