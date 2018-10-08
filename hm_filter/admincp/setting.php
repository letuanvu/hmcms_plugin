<div class="row">
    <div class="col-md-12">
        <h1 class="page_title"><?php echo _('Cài đặt bộ lọc'); ?></h1>
    </div>
    <form action="" method="post">
        <div class="col-md-6">
            <p class="page_action"><?php echo _('Cài đặt chung'); ?></p>
            <div class="row dashboard_box">
                <div class="list-form-input">
                    <?php
                    $args = [
                        'nice_name' => 'Kiểu bộ lọc',
                        'name' => 'filter_type',
                        'input_type' => 'select',
                        'input_option' => [
                            ['value' => 'taxonomy', 'label' => 'Theo từng danh mục'],
                            ['value' => 'content', 'label' => 'Theo từng kiểu bài'],
                            //array('value'=>'all','label'=>'Một bộ lọc chung cho toàn site'),
                        ],
                        'default_value' => get_option(['section' => 'hm_filter', 'key' => 'filter_type', 'default_value' => 'taxonomy']),
                    ];
                    build_input_form($args);
                    ?>
                    <div class="form-group">
                        <button name="submit" type="submit"
                                class="btn btn-primary"><?php echo _('Lưu cài đặt'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    $filter_type = get_option(['section' => 'hm_filter', 'key' => 'filter_type', 'default_value' => 'taxonomy']);
    if ($filter_type == 'content') {
        global $hmcontent;
        $hmcontent = $hmcontent->hmcontent;
        foreach ($hmcontent as $content) {
            $content_name = $content['content_name'];
            $content_key = $content['content_key'];
            ?>
            <form action="" method="post">
                <div class="col-md-12">
                    <p class="page_action"><?php echo _('Cài đặt bộ lọc cho ' . $content_name); ?></p>
                    <div class="row_margin">
                        <div class="col-md-6">
                            <div class="filter_step_title">
                                Bước 1 : Tạo các nhóm lọc
                            </div>
                            <div class="filter_step_content filter_step_1_pad" data-key="<?php echo $content_key; ?>">
                                <?php
                                filter_group_list($content_key);
                                ?>
                            </div>
                            <div class="filter_step_content filter_step_1_control">
                                <input data-key="<?php echo $content_key; ?>" type="text"
                                       class="form-control filter_group_content_value_input"
                                       placeholder="Nhập tên nhóm lọc mới"><span data-key="<?php echo $content_key; ?>"
                                                                                 class="btn btn-warning filter_group_content_value_submit">Thêm nhóm lọc</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="filter_step_title">
                                Bước 2 : Thêm các lựa chọn của nhóm lọc
                            </div>
                            <div class="filter_step_content filter_step_2_pad" data-key="<?php echo $content_key; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
        }
    }
    ?>

</div>
