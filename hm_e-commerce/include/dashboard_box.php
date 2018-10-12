<?php

/*
Dashboard box đơn hàng mới
*/
$args = [
    'width' => '8',
    'function' => 'hm_ecommerce_dashboard_box',
    'label' => hme_lang('purchase_order'),
];
register_dashboard_box($args);

function hm_ecommerce_dashboard_box()
{
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $data = [];
    $hmdb->Query(" SELECT * FROM " . DB_PREFIX . "hme_order LIMIT 10");
    if ($hmdb->HasRecords()) {
        ?>
        <div class="table-container">
            <table id="ordertable" class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th><?php echo hme_lang('time'); ?></th>
                    <th><?php echo hme_lang('customer'); ?></th>
                    <th><?php echo hme_lang('phone_number'); ?></th>
                    <th><?php echo hme_lang('address'); ?></th>
                    <th><?php echo hme_lang('status'); ?></th>
                    <th><?php echo hme_lang('action'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($order = $hmdb->Row()) {
                    $status = $order->status;
                    $time = $order->time;
                    switch ($status) {
                        case 'not_process':
                            $status_label = hme_lang('no_process');
                            $bgclass = 'bg-info';
                            break;
                        case 'delivered':
                            $status_label = hme_lang('delivered');
                            $bgclass = 'bg-success';
                            break;
                        case 'pending':
                            $status_label = hme_lang('handling');
                            $bgclass = 'bg-warning';
                            break;
                        case 'cancel':
                            $status_label = hme_lang('cancelled');
                            $bgclass = 'bg-danger';
                            break;
                        default:
                            $status_label = hme_lang('not_classified');
                            $bgclass = '';
                    }
                    ?>
                    <tr class="<?php echo $bgclass; ?>">
                        <td>
                            <span><?php echo $order->id; ?></span>
                        </td>
                        <td>
                            <span><?php echo date('d-m-Y H:i:s', $time); ?></span>
                        </td>
                        <td>
                            <span><?php echo $order->name; ?></span>
                        </td>
                        <td>
                            <span><?php echo $order->mobile; ?></span>
                        </td>
                        <td>
                            <span><?php echo $order->address; ?></span>
                        </td>
                        <td>
                            <span><?php echo $status_label; ?></span>
                        </td>
                        <td>
                            <a href="?run=admin_page.php&key=hm_ecommerce_edit_order&action=edit&id=<?php echo $order->id; ?>"
                               class="btn btn-default btn-xs"><?php echo hme_lang('view'); ?></a>
                            <a href="?run=admin_page.php&key=hm_ecommerce_edit_order&action=delete&id=<?php echo $order->id; ?>"
                               class="btn btn-danger btn-xs"><?php echo hme_lang('delete'); ?></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>
            </table>
        </div>
        <?php
    }

}

?>
