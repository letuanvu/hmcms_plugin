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
	<div class="vote_label">
		<script type="application/ld+json">
			{
				"@context": "http://schema.org/",
				"@type": "Product",
				"name": "<?php echo $name; ?>",
				"aggregateRating": {
					"@type": "AggregateRating",
					"ratingValue": "<?php echo $average; ?>",
					"reviewCount": "<?php echo $number_vote; ?>"
				}
			}
		</script>
		<span class="votename"><?php echo $name; ?></span>
		<span><?php echo $average; ?></span>/
		<span>5</span>, tổng số
		<span><?php echo $number_vote; ?></span> lượt bình chọn
	</div>
</div>
