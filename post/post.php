<?php
/*
Plugin Name: Bài viết;
Description: Tạo bài viết cho website;
Version: 1.0;
Version Number: 1;
*/


/**
 * Khởi tạo 1 taxonomy mặc định có tên là "Danh mục bài viết" và key là "category"
 * cho dạng nội dung "post" và định nghĩa các trường nhập vào
 * Lưu ý : Luôn phải có 1 trường có key là primary_name_field, trường này sẽ được dùng là tên của
 * content, taxonomy và trường này có 'create_slug'=>TRUE để tạo slug - đường dẫn tĩnh cho content, taxonomy này
 */

hook_action('before_web_setup');

$field_array = array(
    'primary_name_field' => array(
        'nice_name' => hm_lang('category_name'),
        'description' => hm_lang('the_name_is_how_it_appears_on_your_site'),
        'name' => 'name',
        'create_slug' => TRUE,
        'input_type' => 'text',
        'default_value' => '',
        'placeholder' => hm_lang('enter_title_here'),
        'required' => TRUE
    ),
    array(
        'nice_name' => hm_lang('category_description'),
        'description' => hm_lang('a_short_text_description_of_this_category'),
        'name' => 'description',
        'input_type' => 'textarea',
        'default_value' => '',
        'placeholder' => '',
        'required' => FALSE
    )
);

$args = array(
    'taxonomy_name' => hm_lang('category'),
    'taxonomy_key' => 'category',
    'content_key' => 'post',
    'all_items' => hm_lang('all_category'),
    'edit_item' => hm_lang('edit_category'),
    'view_item' => hm_lang('view_category'),
    'update_item' => hm_lang('update_category'),
    'add_new_item' => hm_lang('add_new_category'),
    'new_item_name' => hm_lang('new_category_name'),
    'parent_item' => hm_lang('category_parent'),
    'no_parent' => hm_lang('no_category_parent'),
    'search_items' => hm_lang('search_category'),
    'popular_items' => hm_lang('most_used_category'),
    'taxonomy_field' => $field_array,
    'primary_name_field' => $field_array['primary_name_field']
);
register_taxonomy($args);


/**
 * Khởi tạo 1 content mặc định là "Bài viết" sử dụng kiểu taxonomy là "Danh mục bài viết"
 * đã khởi tạo ở trên, vì ở trên taxonomy "Danh mục bài viết" đã đăng ký content_key là "post"
 * nên dạng nội dung này sẽ có content_key là "post" để dùng được trong "Danh mục bài viết"
 */

$field_array = array(
    'primary_name_field' => array(
        'nice_name' => hm_lang('post_name'),
        'name' => 'name',
        'create_slug' => TRUE,
        'input_type' => 'text',
        'default_value' => '',
        'placeholder' => hm_lang('post_title'),
        'required' => TRUE
    ),
    array(
        'nice_name' => hm_lang('post_description'),
        'description' => hm_lang('briefly_describe_the_contents_of_this_post'),
        'name' => 'description',
        'input_type' => 'textarea',
        'default_value' => '',
        'placeholder' => '',
        'required' => FALSE
    ),
    array(
        'nice_name' => hm_lang('post_content'),
        'name' => 'content',
        'input_type' => 'wysiwyg',
        'default_value' => '',
        'placeholder' => '',
        'required' => FALSE
    )
);
$args        = array(
    'content_name' => hm_lang('post'),
    'taxonomy_key' => 'category',
    'content_key' => 'post',
    'all_items' => hm_lang('all_post'),
    'edit_item' => hm_lang('edit_post'),
    'view_item' => hm_lang('view_post'),
    'update_item' => hm_lang('update_post'),
    'add_new_item' => hm_lang('add_new_post'),
    'new_item_name' => hm_lang('new_post_name'),
    'chapter' => FALSE,
    'search_items' => hm_lang('search_post'),
    'content_field' => $field_array,
    'primary_name_field' => $field_array['primary_name_field']
);
register_content($args);
?>
