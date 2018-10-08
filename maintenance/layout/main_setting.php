<div class="row">
    <div class="col-md-12">
        <h1 class="page_title"><?php echo _('Chế độ bảo trì'); ?></h1>
    </div>
    <form action="" method="post">
        <div class="col-md-12">
            <div class="row dashboard_box">
                <div class="list-form-input">
                    <?php
                    $args = [
                        'nice_name' => 'Bật / tắt',
                        'name' => 'on_off',
                        'input_type' => 'select',
                        'input_option' => [
                            ['value' => 'yes', 'label' => 'Bật'],
                            ['value' => 'no', 'label' => 'Tắt'],
                        ],
                        'default_value' => get_option(['section' => 'maintenance', 'key' => 'on_off', 'default_value' => 'yes']),
                    ];
                    build_input_form($args);

                    $args = [
                        'nice_name' => 'Vẫn hiển trị website với cấp quản lý',
                        'name' => 'display_for_admin',
                        'input_type' => 'select',
                        'input_option' => [
                            ['value' => 'yes', 'label' => 'Bật'],
                            ['value' => 'no', 'label' => 'Tắt'],
                        ],
                        'default_value' => get_option(['section' => 'maintenance', 'key' => 'display_for_admin', 'default_value' => 'yes']),
                    ];
                    build_input_form($args);

                    $args = [
                        'nice_name' => 'Nội dung thông báo',
                        'name' => 'content',
                        'input_type' => 'editor',
                        'required' => false,
                        'default_value' => get_option(['section' => 'maintenance', 'key' => 'content', 'default_value' => '']),
                    ];
                    build_input_form($args);

                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <button name="save_setting" type="submit"
                        class="btn btn-primary"><?php echo _('Lưu cài đặt'); ?></button>
            </div>
        </div>

    </form>
</div>