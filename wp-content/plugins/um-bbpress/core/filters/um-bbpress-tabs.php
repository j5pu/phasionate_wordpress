<?php

	/***
	***	@adds a main tab to display forum activity in profile
	***/
	add_filter('um_profile_tabs', 'um_bbpress_add_tab', 1000 );
	function um_bbpress_add_tab( $tabs ) {
		
		global $um_bbpress;
		
		$user_id = um_user('ID');

		$current_user_id = get_current_user_id();

		if ( $user_id == $current_user_id ) {

			$tabs['forums'] = array(
				'name' => __('Forums','um-bbpress'),
				'icon' => 'um-faicon-comments',
				'subnav' => array(
					'topics' => 'Mis ' . __('Topics Started','um-bbpress')  . '<span>' . bbp_get_user_topic_count_raw( $user_id ) . '</span>',
					'replies' => 'Mis ' . __('Replies Created','um-bbpress')  . '<span>' . bbp_get_user_reply_count_raw( $user_id ) . '</span>',
					'favorites' => 'Mis ' . __('Favorites','um-bbpress') . '<span>' . count( bbp_get_user_favorites_topic_ids( $user_id ) ) . '</span>',
					'subscriptions' => 'Mis ' . __('Subscriptions','um-bbpress') . '<span>' . $um_bbpress->user_subscriptions_count( $user_id ) . '</span>',
				),
				'subnav_default' => 'topics'
			);

		}else{

			$tabs['forums'] = array(
				'name' => __('Forums','um-bbpress'),
				'icon' => 'um-faicon-comments',
				'subnav' => array(
					'topics' => __('Topics Started','um-bbpress') . ' por ' . um_user('display_name') . '<span>' . bbp_get_user_topic_count_raw( $user_id ) . '</span>',
					'replies' => __('Replies Created','um-bbpress') . ' de ' . um_user('display_name') . '<span>' . bbp_get_user_reply_count_raw( $user_id ) . '</span>',
					'favorites' => __('Favorites','um-bbpress') . ' de ' . um_user('display_name') . '<span>' . count( bbp_get_user_favorites_topic_ids( $user_id ) ) . '</span>',
					'subscriptions' => __('Subscriptions','um-bbpress') . ' de ' . um_user('display_name') . '<span>' . $um_bbpress->user_subscriptions_count( $user_id ) . '</span>',
				),
				'subnav_default' => 'topics'
			);

		}
		
		return $tabs;
		
	}
	
	/***
	***	@add tabs based on user
	***/
	add_filter('um_user_profile_tabs', 'um_bbpress_user_add_tab', 1000 );
	function um_bbpress_user_add_tab( $tabs ) {
		
		global $um_bbpress;
		
		$user_id = um_user('ID');
		
		if ( !um_user('can_have_forums_tab') )
			unset( $tabs['forums'] );
		
		if ( !bbp_is_subscriptions_active() )
			unset( $tabs['forums']['subnav']['subscriptions'] );
		
		if ( !bbp_is_favorites_active() )
			unset( $tabs['forums']['subnav']['favorites'] );
		
		if ( !um_is_myprofile() && !um_current_user_can('edit', $user_id ) )
			unset( $tabs['forums']['subnav']['subscriptions'] );
		
		if ( !um_user('can_create_topics') )
			unset( $tabs['forums']['subnav']['topics'] );
		
		if ( !um_user('can_create_replies') )
			unset( $tabs['forums']['subnav']['replies'] );

		
		if ( !isset( $tabs['forums']['subnav'][ $tabs['forums']['subnav_default'] ] ) ) {
		$i = 0;
		foreach( $tabs['forums']['subnav'] as $id => $data ) {
			$i++;
			if ( $i == 1 ) {
				$tabs['forums']['subnav_default'] = $id;
			}
		}
		}
		
		if ( !is_user_logged_in() && um_get_option('bbpress_hide_from_guests') ) {
			unset( $tabs['forums'] );
		}
		
		return $tabs;
		
	}