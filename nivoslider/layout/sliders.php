<link rel="stylesheet" type="text/css"
      href="<?php echo BASE_URL . HM_PLUGIN_DIR . '/nivoslider/asset/admin'; ?>/style.css">
<script type="text/javascript" src="<?php echo BASE_URL . HM_PLUGIN_DIR . '/nivoslider/asset/admin'; ?>/main.js"
        charset="UTF-8"></script>
<script src="<?php echo ADMIN_LAYOUT_PATH; ?>/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<link rel="stylesheet" href="<?php echo ADMIN_LAYOUT_PATH; ?>/perfect-scrollbar/perfect-scrollbar.min.css">
<div class="row">
    <form action="" method="post">
        <div class="col-md-9">
            <?php
            $args = [
                'placeholder' => 'Tên slider mới',
                'name' => 'name',
                'input_type' => 'text',
                'required' => 'required',
                'handle' => false,
            ];
            build_input_form($args);
            ?>
        </div>
        <div class="col-md-3">
            <button type="submit" name="add_slider"
                    class="form-control btn btn-info"><?php echo _('Thêm slider mới'); ?></button>
        </div>
    </form>
</div>
<div class="row">
    <table class="table">
        <thead>
        <tr>
            <th><?php echo _('Tên slider'); ?></th>
            <th><?php echo _('Shortcode'); ?></th>
            <th><?php echo _('Hành động'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data as $row) {
            ?>
            <tr>
                <td><?php echo $row->name; ?></td>
                <td><span>[shortcode=nivoslider&type=display&id=<?php echo $row->id; ?>]<span></td>
                <td>
                    <a href="?run=admin_page.php&key=nivoslider_slide_setting&id=<?php echo $row->id; ?>"
                       class="btn btn-default btn-xs">Sửa</a>
                    <a data-href="?run=admin_page.php&key=nivoslider_slide_delete&id=<?php echo $row->id; ?>"
                       class="btn btn-danger btn-xs ajax-remove-form">Xóa</a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>