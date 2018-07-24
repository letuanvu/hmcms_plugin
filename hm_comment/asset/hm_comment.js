jQuery(document).ready(function() {

  $(document).on( 'click','.hm_comment_rate_wrapper .start_vote', function() {
    var vote = $(this).attr('data-vote');
    var id = $(this).attr('data-id');
    $('.hm_comment_input_vote_value[data-id='+id+']').val(vote);
    $('.hm_comment_rate_wrapper[data-id='+id+'] .start_vote').each(function(){
      var this_vote = parseInt($(this).attr('data-vote'));
      if( this_vote <= parseInt(vote) ){
        $(this).removeClass('start_vote_gray');
        $(this).addClass('start_vote_gold');
      }else{
        $(this).addClass('start_vote_gray');
        $(this).removeClass('start_vote_gold');
      }
    });
  });

  build_comment_list = function(data){
    var items = [];
    var cid = $('.hm_comment_content_id').val();
    $.each( data, function( key, val ) {
      var user_role_label = '';
      if(val['comment']['user_role'] != 0){
        user_role_label = '(' + val['comment']['user_role_label'] + ')'
      }
      comment_list_sub = '';
      if(val['comment_sub'].length > 0){
        comment_list_sub = build_comment_list(val['comment_sub']);
      }
      var comment_html = '<div class="hm_comment_item" data-id="'+val['comment']['id']+'">'+
                          '<p class="comment_name comment_name_'+val['comment']['user_role']+'">'+val['comment_fields']['name']+'</p>'+
                          '<p class="comment_user_role_label">'+user_role_label+'</p><p class="comment_time">'+val['comment']['created']+'</p>'+
                          '<p class="comment_vote">'+val['comment']['vote_value_html']+'</p>'+
                          '<p class="comment_content">'+val['comment_fields']['content']+'</p>'+
                          '<div class="comment_bar">'+
                          '<span class="comment_reply" data-content-id="'+cid+'" data-id="'+val['comment']['id']+'">Trả lời</span>'+
                          '</div>'+
                          '<div class="comment_reply_wrapper" data-id="'+val['comment']['id']+'"></div>'+
                          '<div class="comment_list_sub" data-id="'+val['comment']['id']+'">'+comment_list_sub+'</div>'+
                         '</div>';
      items.push( comment_html );
    });
    return items.join( "" );
  }

  $('.hm_comment_list').ready(function(){
    var cid = $('.hm_comment_content_id').val();
    var url = "/load_comment/?object_id="+cid+"&page=1";
    $.getJSON( url, function( data ) {
      html = build_comment_list(data);
      $('.hm_comment_list').append(html);
    });
  });

  $(document).on( 'click','.hm_comment_submit_btn', function() {
      var id = $(this).attr('data-id');
      var name = $('.hm_comment_input_name[data-id='+id+']').val();
      var content = $('.hm_comment_input_content[data-id='+id+']').val();
      var parent_id = $('.hm_comment_input_parent_id[data-id='+id+']').val();
      var vote_value = $('.hm_comment_input_vote_value[data-id='+id+']').val();
      var object_id = $('.hm_comment_content_id[data-id='+id+']').val();
      $.post("/add_comment/", {
          name: name,
          content: content,
          parent_id: parent_id,
          vote_value: vote_value,
          object_id: object_id,
      }, function(data) {
          if(data['status'] == 'success'){
            alert(data['message']);
            var name = $('.hm_comment_input_name').val('');
            var content = $('.hm_comment_input_content').val('');
            var url = "/load_comment/?object_id="+cid+"&page=1";
            $.getJSON( url, function( data ) {
              html = build_comment_list(data);
              $('.hm_comment_list').append(html);
            });
          }else{
            alert(data['message']);
          }
      });
  });

  $(document).on( 'click','.comment_bar .comment_reply', function() {
    var object_id = $(this).attr('data-content-id');
    if($(this).hasClass('reply_active')){
      $('.hm_comment_item').removeClass('reply_active');
      $(this).removeClass('reply_active');
      $('.comment_reply').text('Trả lời');
      $('.comment_reply_wrapper').html('');
    }else{
      var id = $(this).attr('data-id');
      $('.comment_reply').removeClass('reply_active');
      $(this).addClass('reply_active');
      $('.comment_reply').text('Trả lời');
      $('.comment_reply[data-id='+id+']').text('Hủy trả lời');
      $('.hm_comment_item').removeClass('reply_active');
      $('.hm_comment_item[data-id='+id+']').addClass('reply_active');
      var_reply_form = '<div class="hm_comment_wrapper">'+
                        '<div class="hm_comment_input_wrapper hm_comment_name_wrapper">'+
                          '<input class="hm_comment_name hm_comment_input_name" placeholder="Mời bạn để lại tên..." data-id="'+id+'">'+
                        '</div>'+
                        '<div class="hm_comment_input_wrapper hm_comment_content_wrapper">'+
                          '<textarea class="hm_comment_content hm_comment_input_content" placeholder="Mời bạn để lại bình luận..." data-id="'+id+'"></textarea>'+
                        '</div>'+
                        '<input type="hidden" value="5" class="hm_comment_input_vote_value" data-id="'+id+'">'+
                        '<input type="hidden" value="'+object_id+'" class="hm_comment_content_id" data-id="'+id+'">'+
                        '<input type="hidden" value="'+id+'" class="hm_comment_input_parent_id" data-id="'+id+'">'+
                        '<div class="hm_comment_input_wrapper hm_comment_control_wrapper">'+
                          '<div class="hm_comment_rate_wrapper" data-id="'+id+'">'+
                            '<span class="rate_label">Đánh giá của bạn</span>'+
                            '<span class="start_vote start_vote_gold" data-vote="1" data-id="'+id+'"></span>'+
                            '<span class="start_vote start_vote_gold" data-vote="2" data-id="'+id+'"></span>'+
                            '<span class="start_vote start_vote_gold" data-vote="3" data-id="'+id+'"></span>'+
                            '<span class="start_vote start_vote_gold" data-vote="4" data-id="'+id+'"></span>'+
                            '<span class="start_vote start_vote_gold" data-vote="5" data-id="'+id+'"></span>'+
                            '<span class="hm_comment_submit_btn" data-id="'+id+'" data-content-id="'+object_id+'">Bình luận</span>'+
                          '</div>'+
                        '</div>'+
                      '</div>';
      $('.comment_reply_wrapper').html('');
      $('.comment_reply_wrapper[data-id='+id+']').html(var_reply_form);
    }
  });

});
