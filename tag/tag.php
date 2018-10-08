<?php
/*
Plugin Name: Tag Manager;
Description: Tag management for website;
Version: 1.0;
Version Number: 1;
*/

$field_array = [
    'primary_name_field' => [
        'nice_name' => hm_lang('tag_name'),
        'description' => hm_lang('the_name_is_how_it_appears_on_your_site'),
        'name' => 'name',
        'create_slug' => true,
        'input_type' => 'text',
        'default_value' => '',
        'placeholder' => hm_lang('enter_title_here'),
        'required' => true
    ],
    [
        'nice_name' => hm_lang('tag_description'),
        'description' => hm_lang('a_short_text_description_of_this_tag'),
        'name' => 'description',
        'input_type' => 'textarea',
        'default_value' => '',
        'placeholder' => '',
        'required' => false
    ]
];

$args = [
    'taxonomy_name' => hm_lang('tag'),
    'taxonomy_key' => 'tag',
    'content_key' => 'tag',
    'all_items' => hm_lang('all_tag'),
    'edit_item' => hm_lang('edit_tag'),
    'view_item' => hm_lang('view_tag'),
    'update_item' => hm_lang('update_tag'),
    'add_new_item' => hm_lang('add_new_tag'),
    'new_item_name' => hm_lang('new_tag_name'),
    'parent_item' => hm_lang('tag_parent'),
    'no_parent' => hm_lang('no_tag_parent'),
    'search_items' => hm_lang('search_tag'),
    'popular_items' => hm_lang('most_used_tag'),
    'taxonomy_field' => $field_array,
    'primary_name_field' => $field_array['primary_name_field']
];
register_taxonomy($args);


/*
Register menu
*/
$args = [
    'label' => hm_lang('tag'),
    'admin_menu' => true,
    'key' => 'all_tag',
    'function' => 'all_tag',
    'icon' => 'fa-tag',
    'child_of' => false,
];
register_admin_page($args);

function all_tag()
{
    $url = BASE_URL . HM_ADMINCP_DIR . '?run=taxonomy.php&key=tag&status=public';
    hm_redirect($url);
}

?>
