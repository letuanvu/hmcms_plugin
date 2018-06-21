<?php
/** comment setting */
$args = array(
    'label' => 'Bình luận',
    'key' => 'hm_comment_main_setting',
    'function' => 'hm_comment_main_setting',
    'function_input' => array(),
    'child_of' => FALSE
);
register_admin_setting_page($args);
function hm_comment_main_setting() {
    if (isset($_POST['save_setting'])) {
        foreach ($_POST as $key => $value) {
            $args = array(
                'section' => 'hm_comment',
                'key' => $key,
                'value' => $value
            );
            set_option($args);
        }
    }
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_comment/layout/main_setting.php');
}

/** get comment fields */
function get_comment_fields($cmt_id){
  $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
  $tableName  = DB_PREFIX . "field";
  $whereArray = array(
      'object_type' => MySQL::SQLValue('comment'),
      'object_id' => MySQL::SQLValue($cmt_id)
  );
  $hmdb->SelectRows($tableName, $whereArray);
  if ($hmdb->HasRecords()) {
      while($row = $hmdb->Row()){
        $fields[] = $row;
      }
      return $fields;
  } else {
      return NULL;
  }
}

/** comment list */
$args=array(
  'label'=>'Bình luận',
  'admin_menu'=>TRUE,
  'key'=>'comment_all',
  'function'=>'comment_all',
  'icon'=>'fa-comments',
  'child_of'=>FALSE,
);
register_admin_page($args);

function comment_all(){
  $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
  $data = array();
  $status = hm_get('status',NULL);
  $tableName=DB_PREFIX."comment";
  if($status){
    $hmdb->Query("SELECT * FROM " . $tableName . " WHERE `parent_id` = 0 AND `status` = '" . $status . "' ORDER BY `created` DESC");
  }else{
    $hmdb->Query("SELECT * FROM " . $tableName . " WHERE `status` IN ('public','hidden') AND `parent_id` = 0 ORDER BY `created` DESC");
  }
  if( $hmdb->HasRecords() ){
    while( $row = $hmdb->Row() ){
      $data[] = $row;
    }
  }
  hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_comment/layout/all.php',$data);
}

/** admin ajax */
$args=array(
  'key'=>'comment_action',
  'function'=>'comment_action',
  'method'=>array('post'),
);
register_admin_ajax_page($args);

function comment_action(){
  $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
  $action = hm_post('action');
  $status = hm_post('status');
  $id = hm_post('id');
  if($action == 'update_status'){
    $values = array('status' => MySQL::SQLValue($status));
    $tableName = DB_PREFIX . "comment";
    $whereArray = array(
        'id' => MySQL::SQLValue($id, MySQL::SQLVALUE_NUMBER),
    );
    $hmdb->UpdateRows($tableName, $values, $whereArray);
  }
}
?>
