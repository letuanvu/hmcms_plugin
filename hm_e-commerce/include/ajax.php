<?php
/* 
Đăng request ajax
*/
$args=array(
	'key'=>'hme_ajax',
	'function'=>'hme_ajax',
	'method'=>array('post'),
);
register_admin_ajax_page($args);

function hme_ajax(){

	$action=hm_post('action');
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	
	switch ($action) {
		case 'save_option_group_name':
			
			$id = hm_post('id');
			$value = hm_post('value');
			
			$tableName=DB_PREFIX."hme_product_option_group";
			$values = array();
			$values["name"] = MySQL::SQLValue($value);
			$whereArray=array('id'=>MySQL::SQLValue($id));
			$hmdb->UpdateRows($tableName, $values, $whereArray);
			
		break;
		case 'save_option_name':
			
			$id = hm_post('id');
			$value = hm_post('value');
			
			$tableName=DB_PREFIX."hme_product_option";
			$values = array();
			$values["name"] = MySQL::SQLValue($value);
			$whereArray=array('id'=>MySQL::SQLValue($id));
			$hmdb->UpdateRows($tableName, $values, $whereArray);
			
		break;	
		case 'delete_option':
			
			$id = hm_post('id');
			$tableName = DB_PREFIX.'hme_product_option';
			$whereArray=array('id'=>MySQL::SQLValue($id));
			$hmdb->DeleteRows($tableName, $whereArray);
			
		break;
		case 'load_option_checkbox_list':
			
			$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
			$data = array();
			$group_ids = hm_post('id');
			$content_id = hm_post('content');
			$tableName = DB_PREFIX.'hme_product_option';
			
			foreach($group_ids as $group_id){
				
				$group_name = hme_get_option_group('name',$group_id);
				echo '<div class="product_option_group_widget">'."\n\r";
				echo '	<div class="product_option_group_widget_title">'.$group_name.'</div>'."\n\r";
				echo '	<div class="product_option_group_widget_content">'."\n\r";
				
				$whereArray=array('group_id'=>MySQL::SQLValue($group_id, MySQL::SQLVALUE_NUMBER));
				$hmdb->SelectRows($tableName, $whereArray);		
				if( $hmdb->HasRecords() ){
					while ($row = $hmdb->Row()) {
						$option_id = $row->id;
						$option_name = $row->name;
						$option_slug = $row->slug;
						$group_id = $row->group_id;
						echo '<div class="product_option_item">'."\n\r";
						echo '	<input type="checkbox" name="product_option[]" value="'.$option_id.'">'.$option_name."\n\r";
						echo '</div>'."\n\r";
					}
				}
				
				echo '	</div>'."\n\r";
				echo '</div>'."\n\r";
			}
			
			
		break;
	}
	
	
}
?>