<?php

	/***
	***	@default reviews tab
	***/
	add_action('um_profile_content_reviews_default', 'um_profile_content_reviews_default');
	function um_profile_content_reviews_default( $args ) {
		
		global $ultimatemember, $um_reviews;
		
		include_once um_reviews_path . 'templates/review-overview.php';
		
		include_once um_reviews_path . 'templates/review-add.php';
		
		include_once um_reviews_path . 'templates/review-edit.php';
		
		$um_reviews->api->set_filter();
		
		$reviews = $um_reviews->api->get_reviews( um_profile_id() );
		if ( $reviews && $reviews != -1 ) {
			
			include_once um_reviews_path . 'templates/review-list.php';
		
		} else {
			
			if ( $reviews == -1 ) {
				include_once um_reviews_path . 'templates/review-my.php';
			} else {
				include_once um_reviews_path . 'templates/review-none.php';
			}
			
		}
		
	}