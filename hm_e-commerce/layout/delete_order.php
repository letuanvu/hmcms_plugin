<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.HM_PLUGIN_DIR.'/hm_e-commerce/asset'; ?>/custom.css">

<div class="row" >
	<div class="col-md-12">
		<h1 class="page_title"><?php echo hme_lang('delete_order'); ?></h1>
	</div>
	<form action="" method="post">
	
		<div class="col-md-12">
			<div class="row admin_mainbar_box">
				<div class="col-md-12 bg-danger alert-remove-order">
					<p><?php echo hme_lang('if_you_delete_this_order_you_will_not_be_able_to_restore_it'); ?></p>
				</div>
				<div class="form-group">
					<input type="hidden" name="id" value="<?php echo hm_get('id',0); ?>">
					<button name="delete_order" type="submit" class="btn btn-primary"><?php echo hme_lang('i_understand_and_still_want_to_delete'); ?></button>
					<a class="btn btn-default" href="?run=admin_page.php&key=hm_ecommerce_show_order"><?php echo hme_lang('back'); ?></a>
				</div>
			</div>
		</div>
		
	</form>
		<div class="col-md-6">
			<div class="row admin_mainbar_box">
				
				<div class="form-group">
					<div class="form-group-handle"></div>	
					<label for=""><?php echo hme_lang('customer_name'); ?></label>
					<input name="name" type="text" class="form-control " disabled value="<?php echo $data['customer']->name; ?>">
				</div>
				<div class="form-group">
					<div class="form-group-handle"></div>	
					<label for=""><?php echo hme_lang('phone_number'); ?></label>
					<input name="mobile" type="text" class="form-control " disabled value="<?php echo $data['customer']->mobile; ?>">
				</div>
				<div class="form-group">
					<div class="form-group-handle"></div>	
					<label for=""><?php echo hme_lang('email'); ?></label>
					<input name="email" type="text" class="form-control " disabled value="<?php echo $data['customer']->email; ?>">
				</div>
				<div class="form-group">
					<div class="form-group-handle"></div>	
					<label for=""><?php echo hme_lang('title'); ?></label>
					<input name="subject" type="text" class="form-control " disabled value="<?php echo $data['customer']->subject; ?>">
				</div>
				<div class="form-group">
					<div class="form-group-handle"></div>	
					<label for=""><?php echo hme_lang('message'); ?></label>
					<textarea name="message" type="text" class="form-control " disabled ><?php echo $data['customer']->message; ?></textarea>
				</div>
				
				
				<?php
					$field_array['default_value']=$data['customer']->status;
					$field_array['input_type']='select';
					$field_array['name']='status';
					$field_array['nice_name']=_('Tình trạng');
					$field_array['input_option']=array  (
														array('value'=>'not_process','label'=>hme_lang('no_process')),
														array('value'=>'delivered','label'=>hme_lang('delivered')),
														array('value'=>'pending','label'=>hme_lang('handling')),
														array('value'=>'cancel','label'=>hme_lang('cancelled')),
														);
					build_input_form($field_array);
					unset($field_array);
				?>
				
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="row admin_mainbar_box">
				
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo hme_lang('product_image'); ?></th>
							<th><?php echo hme_lang('product_name'); ?></th>
							<th><?php echo hme_lang('unit_price_at_purchase'); ?></th>
							<th><?php echo hme_lang('quantity'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($data['order_item'] as $item){
							$product_name = $item->product_name;
							$product_price = $item->product_price;
							$product_id = $item->product_id;
							$qty = $item->qty;
							$content_thumbnail = get_con_val("name=content_thumbnail&id=$product_id");
							$img = create_image("file=$content_thumbnail&w=100&h=100");
							$link = '?run=content.php&action=edit&id='.$product_id;
						?>
						<tr>
							<th>
								<a href="<?php echo $link; ?>">
									<img src="<?php echo $img; ?>"/>
								</a>
							</th>
							<th><?php echo $product_name; ?></th>
							<th><?php echo number_format($product_price); ?></th>
							<th><?php echo $qty; ?></th>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				
 			</div>
		</div>
		
</div>
