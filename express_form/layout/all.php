<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL . HM_PLUGIN_DIR . '/express_form/asset'; ?>/style.css">
<script type="text/javascript" src="<?php echo BASE_URL . HM_PLUGIN_DIR . '/express_form/asset'; ?>/main.js"
        charset="UTF-8"></script>

<table class="table">
    <thead>
    <tr>
        <th><?php echo _('Tên Form'); ?></th>
        <th><?php echo _('Shortcode'); ?></th>
        <th><?php echo _('Hành động'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data as $form_id) {
        $form_name = get_express_form_val('form_name', $form_id);
        ?>
        <tr>
            <td><?php echo $form_name; ?></td>
            <td><span>[shortcode=express_form&type=display_form&id=<?php echo $form_id; ?>]<span></td>
            <td>
                <a href="?run=admin_page.php&key=express_form_edit&id=<?php echo $form_id; ?>"
                   class="btn btn-default btn-xs">Sửa</a>
                <a data-href="?run=admin_page.php&key=express_form_del&id=<?php echo $form_id; ?>"
                   class="btn btn-danger btn-xs ajax-remove-form">Xóa</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>