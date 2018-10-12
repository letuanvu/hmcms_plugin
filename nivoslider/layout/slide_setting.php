<link rel="stylesheet" type="text/css"
      href="<?php echo BASE_URL . HM_PLUGIN_DIR . '/nivoslider/asset/admin'; ?>/style.css">
<script type="text/javascript" src="<?php echo BASE_URL . HM_PLUGIN_DIR . '/nivoslider/asset/admin'; ?>/main.js"
        charset="UTF-8"></script>
<script src="<?php echo ADMIN_LAYOUT_PATH; ?>/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<link rel="stylesheet" href="<?php echo ADMIN_LAYOUT_PATH; ?>/perfect-scrollbar/perfect-scrollbar.min.css">
<div class="row">
    <div class="col-md-9">

        <div class="page_action">
            Quản lý ảnh slider
        </div>
        <?php
        $key_prefix = hm_get('id', '') . '_';
        $slider = get_option(['section' => 'nivoslider', 'key' => $key_prefix . 'slides']);
        $slider = json_decode($slider, true);
        if (!is_array($slider)) {
            $slider = [];
        }
        ?>
        <table class="table table-striped content_table list_slides">
            <thead>
            <tr>
                <th>Ảnh</th>
                <th>Link</th>
                <th>Mở trong tab mới</th>
                <th>Xóa</th>
            </tr>
            </thead>
            <tbody class="list_slides_content">
            <?php
            foreach ($slider as $key => $item) {
                $image = $item['image'];
                $link = $item['link'];
                $target_blank = $item['target_blank'];
                $src = get_file_url($image);
                ?>
                <tr data-id="<?php echo $key; ?>">
                    <td class="slide_img">
                        <img src="<?php echo $src; ?>">
                    </td>
                    <td>
                        <?php
                        $args = [
                            'handle' => false,
                            'name' => 'link',
                            'addClass' => 'link_' . $key,
                            'input_type' => 'text',
                            'default_value' => $link,
                        ];
                        build_input_form($args);
                        ?>
                    </td>
                    <td>
                        <?php
                        $args = [
                            'handle' => false,
                            'name' => 'target_blank',
                            'addClass' => 'target_blank_' . $key,
                            'input_type' => 'select',
                            'input_option' => [
                                ['value' => '0', 'label' => 'Không'],
                                ['value' => '1', 'label' => 'Có'],
                            ],
                            'default_value' => $target_blank,
                        ];
                        build_input_form($args);
                        ?>
                    </td>
                    <td>
                        <button type="button" data-image="<?php echo $image; ?>" data-id="<?php echo $key; ?>"
                                data-slider_id="<?php echo hm_get('id'); ?>" class="quick_save_slide btn btn-info ">Lưu
                        </button>
                        <button type="button" data-image="<?php echo $image; ?>" data-id="<?php echo $key; ?>"
                                data-slider_id="<?php echo hm_get('id'); ?>" class="quick_delete_slide btn btn-danger ">
                            Xóa
                        </button>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

        <form action="" method="post">

            <div class="addslider">
                <div class="row">
                    <div class="col-md-3">
                        <?php
                        $args = [
                            'nice_name' => 'Chọn ảnh cho slider',
                            'label' => 'Chọn ảnh',
                            'name' => 'image',
                            'input_type' => 'image',
                            'required' => true,
                        ];
                        build_input_form($args);
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        $args = [
                            'nice_name' => 'Link khi bấm vào',
                            'name' => 'link',
                            'input_type' => 'text',
                        ];
                        build_input_form($args);
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        $args = [
                            'nice_name' => 'Mở trong tab mới',
                            'name' => 'target_blank',
                            'input_type' => 'select',
                            'input_option' => [
                                ['value' => '0', 'label' => 'Không'],
                                ['value' => '1', 'label' => 'Có'],
                            ],
                        ];
                        build_input_form($args);
                        ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-group-handle"></div>
                            <label for="field_append">Hành động</label>
                            <button name="add_slide" type="submit"
                                    class="form-control btn btn-info"><?php echo _('Thêm ảnh vào slider'); ?></button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <div class="col-md-3">
        <form action="" method="post">
            <div class="page_action">
                Cấu hình slider
            </div>
            <div class="nivoslider_config_bar">
                <?php
                $args = [
                    'nice_name' => 'Mã hiển thị',
                    'name' => 'theme_code',
                    'handle' => false,
                    'input_type' => 'text',
                    'required' => false,
                    'description' => 'Sử dụng mã này tại vị trí muốn hiển thị slider',
                    'default_value' => '<?php nivoslider(' . hm_get('id') . '); ?>',
                ];
                build_input_form($args);

                $args = [
                    'nice_name' => 'Giao diện',
                    'name' => 'slide_theme',
                    'input_type' => 'select',
                    'input_option' => [
                        ['value' => 'hmcms', 'label' => 'Mặc định'],
                        ['value' => 'bar', 'label' => 'bar'],
                        ['value' => 'dark', 'label' => 'dark'],
                        ['value' => 'default', 'label' => 'nivo default'],
                        ['value' => 'light', 'label' => 'light'],
                    ],
                    'default_value' => get_option(['section' => 'hm_seo', 'key' => $key_prefix . 'slide_theme', 'default_value' => 'hmcms']),
                ];
                build_input_form($args);

                $setting = [
                    'effect' => 'random',
                    'slices' => '15',
                    'boxCols' => '8',
                    'boxRows' => '4',
                    'animSpeed' => '500',
                    'pauseTime' => '3000',
                    'startSlide' => '0',
                    'directionNav' => 'true',
                    'controlNav' => 'true',
                    'controlNavThumbs' => 'false',
                    'pauseOnHover' => 'true',
                    'manualAdvance' => 'false',
                    'prevText' => 'Prev',
                    'nextText' => 'Next',
                    'randomStart' => 'false'
                ];
                foreach ($setting as $op_key => $op_val) {
                    $default_value = get_option(['section' => 'nivoslider', 'key' => $key_prefix . $op_key]);
                    if ($default_value == '') {
                        $default_value = $op_val;
                    }
                    $args = [
                        'nice_name' => $op_key,
                        'name' => $op_key,
                        'input_type' => 'text',
                        'required' => false,
                        'default_value' => get_option(['section' => 'nivoslider', 'key' => $op_key, 'default_value' => $default_value]),
                    ];
                    build_input_form($args);
                }
                $args = [
                    'nice_name' => 'Tự viết javascript',
                    'name' => 'custom_script',
                    'input_type' => 'textarea',
                    'required' => false,
                    'default_value' => get_option(['section' => 'nivoslider', 'key' => $key_prefix . 'custom_script', 'default_value' => '']),
                ];
                build_input_form($args);
                ?>
            </div>
            <div class="form-group">
                <div class="form-group-handle"></div>
                <label for="field_append">Hành động</label>
                <button name="nivoslider_save_config" type="submit"
                        class="form-control btn btn-info"><?php echo _('Lưu cấu hình'); ?></button>
            </div>
        </form>
    </div>
</div>