<?php
/*
Plugin Name: Customfield;
Description: Thêm các trường nhập dữ liệu cho content và taxonomy;
Version: 1;
Version Number: 1;
*/


/* 
Đăng ký trang plugin setting
*/
$args = [
    'label' => 'Trường tùy biến',
    'key' => 'hm_customfield_main_setting',
    'function' => 'hm_customfield_main_setting',
    'function_input' => [],
    'child_of' => false,
];
register_admin_setting_page($args);
function hm_customfield_main_setting()
{

    if (isset($_POST['save_customfield_setting'])) {

        $field_key = hm_post('field_key');
        if (isset($_POST['default_value'])) {
            if (!is_array($_POST['default_value'])) {
                $_POST['default_value'] = base64_encode($_POST['default_value']);
            }
        }
        if (isset($_POST['input_option'])) {
            if (!is_array($_POST['input_option'])) {
                $_POST['input_option'] = base64_encode($_POST['input_option']);
            }
        }
        $args = [
            'section' => 'hm_customfield',
            'key' => $field_key,
            'value' => $_POST,
        ];
        set_option($args);

    }

    $fields = [];
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

    $tableName = DB_PREFIX . 'option';
    $whereArray = [
        'section' => MySQL::SQLValue('hm_customfield'),
    ];
    $hmdb->SelectRows($tableName, $whereArray);
    while ($row = $hmdb->Row()) {
        $fields[] = $row;
    }

    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_customfield/layout/main_setting.php', $fields);
}


/* 
Đăng request ajax
*/
$args = [
    'key' => 'hm_customfield_ajax',
    'function' => 'hm_customfield_ajax',
    'method' => ['post'],
];
register_admin_ajax_page($args);

function hm_customfield_ajax()
{

    $action = hm_post('action');

    switch ($action) {
        case 'ajax_field_append':

            $type = hm_post('type');
            if ($type == 'content') {
                echo '<div class="form-group">' . "\r\n";
                echo '	<label for="default_value">Bao gồm:</label>' . "\r\n";
                hm_customfield_ajax_content();
                echo '</div>' . "\n\r";
            } else if ($type == 'taxonomy') {
                echo '<div class="form-group">' . "\r\n";
                echo '	<label for="default_value">Bao gồm:</label>' . "\r\n";
                hm_customfield_ajax_taxonomy();
                echo '</div>' . "\n\r";
            }

            break;
        case 'ajax_field_type':

            $type = hm_post('type');
            hm_customfield_ajax_field_type($type);

            break;
        case 'ajax_field_key':

            $name = hm_post('name');
            hm_customfield_ajax_field_key($name);

            break;
        case 'del_field':

            $id = hm_post('id');
            hm_customfield_del_field($id);

            break;
        default:
            hm_exit(_('Truy cập bị từ chối'));
    }
}


function hm_customfield_ajax_content($name = 'field_append_content', $checked = [])
{

    global $hmcontent;

    echo '<ul class="hm_customfield_ajax_list">' . "\n\r";
    foreach ($hmcontent->hmcontent as $item) {

        if (!isset($item['content_name'])) {
            $item['content_name'] = null;
        }
        if (!isset($item['content_key'])) {
            $item['content_key'] = null;
        }
        if (!is_array($checked)) {
            $checked = [];
        }
        $content_name = $item['content_name'];
        $content_key = $item['content_key'];
        $thischecked = '';
        if (in_array($content_key, $checked)) {
            $thischecked = ' checked';
        }
        echo '<li>' . "\n\r" .
            '<input type="checkbox"' . $thischecked . ' name="' . $name . '[]" value="' . $content_key . '"  />' . "\n\r" .
            '<label>' . $content_name . '</label>' . "\n\r" .
            '</li>' . "\n\r";
    }
    echo '</ul>' . "\n\r";

}


function hm_customfield_ajax_taxonomy($name = 'field_append_taxonomy', $checked = [])
{

    global $hmtaxonomy;

    if (!is_array($checked)) {
        $checked = [];
    }

    echo '<ul class="hm_customfield_ajax_list">' . "\n\r";
    foreach ($hmtaxonomy->hmtaxonomy as $item) {
        $taxonomy_name = $item['taxonomy_name'];
        $taxonomy_key = $item['taxonomy_key'];
        $thischecked = '';
        if (in_array($taxonomy_key, $checked)) {
            $thischecked = ' checked';
        }
        echo '<li>' . "\n\r" .
            '<input type="checkbox"' . $thischecked . ' name="' . $name . '[]" value="' . $taxonomy_key . '"  />' . "\n\r" .
            '<label>' . $taxonomy_name . '</label>' . "\n\r" .
            '</li>' . "\n\r";
    }
    echo '</ul>' . "\n\r";

}

function hm_customfield_ajax_field_type($type, $default = false, $input_option = false)
{


    $has_option = [
        'select',
        'radio',
        'checkbox',
    ];

    $avanced = [
        'content',
        'taxonomy',
    ];

    $upload_file = [
        'image',
        'file',
    ];

    $upload_multi_file = [
        'multiimage',
        'multifile',
    ];

    //decode default
    if ($default AND !in_array($type, $avanced)) {
        $default = base64_decode($default);
    }
    if ($input_option AND !is_array($input_option)) {
        $input_option = base64_decode($input_option);
    }


    if (in_array($type, $avanced)) {

        echo '	<div class="form-group">' . "\r\n";
        echo '	<label for="default_value">Suggest từ:</label>' . "\r\n";
        if ($type == 'content') {
            hm_customfield_ajax_content('data_key', $input_option);
        } else if ($type == 'taxonomy') {
            hm_customfield_ajax_taxonomy('data_key', $input_option);
        }
        echo '	</div>' . "\r\n";

        $args = [];
        $args['nice_name'] = 'Giá trị mặc định';
        $args['name'] = 'default_value';
        $args['data_type'] = $type;
        $args['data_key'] = $input_option;
        $args['default_value'] = base64_decode($default);
        input_data($args);

    } else if (in_array($type, $has_option)) {

        echo '<div class="form-group">' . "\r\n";
        echo '	<label for="default_value">Các lựa chọn</label>' . "\r\n";
        echo '	<p class="input_description">Viết theo cấu trúc: <font color="red">option:label</font>, các lựa chọn <font color="red">cách nhau bằng dấu phẩy</font>. Ví dụ:<br> khongluachon:Không lựa chọn,<br>co:Có,<br>khong:Không</p>' . "\r\n";
        echo '	<textarea name="input_option" type="text" class="form-control " id="default_value">' . $input_option . '</textarea>' . "\r\n";
        echo '</div>' . "\r\n";

        echo '<div class="form-group">' . "\r\n";
        echo '	<label for="default_value">Giá trị mặc định</label>' . "\r\n";
        echo '	<input name="default_value" type="text" class="form-control " id="default_value" value="' . $default . '">' . "\r\n";
        echo '</div>' . "\r\n";


    } else if (in_array($type, $upload_file)) {

        $args = [];
        $args['name'] = 'default_value';
        $args['label'] = 'Tệp tin mặc định';
        if ($type == 'image') {
            $args['imageonly'] = true;
        }
        $args['default_value'] = $default;
        media_file_input($args);

    } else if (in_array($type, $upload_multi_file)) {

        $args = [];
        $args['name'] = 'default_value';
        $args['label'] = 'Các tệp tin mặc định';
        $args['multi'] = true;
        if ($type == 'multiimage') {
            $args['imageonly'] = true;
        }
        $args['default_value'] = $default;
        media_file_input($args);

    } else {

        echo '<div class="form-group">' . "\r\n";
        echo '	<label for="default_value">Giá trị mặc định</label>' . "\r\n";
        echo '	<input name="default_value" type="text" class="form-control " id="default_value" value="' . $default . '">' . "\r\n";
        echo '</div>' . "\r\n";

    }
}

function hm_customfield_ajax_field_key($name)
{
    echo sanitize_title($name);
}

function hm_customfield_del_field($id)
{

    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $tableName = DB_PREFIX . 'option';
    $whereArray = [
        'section' => MySQL::SQLValue('hm_customfield'),
        'id' => MySQL::SQLValue($id),
    ];
    $hmdb->DeleteRows($tableName, $whereArray);


}


/*
Tạo content box
*/
$args = [
    'label' => 'Trường tùy biến',
    'position' => 'left',
    'function' => 'hm_customfield_box',
];
register_content_box($args);
register_taxonomy_box($args);

function hm_customfield_box()
{

    $fields = [];
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

    $tableName = DB_PREFIX . 'option';
    $whereArray = [
        'section' => MySQL::SQLValue('hm_customfield'),
    ];
    $hmdb->SelectRows($tableName, $whereArray);
    $now_in = hm_get('run');

    while ($row = $hmdb->Row()) {

        $value = json_decode($row->value);
        $id = $value->id;
        $field_name = $value->field_name;
        $field_key = $value->field_key;
        $field_append = $value->field_append;
        if ($field_append == 'content') {
            $field_append_content = $value->field_append_content;
        }
        if ($field_append == 'taxonomy') {
            $field_append_taxonomy = $value->field_append_taxonomy;
        }
        $field_type = $value->field_type;

        $has_option = [
            'select',
            'radio',
            'checkbox',
        ];

        $avanced = [
            'content',
            'taxonomy',
        ];

        $upload_file = [
            'image',
            'file',
        ];

        $upload_multi_file = [
            'multiimage',
            'multifile',
        ];

        //default value
        $default_value = '';
        if (isset($value->default_value)) {
            $default_value = $value->default_value;
        }
        $data_key = [];
        if (in_array($field_type, $avanced)) {
            if (isset($value->data_key)) {
                $data_key = $value->data_key;
            }
        }
        $default_value = base64_decode($default_value);

        //in edit
        if (hm_get('action') == 'edit') {
            if (hm_get('run') == 'taxonomy.php') {
                $default_value = get_tax_val(['name' => $field_key, 'id' => hm_get('id')]);
            } else if (hm_get('run') == 'content.php') {
                $default_value = get_con_val(['name' => $field_key, 'id' => hm_get('id')]);
            }
        }

        $args = [
            'nice_name' => $field_name,
            'label' => $field_name,
            'name' => $field_key,
            'input_type' => $field_type,
            'addClass' => 'hm_customfield',
            'addAttr' => 'data-id="' . $id . '"',
            'default_value' => $default_value,
            'data_key' => $data_key,
        ];


        //has option
        if (in_array($field_type, $has_option)) {

            $input_option = [];
            $input_option_str = base64_decode($value->input_option);
            $ex = explode(',', $input_option_str);
            $ex = array_map('trim', $ex);
            foreach ($ex as $item) {
                $ex_option = explode(':', $item);
                $ex_option = array_map('trim', $ex_option);
                $input_option[] = ['value' => $ex_option[0], 'label' => $ex_option[1]];
            }

            $args['input_option'] = $input_option;

        }

        $key = hm_get('key');
        $action = hm_get('action');
        if ($action == 'edit') {
            if ($now_in == 'content.php') {
                $data = content_data_by_id(hm_get('id'));
                $key = $data['content']->key;
            } else if ($now_in == 'taxonomy.php') {
                $data = taxonomy_data_by_id(hm_get('id'));
                $key = $data['taxonomy']->key;
            }
        }

        //content
        if ($now_in == 'content.php' AND $field_append == 'content' AND in_array($key, $field_append_content)) {
            build_input_form($args);
        }
        //taxonomy
        if ($now_in == 'taxonomy.php' AND $field_append == 'taxonomy' AND in_array($key, $field_append_taxonomy)) {
            build_input_form($args);
        }


    }

}

?>