$(document).ready(function(){
  $('.product_option_group_item input').click(function(){
    $('.product_option_list_content').text('Đang làm mới dữ liệu ...');
    var allVals = [];
    $('.product_option_group_item input:checked').each(function() {
      allVals.push($(this).val());
    });
    var href = '?run=ajax.php&key=hme_ajax';
    var content = $('.product_option_group_list').attr('data-id');
    $.post(href,{action:'load_option_checkbox_list',id:allVals,content:content},function(data){
      $('.product_option_list_content').html(data);
    });
  });
  var product_version_re_line = function (){
    $('.product_version_lines .product_version_line').each(function( index ) {
      $(this).attr('data-line',index);
      $(this).find('.input_version_name').attr('name','version_name['+index+']');
      $(this).find('.input_version_price').attr('name','version_price['+index+']');
      $(this).find('.input_version_deal_price').attr('name','version_deal_price['+index+']');
      $(this).find('.delete_vesion_btn').attr('data-line',index);
    });
  }
  $('.add_new_version_btn').click(function(){
    var_html =  '<div class="product_version_line row_margin" data-line="">'+
                '  <div class="col-md-4">'+
                '    <input class="form-control input_version_name" name="version_name[]">'+
                '  </div> '+
                '  <div class="col-md-3">'+
                '    <input type="number" class="form-control input_version_price" name="version_price[]">'+
                '  </div>'+
                '  <div class="col-md-3">'+
                '    <input type="number" class="form-control input_version_deal_price" name="version_deal_price[]">'+
                '  </div>'+
                '  <div class="col-md-2">'+
                '    <span class="btn btn-danger delete_vesion_btn" data-line="1">Xóa</span>'+
                '  </div>'+
                '</div>';
    $('.product_version_lines').append(var_html);
    product_version_re_line();
  });
  $(document).on('click', '.delete_vesion_btn', function(){
    var line = $(this).attr('data-line');
    $('.product_version_line[data-line='+line+']').remove();
    product_version_re_line();
  });
});
