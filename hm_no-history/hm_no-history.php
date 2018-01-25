<?php
/*
Plugin Name: Không lưu lịch sử;
Description: Bỏ qua việc lưu lại lịch sử chỉnh sửa;
Version: 1.0;
Version Number: 1;
*/

register_filter('content_create_revision','id_to_zero');
function id_to_zero($id){
	return 0; 
}
?>