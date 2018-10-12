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
                                        <a href="?run=admin_page.php&key=hm_ecommerce_product_option_add"
                                           class="btn btn-info btn-filter"><?php echo hme_lang('add_product_attributes'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="ordertable" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên nhóm</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($data as $group) {
                                    ?>
                                    <tr>
                                        <td>
                                            <span><?php echo $group->id; ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo $group->name; ?></span>
                                        </td>
                                        <td>
                                            <a href="?run=admin_page.php&key=hm_ecommerce_product_option_edit&action=edit&id=<?php echo $group->id; ?>"
                                               class="btn btn-default btn-xs">Sửa</a>
                                            <a href="?run=admin_page.php&key=hm_ecommerce_product_option_delete&action=delete&id=<?php echo $group->id; ?>"
                                               class="btn btn-danger btn-xs">Xóa</a>
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

        $('#ordertable').DataTable();

    });
</script>