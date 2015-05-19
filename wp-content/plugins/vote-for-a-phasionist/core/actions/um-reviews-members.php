<?php

	/***
	***	@add user rating in members directory
	***/
	add_action('um_members_after_user_name', 'um_reviews_add_rating', 50, 2 );
	function um_reviews_add_rating( $user_id, $args ) {
		global $um_reviews;

		/*if ($_SERVER['REQUEST_URI'] !='/concursantes'){
			return;
		}*/

		if ( !um_get_option('members_show_rating') || !$um_reviews->api->is_a_player($user_id)){
			return;
		} 
		$user_id = ( $user_id ) ? $user_id : um_profile_id();
		?>
		
		<div class="um-member-rating"><span class="um-reviews-avg" data-number="1" data-score="<?php echo $um_reviews->api->get_rating( $user_id ); ?>"><span id="phasionate-score<?php echo $user_id ?>" class="phasionate-score"><?php echo intval($um_reviews->api->get_rating( $user_id )); ?></span></span></div>
		<?php
	}
	
	/***
	***	@Needed for new user signups
	***/
	add_action('user_register', 'um_reviews_sync_new_user', 10, 1);
	function um_reviews_sync_new_user( $user_id ) {
		
		/*if ( !get_user_meta( $user_id, '_reviews_avg', true ) ) {
			update_user_meta( $user_id, '_reviews_avg', 1.00 );
		}*/

		update_user_meta( $user_id, '_reviews_total', 0 );
		update_user_meta( $user_id, '_reviews_avg', 0.00 );
		update_user_meta( $user_id, '_reviews_compound', 0 );
		
	}