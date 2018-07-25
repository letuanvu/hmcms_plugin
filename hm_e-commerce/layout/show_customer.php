<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/datatables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/custom.css">
<script type="text/javascript" src="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/datatables.min.js" charset="UTF-8"></script>
<div class="container">
  <div class="row">

    <section class="show_order">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="table-container">
              <table id="customer_table" class="table table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th><?php echo hme_lang('name'); ?></th>
                    <th><?php echo hme_lang('email'); ?></th>
                    <th><?php echo hme_lang('phone_number'); ?></th>
                    <th><?php echo hme_lang('action'); ?></th>
                  </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data as $customer) {
                ?>
                  <tr>
                    <td>
                      <span><?php echo $customer->id; ?></span>
                    </td>
                    <td>
                      <span><?php echo $customer->name; ?></span>
                    </td>
                    <td>
                      <span><?php echo $customer->email; ?></span>
                    </td>
                    <td>
                      <span><?php echo $customer->mobile; ?></span>
                    </td>
                    <td>
                      <a href="?run=admin_page.php&key=edit_customer&id=<?php echo $customer->id; ?>" class="btn btn-default btn-xs"><?php echo hme_lang('view'); ?></a>
                      <a href="?run=admin_page.php&key=edit_customer&id=<?php echo $customer->id; ?>" class="btn btn-danger btn-xs"><?php echo hme_lang('delete'); ?></a>
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
  $('#customer_table').DataTable();
});
</script>
