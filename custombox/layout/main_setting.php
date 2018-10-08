<div class="row">
    <div class="col-md-12">
        <h1 class="page_title"><?php echo _('Cài đặt Popup'); ?></h1>
    </div>
    <form action="" method="post">


        <div class="col-md-3">
            <div class="row dashboard_box">
                <div class="list-form-input">
                    <?php
                    $args = [
                        'nice_name' => 'Bật tắt',
                        'name' => 'active',
                        'input_type' => 'select',
                        'input_option' => [
                            ['value' => 'yes', 'label' => 'Bật'],
                            ['value' => 'no', 'label' => 'Không'],
                        ],
                        'default_value' => get_option(['section' => 'custombox', 'key' => 'active', 'default_value' => 'yes']),
                    ];
                    build_input_form($args);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row dashboard_box">
                <div class="list-form-input">
                    <?php
                    $args = [
                        'nice_name' => 'Hiển thị ở',
                        'name' => 'display_on',
                        'input_type' => 'select',
                        'input_option' => [
                            ['value' => 'home', 'label' => 'Trang chủ'],
                            ['value' => 'all', 'label' => 'Mọi trang'],
                        ],
                        'default_value' => get_option(['section' => 'custombox', 'key' => 'display_on', 'default_value' => 'home']),
                    ];
                    build_input_form($args);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row dashboard_box">
                <div class="list-form-input">
                    <?php
                    $args = [
                        'nice_name' => 'Lặp lại',
                        'name' => 'display_repeat',
                        'input_type' => 'select',
                        'input_option' => [
                            ['value' => 'once', 'label' => 'Chỉ một lần'],
                            ['value' => 'always', 'label' => 'Luôn luôn'],
                        ],
                        'default_value' => get_option(['section' => 'custombox', 'key' => 'display_repeat', 'default_value' => 'always']),
                    ];
                    build_input_form($args);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row dashboard_box">
                <div class="list-form-input">
                    <?php
                    $args = [
                        'nice_name' => 'Hiệu ứng',
                        'name' => 'effects',
                        'input_type' => 'select',
                        'input_option' => [
                            ['value' => 'fadein', 'label' => 'Fadein'],
                            ['value' => 'slide', 'label' => 'Slide'],
                            ['value' => 'newspaper', 'label' => 'Newspaper'],
                            ['value' => 'fall', 'label' => 'Fall'],
                            ['value' => 'sidefall', 'label' => 'Sidefall'],
                            ['value' => 'blur', 'label' => 'Blur'],
                            ['value' => 'flip', 'label' => 'Flip'],
                            ['value' => 'sign', 'label' => 'Sign'],
                            ['value' => 'superscaled', 'label' => 'Superscaled'],
                            ['value' => 'slit', 'label' => 'Slit'],
                            ['value' => 'corner', 'label' => 'Corner'],
                            ['value' => 'slidetogether', 'label' => 'Slidetogether'],
                            ['value' => 'scale', 'label' => 'Scale'],
                            ['value' => 'door', 'label' => 'Door'],
                            ['value' => 'push', 'label' => 'Push'],
                            ['value' => 'contentscale', 'label' => 'Contentscale'],
                            ['value' => 'swell', 'label' => 'Swell'],
                            ['value' => 'rotatedown', 'label' => 'Rotatedown'],
                            ['value' => 'flash', 'label' => 'Flash'],
                        ],
                        'default_value' => get_option(['section' => 'custombox', 'key' => 'effects', 'default_value' => 'fadein']),
                    ];
                    build_input_form($args);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row dashboard_box">
                <?php
                $args = [
                    'nice_name' => 'Nội dung popup',
                    'name' => 'popup_content',
                    'input_type' => 'editor',
                    'required' => false,
                    'default_value' => get_option(['section' => 'custombox', 'key' => 'popup_content', 'default_value' => '']),
                ];
                build_input_form($args);
                ?>
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