<?php
function hme_customer_field_config()
{
    return [
        [
            'nice_name' => hme_lang('customer_name'),
            'name' => 'name',
            'input_type' => 'text',
            'default_value' => '',
            'placeholder' => hme_lang('customer_name'),
            'show_on' => array('list', 'edit')
        ],
        [
            'nice_name' => hme_lang('phone_number'),
            'name' => 'mobile',
            'input_type' => 'text',
            'default_value' => '',
            'placeholder' => hme_lang('phone_number'),
            'show_on' => array('list', 'edit')
        ],
        [
            'nice_name' => hme_lang('address'),
            'name' => 'address',
            'input_type' => 'text',
            'default_value' => '',
            'placeholder' => hme_lang('address'),
            'show_on' => array('edit')
        ],
    ];
}

?>
