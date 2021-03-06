<?php

/** Tạo danh mục sản phẩm */
$field_array = [
    'primary_name_field' => [
        'nice_name' => hme_lang('category_name'),
        'description' => hme_lang('category_used_to_classify_your_products'),
        'name' => 'name',
        'create_slug' => true,
        'input_type' => 'text',
        'default_value' => '',
        'placeholder' => hme_lang('enter_category_name'),
        'required' => true
    ],
    [
        'nice_name' => hme_lang('product_category_description'),
        'description' => hme_lang('a_short_text_describing_this_product_category'),
        'name' => 'description',
        'input_type' => 'textarea',
        'default_value' => '',
        'placeholder' => '',
        'required' => false
    ]
];

$args = [
    'taxonomy_name' => hme_lang('product_category'),
    'taxonomy_key' => 'product-category',
    'content_key' => 'product',
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
];
register_taxonomy($args);

/** Tạo post type sản phẩm */
$field_array = [
    'primary_name_field' => [
        'nice_name' => hme_lang('product_name'),
        'name' => 'name',
        'create_slug' => true,
        'input_type' => 'text',
        'default_value' => '',
        'placeholder' => hme_lang('product_name'),
        'required' => true
    ],
    [
        'nice_name' => hme_lang('sku'),
        'name' => 'sku',
        'input_type' => 'text',
        'default_value' => '',
        'placeholder' => hme_lang('stock_keeping_unit')
    ],
    [
        'nice_name' => hme_lang('product_description'),
        'description' => hme_lang('a_short_text_description_of_this_product'),
        'name' => 'description',
        'input_type' => 'textarea',
        'default_value' => '',
        'placeholder' => '',
        'required' => false
    ],
    [
        'nice_name' => hme_lang('price'),
        'name' => 'price',
        'input_type' => 'number',
        'default_value' => '',
        'placeholder' => hme_lang('just_enter_the_number')
    ],
    [
        'nice_name' => hme_lang('deal_price'),
        'name' => 'deal_price',
        'input_type' => 'number',
        'default_value' => '',
        'placeholder' => hme_lang('just_enter_the_number')
    ],
    [
        'nice_name' => hme_lang('status'),
        'name' => 'product_status',
        'input_type' => 'select',
        'input_option' => [
            [
                'value' => 'none',
                'label' => hme_lang('does_not_show')
            ],
            [
                'value' => 'new',
                'label' => hme_lang('new')
            ],
            [
                'value' => 'in-stock',
                'label' => hme_lang('stocking')
            ],
            [
                'value' => 'out-of-stock',
                'label' => hme_lang('out_of_stock')
            ],
            [
                'value' => 'place-an-order',
                'label' => hme_lang('get_order')
            ]
        ],
        'required' => true
    ],
    [
        'nice_name' => hme_lang('featured_products'),
        'name' => 'product_hot',
        'input_type' => 'select',
        'input_option' => [
            [
                'value' => 'yes',
                'label' => hme_lang('yes')
            ],
            [
                'value' => 'no',
                'label' => hme_lang('no')
            ]
        ],
        'required' => true
    ],
    [
        'nice_name' => hme_lang('product_details'),
        'name' => 'content',
        'input_type' => 'wysiwyg',
        'default_value' => '',
        'placeholder' => '',
        'required' => false
    ]

];

$args = [
    'content_name' => hme_lang('product'),
    'taxonomy_key' => 'product-category',
    'content_key' => 'product',
    'all_items' => hme_lang('all_products'),
    'edit_item' => hme_lang('edit_product'),
    'view_item' => hme_lang('see_product'),
    'update_item' => hme_lang('update_product'),
    'add_new_item' => hme_lang('add_new_product'),
    'new_item_name' => hme_lang('new_product_name'),
    'search_items' => hme_lang('search_product'),
    'content_field' => $field_array,
    'primary_name_field' => $field_array['primary_name_field']
];
register_content($args);
?>
