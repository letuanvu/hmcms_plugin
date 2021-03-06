<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL . HM_PLUGIN_DIR . '/express_form/asset'; ?>/style.css">
<script type="text/javascript" src="<?php echo BASE_URL . HM_PLUGIN_DIR . '/express_form/asset'; ?>/main.js"
        charset="UTF-8"></script>
<div class="row">
    <div class="col-md-12">
        <h1 class="page_title"><?php echo _('Sửa form'); ?></h1>
    </div>
    <?php
    if (hm_get('update_success')) {
        echo '<div class="col-md-12"><div class="alert alert-success" role="alert">Đã lưu thay đổi</div></div>';
    }
    if (hm_get('update_error')) {
        echo '<div class="col-md-12"><div class="alert alert-danger" role="alert">Có lỗi, vui lòng thử lại</div></div>';
    }
    ?>
    <form action="" method="post">

        <div class="col-md-12">
            <div class="row">
                <?php
                $id = hm_get('id');
                $args = [
                    'nice_name' => 'Tiêu đề form',
                    'name' => 'form_name',
                    'input_type' => 'text',
                    'required' => true,
                    'default_value' => get_express_form_val('form_name', $id),
                ];
                build_input_form($args);

                $args = [
                    'nice_name' => 'Shortcode',
                    'name' => 'shortcode',
                    'input_type' => 'text',
                    'default_value' => '[shortcode=express_form&type=display_form&id=' . $id . ']',
                ];
                build_input_form($args);
                ?>
            </div>
            <div class="row">
                <div class="express_form_content">

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab1">Biểu mẫu</a></li>
                        <li><a data-toggle="tab" href="#tab2">Thiết lập mail</a></li>
                        <li><a data-toggle="tab" href="#tab3">Thông báo</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab1" class="tab-pane fade in active">
                            <div class="tab_container">
                                <div class="btn-group">
                                    <span class="btn btn-default btn-xs popup_input" data-input-type="text">text</span>
                                    <span class="btn btn-default btn-xs popup_input"
                                          data-input-type="textarea">textarea</span>
                                    <span class="btn btn-default btn-xs popup_input"
                                          data-input-type="email">email</span>
                                    <span class="btn btn-default btn-xs popup_input"
                                          data-input-type="number">number</span>
                                    <span class="btn btn-default btn-xs popup_input"
                                          data-input-type="hidden">hidden</span>
                                    <span class="btn btn-default btn-xs popup_input" data-input-type="date">date</span>
                                    <span class="btn btn-default btn-xs popup_input"
                                          data-input-type="dropdown">dropdown</span>
                                    <span class="btn btn-default btn-xs insert_input_captcha" data-input-type="captcha">captcha</span>
                                    <span class="btn btn-default btn-xs insert_input_submit" data-input-type="submit">submit</span>
                                </div>
                                <div class="express_form_description">
                                    <p>Các biểu mẫu được thể hiện dưới dạng shortcode, bạn có thể tự viết thêm HTML vào
                                        template dưới đây</p>
                                </div>
                                <div class="express_form_template">
                                    <textarea
                                            name="form_template"><?php echo get_express_form_val('form_template', $id); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="tab2" class="tab-pane fade">
                            <div class="tab_container">
                                <?php
                                $args = [
                                    'nice_name' => 'Vị trí thông báo',
                                    'name' => 'form_noti_message_location',
                                    'input_type' => 'select',
                                    'default_value' => get_express_form_val('form_noti_message_location', $id),
                                    'input_option' => [
                                        [
                                            'value' => 'top',
                                            'label' => 'Bên trên from'
                                        ],
                                        [
                                            'value' => 'bottom',
                                            'label' => 'Bên dưới from'
                                        ],
                                        [
                                            'value' => 'alert',
                                            'label' => 'Alert'
                                        ],
                                    ],
                                ];
                                build_input_form($args);

                                $args = [
                                    'nice_name' => 'Email nhận thông báo',
                                    'name' => 'form_email_address',
                                    'input_type' => 'text',
                                    'default_value' => get_express_form_val('form_email_address', $id),
                                ];
                                build_input_form($args);

                                $args = [
                                    'nice_name' => 'Tiêu đề email',
                                    'name' => 'form_email_subject',
                                    'input_type' => 'text',
                                    'default_value' => get_express_form_val('form_email_subject', $id),
                                ];
                                build_input_form($args);

                                $args = [
                                    'nice_name' => 'Nội dung email',
                                    'name' => 'form_email_content',
                                    'input_type' => 'textarea',
                                    'default_value' => get_express_form_val('form_email_content', $id),
                                ];
                                build_input_form($args);
                                ?>
                            </div>
                        </div>
                        <div id="tab3" class="tab-pane fade">
                            <div class="tab_container">
                                <?php
                                $args = [
                                    'nice_name' => 'Gửi form thành công',
                                    'name' => 'form_submit_success_message',
                                    'input_type' => 'text',
                                    'default_value' => get_express_form_val('form_submit_success_message', $id),
                                ];
                                build_input_form($args);

                                $args = [
                                    'nice_name' => 'Gửi form thất bại',
                                    'name' => 'form_submit_error_message',
                                    'input_type' => 'text',
                                    'default_value' => get_express_form_val('form_submit_error_message', $id),
                                ];
                                build_input_form($args);

                                $args = [
                                    'nice_name' => 'Sai mã captcha',
                                    'name' => 'captcha_error_message',
                                    'input_type' => 'text',
                                    'default_value' => get_express_form_val('captcha_error_message', $id),
                                ];
                                build_input_form($args);

                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <input type="submit" class="btn btn-primary" name="submit" value="Sửa form">
            </div>
        </div>
    </form>
    <?php
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/express_form/layout/input_popup/text.php');
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/express_form/layout/input_popup/textarea.php');
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/express_form/layout/input_popup/email.php');
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/express_form/layout/input_popup/number.php');
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/express_form/layout/input_popup/hidden.php');
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/express_form/layout/input_popup/date.php');
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/express_form/layout/input_popup/dropdown.php');
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/express_form/layout/input_popup/file.php');
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/express_form/layout/input_popup/captcha.php');
    ?>
</div>