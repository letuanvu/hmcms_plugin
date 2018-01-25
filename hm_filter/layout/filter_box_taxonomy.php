<div class="row_margin">
	<div class="col-md-6">
		<div class="filter_step_title">
			Bước 1 : Tạo các nhóm lọc
		</div>
		<div class="filter_step_content filter_step_1_pad">
			<?php
				filter_group_taxonomy(hm_get('id',0));
			?>							
		</div>
		<div class="filter_step_content filter_step_1_control">
			<input type="text" class="form-control filter_group_taxonomy_value_input" placeholder="Nhập tên nhóm lọc mới"><span data-id="<?php echo hm_get('id',0); ?>" class="btn btn-warning filter_group_taxonomy_value_submit">Thêm nhóm lọc</span>
		</div>
	</div>
	<div class="col-md-6">
		<div class="filter_step_title">
			Bước 2 : Thêm các lựa chọn của nhóm lọc
		</div>
		<div class="filter_step_content filter_step_2_pad">
		</div>
	</div>
	<div class="col-md-12 filter_extends_wrapper">
		<div class="filter_step_title">
			Hoặc kế thừa từ bộ lọc khác
		</div>
		<div class="filter_step_content">
		<?php
			if(hm_get('action')=='edit'){
				filter_extends(hm_get('id'));
			}else{
				filter_extends(hm_get('key'));
			}
			
		?>	
		</div>
	</div>
</div>
