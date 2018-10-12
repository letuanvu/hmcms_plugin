<link rel="stylesheet" type="text/css"
      href="<?php echo BASE_URL . HM_PLUGIN_DIR . '/hm_e-commerce/asset'; ?>/datatables.min.css">
<link rel="stylesheet" type="text/css"
      href="<?php echo BASE_URL . HM_PLUGIN_DIR . '/hm_e-commerce/asset'; ?>/custom.css">
<script type="text/javascript" src="<?php echo BASE_URL . HM_PLUGIN_DIR . '/hm_e-commerce/asset'; ?>/datatables.min.js"
        charset="UTF-8"></script>
<div class="container">
    <div class="row">

        <section class="show_order">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <a href="?run=admin_page.php&key=hm_ecommerce_show_order&status=not_process"
                                           class="btn btn-info btn-filter"><?php echo hme_lang('no_process'); ?></a>
                                        <a href="?run=admin_page.php&key=hm_ecommerce_show_order&status=delivered"
                                           class="btn btn-success btn-filter"><?php echo hme_lang('delivered'); ?></a>
                                        <a href="?run=admin_page.php&key=hm_ecommerce_show_order&status=pending"
                                           class="btn btn-warning btn-filter"><?php echo hme_lang('handling'); ?></a>
                                        <a href="?run=admin_page.php&key=hm_ecommerce_show_order&status=cancel"
                                           class="btn btn-danger btn-filter"><?php echo hme_lang('cancelled'); ?></a>
                                        <a href="?run=admin_page.php&key=hm_ecommerce_show_order"
                                           class="btn btn-default btn-filter"><?php echo hme_lang('all'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="ordertable" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th><?php echo hme_lang('time'); ?></th>
                                    <th><?php echo hme_lang('customer'); ?></th>
                                    <th><?php echo hme_lang('phone_number'); ?></th>
                                    <th><?php echo hme_lang('status'); ?></th>
                                    <th><?php echo hme_lang('installment'); ?></th>
                                    <th><?php echo hme_lang('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($data as $order) {
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
                                            <span><?php echo date(DATETIME_FORMAT, $time); ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo $order->name; ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo $order->mobile; ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo $status_label; ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo $order->is_installment; ?></span>
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
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<script>
    $(document).ready(function () {


        $('.ckbox label').on('click', function () {
            $(this).parents('tr').toggleClass('selected');
        });

        $('#ordertable').DataTable();

    });
</script>
