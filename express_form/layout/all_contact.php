<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL . HM_PLUGIN_DIR . '/express_form/asset'; ?>/style.css">
<script type="text/javascript" src="<?php echo BASE_URL . HM_PLUGIN_DIR . '/express_form/asset'; ?>/main.js"
        charset="UTF-8"></script>

<table class="table">
    <thead>
    <tr>
        <th><?php echo _('Tên Form'); ?></th>
        <th><?php echo _('Thời gian'); ?></th>
        <th><?php echo _('Gửi từ'); ?></th>
        <th><?php echo _('IP'); ?></th>
        <th><?php echo _('Hành động'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $form_content = [];
    foreach ($data as $form) {
        $id = $form->id;
        $form_id = $form->object_id;
        $form_val = $form->val;
        $form_name = get_express_form_val('form_name', $form_id);
        $form_val = json_decode($form_val, true);
        $express_form_submit_ip = $form_val['express_form_submit_ip'];
        $express_form_submit_url = $form_val['express_form_submit_url'];
        $express_form_submit_time = $form_val['express_form_submit_time'];
        $express_form_submit_url = '<a href="' . SITE_URL . $express_form_submit_url . '" target="_blank">' . $express_form_submit_url . '</a>';
        $content = '';
        $no_save = [
            'express_form_id',
            'express_form_submit_ip',
            'express_form_submit_url',
            'express_form_submit_time',
        ];
        foreach ($form_val as $key => $val) {
            if (!in_array($key, $no_save)) {
                $content .= '<p>' . $key . ' : ' . $val . '</p>';
            }
        }
        $form_content[$id] = $content;
        ?>
        <tr>
            <td><?php echo $form_name; ?></td>
            <td><?php echo date('d/m/Y H:i:s', $express_form_submit_time); ?></td>
            <td><?php echo $express_form_submit_url; ?></td>
            <td><?php echo $express_form_submit_ip; ?></td>
            <td>
                <a data-input-type="contact_<?php echo $id; ?>"
                   class="popup_input btn btn-info btn-xs ajax-view-contact">Xem</a>
                <a data-href="?run=admin_page.php&key=express_form_del_contact&id=<?php echo $id; ?>"
                   class="btn btn-danger btn-xs ajax-remove-form-contact">Xóa</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<?php
foreach ($form_content as $id => $content) {
    ?>
    <div class="express_form_popup express_form_popup_contact_<?php echo $id; ?>">
        <?php echo $content; ?>
    </div>
    <?php
}
?>