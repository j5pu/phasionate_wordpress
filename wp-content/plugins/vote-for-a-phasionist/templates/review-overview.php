<!--
<div class="um-reviews-header">
	<?php $user_id = ( $user_id ) ? $user_id : um_profile_id();?>
	<span class="um-reviews-header-span"><?php echo $um_reviews->api->rating_header(); ?></span>
	
	<span class="um-reviews-avg" data-number="1" data-score="<?php echo $um_reviews->api->get_rating(); ?>"><span id="phasionate-score<?php echo $user_id ?>" class="phasionate-score"><?php echo intval($um_reviews->api->get_rating()); ?></span></span>
	
</div>

<div class="um-reviews-avg-rating"><?php echo $um_reviews->api->avg_rating(); ?></div>


<div class="um-reviews-details">
	<?php echo $um_reviews->api->get_details(); ?>
	
	<?php if ( $um_reviews->api->get_filter() ) { ?>
	
	<span class="um-reviews-filter"><?php printf(__('(You are viewing only %s star reviews. <a href="%s">View all reviews</a>)','um-reviews'), $um_reviews->api->get_filter(), remove_query_arg('filter') ); ?></span>
	
	<?php } ?>
	
</div>
-->