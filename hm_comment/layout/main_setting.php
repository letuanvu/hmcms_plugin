<div class="row">
    <div class="col-md-12">
        <h1 class="page_title">Cài đặt bình luận</h1>
    </div>
    <form action="" method="post">
        <div class="col-md-6">
            <div class="row dashboard_box">
                <div class="list-form-input">
                    <?php
                    /* include */
                    $args = [
                        'nice_name' => 'Trạng thái mặc định của bình luận mới',
                        'name' => 'default_status',
                        'input_type' => 'select',
                        'input_option' => [
                            ['value' => 'public', 'label' => 'Công khai'],
                            ['value' => 'hidden', 'label' => 'Chờ kiểm duyệt'],
                        ],
                        'default_value' => get_option(['section' => 'hm_comment', 'key' => 'default_status', 'default_value' => 'hidden']),
                    ];
                    build_input_form($args);

                    $args = [
                        'nice_name' => 'Thông báo khi gửi bình luận công khai',
                        'name' => 'public_comment_submit_noti',
                        'input_type' => 'text',
                        'required' => false,
                        'default_value' => get_option(['section' => 'hm_comment', 'key' => 'public_comment_submit_noti']),
                    ];
                    build_input_form($args);

                    $args = [
                        'nice_name' => 'Thông báo khi gửi bình luận chờ kiểm duyệt',
                        'name' => 'hidden_comment_submit_noti',
                        'input_type' => 'text',
                        'required' => false,
                        'default_value' => get_option(['section' => 'hm_comment', 'key' => 'hidden_comment_submit_noti']),
                    ];
                    build_input_form($args);

                    $args = [
                        'nice_name' => 'Thông báo khi gửi bình luận bị lỗi',
                        'name' => 'error_comment_submit_noti',
                        'input_type' => 'text',
                        'required' => false,
                        'default_value' => get_option(['section' => 'hm_comment', 'key' => 'error_comment_submit_noti']),
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
