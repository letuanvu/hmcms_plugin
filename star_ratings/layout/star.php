<div class="hm_star_ratings" itemprop="aggregateRating" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate" property="v:itemreviewed">
	<?php
	$average = round($total_vote/$number_vote);
	for($i=1;$i<=5;$i++){
		if($i<=$average){
			$class="start_vote start_vote_gold";
		}else{
			$class="start_vote start_vote_gray";
		}
		echo '<span class="'.$class.'" data-vote="'.$i.'" data-id="'.$id.'" data-option-name="'.$option.'" data-name="'.$name.'"></span>';
		
	}
	?>
	<div xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate" class="vote_label">
		<span property="v:itemreviewed" class="votename"><?php echo $name; ?></span>
		<span rel="v:rating">
			<span typeof="v:Rating">
				<span property="v:average"><?php echo $average; ?></span>/
				<span property="v:best">5</span>, tổng số 
				<span property="v:votes"><?php echo $number_vote; ?></span> lượt bình chọn
			</span>
		</span>
	</div>
</div>