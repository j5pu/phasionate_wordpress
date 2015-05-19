<?php

	add_action( 'trash_um_review', 'trash_um_review' );
	function trash_um_review( $postid ){
		global $um_reviews;
		if(!did_action('trash_post')){
			
			$um_reviews->api->undo_review( $postid );
			
			wp_delete_post( $postid, true );
		
		}
	}