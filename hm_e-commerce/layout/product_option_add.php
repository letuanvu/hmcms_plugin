<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/datatables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/custom.css">
<script type="text/javascript" src="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/datatables.min.js" charset="UTF-8"></script>
<div class="col-md-12">
	<form action="" method="post">
		
		<div class="col-md-12">
			<p class="page_action"><?php echo hme_lang('add_product_attributes'); ?></p>
			<div class="row dashboard_box">
				<div class="list-form-input">
					<div class="col-md-9">
					<?php
						$args = array(
							'nice_name'=>'Tên nhóm thuộc tính',
							'name'=>'group_name',
							'input_type'=>'text',
							'required'=>FALSE,
						);
						build_input_form($args);
					?>
					</div>
					<div class="col-md-3">
						<div class="form-group"> 
							<div class="form-group-handle"></div><label for="field_append">Hành động</label>
							<button name="add_group" type="submit" class="form-control btn btn-info"><?php echo _('Tạo nhóm thuộc tính'); ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>

	</form>
</div>
<script>
$(document).ready(function () {



});
</script>