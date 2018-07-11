<div class="row" >
  <div class="col-md-12">
    <h1 class="page_title"><?php echo hme_lang('e_commercer'); ?></h1>
  </div>
  <div class="col-md-6">
    <p class="page_action"><?php echo hme_lang('export_the_product_list_to_excel_file'); ?></p>
    <div class="row dashboard_box">
      <a href="<?php echo BASE_URL; ?>hm_ecommerce_explode_excel" target="_blank" class="btn btn-default media_btn">
      <i class="fa fa-file-excel-o" aria-hidden="true"></i> <?php echo hme_lang('download'); ?>
      </a>
    </div>
  </div>
  <div class="col-md-6">
    <p class="page_action"><?php echo hme_lang('update_product_from_excel_file'); ?></p>
    <div class="row dashboard_box">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-6">
          <input type="file" name="excel" />
        </div>
        <div class="col-md-6">
          <input type="submit" name="submit_excel" class="btn btn-default" value="<?php echo hme_lang('upload'); ?>">
        </div>
      </form>
    </div>
  </div>

  <form action="" method="post">

  <div class="col-md-6">
    <p class="page_action"><?php echo hme_lang('email_notification_configuration'); ?></p>
    <div class="row dashboard_box">
      <div class="list-form-input">
        <?php
          $args = array(
            'nice_name'=>hme_lang('email_received_notification'),
            'description'=>hme_lang('email_received_notification_can_write_multiple_emails_separated_by_commas'),
            'name'=>'noti_email',
            'input_type'=>'text',
            'required'=>FALSE,
            'default_value'=>get_option( array('section'=>'hme','key'=>'noti_email','default_value'=>'') ),
          );
          build_input_form($args);
        ?>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <p class="page_action"><?php echo hme_lang('other_features'); ?></p>
    <div class="row dashboard_box">
      <div class="list-form-input">
        <?php
        /* product_photos */
        $args = array(
          'nice_name'=>hme_lang('photos_of_the_product'),
          'name'=>'product_photos',
          'input_type'=>'select',
          'input_option'=>array(
                      array('value'=>'yes','label'=>hme_lang('yes')),
                      array('value'=>'no','label'=>hme_lang('no')),
                    ),
          'default_value'=>get_option( array('section'=>'hme','key'=>'product_photos','default_value'=>'yes') ),
        );
        build_input_form($args);

        /* product_options */
        $args = array(
          'nice_name'=>hme_lang('product_attributes'),
          'name'=>'product_options',
          'input_type'=>'select',
          'input_option'=>array(
                      array('value'=>'yes','label'=>hme_lang('yes')),
                      array('value'=>'no','label'=>hme_lang('no')),
                    ),
          'default_value'=>get_option( array('section'=>'hme','key'=>'product_options','default_value'=>'yes') ),
        );
        build_input_form($args);

        /* product_versions */
        $args = array(
          'nice_name'=>hme_lang('product_versions'),
          'name'=>'product_versions',
          'input_type'=>'select',
          'input_option'=>array(
                      array('value'=>'yes','label'=>hme_lang('yes')),
                      array('value'=>'no','label'=>hme_lang('no')),
                    ),
          'default_value'=>get_option( array('section'=>'hme','key'=>'product_versions','default_value'=>'yes') ),
        );
        build_input_form($args);

        /* product_deal */
        $args = array(
          'nice_name'=>hme_lang('product_deal'),
          'name'=>'product_deal',
          'input_type'=>'select',
          'input_option'=>array(
                      array('value'=>'yes','label'=>hme_lang('yes')),
                      array('value'=>'no','label'=>hme_lang('no')),
                    ),
          'default_value'=>get_option( array('section'=>'hme','key'=>'product_deal','default_value'=>'yes') ),
        );
        build_input_form($args);

        /* installment interest rate */
        $args = array(
          'nice_name'=>hme_lang('installment_interest_rate'). ' (%)',
          'name'=>'installment_interest_rate',
          'input_type'=>'number',
          'required'=>FALSE,
          'default_value'=>get_option( array('section'=>'hme','key'=>'installment_interest_rate','default_value'=>'10') ),
        );
        build_input_form($args);
        ?>
      </div>
    </div>
  </div>


  <div class="col-md-12">
    <div class="form-group">
      <button name="save_hme_setting" type="submit" class="btn btn-primary"><?php echo hm_lang('save'); ?></button>
    </div>
  </div>

  </form>
</div>
