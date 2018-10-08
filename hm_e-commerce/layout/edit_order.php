<div class="row">
    <div class="col-md-12">
        <h1 class="page_title"><?php echo hme_lang('order_details'); ?></h1>
    </div>
    <form action="" method="post">
        <div class="col-md-6">
            <div class="row admin_mainbar_box">
                <?php
                $fields = hme_payment_field_config();
                foreach ($fields as $field) {
                    $field['default_value'] = $order_field[$field['name']];
                    build_input_form($field);
                }
                if ($data['customer']->is_installment == 'yes') {
                    ?>
                    <div class="form-group">
                        <div class="form-group-handle"></div>
                        <label for=""><?php echo hme_lang('installment_partner'); ?></label>
                        <input name="email" type="text" class="form-control " disabled
                               value="<?php echo $data['customer']->installment_partner; ?>">
                    </div>
                    <div class="form-group">
                        <div class="form-group-handle"></div>
                        <label for=""><?php echo hme_lang('installment_first_pay'); ?></label>
                        <input name="email" type="text" class="form-control " disabled
                               value="<?php echo $data['customer']->installment_first_pay; ?>">
                    </div>
                    <div class="form-group">
                        <div class="form-group-handle"></div>
                        <label for=""><?php echo hme_lang('installment_month'); ?></label>
                        <input name="email" type="text" class="form-control " disabled
                               value="<?php echo $data['customer']->installment_month; ?>">
                    </div>
                    <div class="form-group">
                        <div class="form-group-handle"></div>
                        <label for=""><?php echo hme_lang('installment_per_month_pay'); ?></label>
                        <input name="email" type="text" class="form-control " disabled
                               value="<?php echo $data['customer']->installment_per_month_pay; ?>">
                    </div>
                    <div class="form-group">
                        <div class="form-group-handle"></div>
                        <label for=""><?php echo hme_lang('installment_total_pay'); ?></label>
                        <input name="email" type="text" class="form-control " disabled
                               value="<?php echo $data['customer']->installment_total_pay; ?>">
                    </div>
                    <?php
                }
                ?>
                <?php
                $field_array['default_value'] = $data['customer']->status;
                $field_array['input_type'] = 'select';
                $field_array['name'] = 'status';
                $field_array['nice_name'] = hme_lang('status');
                $field_array['input_option'] = [
                    ['value' => 'not_process', 'label' => hme_lang('no_process')],
                    ['value' => 'delivered', 'label' => hme_lang('delivered')],
                    ['value' => 'pending', 'label' => hme_lang('handling')],
                    ['value' => 'cancel', 'label' => hme_lang('cancelled')],
                ];
                build_input_form($field_array);
                unset($field_array);
                ?>

            </div>
        </div>

        <div class="col-md-6">
            <div class="row admin_mainbar_box">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?php echo hme_lang('product_image'); ?></th>
                        <th><?php echo hme_lang('product_name'); ?></th>
                        <th><?php echo hme_lang('unit_price_at_purchase'); ?></th>
                        <th><?php echo hme_lang('quantity'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($data['order_item'] as $item) {
                        $product_name = $item->product_name;
                        $product_price = $item->product_price;
                        $product_id = $item->product_id;
                        $qty = $item->qty;
                        $product_option = $item->product_option;
                        $product_attributes = $item->product_attributes;
                        $content_thumbnail = get_con_val("name=content_thumbnail&id=$product_id");
                        $img = create_image("file=$content_thumbnail&w=100&h=100");
                        $link = '?run=content.php&action=edit&id=' . $product_id;
                        ?>
                        <tr>
                            <td>
                                <a href="<?php echo $link; ?>">
                                    <img src="<?php echo $img; ?>"/>
                                </a>
                            </td>
                            <td>
                                <p><?php echo $product_name; ?></p>
                                <?php
                                $product_option = json_decode($product_option, true);
                                if (sizeof($product_option) > 0) {
                                    foreach ($product_option as $group_id => $option_id) {
                                        $group_name = hme_get_option_group('name', $group_id);
                                        $option_name = hme_get_option('name', $option_id);
                                        echo '<p>- ' . $group_name . ': ' . $option_name . '</p>';
                                    }
                                }
                                $product_attributes = json_decode($product_attributes, true);
                                if (sizeof($product_attributes) > 0) {
                                    foreach ($product_attributes as $attribute_key => $attribute_value) {
                                        echo '<p>- ' . $attribute_key . ': ' . $attribute_value . '</p>';
                                    }
                                }
                                ?>
                            </td>
                            <td><?php echo number_format($product_price); ?></td>
                            <td><?php echo $qty; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="col-md-12">
            <div class="row admin_mainbar_box">
                <p class="admin_sidebar_box_title"><?php echo hme_lang('action'); ?></p>
                <div class="form-group">
                    <button name="save_order_setting" type="submit"
                            class="btn btn-primary"><?php echo hme_lang('save'); ?></button>
                    <a class="btn btn-primary"
                       href="?run=admin_page.php&key=hm_ecommerce_edit_order&action=delete&id=<?php echo hm_get('id'); ?>"><?php echo hme_lang('delete_order'); ?></a>
                </div>
            </div>
        </div>
    </form>
</div>
