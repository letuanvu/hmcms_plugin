$(document).ready(function(){
	$('.start_vote').click(function(){
		var vote = $(this).attr('data-vote');
		var id = $(this).attr('data-id');
		var name = $(this).attr('data-name');
		var option = $(this).attr('data-option-name');
		$.post( star_ratings_base+"hm_star_ratings_ajax",{vote:vote,option:option,id:id,name:name}, function( data ) {
			if(data == '1'){
				alert('xin lỗi, bạn đã vote cho bài này rồi');
			}else{
				$('.hm_star_ratings').html(data);
			}
		});
	});
});