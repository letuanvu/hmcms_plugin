<div class="row">
    <div class="col-md-12">
        <h1 class="page_title"><?php echo hme_lang('customer_details'); ?></h1>
    </div>
    <form action="" method="post">
        <div class="col-md-6">
            <div class="row admin_mainbar_box">
                <div class="form-group">
                    <input value="<?php echo hm_post('name', $data->name, false); ?>" type="text" class="form-control"
                           id="name" name="name" placeholder="Tên quý khách" required>
                </div>
                <div class="form-group">
                    <input value="<?php echo hm_post('email', $data->email, false); ?>" type="text" class="form-control"
                           id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input value="<?php echo hm_post('mobile', $data->mobile, false); ?>" type="text"
                           class="form-control" id="mobile" name="mobile" placeholder="Số điện thoại">
                </div>

                <p>Nếu không cần đổi mật khẩu thì bỏ trống 2 ô dưới <br><br></p>

                <div class="form-group">
                    <input type="password" class="form-control" id="subject" name="password" placeholder="Mật khẩu">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="subject" name="password_again"
                           placeholder="Nhập lại mật khẩu">
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="row admin_mainbar_box">
                <p class="admin_sidebar_box_title"><?php echo hme_lang('action'); ?></p>
                <div class="form-group">
                    <button name="save_customer_setting" type="submit"
                            class="btn btn-primary"><?php echo hme_lang('save'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>
