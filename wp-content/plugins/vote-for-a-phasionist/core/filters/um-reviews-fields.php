<?php

	/***
	***	@extend core fields
	***/
	add_filter("um_predefined_fields_hook", 'um_reviews_add_field', 20 );
	function um_reviews_add_field($fields){

		$fields['user_rating'] = array(
				'title' => __('User Rating','um-reviews'),
				'metakey' => 'user_rating',
				'type' => 'text',
				'label' => __('User Rating','um-reviews'),
				'required' => 0,
				'public' => 1,
				'editable' => 0,
				'icon' => 'um-faicon-star',
				'edit_forbidden' => 1,
				'show_anyway' => true,
				'custom' => true,
		);

		return $fields;
		
	}
	
	/***
	***	@show rating
	***/
	add_filter('um_profile_field_filter_hook__user_rating', 'um_reviews_show_rating', 10);
	function um_reviews_show_rating() {
		global $um_reviews;
		$user_id = ( $user_id ) ? $user_id : um_profile_id();
		
		
		if ( $um_reviews->api->is_a_player($user_id)){
			?><span class="um-reviews-avg" style="display: inline-block !important;" data-number="1" data-score="<?php echo $um_reviews->api->get_rating() ;?>"><span id="phasionate-score<?php echo $user_id ;?>" class="phasionate-score"><?php echo intval($um_reviews->api->get_rating()) ;?></span></span><?php
			
			if (!$um_reviews->api->already_reviewed($user_id)){
			?>
			<div class="review-form">
				<form class="um-reviews-form" action="" method="post">	
					<span class="um-reviews-rate" data-key="rating" data-number="1" data-score="0" style="display: none !important;"></span>

					<span class="um-reviews-title"><input type="text" name="title" placeholder="<?php _e('Enter subject...','um-reviews'); ?>" style="display: none !important;" /></span>
					
					<span class="um-reviews-meta" style="display: none !important;" ><?php printf(__('by <a href="%s">%s</a>, %s','um-reviews'), um_user_profile_url(), um_user('display_name'), current_time('F d, Y') ); ?></span>

					<span class="um-reviews-content" style="display: none !important;" ><textarea name="content" placeholder="<?php _e('Enter your review...','um-reviews'); ?>" style="display: none !important;"></textarea></span>

					<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
					<input type="hidden" name="reviewer_id" id="reviewer_id" value="<?php echo get_current_user_id(); ?>" />
					<input type="hidden" name="reviewer_publish" id="reviewer_publish" value="<?php echo um_user('can_publish_review'); ?>" />
					<input type="hidden" name="action" id="action" value="um_review_add" />
					
					<div class="um-field-error" style="display:none"></div>
					
					<span class="um-reviews-send">
						<input type="submit" value="<?php _e('¡Vótame!','um-reviews'); ?>" class="um-button" />
					</span>
				</form>
			</div>
			<div id="ya-votado-<?php echo $user_id ;?>" class="ya-votado" style="display: none;"><span>¡Vuelve a votarle mañana!</span></div>
			<div id="spinner-place-<?php echo $user_id ?>" class="spinner-place"></div>
			<?php
			}elseif ($user_id == get_current_user_id()){
				?><div id="ya-votado-<?php echo $user_id ;?>"><span></span></div><?php
			}elseif (get_current_user_id() == 0){
				?>	<span id="mostrar-pop-up-registro" class="um-reviews-send">
						<input type="submit" value="<?php _e('¡Vótame!','um-reviews'); ?>" class="um-button" />
					</span><?php
			}else{
				?><div id="ya-votado-<?php echo $user_id ;?>"><span>¡Vuelve a votarle mañana!</span></div><?php
			}
		}
	}
	/***
	***	@Show votame button
	***/
	//add_filter('um_profile_field_filter_hook__user_rating', 'um_reviews_show_votame_button', 100, 2);
	function um_reviews_show_votame_button( $value, $data ) {
		global $um_reviews;
		$user_id = ( $user_id ) ? $user_id : um_profile_id();

		if ( $um_reviews->api->is_a_player($user_id)){

			return '<span class="um-reviews-avg" data-number="1" data-score="'. $um_reviews->api->get_rating() . '"><span id="phasionate-score'. $user_id .'" class="phasionate-score">'.intval($um_reviews->api->get_rating()).'</span></span>';

		}else{
			return ;
		}

	}