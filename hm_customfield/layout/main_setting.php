<link rel="stylesheet" type="text/css"
      href="<?php echo SITE_URL . '/' . HM_PLUGIN_DIR . '/hm_customfield/asset'; ?>/style.css">
<script type="text/javascript" src="<?php echo SITE_URL . '/' . HM_PLUGIN_DIR . '/hm_customfield/asset'; ?>/main.js"
        charset="UTF-8"></script>

<div class="row">
    <div class="col-md-12">
        <h1 class="page_title"><?php echo _('Quản lý trường tùy biến'); ?></h1>
    </div>
    <?php
    if (is_array($data)) {
        foreach ($data as $field) {
            $id = $field->id;
            $section = $field->section;
            $key = $field->key;
            $value = json_decode($field->value);
            ?>
            <form action="" method="post">
                <div class="customfield_line">
                    <div class="row">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="col-md-2">
                            <?php
                            $args = [
                                'nice_name' => 'Tên trường',
                                'name' => 'field_name',
                                'input_type' => 'text',
                                'required' => true,
                                'addClass' => 'ajax_field_name',
                                'addAttr' => 'data-id="' . $id . '"',
                                'default_value' => $value->field_name,
                            ];
                            build_input_form($args);
                            ?>
                        </div>
                        <div class="col-md-2">
                            <?php
                            $args = [
                                'nice_name' => 'Key',
                                'name' => 'field_key',
                                'input_type' => 'text',
                                'required' => true,
                                'addClass' => 'ajax_field_key',
                                'addAttr' => 'data-id="' . $id . '"',
                                'default_value' => $value->field_key,
                            ];
                            build_input_form($args);
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                            $args = [
                                'nice_name' => 'Áp dụng cho',
                                'name' => 'field_append',
                                'input_type' => 'select',
                                'addClass' => 'ajax_field_append_select',
                                'addAttr' => 'data-id="' . $id . '"',
                                'input_option' => [
                                    ['value' => 'none', 'label' => 'Không kích hoạt'],
                                    ['value' => 'content', 'label' => 'Kiểu nội dung'],
                                    ['value' => 'taxonomy', 'label' => 'Kiểu phân loại'],
                                ],
                                'default_value' => $value->field_append,
                            ];
                            build_input_form($args);
                            ?>
                            <div class="ajax_field_append" data-id="<?php echo $id; ?>">
                                <?php
                                if ($value->field_append == 'content') {
                                    echo '<div class="form-group">' . "\r\n";
                                    echo '	<label for="default_value">Bao gồm:</label>' . "\r\n";
                                    hm_customfield_ajax_content('field_append_content', $value->field_append_content);
                                    echo '</div>' . "\n\r";
                                } else if ($value->field_append == 'taxonomy') {
                                    echo '<div class="form-group">' . "\r\n";
                                    echo '	<label for="default_value">Bao gồm:</label>' . "\r\n";
                                    hm_customfield_ajax_taxonomy('field_append_taxonomy', $value->field_append_taxonomy);
                                    echo '</div>' . "\n\r";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            $args = [
                                'nice_name' => 'Phương thức nhập',
                                'name' => 'field_type',
                                'input_type' => 'select',
                                'addClass' => 'ajax_field_type_select',
                                'addAttr' => 'data-id="' . $id . '"',
                                'input_option' => [
                                    ['value' => 'text', 'label' => 'Văn bản (text)'],
                                    ['value' => 'textarea', 'label' => 'Văn bản dài (textarea)'],
                                    ['value' => 'number', 'label' => 'Số (number)'],
                                    ['value' => 'email', 'label' => 'Email (email)'],
                                    ['value' => 'password', 'label' => 'Mật khẩu (password)'],
                                    ['value' => 'hidden', 'label' => 'Ẩn (hidden)'],
                                    ['value' => 'request_uri', 'label' => 'URL nội bộ (request)'],
                                    ['value' => 'wysiwyg', 'label' => 'Bộ soạn thảo (wysiwyg)'],
                                    ['value' => 'select', 'label' => 'Lựa chọn đơn (select)'],
                                    ['value' => 'radio', 'label' => 'Lựa chọn đơn (radio)'],
                                    ['value' => 'checkbox', 'label' => 'Lựa chọn nhiều (checkbox)'],
                                    ['value' => 'image', 'label' => 'Ảnh (image)'],
                                    ['value' => 'multiimage', 'label' => 'Nhiều ảnh (multiimage)'],
                                    ['value' => 'file', 'label' => 'Tệp tin (file)'],
                                    ['value' => 'content', 'label' => 'Nội dung (content)'],
                                    ['value' => 'taxonomy', 'label' => 'Phân loại (taxonomy)'],
                                ],
                                'default_value' => $value->field_type,
                            ];
                            build_input_form($args);
                            ?>
                            <div class="ajax_field_type" data-id="<?php echo $id; ?>">
                                <?php
                                $has_option = [
                                    'select',
                                    'radio',
                                    'checkbox',
                                ];
                                $avanced = [
                                    'content',
                                    'taxonomy',
                                ];
                                $default_value = '';
                                if (isset($value->default_value)) {
                                    $default_value = $value->default_value;
                                }
                                $data_key = [];
                                if (isset($value->data_key)) {
                                    $data_key = $value->data_key;
                                }
                                if (in_array($value->field_type, $has_option)) {
                                    hm_customfield_ajax_field_type($value->field_type, $default_value, $value->input_option);
                                } else if (in_array($value->field_type, $avanced)) {
                                    hm_customfield_ajax_field_type($value->field_type, $default_value, $data_key);
                                } else {
                                    hm_customfield_ajax_field_type($value->field_type, $default_value);
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="form-group-handle"></div>
                                <label for="field_append">Hành động</label>
                                <div class="row">
                                    <button name="save_customfield_setting" type="submit"
                                            class="btn btn-success"><?php echo _('Lưu'); ?></button>
                                    <span class="btn btn-danger ajax-del-field"
                                          data-id="<?php echo $id; ?>"><?php echo _('Xóa'); ?></span>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </form>
            <?php
        }
    }
    ?>


    <form action="" method="post">

        <div class="customfield_line">
            <div class="row">
                <div class="col-md-2">
                    <?php
                    $args = [
                        'nice_name' => 'Tên trường',
                        'name' => 'field_name',
                        'input_type' => 'text',
                        'required' => true,
                        'addClass' => 'ajax_field_name',
                        'addAttr' => 'data-id="0"',
                    ];
                    build_input_form($args);
                    ?>
                </div>
                <div class="col-md-2">
                    <?php
                    $args = [
                        'nice_name' => 'Key',
                        'name' => 'field_key',
                        'input_type' => 'text',
                        'required' => true,
                        'addClass' => 'ajax_field_key',
                        'addAttr' => 'data-id="0"',
                    ];
                    build_input_form($args);
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    $args = [
                        'nice_name' => 'Áp dụng cho',
                        'name' => 'field_append',
                        'input_type' => 'select',
                        'addClass' => 'ajax_field_append_select',
                        'addAttr' => 'data-id="0"',
                        'input_option' => [
                            ['value' => 'none', 'label' => 'Không kích hoạt'],
                            ['value' => 'content', 'label' => 'Kiểu nội dung'],
                            ['value' => 'taxonomy', 'label' => 'Kiểu phân loại'],
                        ],
                    ];
                    build_input_form($args);
                    ?>
                    <div class="ajax_field_append" data-id="0">

                    </div>
                </div>
                <div class="col-md-3">
                    <?php
                    $args = [
                        'nice_name' => 'Phương thức nhập',
                        'name' => 'field_type',
                        'input_type' => 'select',
                        'addClass' => 'ajax_field_type_select',
                        'addAttr' => 'data-id="0"',
                        'input_option' => [
                            ['value' => 'text', 'label' => 'Văn bản (text)'],
                            ['value' => 'textarea', 'label' => 'Văn bản dài (textarea)'],
                            ['value' => 'number', 'label' => 'Số (number)'],
                            ['value' => 'email', 'label' => 'Email (email)'],
                            ['value' => 'password', 'label' => 'Mật khẩu (password)'],
                            ['value' => 'hidden', 'label' => 'Ẩn (hidden)'],
                            ['value' => 'request_uri', 'label' => 'URL nội bộ (request)'],
                            ['value' => 'wysiwyg', 'label' => 'Bộ soạn thảo (wysiwyg)'],
                            ['value' => 'select', 'label' => 'Lựa chọn đơn (select)'],
                            ['value' => 'radio', 'label' => 'Lựa chọn đơn (radio)'],
                            ['value' => 'checkbox', 'label' => 'Lựa chọn nhiều (checkbox)'],
                            ['value' => 'image', 'label' => 'Ảnh (image)'],
                            ['value' => 'multiimage', 'label' => 'Nhiều ảnh (multiimage)'],
                            ['value' => 'file', 'label' => 'Tệp tin (file)'],
                            ['value' => 'content', 'label' => 'Nội dung (content)'],
                            ['value' => 'taxonomy', 'label' => 'Phân loại (taxonomy)'],
                        ],
                    ];
                    build_input_form($args);
                    ?>
                    <div class="ajax_field_type" data-id="0">

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="form-group-handle"></div>
                        <label for="field_append">Hành động</label>
                        <button name="save_customfield_setting" type="submit"
                                class="form-control btn btn-info"><?php echo _('Thêm'); ?></button>
                    </div>
                </div>
            </div>
        </div>


    </form>
</div>