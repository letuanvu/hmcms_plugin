<?php
/*
Manage customer
*/
$args=array(
  'label'=>hme_lang('customer'),
  'admin_menu'=>TRUE,
  'key'=>'show_customer',
  'function'=>'show_customer',
  'icon'=>'fa-users',
  'child_of'=>FALSE,
);
register_admin_page($args);
function show_customer(){
  $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
  $data = array();
  $tableName=DB_PREFIX."hme_customer";
  $hmdb->SelectRows($tableName);
  if( $hmdb->HasRecords() ){
    while( $row = $hmdb->Row() ){
      $data[] = $row;
    }
  }
  hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/layout/show_customer.php',$data);
}

/*
edit customer
*/
$args=array(
  'label'=>hme_lang('customer'),
  'admin_menu'=>FALSE,
  'key'=>'edit_customer',
  'function'=>'edit_customer',
  'icon'=>'fa-users',
  'child_of'=>FALSE,
);
register_admin_page($args);
function edit_customer(){
  $cid = hm_get('id',0);
  if(isset($_POST['save_customer_setting'])){
    $data = hme_customer_update_customer($cid);
  }
  $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
  $tableName=DB_PREFIX."hme_customer";
  $whereArray = array(
      'id' => MySQL::SQLValue($cid)
  );
  $hmdb->SelectRows($tableName, $whereArray);
  $data = $hmdb->Row();
  hm_include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/layout/edit_customer.php',$data);
}
?>
