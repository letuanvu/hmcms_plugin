<?php
/** Product images */
$product_photos = get_option(array(
    'section' => 'hme',
    'key' => 'product_photos',
    'default_value' => 'yes'
));
if ($product_photos == 'yes') {
    function product_image_upload() {

        $args = array(
            'nice_name' => hme_lang('image_product'),
            'label' => hme_lang('add_a_product_photo'),
            'name' => 'product_image',
            'input_type' => 'multiimage',
            'required' => FALSE,
            'imageonly' => TRUE,
            'default_value' => get_con_val(array(
                'name' => 'product_image',
                'id' => hm_get('id')
            ))
        );
        build_input_form($args);

    }
    $args = array(
        'label' => hme_lang('photos_of_the_product'),
        'content_key' => 'product',
        'position' => 'left',
        'function' => 'product_image_upload'
    );
    register_content_box($args);
}


/** create content box product option */
$product_options = get_option(array(
    'section' => 'hme',
    'key' => 'product_options',
    'default_value' => 'yes'
));
if ($product_options == 'yes') {
    function product_option_panel() {

        $action = hm_get('action');
        $id     = hm_get('id', 0);

        $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
        $data = array();
        $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_product_option_group");
        while ($row = $hmdb->Row()) {
            $data[] = $row;
        }

        echo '<div class="product_option_group_list" data-id="' . $id . '">';
        echo '<div class="product_option_box_title">' . hme_lang('select_the_attribute_group') . '</div>';
        foreach ($data as $group) {
            $group_id   = $group->id;
            $group_name = $group->name;
            $group_slug = $group->slug;

            $product_group_option = array();
            if ($action == 'edit') {
                $product_group_option = get_con_val('name=product_group_option&id=' . $id);
                $product_group_option = json_decode($product_group_option, TRUE);
            }

            echo '<div class="product_option_group_item">' . "\n\r";
            if (in_array($group_id, $product_group_option)) {
                echo '<input checked type="checkbox" name="product_group_option[]" value="' . $group_id . '">' . $group_name . "\n\r";
            } else {
                echo '<input type="checkbox" name="product_group_option[]" value="' . $group_id . '">' . $group_name . "\n\r";
            }
            echo '</div>' . "\n\r";
        }
        echo '</div>';
        echo '<div class="product_option_list">';
        echo '<div class="product_option_box_title">' . hme_lang('select_attribute') . '</div>';
        echo '<div class="product_option_list_content">';
        if ($action == 'edit') {
            $product_group_option = get_con_val('name=product_group_option&id=' . $id);
            $product_group_option = json_decode($product_group_option, TRUE);
            if (!is_array($product_group_option)) {
                $product_group_option = array();
            }
            foreach ($product_group_option as $group_id) {

                $product_option = get_con_val('name=product_option&id=' . $id);
                $product_option = json_decode($product_option, TRUE);

                $group_name = hme_get_option_group('name', $group_id);
                echo '<div class="product_option_group_widget">' . "\n\r";
                echo '	<div class="product_option_group_widget_title">' . $group_name . '</div>' . "\n\r";
                echo '	<div class="product_option_group_widget_content">' . "\n\r";

                $tableName  = DB_PREFIX . 'hme_product_option';
                $whereArray = array(
                    'group_id' => MySQL::SQLValue($group_id, MySQL::SQLVALUE_NUMBER)
                );
                $hmdb->SelectRows($tableName, $whereArray);
                if ($hmdb->HasRecords()) {
                    while ($row = $hmdb->Row()) {
                        $option_id   = $row->id;
                        $option_name = $row->name;
                        $option_slug = $row->slug;
                        $group_id    = $row->group_id;
                        echo '<div class="product_option_item">' . "\n\r";
                        if (is_numeric($row->option_image)) {
                            echo '	<img class="option_image" src="' . get_file_url($row->option_image) . '" >';
                        }
                        if (in_array($option_id, $product_option)) {
                            echo '	<input checked type="checkbox" name="product_option[]" value="' . $option_id . '">' . $option_name . "\n\r";
                        } else {
                            echo '	<input type="checkbox" name="product_option[]" value="' . $option_id . '">' . $option_name . "\n\r";
                        }
                        echo '</div>' . "\n\r";
                    }
                }

                echo '	</div>' . "\n\r";
                echo '</div>' . "\n\r";

            }
        }
        echo '</div>';
        echo '</div>';

    }
    $args = array(
        'label' => hme_lang('product_attributes'),
        'content_key' => 'product',
        'position' => 'left',
        'function' => 'product_option_panel'
    );
    register_content_box($args);
}

/** create content box product deal */
$product_deal = get_option(array(
    'section' => 'hme',
    'key' => 'product_deal',
    'default_value' => 'yes'
));
if ($product_deal == 'yes') {
    function product_deal_panel() {
        echo '<div class="product_deal_panel row_margin">' . "\n\r";
        echo '  <div class="col-md-4">' . "\n\r";
        $args = array(
            'nice_name' => hme_lang('active_deal'),
            'name' => 'active_deal',
            'input_type' => 'select',
            'input_option' => array(
                array(
                    'value' => 'no',
                    'label' => hme_lang('no')
                ),
                array(
                    'value' => 'yes',
                    'label' => hme_lang('yes')
                )
            ),
            'required' => False
        );
        build_input_form($args);
        echo '  </div>' . "\n\r";
        echo '  <div class="col-md-4">' . "\n\r";
        $args = array(
            'nice_name' => hme_lang('deal_start'),
            'name' => 'deal_start',
            'class' => 'form-control hm_datetimepicker',
            'input_type' => 'text',
            'required' => False
        );
        build_input_form($args);
        echo '  </div>' . "\n\r";
        echo '  <div class="col-md-4">' . "\n\r";
        $args = array(
            'nice_name' => hme_lang('deal_end'),
            'name' => 'deal_end',
            'class' => 'form-control hm_datetimepicker',
            'input_type' => 'text',
            'required' => False
        );
        build_input_form($args);
        echo '  </div>' . "\n\r";
        echo '</div>' . "\n\r";
    }
    $args = array(
        'label' => hme_lang('deal'),
        'content_key' => 'product',
        'position' => 'left',
        'function' => 'product_deal_panel'
    );
    register_content_box($args);
}

/** create content box product version */
$product_versions = get_option(array(
    'section' => 'hme',
    'key' => 'product_versions',
    'default_value' => 'yes'
));
if ($product_versions == 'yes') {
    function product_version_panel() {

        $action = hm_get('action');
        $id     = hm_get('id', 0);

        $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

        echo '<div class="product_version_widget">' . "\n\r";
        echo '  <div class="product_version_lines">' . "\n\r";
        echo '    <div class="product_version_line row_margin">' . "\n\r";
        echo '      <div class="col-md-4">' . hme_lang('version_name') . '</div>' . "\n\r";
        echo '      <div class="col-md-3">' . hme_lang('version_price') . '</div>' . "\n\r";
        echo '      <div class="col-md-3">' . hme_lang('version_deal_price') . '</div>' . "\n\r";
        echo '      <div class="col-md-2">' . hme_lang('delete_vesion') . '</div>' . "\n\r";
        echo '    </div>' . "\n\r";

        if ($action == 'edit') {
            $version_names       = get_con_val('name=version_name&id=' . $id);
            $version_names       = json_decode($version_names, TRUE);
            $version_prices      = get_con_val('name=version_price&id=' . $id);
            $version_prices      = json_decode($version_prices, TRUE);
            $version_deal_prices = get_con_val('name=version_deal_price&id=' . $id);
            $version_deal_prices = json_decode($version_deal_prices, TRUE);
            foreach ($version_names as $line => $version_name) {

                echo '    <div class="product_version_line row_margin" data-line="' . $line . '">' . "\n\r";
                echo '      <div class="col-md-4"><input class="form-control input_version_name" name="version_name[' . $line . ']" value="' . $version_name . '" /></div>' . "\n\r";
                echo '      <div class="col-md-3"><input type="number" class="form-control input_version_price" name="version_price[' . $line . ']"  value="' . $version_prices[$line] . '" /></div>' . "\n\r";
                echo '      <div class="col-md-3"><input type="number" class="form-control input_version_price" name="version_deal_price[' . $line . ']"  value="' . $version_deal_prices[$line] . '" /></div>' . "\n\r";
                echo '      <div class="col-md-2"><span class="btn btn-danger delete_vesion_btn" data-line="' . $line . '">' . hme_lang('delete') . '</span></div>' . "\n\r";
                echo '    </div>' . "\n\r";

            }
        } else {
            echo '    <div class="product_version_line row_margin" data-line="1">' . "\n\r";
            echo '      <div class="col-md-4"><input class="form-control input_version_name" name="version_name[1]" /></div>' . "\n\r";
            echo '      <div class="col-md-3"><input type="number" class="form-control input_version_price" name="version_price[1]" /></div>' . "\n\r";
            echo '      <div class="col-md-3"><input type="number" class="form-control input_version_price" name="version_deal_price[1]" /></div>' . "\n\r";
            echo '      <div class="col-md-2"><span class="btn btn-danger delete_vesion_btn" data-line="1">' . hme_lang('delete') . '</span></div>' . "\n\r";
            echo '    </div>' . "\n\r";
        }

        echo '  </div>' . "\n\r";
        echo '  <div class="product_version_contror">' . "\n\r";
        echo '  <span class="btn btn-info add_new_version_btn">' . hme_lang('add_new_version') . '</span>' . "\n\r";
        echo '  </div>' . "\n\r";
        echo '</div>' . "\n\r";
    }
    $args = array(
        'label' => hme_lang('product_versions'),
        'content_key' => 'product',
        'position' => 'left',
        'function' => 'product_version_panel'
    );
    register_content_box($args);
}
?>
