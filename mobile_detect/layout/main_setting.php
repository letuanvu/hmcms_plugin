<div class="row">
    <div class="col-md-12">
        <h1 class="page_title"><?php echo _('Cài đặt giao diện mobile'); ?></h1>
    </div>
    <form action="" method="post">

        <div class="col-md-6">
            <p class="page_action"><?php echo _('Nhận diện theo thiết bị'); ?></p>
            <div class="row dashboard_box">
                <div class="list-form-input">
                    <?php
                    $args = [
                        'nice_name' => 'Giao diện mobile và tablet chung',
                        'name' => 'isMobile',
                        'input_type' => 'select',
                        'input_option' => $themes,
                        'required' => false,
                        'default_value' => get_option(['section' => 'mobile_detect', 'key' => 'isMobile', 'default_value' => '']),
                    ];
                    build_input_form($args);

                    $args = [
                        'nice_name' => 'Giao diện tablet',
                        'name' => 'isTablet',
                        'input_type' => 'select',
                        'input_option' => $themes,
                        'required' => false,
                        'default_value' => get_option(['section' => 'mobile_detect', 'key' => 'isTablet', 'default_value' => '']),
                    ];
                    build_input_form($args);

                    $args = [
                        'nice_name' => 'Giao diện cho IOS',
                        'name' => 'isiOS',
                        'input_type' => 'select',
                        'input_option' => $themes,
                        'required' => false,
                        'default_value' => get_option(['section' => 'mobile_detect', 'key' => 'isiOS', 'default_value' => '']),
                    ];
                    build_input_form($args);

                    $args = [
                        'nice_name' => 'Giao diện Android',
                        'name' => 'isAndroidOS',
                        'input_type' => 'select',
                        'input_option' => $themes,
                        'required' => false,
                        'default_value' => get_option(['section' => 'mobile_detect', 'key' => 'isAndroidOS', 'default_value' => '']),
                    ];
                    build_input_form($args);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <p class="page_action"><?php echo _('Nhận diện theo tên miền'); ?></p>
            <div class="row dashboard_box">
                <div class="list-form-input">
                    <?php
                    $args = [
                        'nice_name' => 'Tên miền mobile',
                        'name' => 'domain_mobile',
                        'input_type' => 'text',
                        'required' => false,
                        'default_value' => get_option(['section' => 'mobile_detect', 'key' => 'domain_mobile', 'default_value' => '']),
                    ];
                    build_input_form($args);

                    $args = [
                        'nice_name' => 'Giao diện sử dụng',
                        'name' => 'domain_theme',
                        'input_type' => 'select',
                        'input_option' => $themes,
                        'required' => false,
                        'default_value' => get_option(['section' => 'mobile_detect', 'key' => 'domain_theme', 'default_value' => '']),
                    ];
                    build_input_form($args);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <p class="page_action"><?php echo _('Nhận diện theo IP'); ?></p>
            <div class="row dashboard_box">
                <div class="list-form-input">
                    <?php
                    $args = [
                        'nice_name' => 'IP',
                        'name' => 'ip_mobile',
                        'input_type' => 'text',
                        'required' => false,
                        'description' => 'Có thể nhập nhiều IP, cách nhau bằng dấu phẩy',
                        'default_value' => get_option(['section' => 'mobile_detect', 'key' => 'ip_mobile', 'default_value' => '']),
                    ];
                    build_input_form($args);

                    $args = [
                        'nice_name' => 'Giao diện sử dụng',
                        'name' => 'ip_theme',
                        'input_type' => 'select',
                        'input_option' => $themes,
                        'required' => false,
                        'default_value' => get_option(['section' => 'mobile_detect', 'key' => 'ip_theme', 'default_value' => '']),
                    ];
                    build_input_form($args);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <button name="save_md_setting" type="submit"
                        class="btn btn-primary"><?php echo _('Lưu cài đặt'); ?></button>
            </div>
        </div>

    </form>
</div>