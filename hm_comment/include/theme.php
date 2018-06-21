<?php
/** connect db */
$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

/** add comment url */
register_request('add_comment','add_comment',array('name'=>'add_comment','menu'=>False));
function add_comment(){
  global $hmdb;
  $object_id = intval(hm_post('object_id'));
  $object_type = hm_post('object_type','content');
  $parent_id = intval(hm_post('parent_id'));
  $default_status = get_option(array(
      'section' => 'hm_comment',
      'key' => 'default_status',
      'default_value' => 'pending'
  ));
  $tableName  = DB_PREFIX . "comment";
  $values = array(
    'object_id' => MySQL::SQLValue($object_id, MySQL::SQLVALUE_NUMBER),
    'object_type' => MySQL::SQLValue($object_type),
    'parent_id' => MySQL::SQLValue($parent_id, MySQL::SQLVALUE_NUMBER),
    'status' => MySQL::SQLValue($default_status),
    'created' => MySQL::SQLValue(time(), MySQL::SQLVALUE_NUMBER),
    'updated' => MySQL::SQLValue(time(), MySQL::SQLVALUE_NUMBER),
  );
  $comment_id = $hmdb->InsertRow($tableName, $values);
  if(is_numeric($comment_id)){
    $input_post = $_POST;
    unset($input_post['object_id']);
    unset($input_post['parent_id']);
    foreach ($input_post as $post_key => $post_val) {
        if (is_array($post_val)) {
            $post_val = hm_json_encode($post_val);
        }
        $tableName = DB_PREFIX . 'field';
        $values = array(
          'name' => MySQL::SQLValue($post_key),
          'val' => MySQL::SQLValue($post_val),
          'object_id' => MySQL::SQLValue($comment_id, MySQL::SQLVALUE_NUMBER),
          'object_type' => MySQL::SQLValue('comment'),
        );
        $hmdb->InsertRow($tableName, $values);
    }
    switch ($default_status) {
      case 'public':
        $message = get_option( array('section'=>'hm_comment','key'=>'public_comment_submit_noti') );
      break;
      case 'hidden':
        $message = get_option( array('section'=>'hm_comment','key'=>'hidden_comment_submit_noti') );
      break;
      default:
        $message = '';
    }
    $return_mes = array(
      'status' => 'success',
      'message' => $message
    );
  }else{
    $return_mes = array(
      'status' => 'error',
      'message' => get_option( array('section'=>'hm_comment','key'=>'error_comment_submit_noti') ),
    );
  }

  header('Content-Type: application/json');
  echo json_encode($return_mes);
}

/** load comment url */
register_request('load_comment','load_comment',array('name'=>'load_comment','menu'=>False));
function load_comment(){
  $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
  $object_id =  hm_get('object_id');
  $page =  hm_get('page');

  $data = array();
  $tableName=DB_PREFIX."comment";
  $sql = "SELECT * FROM " . $tableName . " WHERE `status` = 'public' AND `parent_id` = 0 AND `object_id` = '" . $object_id . "' ORDER BY `created` DESC";
  $hmdb->Query($sql);
  if( $hmdb->HasRecords() ){
    while( $row = $hmdb->Row() ){
      $cmt_fields = get_comment_fields($row->id);
      $this_cmt_field = array();
      foreach($cmt_fields as $cmt_field){
        $this_cmt_field[$cmt_field->name] = $cmt_field->val;
      }
      $data[] = array(
        'comment' => $row,
        'comment_fields' => $this_cmt_field
      );
    }
  }
  header('Content-Type: application/json');
  echo json_encode($data);
}

?>
