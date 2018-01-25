<?php
/*
Plugin Name: Trang;
Description: Tạo trang tĩnh cho website;
Version: 1.0;
Version Number: 1;
*/


$field_array=array(
	'primary_name_field'=>array(
		'nice_name'=>'Tên trang',
		'name'=>'name',
		'create_slug'=>TRUE,
		'input_type'=>'text',
		'default_value'=>'',
		'placeholder'=>'Tiêu đề trang',
		'required'=>TRUE,
	),
	array(
		'nice_name'=>'Mô tả trang',
		'description'=>'Mô tả ngắn gọn về nội dung của trang này',
		'name'=>'description',
		'input_type'=>'textarea',
		'default_value'=>'',
		'placeholder'=>'',
		'required'=>FALSE,
	),
	array(
		'nice_name'=>'Nội dung trang',
		'name'=>'content',
		'input_type'=>'wysiwyg',
		'default_value'=>'',
		'placeholder'=>'',
		'required'=>FALSE,
	),
);
$args=array(
	'content_name'=>'Trang',
	'content_key'=>'page',
	'all_items'=>'Tất cả trang',
	'edit_item'=>'Sửa trang',
	'view_item'=>'Xem trang',
	'update_item'=>'Cập nhật trang',
	'add_new_item'=>'Thêm trang mới',
	'new_item_name'=>'Tên trang mới',
	'chapter'=>FALSE,
	'search_items'=>'Tìm kiếm trang',
	'content_field'=>$field_array,
	'primary_name_field'=>$field_array['primary_name_field'],
);
register_content($args);