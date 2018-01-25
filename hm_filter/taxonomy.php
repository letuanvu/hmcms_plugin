<?php

/* 
Tạo taxonomy box
*/
$args=array(
	'label'=>'Bộ lọc',
	'position'=>'left',
	'function'=>'hm_filter_box_taxonomy',
);
register_taxonomy_box($args);

function hm_filter_box_taxonomy(){
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_filter/layout/filter_box_taxonomy.php');
}

/* 
Tạo content box
*/
$args=array(
	'label'=>'Bộ lọc',
	'position'=>'left',
	'function'=>'hm_filter_box_content',
);
register_content_box($args);

function hm_filter_box_content(){
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_filter/layout/filter_box_content_taxonomy.php');
}


/* 
Đăng request ajax
*/
$args=array(
	'key'=>'hm_filter_ajax',
	'function'=>'hm_filter_ajax',
	'method'=>array('post'),
);
register_admin_ajax_page($args);

function hm_filter_ajax(){

	$action=hm_post('action');

	switch ($action) {
		case 'add_group':
			$id = hm_post('id');
			$val = hm_post('val');
			ajaxfilter_add_group($id,$val);
		break;
		case 'del_group':
			$id = hm_post('id');
			ajaxfilter_del_group($id);
		break;
		case 'edit_group':
			$id = hm_post('id');
			$name = hm_post('new_name');
			ajaxfilter_edit_group($id,$name);
		break;
		case 'edit_group_input_type':
			$id = hm_post('id');
			$type = hm_post('type');
			ajaxfilter_edit_group_input_type($id,$type);
		break;
		case 'sort_group':
			$id = hm_post('id');
			$number_order = hm_post('number_order');
			ajaxfilter_sort_group($id,$number_order);
		break;
		case 'group_option_list':
			$id = hm_post('id');
			ajaxfilter_group_taxonomy_option_list($id);
		break;
		case 'group_option_add':
			$id = hm_post('id');
			$val = hm_post('val');
			ajaxfilter_add_group_option($id,$val);
		break;
		case 'del_group_option':
			$id = hm_post('id');
			ajaxfilter_del_group_option($id,$val);
		break;
		case 'edit_group_option':
			$id = hm_post('id');
			$name = hm_post('new_name');
			ajaxfilter_edit_group_option($id,$name);
		break;
		case 'filter_content':
			$id = hm_post('id');
			ajaxfilter_filter_content($id);
		break;
		case 'sort_group_option':
			$id = hm_post('id');
			$number_order = hm_post('number_order');
			ajaxfilter_sort_group_option($id,$number_order);
		break;
	}
	
}

/* 
Hook action để lưu filter cho danh mục
*/
register_filter('taxonomy_ajax_add','ajaxfilter_tax_add');
function ajaxfilter_tax_add($taxonomy_id){
	
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	$tableName = DB_PREFIX.'filter_group_taxonomy';
	
	$valuesArray=array(
						'type'=>MySQL::SQLValue('public'),
						'taxonomy_id'=>MySQL::SQLValue($taxonomy_id, MySQL::SQLVALUE_NUMBER),
					);
	$whereArray = array (
						'type'=>MySQL::SQLValue('tmp'),
					);
	$hmdb->UpdateRows($tableName, $valuesArray, $whereArray);
	
	$tableName = DB_PREFIX.'filter_option_taxonomy';
	$valuesArray=array(
						'type'=>MySQL::SQLValue('public'),
					);
	$whereArray = array (
						'type'=>MySQL::SQLValue('tmp'),
					);
	$hmdb->UpdateRows($tableName, $valuesArray, $whereArray);
	
	
}


register_action('taxonomy_ajax_edit','ajaxfilter_tax_edit');
function ajaxfilter_tax_edit(){
	
	$taxonomy_id=hm_get('id');
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	$tableName = DB_PREFIX.'filter_group_taxonomy';
	
	$valuesArray=array(
						'type'=>MySQL::SQLValue('public'),
					);
	$whereArray = array (
						'type'=>MySQL::SQLValue('tmp'),
					);
	$hmdb->UpdateRows($tableName, $valuesArray, $whereArray);
	
	$tableName = DB_PREFIX.'filter_option_taxonomy';
	$valuesArray=array(
						'type'=>MySQL::SQLValue('public'),
					);
	$whereArray = array (
						'type'=>MySQL::SQLValue('tmp'),
					);
	$hmdb->UpdateRows($tableName, $valuesArray, $whereArray);
	
	
}


register_action('taxonomy_delete_permanently','ajaxfilter_tax_delete');
function ajaxfilter_tax_delete(){
	
	$taxonomy_id = hm_post('id');
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	$tableName=DB_PREFIX.'filter_group_taxonomy';
	
	$whereArray=array(
					'taxonomy_id'=>MySQL::SQLValue($taxonomy_id, MySQL::SQLVALUE_NUMBER),
					);
	$hmdb->SelectRows($tableName, $whereArray);

	if($hmdb->HasRecords()){
		while ($row = $hmdb->Row()) {
			$group_id = $row->id;
			ajaxfilter_del_group($group_id);
		}
	}
	
}

function filter_group_taxonomy($taxonomy_id = '0'){	
	
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	
	$tableName = DB_PREFIX.'filter_group_taxonomy';
	$whereArray = array (
						'type'=>MySQL::SQLValue('tmp'),
					);
	$hmdb->DeleteRows($tableName, $whereArray);
	
	$tableName = DB_PREFIX.'filter_option_taxonomy';
	$whereArray = array (
						'type'=>MySQL::SQLValue('tmp'),
					);
	$hmdb->DeleteRows($tableName, $whereArray);
	
	filter_group_list($taxonomy_id);
		
}


function filter_extends($taxonomy_id){	
	
	if(is_numeric($taxonomy_id)){
		$tax_data = taxonomy_data_by_id($taxonomy_id);
		$tax_key = $tax_data['taxonomy']->key;
	}else{
		$tax_key = $taxonomy_id;
	}
	
	
	$args = array(
				'name' => 'filter_extends',
				'nice_name' => 'Kế thừa bộ lọc',
				'description' => 'Nếu danh mục này có bộ lọc giống hệt một danh mục khác, bạn có thể kế thừa lại luôn bộ lọc đã tạo trước đó mà không cần tạo bộ lọc mới',
				'no_parent' => 'Không kế thừa',
			);
	$action =  hm_get('action');
	if($action == 'edit'){
		$tax_id =  hm_get('id');
		$value = get_tax_val("name=filter_extends&id=$tax_id");
		$args['default_value'] = $value;
	}
	taxonomy_select_parent($tax_key,0,$args);

}

function ajaxfilter_add_group($taxonomy_id = '0', $val = FALSE){	
	
	if($val!=FALSE){
		$val = trim($val);
		if($val != '' ){
			
			$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
			
			$slug = 'ft_'.sanitize_title($val);
			$tableName = DB_PREFIX.'filter_group_taxonomy';
			$whereArray=array(
							'taxonomy_id'=>MySQL::SQLValue($taxonomy_id, MySQL::SQLVALUE_NUMBER),
							'name'=>MySQL::SQLValue($val),
							'type'=>MySQL::SQLValue('tmp'),
						);
			$values = array();	
			$values["taxonomy_id"] = MySQL::SQLValue($taxonomy_id);
			$values["name"] = MySQL::SQLValue($val);
			$values["slug"] = MySQL::SQLValue($slug);
			$values["type"] = MySQL::SQLValue('tmp');
			$values["input_type"] = MySQL::SQLValue('checkbox');
			
			$hmdb->AutoInsertUpdate($tableName, $values, $whereArray);			
			
		}
	}
	
	echo '<div class="alert alert-success" role="alert">Bấm vào tên nhóm lọc để thêm lựa chọn</div>';
	filter_group_list($taxonomy_id);
}


function filter_group_list($taxonomy_id = '0'){
	
	if(is_numeric($taxonomy_id)){
		
		$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
		$tableName = DB_PREFIX.'filter_group_taxonomy';
		$whereArray = array (
								'taxonomy_id'=>MySQL::SQLValue($taxonomy_id, MySQL::SQLVALUE_NUMBER),
							);
		$hmdb->SelectRows($tableName, $whereArray, NULL, 'number_order', TRUE);
	
		if( $hmdb->HasRecords() ){
			while( $row=$hmdb->Row() ){
				
				$checkbox_selected = '';
				if($row->input_type == 'checkbox'){ $checkbox_selected = 'selected'; }
				$radio_selected = '';
				if($row->input_type == 'radio'){ $radio_selected = 'selected'; }
				
				echo '<div class="filter_value_line filter_value_line_'.$row->id.'">';
				echo '<span class="bg-success filter_group_taxonomy" data-id="'.$row->id.'" data-slug="'.$row->slug.'" data-label="'.$row->name.'">';
				echo '<input data-id="'.$row->id.'" type="text" class="edit_filter_group_taxonomy" value="'.$row->name.'" />';
				echo '<select data-id="'.$row->id.'" class="edit_filter_group_taxonomy_input_type">';
				echo '<option '.$checkbox_selected.' value="checkbox">Chọn nhiều</option>';
				echo '<option '.$radio_selected.' value="radio">Chọn một</option>';
				echo '</select>';
				echo '<input type="hidden" class="filter_number_order" data-id="'.$row->id.'" value="'.$row->number_order.'" />';
				echo '<b data-id="'.$row->id.'" class="remove_filter_group_taxonomy btn btn-danger btn-xs">xóa</b>';
				echo '</span>';
				echo '</div>';
					
			}
		}

	}
	
}

function ajaxfilter_del_group($id = 0){
	
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	
	$tableName = DB_PREFIX.'filter_group_taxonomy';
	$whereArray = array (
						'id'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER),
					);
	$hmdb->DeleteRows($tableName, $whereArray);
	
	$tableName = DB_PREFIX.'filter_option_taxonomy';
	$whereArray = array (
						'filter_group'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER),
					);
	$hmdb->DeleteRows($tableName, $whereArray);
	
}

function ajaxfilter_edit_group($id = 0,$name = ''){
	
	$name = trim($name);
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	
	$tableName = DB_PREFIX.'filter_group_taxonomy';
	$whereArray=array('id'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER));
	$hmdb->SelectRows($tableName, $whereArray);
	if( $hmdb->HasRecords() ){
		$row = $hmdb->Row();
		$old_name = $row->name;
		$old_slug = $row->slug;
		
		if($name!=''){
			$slug = 'ft_'.sanitize_title($name);
			$values = 	array(
							'name'=>MySQL::SQLValue($name),
							'slug'=>MySQL::SQLValue($slug),
						);
			$hmdb->UpdateRows($tableName, $values, $whereArray);
		}
	}
	
}

function ajaxfilter_edit_group_input_type($id = 0,$type = ''){
	
	$type = trim($type);
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	
	$tableName = DB_PREFIX.'filter_group_taxonomy';
	$whereArray=array('id'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER));
	$hmdb->SelectRows($tableName, $whereArray);
	if( $hmdb->HasRecords() ){
		$row = $hmdb->Row();
		if($type!=''){
			$values = 	array(
							'input_type'=>MySQL::SQLValue($type),
						);
			$hmdb->UpdateRows($tableName, $values, $whereArray);
		}
	}
	
}

function ajaxfilter_sort_group($id = 0,$number_order = 1){
	
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	$tableName = DB_PREFIX.'filter_group_taxonomy';
	$whereArray=array('id'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER));
	$hmdb->SelectRows($tableName, $whereArray);
	if( $hmdb->HasRecords() ){
		$values = 	array(
						'number_order'=>MySQL::SQLValue($number_order, MySQL::SQLVALUE_NUMBER),
					);
		$hmdb->UpdateRows($tableName, $values, $whereArray);
	}
	
}

function ajaxfilter_del_group_option($id = 0){
	
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	
	$tableName = DB_PREFIX.'filter_option_taxonomy';
	$whereArray = array (
						'id'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER),
					);
	$hmdb->DeleteRows($tableName, $whereArray);
	
}

function ajaxfilter_group_taxonomy_option_list($group_id = 0){
	
	if(is_numeric($group_id) AND $group_id!='0'){
		
		$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
		$tableName = DB_PREFIX.'filter_group_taxonomy';
		$whereArray = array (
								'id'=>MySQL::SQLValue($group_id, MySQL::SQLVALUE_NUMBER),
							);
		$hmdb->SelectRows($tableName, $whereArray);
		if( $hmdb->HasRecords() ){
			
			$row=$hmdb->Row();
			echo '<div class="alert alert-success" role="alert">Bạn đang thêm các lựa chọn cho <b>'.$row->name.'</b></div>';
			
			$tableName = DB_PREFIX.'filter_option_taxonomy';
			$whereArray = array (
								'filter_group'=>MySQL::SQLValue($group_id, MySQL::SQLVALUE_NUMBER),
							);
			$hmdb->SelectRows($tableName, $whereArray, NULL, 'number_order', TRUE);
			
			if( $hmdb->HasRecords() ){
				while( $row=$hmdb->Row() ){
					
					echo '<div class="filter_value_line filter_option_taxonomy_value_line_'.$row->id.'">';
					echo '<span class="bg-info filter_option_taxonomy" data-id="'.$row->id.'" data-slug="'.$row->slug.'" data-label="'.$row->name.'">';
					echo '<input data-id="'.$row->id.'" type="text" class="edit_filter_option_taxonomy" value="'.$row->name.'" />';
					echo '<input type="hidden" class="filter_option_taxonomy_number_order" data-id="'.$row->id.'" value="'.$row->number_order.'" />';
					echo '<b data-id="'.$row->id.'" class="remove_filter_option_taxonomy btn btn-danger btn-xs">xóa</b>';
					echo '</span>';
					echo '</div>';
					
				}
			}
			echo '<input type="text" class="form-control filter_option_taxonomy_value_input" placeholder="Nhập tên lựa chọn mới">';
			echo '<span data-id="'.$group_id.'" class="btn btn-warning filter_option_taxonomy_value_submit">Thêm lựa chọn</span>';
			
		}
		
	}

}


function ajaxfilter_add_group_option($group_id = '0', $val = FALSE){	
	
	if($val!=FALSE){
		$val = trim($val);
		if($val != '' ){
			
			$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
			
			$slug = sanitize_title($val);
			$tableName = DB_PREFIX.'filter_option_taxonomy';
			$whereArray=array(
							'filter_group'=>MySQL::SQLValue($group_id, MySQL::SQLVALUE_NUMBER),
							'name'=>MySQL::SQLValue($val),
							'type'=>MySQL::SQLValue('tmp'),
						);
			$values = array();	
			$values["filter_group"] = MySQL::SQLValue($group_id);
			$values["name"] = MySQL::SQLValue($val);
			$values["slug"] = MySQL::SQLValue($slug);
			$values["type"] = MySQL::SQLValue('tmp');
			
			$hmdb->AutoInsertUpdate($tableName, $values, $whereArray);			
			
		}
	}
	
	ajaxfilter_group_taxonomy_option_list($group_id);
}


function ajaxfilter_edit_group_option($id = 0,$name = ''){
	
	$name = trim($name);
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	
	$tableName = DB_PREFIX.'filter_option_taxonomy';
	$whereArray=array('id'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER));
	$hmdb->SelectRows($tableName, $whereArray);
	if( $hmdb->HasRecords() ){
		$row = $hmdb->Row();
		$old_name = $row->name;
		$old_slug = $row->slug;
		$filter_group_taxonomy = $row->filter_group_taxonomy;
		
		/* update option */
		if($name!=''){
			$slug = sanitize_title($name);
			$values = 	array(
							'name'=>MySQL::SQLValue($name),
							'slug'=>MySQL::SQLValue($slug),
						);
			$hmdb->UpdateRows($tableName, $values, $whereArray);
		}
		
		/* update field */
		$whereArray=array('id'=>MySQL::SQLValue($filter_group_taxonomy, MySQL::SQLVALUE_NUMBER));
		$hmdb->SelectRows(DB_PREFIX.'filter_group_taxonomy', $whereArray);
		if( $hmdb->HasRecords() ){
			$row = $hmdb->Row();
			$group_name = $row->name;
			$group_slug = $row->slug;
			
			/* find field by group_slug */
			$whereArray=array('name'=>MySQL::SQLValue($group_slug));
			$hmdb->SelectRows(DB_PREFIX.'field', $whereArray);
			$updates = array();
			while( $row=$hmdb->Row() ){
				$field_id = $row->id;
				$field_val = $row->val;
				$field_val_new = str_replace('"'.$old_slug.'"','"'.$slug.'"',$field_val);  
				$updates[$field_id] = $field_val_new;
			}
			
			foreach($updates as $field_id => $field_val){
				
				$values = array();
				$values["val"] = MySQL::SQLValue($field_val);
				$whereArray=array('id'=>MySQL::SQLValue($field_id));
				$hmdb->UpdateRows(DB_PREFIX.'field', $values, $whereArray);
				
			}
			
		}
		
	}
	
}


function ajaxfilter_filter_content($taxonomy_id = '0'){
	
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

	$tableName = DB_PREFIX.'filter_group_taxonomy';
	$whereArray = array (
							'taxonomy_id'=>MySQL::SQLValue($taxonomy_id, MySQL::SQLVALUE_NUMBER),
						);
	$hmdb->SelectRows($tableName, $whereArray, NULL, 'number_order', TRUE);
	
	if( $hmdb->HasRecords() ){
		
		$taxonomy_name = get_tax_val(array('name'=>'name','id'=>$taxonomy_id));
		
		while( $row=$hmdb->Row() ){
			$groups[] = $row;
		}
		foreach($groups as $row){
			$group_id = $row->id;
			$group_name = $row->name;
			$group_slug = $row->slug;
			
			$tableName = DB_PREFIX.'filter_option_taxonomy';
			$whereArray = array (
								'filter_group'=>MySQL::SQLValue($group_id, MySQL::SQLVALUE_NUMBER),
							);
			$hmdb->SelectRows($tableName, $whereArray, NULL, 'number_order', TRUE);
			
			echo '<div class="filter_content_box filter_content_box'.$group_id.'">';
			echo '	<div class="filter_content_box_title bg-success">[<b>'.$taxonomy_name.'</b>] '.$group_name.'</div>';
			echo '	<div class="filter_content_box_content">';
			echo '		<ul>';
			if( $hmdb->HasRecords() ){
				
				$action =  hm_get('action');
				$content_id =  hm_get('id');
				if($action == 'edit'){
					$option_val = get_con_val(array('name'=>$group_slug,'id'=>$content_id));
					$option_val = json_decode($option_val,TRUE);
				}else{
					$option_val = array();
				}
				
				if(!is_array($option_val)){
					$option_val = array();
				}
				
				while( $row=$hmdb->Row() ){
					$this_option_val = $row->slug;
					if(in_array($this_option_val,$option_val)){
						$checked = 'checked';
					}else{
						$checked = '';
					}
					echo '<li><input '.$checked.' type="checkbox" name="'.$group_slug.'[]" value="'.$this_option_val.'">'.$row->name.'</li>';	
				}
			}
			echo '		</ul>';
			echo '	</div>';
			echo '</div>';
		}
	}

}


function ajaxfilter_sort_group_option($id = 0,$number_order = 1){
	
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	$tableName = DB_PREFIX.'filter_option_taxonomy';
	$whereArray=array('id'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER));
	$hmdb->SelectRows($tableName, $whereArray);
	if( $hmdb->HasRecords() ){
		$values = 	array(
						'number_order'=>MySQL::SQLValue($number_order, MySQL::SQLVALUE_NUMBER),
					);
		$hmdb->UpdateRows($tableName, $values, $whereArray);
	}
	
}

/** hiển thị bộ lọc ở giao diện */
function show_filter($taxonomy_id = '0',$args=array()){
	$taxonomy_id_call = $taxonomy_id;
	$default_array=array(
					'slug'=>FALSE,
					'input_hidden'=>array(),
				);
	$args = hm_parse_args($args,$default_array);
	
	$filter_extends = get_tax_val("name=filter_extends&id=$taxonomy_id");
	if(is_numeric($filter_extends) AND $filter_extends!=0){
		$taxonomy_id = $filter_extends;
	}
	
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

	$tableName = DB_PREFIX.'filter_group_taxonomy';
	$whereArray = array (
							'taxonomy_id'=>MySQL::SQLValue($taxonomy_id, MySQL::SQLVALUE_NUMBER),
						);
	$hmdb->SelectRows($tableName, $whereArray, NULL, 'number_order', TRUE);
	
	if( $hmdb->HasRecords() ){
		
		if($args['slug']==FALSE){
			$taxonomy_link = request_uri("type=taxonomy&id=$taxonomy_id_call");
		}else{
			$taxonomy_link = BASE_URL.$args['slug'];
		}
		
		
		echo '<div class="filter_wrapper">';
		echo '<form action="'.$taxonomy_link.'" class="filter_form" method="get">';
		
		$taxonomy_name = get_tax_val(array('name'=>'name','id'=>$taxonomy_id));
		
		while( $row=$hmdb->Row() ){
			$groups[] = $row;
		}
		foreach($groups as $row){
			$group_id = $row->id;
			$group_name = $row->name;
			$group_slug = $row->slug;
			
			$group_input_type = 'radio';
			if($row->input_type == 'checkbox'){ $group_input_type = 'checbox'; }
			if($row->input_type == 'radio'){ $group_input_type = 'radio'; }
			
			$tableName = DB_PREFIX.'filter_option_taxonomy';
			$whereArray = array (
								'filter_group'=>MySQL::SQLValue($group_id, MySQL::SQLVALUE_NUMBER),
							);
			$hmdb->SelectRows($tableName, $whereArray, NULL, 'number_order', TRUE);
			
			echo '<div class="filter_content_box filter_content_box'.$group_id.'">';
			echo '	<div class="filter_content_box_title"><span>'.$group_name.'</span></div>';
			echo '	<div class="filter_content_box_content">';
			echo '		<ul>';
			if( $hmdb->HasRecords() ){
				
				$option_val = hm_get($group_slug,array());
				while( $row=$hmdb->Row() ){
					$this_option_val = $row->slug;
					if(in_array($this_option_val,$option_val)){
						$checked = 'checked';
					}else{
						$checked = '';
					}
					echo '<li><input '.$checked.' type="'.$group_input_type.'" name="'.$group_slug.'[]" value="'.$this_option_val.'">'.$row->name.'</li>';	
				}
			}
			echo '		</ul>';
			echo '	</div>';
			echo '</div>';
		}
		
		if(is_array($args['input_hidden'])){
			foreach($args['input_hidden'] as $input_name => $input_val){
				echo '<input type="hidden" name="'.$input_name.'" value="'.$input_val.'" />';
			}
		}
		echo '<input type="hidden" name="use_hm_filter" value="1" />';
		echo '</form>';
		echo '</div>';
		
	}

}

function show_filter_dropdown($taxonomy_id = '0',$args=array()){
	
	$default_array=array(
					'slug'=>FALSE,
					'input_hidden'=>array(),
				);
	$args = hm_parse_args($args,$default_array);
	
	$filter_extends = get_tax_val("name=filter_extends&id=$taxonomy_id");
	if(is_numeric($filter_extends) AND $filter_extends!=0){
		$taxonomy_id = $filter_extends;
	}
	
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

	$tableName = DB_PREFIX.'filter_group_taxonomy';
	$whereArray = array (
							'taxonomy_id'=>MySQL::SQLValue($taxonomy_id, MySQL::SQLVALUE_NUMBER),
						);
	$hmdb->SelectRows($tableName, $whereArray, NULL, 'number_order', TRUE);
	
	if( $hmdb->HasRecords() ){
		
		if($args['slug']==FALSE){
			$taxonomy_link = request_uri("type=taxonomy&id=$taxonomy_id");
		}else{
			$taxonomy_link = BASE_URL.$args['slug'];
		}
		
		
		echo '<div class="filter_wrapper">';
		echo '<form action="'.$taxonomy_link.'" class="filter_form" method="get">';
		
		$taxonomy_name = get_tax_val(array('name'=>'name','id'=>$taxonomy_id));
		
		while( $row=$hmdb->Row() ){
			$groups[] = $row;
		}
		foreach($groups as $row){
			$group_id = $row->id;
			$group_name = $row->name;
			$group_slug = $row->slug;
			
			$tableName = DB_PREFIX.'filter_option_taxonomy';
			$whereArray = array (
								'filter_group'=>MySQL::SQLValue($group_id, MySQL::SQLVALUE_NUMBER),
							);
			$hmdb->SelectRows($tableName, $whereArray, NULL, 'number_order', TRUE);
			
			echo '<div class="filter_content_box filter_content_box'.$group_id.'">';
			echo '	<div class="filter_content_box_title"><span>'.$group_name.'</span></div>';
			echo '	<div class="filter_content_box_content">';
			echo '		<select name="'.$group_slug.'[]">';
			if( $hmdb->HasRecords() ){
					echo '<option '.$selected.' value="">'.$group_name.'</option>';	
				$option_val = hm_get($group_slug,array());
				while( $row=$hmdb->Row() ){
					$this_option_val = $row->slug;
					if(in_array($this_option_val,$option_val)){
						$checked = 'checked';
					}else{
						$checked = '';
					}
					echo '<option '.$selected.' value="'.$this_option_val.'">'.$row->name.'</option>';	
				}
			}
			echo '		</select>';
			echo '	</div>';
			echo '</div>';
		}
		
		if(is_array($args['input_hidden'])){
			foreach($args['input_hidden'] as $input_name => $input_val){
				echo '<input type="hidden" name="'.$input_name.'" value="'.$input_val.'" />';
			}
		}
		echo '<input type="hidden" name="use_hm_filter" value="1" />';
		echo '<input type="hidden" name="use_hm_filter_dropdown" value="1" />';
		echo '</form>';
		echo '</div>';
		
	}

}


/** can thiệp vào query_content */
register_filter('before_query_content','filter_query_content');
function filter_query_content($args){
	if(hm_get('use_hm_filter')=='1'){
		
		$use_filter = FALSE;
		$taxonomy_id = FALSE;
		if(is_numeric($args['taxonomy'])){
			$taxonomy_id = $args['taxonomy'];
		}
		
		$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
		$tableName = DB_PREFIX.'filter_group_taxonomy';
		$whereArray = array (
							'taxonomy_id'=>MySQL::SQLValue($taxonomy_id, MySQL::SQLVALUE_NUMBER),
						);
		$hmdb->SelectRows($tableName, $whereArray, NULL, 'number_order', TRUE);
		if( $hmdb->HasRecords() ){
			while( $row=$hmdb->Row() ){
				$groups[] = $row;
			}
			foreach($groups as $row){
				$group_id = $row->id;
				$group_name = $row->name;
				$group_slug = $row->slug;
				$option_val = hm_get($group_slug,array());
				if(sizeof($option_val) > 0){
					$use_filter = TRUE;
				}
			}
		}
		
		/** Trên url có sử dụng bộ lọc */
		if($use_filter == TRUE){
			
			/** Thêm các điều kiện lọc vào  $args['field_query'] */
			foreach($groups as $row){
				$group_id = $row->id;
				$group_name = $row->name;
				$group_slug = $row->slug;
				$option_val = hm_get($group_slug,array());
				if(sizeof($option_val) > 0){
					foreach($option_val as $filter_value){
						if($filter_value!=''){
							$args['field_query'][] = array( 
												'field'=>$group_slug,
												'compare'=>'like%',
												'value'=>$filter_value,
											);
						}
					}
				}
			}

			$args['field_query_relation'] = 'or';
			if(hm_get('use_hm_filter_dropdown')=='1'){
				$args['field_query_relation'] = 'and';
			}
		}
	}
	return $args;
}
?>