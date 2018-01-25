<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/datatables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/custom.css">
<script type="text/javascript" src="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/datatables.min.js" charset="UTF-8"></script>
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
										<a href="?run=admin_page.php&key=hm_ecommerce_show_order&status=not_process" class="btn btn-info btn-filter"><?php echo hme_lang('no_process'); ?></a>
										<a href="?run=admin_page.php&key=hm_ecommerce_show_order&status=delivered" class="btn btn-success btn-filter"><?php echo hme_lang('delivered'); ?></a>
										<a href="?run=admin_page.php&key=hm_ecommerce_show_order&status=pending" class="btn btn-warning btn-filter"><?php echo hme_lang('handling'); ?></a>
										<a href="?run=admin_page.php&key=hm_ecommerce_show_order&status=cancel" class="btn btn-danger btn-filter"><?php echo hme_lang('cancelled'); ?></a>
										<a href="?run=admin_page.php&key=hm_ecommerce_show_order" class="btn btn-default btn-filter"><?php echo hme_lang('all'); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="table-container">
							<div class="alert alert-danger" role="alert"><?php echo hme_lang('there_are_currently_no_orders'); ?></div>
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