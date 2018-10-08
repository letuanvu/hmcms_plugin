<?php
$cid = get_id();
?>
<div class="hm_comment_wrapper" data-id="c_<?php echo $cid; ?>">
    <div class="hm_comment_input_wrapper hm_comment_name_wrapper">
        <input class="hm_comment_name hm_comment_input_name" placeholder="Mời bạn để lại tên..."
               data-id="c_<?php echo $cid; ?>">
    </div>
    <div class="hm_comment_input_wrapper hm_comment_content_wrapper">
        <textarea class="hm_comment_content hm_comment_input_content" placeholder="Mời bạn để lại bình luận..."
                  data-id="c_<?php echo $cid; ?>"></textarea>
    </div>
    <input type="hidden" value="5" class="hm_comment_input_vote_value" data-id="c_<?php echo $cid; ?>">
    <input type="hidden" value="<?php echo $cid; ?>" class="hm_comment_content_id" data-id="c_<?php echo $cid; ?>">
    <input type="hidden" value="0" class="hm_comment_input_parent_id" data-id="c_<?php echo $cid; ?>">
    <div class="hm_comment_input_wrapper hm_comment_control_wrapper">
        <div class="hm_comment_rate_wrapper" data-id="c_<?php echo $cid; ?>">
            <span class="rate_label">Đánh giá của bạn</span>
            <?php
            for ($i = 1; $i <= 5; $i++) {
                echo '<span class="start_vote start_vote_gold" data-vote="' . $i . '" data-id="c_' . $cid . '" ></span>';
            }
            ?>
            <span class="hm_comment_submit_btn" data-id="c_<?php echo $cid; ?>" data-content-id="<?php echo $cid; ?>">Bình luận</span>
        </div>
    </div>
</div>
