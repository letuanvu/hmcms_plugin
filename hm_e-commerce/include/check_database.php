<?php
/** Tạo các table cần thiết */
$hmdb   = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
$result = $hmdb->GetTables();

$tableName = DB_PREFIX . "hme_order";
if (!in_array($tableName, $result)) {

    $sql = "
  CREATE TABLE IF NOT EXISTS `$tableName` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `time` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `mobile` varchar(255) NOT NULL,
    `address` varchar(255) NOT NULL,
    `payment_method` varchar(255) NOT NULL,
    `ship_method` varchar(255) NOT NULL,
    `message` varchar(255) NOT NULL,
    `is_installment` varchar(255) NOT NULL,
    `installment_month` int(11) NOT NULL,
    `installment_first_pay` int(11) NOT NULL,
    `installment_per_month_pay` int(11) NOT NULL,
    `installment_total_pay` int(11) NOT NULL,
    `installment_partner` varchar(255) NOT NULL,
    `status` varchar(255) NOT NULL,
    `customer_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  ";
    $hmdb->Query($sql);

}

$tableName = DB_PREFIX . "hme_order_item";
if (!in_array($tableName, $result)) {

    $sql = "
  CREATE TABLE IF NOT EXISTS `$tableName` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `order_id` int(11) NOT NULL,
    `product_id` int(11) NOT NULL,
    `product_name` varchar(255) NOT NULL,
    `product_price` int(11) NOT NULL,
    `qty` int(11) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  ";
    $hmdb->Query($sql);

}

$tableName = DB_PREFIX . "hme_customer";
if (!in_array($tableName, $result)) {

    $sql = "
  CREATE TABLE IF NOT EXISTS `$tableName` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `mobile` varchar(255) NOT NULL,
    `customer_group` int(11) NOT NULL,
    `note` longtext NOT NULL,
    `user_id` int(11) NOT NULL,
    `discount` varchar(255) NOT NULL,
    `discount_type` varchar(255) NOT NULL,
    `activation_code` varchar(255) NOT NULL,
    `register_time` int(11) NOT NULL,
    `last_login_time` int(11) NOT NULL,
    `ip` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  ";
    $hmdb->Query($sql);

}

$tableName = DB_PREFIX . "hme_product_option_group";
if (!in_array($tableName, $result)) {

    $sql = "
  CREATE TABLE IF NOT EXISTS `$tableName` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `key` varchar(255) NOT NULL,
    `parent` int(11) NOT NULL,
    `group_order` int(11) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  ";
    $hmdb->Query($sql);

}

$tableName = DB_PREFIX . "hme_product_option";
if (!in_array($tableName, $result)) {

    $sql = "
  CREATE TABLE IF NOT EXISTS `$tableName` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `option_image` int(11) NOT NULL,
    `key` varchar(255) NOT NULL,
    `parent` int(11) NOT NULL,
    `group_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  ";
    $hmdb->Query($sql);

}


/** fix for update */
$tableName = DB_PREFIX . "hme_order";
$columns   = $hmdb->GetColumnNames($tableName);
if (!isset($columns['customer_id'])) {
    $sql = "ALTER TABLE `" . $tableName . "` ADD `customer_id` int(11) NOT NULL DEFAULT 0";
    $hmdb->Query($sql);
}

$tableName = DB_PREFIX . "hme_order_item";
$columns   = $hmdb->GetColumnNames($tableName);
if (!isset($columns['product_option'])) {
    $sql = "ALTER TABLE `" . $tableName . "` ADD `product_option` varchar(255) NOT NULL";
    $hmdb->Query($sql);
}

?>
