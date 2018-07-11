<?php
/*
Plugin Name: Express Form;
Description: Tạo form liên hệ cho website;
Version: 1;
Version Number: 1;
*/

/*
Đăng ký trang tất cả form
*/
$args=array(
	'label'=>'Express Form',
	'admin_menu'=>TRUE,
	'key'=>'express_form_all',
	'function'=>'express_form_all',
	'icon'=>'fa-envelope-o',
	'child_of'=>FALSE,
);
register_admin_page($args);

function express_form_all(){

	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

	$data = array();
	$tableName=DB_PREFIX."object";
	$whereArray=array('key'=>MySQL::SQLValue('express_form'));
	$hmdb->SelectRows($tableName, $whereArray, NULL, 'name', TRUE);
	if( $hmdb->HasRecords() ){
		while( $row = $hmdb->Row() ){
			$data[] = $row->id;
		}
	}
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/all.php',$data);

}

/*
Đăng ký trang tất cả form sub
*/
$args=array(
	'label'=>'Tất cả form',
	'admin_menu'=>TRUE,
	'key'=>'express_form_all_sub',
	'function'=>'express_form_all_sub',
	'child_of'=>'express_form_all',
);
register_admin_page($args);

function express_form_all_sub(){

	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

	$data = array();
	$tableName=DB_PREFIX."object";
	$whereArray=array('key'=>MySQL::SQLValue('express_form'));
	$hmdb->SelectRows($tableName, $whereArray, NULL, 'name', TRUE);
	if( $hmdb->HasRecords() ){
		while( $row = $hmdb->Row() ){
			$data[] = $row->id;
		}
	}
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/all.php',$data);

}

/*
Đăng ký trang thêm form
*/
$args=array(
	'label'=>'Tạo form mới',
	'admin_menu'=>TRUE,
	'key'=>'express_form_add',
	'function'=>'express_form_add',
	'child_of'=>'express_form_all',
);
register_admin_page($args);

function express_form_add(){

	if(isset($_POST['submit'])){

		$form_name = hm_post('form_name');
		$form_template = hm_post('form_template');
		$form_email_address = hm_post('form_email_address');
		$form_email_subject = hm_post('form_email_subject');
		$form_email_content = hm_post('form_email_content');
		$form_submit_success_message = hm_post('form_submit_success_message');
		$form_submit_error_message = hm_post('form_submit_error_message');
		$captcha_error_message = hm_post('captcha_error_message');
		$form_key = sanitize_title($form_name);

		$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

		/** Insert form */
		$tableName=DB_PREFIX.'object';
		$data = array();
		$data["name"] = MySQL::SQLValue($form_name);
		$data["key"] = MySQL::SQLValue('express_form');
		$data["parent"] = MySQL::SQLValue('0');
		$data["order_number"] = MySQL::SQLValue('0');
		$form_id=$hmdb->InsertRow($tableName, $data);

		/** Insert form filed  */
		if(is_numeric($form_id)){

			$tableName=DB_PREFIX.'field';
			foreach ( $_POST as $post_key => $post_val ){

				if(is_array($post_val)){ $post_val = hm_json_encode($post_val); }

				$values = array();
				$values["name"] = MySQL::SQLValue($post_key);
				$values["val"] = MySQL::SQLValue($post_val);
				$values["object_id"] = MySQL::SQLValue($form_id, MySQL::SQLVALUE_NUMBER);
				$values["object_type"] = MySQL::SQLValue('express_form');
				$hmdb->InsertRow($tableName, $values);

			}
			/** edit form */
			$url = '?run=admin_page.php&key=express_form_edit&id='.$form_id;
			hm_redirect($url);
		}else{
			$url = '?run=admin_page.php&key=express_form_add&insert_error=1';
			hm_redirect($url);
		}

	}else{
		hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/add.php');
	}

}

/*
Đăng ký trang sửa form
*/
$args=array(
	'label'=>'Sửa form',
	'admin_menu'=>FALSE,
	'key'=>'express_form_edit',
	'function'=>'express_form_edit',
);
register_admin_page($args);

function express_form_edit(){

	if(isset($_POST['submit'])){

		$form_id = hm_get('id');
		$form_name = hm_post('form_name');
		$form_template = hm_post('form_template');
		$form_email_address = hm_post('form_email_address');
		$form_email_subject = hm_post('form_email_subject');
		$form_email_content = hm_post('form_email_content');
		$form_submit_success_message = hm_post('form_submit_success_message');
		$form_submit_error_message = hm_post('form_submit_error_message');
		$captcha_error_message = hm_post('captcha_error_message');
		$form_key = sanitize_title($form_name);

		$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

		/** Update form */
		$tableName=DB_PREFIX.'object';
		$whereArray = array (
			'key'=>MySQL::SQLValue('express_form'),
			'id'=>MySQL::SQLValue($form_id, MySQL::SQLVALUE_NUMBER),
		);
		$data = array();
		$data["name"] = MySQL::SQLValue($form_name);
		$data["key"] = MySQL::SQLValue('express_form');
		$data["parent"] = MySQL::SQLValue('0');
		$data["order_number"] = MySQL::SQLValue('0');
		$hmdb->UpdateRows($tableName, $data, $whereArray);


		/** Update form filed  */
		if(is_numeric($form_id)){

			$tableName=DB_PREFIX.'field';
			foreach ( $_POST as $post_key => $post_val ){

				if(is_array($post_val)){ $post_val = hm_json_encode($post_val); }

				$values = array();
				$values["name"] = MySQL::SQLValue($post_key);
				$values["val"] = MySQL::SQLValue($post_val);
				$values["object_id"] = MySQL::SQLValue($form_id, MySQL::SQLVALUE_NUMBER);
				$values["object_type"] = MySQL::SQLValue('express_form');

				$whereArray = array (
					'object_id'=>MySQL::SQLValue($form_id, MySQL::SQLVALUE_NUMBER),
					'object_type'=>MySQL::SQLValue('express_form'),
					'name'=>MySQL::SQLValue($post_key),
				);

				$hmdb->AutoInsertUpdate($tableName, $values, $whereArray);

			}
			/** edit form */
			$url = '?run=admin_page.php&key=express_form_edit&id='.$form_id.'&update_success=1';
			hm_redirect($url);
		}else{
			$url = '?run=admin_page.php&key=express_form_edit&id='.$form_id.'&update_error=1';
			hm_redirect($url);
		}


	}else{
		hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/edit.php');
	}

}

/*
Xem các liên hệ
*/
$args=array(
	'label'=>'Xem liên hệ',
	'admin_menu'=>TRUE,
	'key'=>'express_form_all_contact',
	'function'=>'express_form_all_contact',
	'child_of'=>'express_form_all',
);
register_admin_page($args);

function express_form_all_contact(){

	$data = array();
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	$tableName=DB_PREFIX."field";
	$whereArray=array(
		'name'=>MySQL::SQLValue('express_form_saved'),
		'object_type'=>MySQL::SQLValue('express_form'),
	);

	$hmdb->SelectRows($tableName, $whereArray, NULL, 'id', FALSE);
	if ($hmdb->HasRecords()){
		while($row = $hmdb->Row()){
			$data[] = $row;
		}
	}
	hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/express_form/layout/all_contact.php',$data);

}


/*
Đăng ký trang xóa liên hệ
*/
$args=array(
	'admin_menu'=>FALSE,
	'key'=>'express_form_del_contact',
	'function'=>'express_form_del_contact',
);
register_admin_page($args);

function express_form_del_contact(){
	$id = hm_get('id');
	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	$tableName=DB_PREFIX.'field';
	$whereArray = array (
		'id'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER),
	);
	$hmdb->DeleteRows($tableName, $whereArray);
}

/*
Đăng ký trang xóa form
*/
$args=array(
	'admin_menu'=>FALSE,
	'key'=>'express_form_del',
	'function'=>'express_form_del',
);
register_admin_page($args);

function express_form_del(){
	$id = hm_get('id');

	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	$tableName=DB_PREFIX.'object';
	$whereArray = array (
		'id'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER),
	);
	$hmdb->DeleteRows($tableName, $whereArray);

	$tableName=DB_PREFIX.'field';
	$whereArray = array (
		'object_id'=>MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER),
		'object_type'=>MySQL::SQLValue('express_form'),
	);
	$hmdb->DeleteRows($tableName, $whereArray);
}

function get_express_form_val($name,$id){

	$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
	$tableName=DB_PREFIX."field";
	$whereArray=array(
		'name'=>MySQL::SQLValue($name),
		'object_type'=>MySQL::SQLValue('express_form'),
		'object_id'=>MySQL::SQLValue($id)
	);

	$hmdb->SelectRows($tableName, $whereArray);
	if ($hmdb->HasRecords()) {
		$row = $hmdb->Row();
		return $row->val;
	}else{
		return NULL;
	}

}

register_action('before_hm_footer','jquery_ui_asset');
function jquery_ui_asset(){
	echo css(BASE_URL.HM_ADMINCP_DIR.'/layout/css/jquery-ui.css');
	echo js(BASE_URL.HM_ADMINCP_DIR.'/layout/js/jquery-ui.js');
	echo js(BASE_URL.HM_PLUGIN_DIR.'/express_form/asset/jquery.form.js');
	echo js(BASE_URL.HM_PLUGIN_DIR.'/express_form/asset/frontend.js');
}


/** shortcode */
$args = array(
	'name'=>'express_form',
	'func'=>'express_form_shortcode',
);
register_shortcode($args);

function express_form_input_value($input_value){
	$rest = substr($input_value, 0, 4);
	if($rest == 'get|'){
		$ex = explode('|',$input_value);
		$parameter_value = hm_get($ex[1]);
		$value = $parameter_value;
	}elseif($rest == 'post|'){
		$ex = explode('|',$input_value);
		$parameter_value = hm_post($ex[1]);
		$value = $parameter_value;
	}else{
		$value = $input_value;
	}
	return $value;
}

/** tạo trang submit form  */
register_request('express_form_submit','express_form_submit',array('name'=>'express_form_submit','menu'=>FALSE));
function express_form_submit(){
	if(isset($_POST['express_form_submit'])){
		$id = hm_post('express_form_id');
		$captcha_check = TRUE;
		$form_template = get_express_form_val('form_template',$id);
		$form_noti_message_location = get_express_form_val('form_noti_message_location',$id);
		if($form_noti_message_location == ''){$form_noti_message_location = 'bottom';}

		if (strpos($form_template, '[shortcode=express_form&type=captcha]') !== false) {
			/** captcha check */
			$express_form_captcha = hm_post('express_form_captcha');
			if(strtolower($express_form_captcha) == strtolower($_SESSION['captcha'])){
				$captcha_check = TRUE;
			}else{
				$captcha_check = FALSE;
			}
		}

		if($captcha_check == TRUE){

			$fields = array();
			foreach($_POST as $post_key => $post_val){
				$no_save = array(
					'express_form_submit',
					'express_form_captcha',
				);
				if(!in_array($post_key,$no_save)){
					$post_val = addslashes(htmlspecialchars($post_val));
					$fields[$post_key] = $post_val;
				}
			}
			$fields['express_form_submit_time'] = time();
			$fields['express_form_submit_ip'] = hm_ip();
			$fields['express_form_submit_url'] = $_SERVER["HTTP_REFERER"];
			$fields_json = hm_json_encode($fields);

			$name = 'express_form_saved';
			$object_type = 'express_form';
			$saved = hm_set_field($name,$fields_json,$id,$object_type);
			if($saved){
				$status = 'success';
				if($form_noti_message_location != 'alert'){
					$mes = '<div class="express_form_submit_success_message">'."\n\r";
					$mes.= get_express_form_val('form_submit_success_message',$id);
					$mes.= '</div>'."\n\r";
				}else{
					$mes = get_express_form_val('form_submit_success_message',$id);
				}
			}else{
				$status = 'error';
				if($form_noti_message_location != 'alert'){
					$mes = '<div class="express_form_submit_error_message">'."\n\r";
					$mes.= get_express_form_val('form_submit_error_message',$id);
					$mes.= '</div>'."\n\r";
				}else{
					$mes = get_express_form_val('form_submit_error_message',$id);
				}
			}

			//send mail
			$form_email_address = get_express_form_val('form_email_address',$id);
			$form_email_subject = get_express_form_val('form_email_subject',$id);
			$form_email_content = get_express_form_val('form_email_content',$id);
			$content = '';
			$form_email_content.= '<hr>'."\n\r";
			foreach($fields as $key => $val){
				$form_email_content.= '<p>'.$key.' : '.$val.'</p>'."\n\r";
			}
			hm_mail($form_email_address,$form_email_subject,$form_email_content);

		}else{
			$status = 'error';
			if($form_noti_message_location != 'alert'){
				$mes = '<div class="express_form_submit_error_message express_form_captcha_error_message">'."\n\r";
				$mes.= get_express_form_val('captcha_error_message',$id);
				$mes.= '</div>'."\n\r";
			}else{
				$mes = get_express_form_val('captcha_error_message',$id);
			}

		}

		echo json_encode(array('status'=>$status,'message'=>$mes));

	}
}

function express_form_shortcode($args){
	$type = $args['type'];
	$name = FALSE;
	$value = FALSE;
	$maxlength = FALSE;
	$placeholder = FALSE;
	$class = FALSE;
	$id = FALSE;
	$required = FALSE;
	$options = FALSE;
	$format = FALSE;

	switch ($type) {
		case 'display_form':

			$id = $args['id'];
			$form_noti_message_location = get_express_form_val('form_noti_message_location',$id);
			if($form_noti_message_location == ''){$form_noti_message_location = 'bottom';}

			/** hiển thị form */
			$form_template = get_express_form_val('form_template',$id);
			switch ($form_noti_message_location) {
				case 'top':
				return  '<form action="'.BASE_URL.'express_form_submit" method="post" class="express_form express_form_ajax">'.
				'<div class="express_form_ajax_result"></div>'.
				'<input type="hidden" name="express_form_id" value="'.$id.'">'.
				'<input type="hidden" name="express_form_alert" value="0">'.
				do_all_shortcode_from_string($form_template).
				'</form>';
				break;
				case 'bottom':
				return  '<form action="'.BASE_URL.'express_form_submit" method="post" class="express_form express_form_ajax">'.
				'<input type="hidden" name="express_form_id" value="'.$id.'">'.
				'<input type="hidden" name="express_form_alert" value="0">'.
				do_all_shortcode_from_string($form_template).
				'<div class="express_form_ajax_result"></div>'.
				'</form>';
				break;
				case 'alert':
				return  '<form action="'.BASE_URL.'express_form_submit" method="post" class="express_form express_form_ajax">'.
				'<input type="hidden" name="express_form_id" value="'.$id.'">'.
				'<input type="hidden" name="express_form_alert" value="1">'.
				do_all_shortcode_from_string($form_template).
				'</form>';
				break;
			}
			break;
			case 'text':
			/** text */
			$name = '';$value = '';$maxlength = '';$placeholder = '';$class = '';$id = '';$required = '';
			if(isset($args['name'])){
				$name = 'name="'.$args['name'].'" ';
			}
			if(isset($args['value'])){
				$value = express_form_input_value($args['value']);
				$value = 'value="'.$value.'" ';
			}
			if(isset($args['maxlength'])){
				$maxlength = 'maxlength="'.$args['maxlength'].'" ';
			}
			if(isset($args['placeholder'])){
				$placeholder = 'placeholder="'.$args['placeholder'].'" ';
			}
			if(isset($args['class'])){
				$class = 'class="'.$args['class'].'" ';
			}
			if(isset($args['id'])){
				$id = 'id="'.$args['id'].'" ';
			}
			if(isset($args['required'])){
				$required = 'required ';
			}
			return '<input type="text" '.$name.$value.$maxlength.$placeholder.$class.$id.$required.'>';
			break;
			case 'textarea':
			/** textarea */
			$name = '';$value = '';$maxlength = '';$placeholder = '';$class = '';$id = '';$required = '';
			if(isset($args['name'])){
				$name = 'name="'.$args['name'].'" ';
			}
			if(isset($args['value'])){
				$value = express_form_input_value($args['value']);
				$value = $value;
			}
			if(isset($args['maxlength'])){
				$maxlength = 'maxlength="'.$args['maxlength'].'" ';
			}
			if(isset($args['placeholder'])){
				$placeholder = 'placeholder="'.$args['placeholder'].'" ';
			}
			if(isset($args['class'])){
				$class = 'class="'.$args['class'].'" ';
			}
			if(isset($args['id'])){
				$id = 'id="'.$args['id'].'" ';
			}
			if(isset($args['required'])){
				$required = 'required ';
			}
			return '<textarea '.$name.$maxlength.$placeholder.$class.$id.$required.'>'.$value.'</textarea>';
			break;
			case 'email':
			/** email */
			$name = '';$value = '';$maxlength = '';$placeholder = '';$class = '';$id = '';$required = '';
			if(isset($args['name'])){
				$name = 'name="'.$args['name'].'" ';
			}
			if(isset($args['value'])){
				$value = express_form_input_value($args['value']);
				$value = 'value="'.$value.'" ';
			}
			if(isset($args['maxlength'])){
				$maxlength = 'maxlength="'.$args['maxlength'].'" ';
			}
			if(isset($args['placeholder'])){
				$placeholder = 'placeholder="'.$args['placeholder'].'" ';
			}
			if(isset($args['class'])){
				$class = 'class="'.$args['class'].'" ';
			}
			if(isset($args['id'])){
				$id = 'id="'.$args['id'].'" ';
			}
			if(isset($args['required'])){
				$required = 'required ';
			}
			return '<input type="email" '.$name.$value.$maxlength.$placeholder.$class.$id.$required.'>';
			break;
			case 'number':
			/** number */
			$name = '';$value = '';$maxlength = '';$placeholder = '';$class = '';$id = '';$required = '';
			if(isset($args['name'])){
				$name = 'name="'.$args['name'].'" ';
			}
			if(isset($args['value'])){
				$value = express_form_input_value($args['value']);
				$value = 'value="'.$value.'" ';
			}
			if(isset($args['maxlength'])){
				$maxlength = 'maxlength="'.$args['maxlength'].'" ';
			}
			if(isset($args['placeholder'])){
				$placeholder = 'placeholder="'.$args['placeholder'].'" ';
			}
			if(isset($args['class'])){
				$class = 'class="'.$args['class'].'" ';
			}
			if(isset($args['id'])){
				$id = 'id="'.$args['id'].'" ';
			}
			if(isset($args['required'])){
				$required = 'required ';
			}
			return '<input type="number" '.$name.$value.$maxlength.$placeholder.$class.$id.$required.'>';
			break;
			case 'hidden':
			/** hidden */
			$name = '';$value = '';$maxlength = '';$placeholder = '';$class = '';$id = '';$required = '';
			if(isset($args['name'])){
				$name = 'name="'.$args['name'].'" ';
			}
			if(isset($args['value'])){
				$value = express_form_input_value($args['value']);
				$value = 'value="'.$value.'" ';
			}
			if(isset($args['maxlength'])){
				$maxlength = 'maxlength="'.$args['maxlength'].'" ';
			}
			if(isset($args['placeholder'])){
				$placeholder = 'placeholder="'.$args['placeholder'].'" ';
			}
			if(isset($args['class'])){
				$class = 'class="'.$args['class'].'" ';
			}
			if(isset($args['id'])){
				$id = 'id="'.$args['id'].'" ';
			}
			if(isset($args['required'])){
				$required = 'required ';
			}
			return '<input type="hidden" '.$name.$value.$maxlength.$placeholder.$class.$id.$required.'>';
			break;
			case 'date':
			/** date */
			$name = '';$value = '';$format = 'dd/mm/yy';$class = 'class="express_form_datepicker" ';$id = '';$required = '';
			if(isset($args['name'])){
				$name = 'name="'.$args['name'].'" ';
			}
			if(isset($args['value'])){
				$value = express_form_input_value($args['value']);
				$value = 'value="'.$value.'" ';
			}
			if(isset($args['format'])){
				$format = $args['format'];
			}
			if(isset($args['class'])){
				$class = 'class="express_form_datepicker '.$args['class'].'" ';
			}
			if(isset($args['id'])){
				$id = 'id="'.$args['id'].'" ';
			}
			if(isset($args['required'])){
				$required = 'required ';
			}
			return '<input type="text"  data-datepicker=\'{ "dateFormat": "'.$format.'"}\' '.$name.$value.$class.$id.$required.'>';
			break;
			case 'dropdown':
			/** dropdown */
			$name = '';$value = '';$options = 'yes,no';$class = '';$id = '';$required = '';
			if(isset($args['name'])){
				$name = 'name="'.$args['name'].'" ';
			}
			if(isset($args['value'])){
				$value = express_form_input_value($args['value']);
			}
			if(isset($args['options'])){
				$options = $args['options'];
			}
			if(isset($args['class'])){
				$class = 'class="'.$args['class'].'" ';
			}
			if(isset($args['id'])){
				$id = 'id="'.$args['id'].'" ';
			}
			if(isset($args['required'])){
				$required = 'required ';
			}
			$return.= '<select '.$name.$class.$id.$required.'>'."\n\r";
			$ex = explode(',',$options);
			$selected = '';
			foreach($ex as $option){
				$option = trim($option);
				$ex_op = explode('|',$option);
				if( sizeof($ex_op) == 2){
					$this_value = $ex_op[0];
					$this_label = $ex_op[1];
					if($this_value==$value){
						$selected = ' selected ';
					}
				}else{
					$this_value = $option;
					$this_label = $option;
					if($this_value==$value){
						$selected = ' selected ';
					}
				}
				$return.= '<option '.$selected.' value="'.$this_value.'">'.$this_label.'</option>'."\n\r";
			}
			$return.= '<select>';
			return $return;
			break;
			case 'captcha':
			/** captcha */
			$return = '';
			$return.= '<div class="express_form_captacha_img">'."\n\r";
			$return.= '	<img src="'.BASE_URL.'captcha.jpg" id="hm_captacha_img" />'."\n\r";
			$return.= '	<button type="button" class="express_form_reload_captcha_btn" onclick="
			document.getElementById(\'hm_captacha_img\').src=\''.BASE_URL.'captcha.jpg?\'+Math.random();
			document.getElementById(\'captcha-form\').focus();"
			id="change-image">'._('Đổi ảnh khác').'</button>';
			$return.= '	</div>'."\n\r";
			$return.= '<input type="text" name="express_form_captcha" class="express_form_captcha" placeholder="'._('Mã xác thực').'" required>';
			return $return;
			break;
			case 'submit':
			/** submit */
			$return = '';
			if(isset($args['value'])){
				$value = express_form_input_value($args['value']);
			}
			$return.= '<input type="submit" name="express_form_submit" class="express_form_submit" value="'.$value.'">';
			return $return;
			break;
			default:
			return FALSE;
		}
	}
?>
