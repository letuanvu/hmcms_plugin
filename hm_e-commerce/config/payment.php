<?php
function hme_payment_field_config()
{
    return [
        [
            'nice_name' => hme_lang('customer_name'),
            'name' => 'name',
            'input_type' => 'text',
            'default_value' => '',
            'placeholder' => hme_lang('customer_name'),
        ],
        [
            'nice_name' => hme_lang('phone_number'),
            'name' => 'mobile',
            'input_type' => 'text',
            'default_value' => '',
            'placeholder' => hme_lang('phone_number'),
        ],
        [
            'nice_name' => hme_lang('email'),
            'name' => 'email',
            'input_type' => 'email',
            'default_value' => '',
            'placeholder' => hme_lang('email'),
        ],
        [
            'nice_name' => hme_lang('address'),
            'name' => 'address',
            'input_type' => 'text',
            'default_value' => '',
            'placeholder' => hme_lang('address'),
        ],
        [
            'nice_name' => hme_lang('message'),
            'name' => 'message',
            'input_type' => 'textarea',
            'default_value' => '',
            'placeholder' => hme_lang('message'),
        ],
    ];
}

?>
