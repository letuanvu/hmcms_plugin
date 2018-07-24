<?php
/** Tạo các table cần thiết */
$hmdb   = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
$result = $hmdb->GetTables();

$tableName = DB_PREFIX . "comment";
if (!in_array($tableName, $result)) {

  $sql = "
  CREATE TABLE IF NOT EXISTS `$tableName` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `object_id` int(11) NOT NULL,
    `object_type` varchar(255) NOT NULL,
    `parent_id` int(11) NOT NULL,
    `status` varchar(255) NOT NULL,
    `vote_value` int(11) NOT NULL,
    `like` int(11) NOT NULL,
    `un_like` int(11) NOT NULL,
    `user_role` int(11) NOT NULL,
    `created` int(11) NOT NULL,
    `updated` int(11) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  ";
  $hmdb->Query($sql);

}

?>
