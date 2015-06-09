<?php

class UM_Reviews_Shortcode {

	function __construct() {
	
		add_shortcode('ultimatemember_bases', array(&$this, 'ultimatemember_bases'), 1);
		add_shortcode('ultimatemember_top_rated', array(&$this, 'ultimatemember_top_rated'), 1);
		add_shortcode('ultimatemember_user_position', array(&$this, 'ultimatemember_user_position'), 1);
		add_shortcode('ultimatemember_top_50', array(&$this, 'ultimatemember_top_50'), 1);
		add_shortcode('ultimatemember_most_rated', array(&$this, 'ultimatemember_most_rated'), 1);
		add_shortcode('ultimatemember_lowest_rated', array(&$this, 'ultimatemember_lowest_rated'), 1);
		add_shortcode('ultimatemember_activity', array(&$this, 'ultimatemember_activity'), 1);
	}
	

	/***
	***	@Shortcode
	***/
	function ultimatemember_activity( $args = array() ) {

		global $um_review;
		global $wpdb;
	    $current_user = get_current_user_id();

		//Creaccion de topics
		$bbp_topic_query = new WP_Query( array(
			'post_type'           => 'topic',
			'post_status'         => array( bbp_get_public_status_id(), bbp_get_closed_status_id() ),
			'posts_per_page'      => 20,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'orderby' 		 => 'date',
			'order'    		 => 'DESC',
		) );

		//Respuestas a topics

		$bbp_query = new WP_Query( array(
			'post_type'           => bbp_get_reply_post_type(),
			'post_status'         => array( bbp_get_public_status_id(), bbp_get_closed_status_id() ),
			'posts_per_page'      => 20,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'orderby' 		 => 'date',
			'order'    		 => 'DESC',
		) );

		// Posts de la revista

		$args = array(
			'post_status'  	 => 'publish',
			'posts_per_page' => 20,
			'orderby' 		 => 'date',
			'order'    		 => 'DESC',
			'cat'			 => -566
		);
		$post_magazine = new WP_Query( array( $args ) );

		// Votos del current user

	    if($current_user){
			$um_reviews_current_user = new WP_Query( array(
				'post_type'           => 'um_review',
				'post_status'         => 'publish',
				'author'		  	  => $current_user
			) );
			$array_aux = get_user_meta( $current_user, '_reviews')[0];
			$array_aux_um_reviews = array_reverse(array_keys( $array_aux));
	    }

	    // Seguidores

	    if($current_user){
			$followers = $wpdb->get_results(
				"SELECT * FROM wp_um_followers WHERE user_id1=$current_user"
			);
	    }

		// Notificaciones Apuntados al concurso

		$roles_change = $wpdb->get_results(
			"SELECT * FROM wp_um_notifications WHERE type='upgrade_role' and content like concat('%','a<strong>Concursante-Portada-Mayo-2015','%')"
		);

		//ordernar por tiempo

		$final_exits = array_merge($bbp_query->posts, $post_magazine->posts);
		$final_exits = array_merge($final_exits, $bbp_topic_query->posts);
		if ($current_user) { $final_exits = array_merge($final_exits, $um_reviews_current_user->posts); }
		if ($current_user) { $final_exits = array_merge($final_exits, $followers); }
		$final_exits = array_merge($final_exits, $roles_change);

	    $post_order = array();
	    foreach( $final_exits as $post_exit ) {
	    	$post_exit_time = get_the_time('U', $post_exit);
	    	if (!$post_exit_time){ $post_exit_time=strtotime($post_exit->time); };
	    	$post_exit_id = $post_exit->ID; 
	    	if ( $post_exit_id == 0 ){ $post_exit_id = $post_exit->id*1000000; }; //otorga id unico a los post de notificaciones apuntados al concurso
	    	if ( $post_exit->user_id1 != 0){ $post_exit_id = $post_exit->id-1000000; }; //otorga id unico a los post de seguidores
	        $post_order[$post_exit_id] =  $post_exit_time ;
	    }
	    arsort( $post_order );
	    $final_exits = array_keys( $post_order );
	    $posts_final = array();
	    foreach( $final_exits as $post_exit ) {
	    	if ( $post_exit<0){
	    		$post_exit = $post_exit+1000000;
				$follower = $wpdb->get_results(
					"SELECT * FROM wp_um_followers WHERE user_id1=$current_user and id=$post_exit"
				);
	    		$post_final_new = $follower[0];
	    	}else if ( $post_exit>1000000 ){ 
	    		$post_exit = $post_exit/1000000;
				$role_change = $wpdb->get_results(
					"SELECT * FROM wp_um_notifications WHERE type='upgrade_role' and id=$post_exit"
				);
	    		$post_final_new = $role_change[0];
	    	}else{
	    	$post_final_new = get_post( $post_exit );
	    	}
	    	$posts_final[] = $post_final_new;
	    	$post_final_id = $post_final_new->ID;
	    }

		//imprimir resultados
		?>
		<ul class="um-activity-ul">

			
			<?php
			$ind_um_rev = 0;
			foreach( $posts_final as $final_exit ) {
			?>
			<?php 
				if ( $final_exit->post_type == 'reply' ){ 
					$reply_id   = bbp_get_reply_id( $final_exit->ID );
					$post_topic = get_post( $final_exit->post_parent );
					$post_forum = get_post( $post_topic->post_parent );
				}
				if ( $final_exit->post_type == 'topic'){
					$reply_id   = bbp_get_reply_id( $final_exit->ID );
					$post_topic = $final_exit;
					$post_forum = get_post( $post_topic->post_parent );
				}
			?>
			<li class="um-activity-li 
				<?php   if ( $final_exit->post_type == 'reply' || $final_exit->post_type == 'topic'){ echo 'activity-li-reply bbp-for-'.$post_forum->post_title; }; 
						if ( $final_exit->post_type == 'post' ){ echo 'activity-li-post'; }
						if ( $final_exit->post_type == 'um_review'){ echo 'activity-li-review'; }
				?>">
					<!--Title-->
					<?php if ( $final_exit->post_type == 'reply' ){ 
						echo '<h5>Nueva respuesta en <a class="bbp-cat" href="'.$post_topic->guid.'">'.$post_topic->post_title.'</a><span>Foro: <a class="bbp-for" href="'.$post_forum->guid.'">'.$post_forum->post_title.'</a></span></h5>';
						}?>
					<?php if ( $final_exit->post_type == 'topic' ){ 
						echo '<h5>Nuevo debate: <a class="bbp-cat" href="'.$post_topic->guid.'">'.$post_topic->post_title.'</a><span>Foro: <a class="bbp-for" href="'.$post_forum->guid.'">'.$post_forum->post_title.'</a></span></h5>';
						}?>
					<?php if ( $final_exit->post_type == 'post' ){ echo '<h4 class="activity-post-title"><a href="'.get_permalink($final_exit->ID).'">'.get_the_title($final_exit->ID).'</a></h4>'; } ?>
					<?php if ( $final_exit->post_type == 'um_review' ){ ?><a href="https://www.bogadia.com/concurso/" title="Ir al Ranking"><i class="star-on-png">+1</i></a><?php } ?>
					<?php if ( $final_exit->type == 'upgrade_role' ){ ?><?php } ?>

					<!-- Content -->
					<?php if ( $final_exit->post_type == 'reply' || $final_exit->post_type == 'topic'){ 
					$reply_link = '<a class="bbp-reply-topic-title" href="' . esc_url( bbp_get_reply_url( $reply_id ) ) . '" title="Ir al debate">' . bbp_get_reply_topic_title( $reply_id ) . '</a>';

					$author_link = bbp_get_reply_author_link( array( 'post_id' => $reply_id, 'type' => 'both', 'size' => 50 ) );

					printf( _x( '%1$s', 'widgets', 'bbpress' ), $author_link, $reply_link, '<div>' . bbp_get_time_since( get_the_time( 'U' ) ) . '</div>' );
					
					?><div class="activity-content-reply"><?php echo $final_exit->post_content ?></div><?php
					}?>

					<?php if ( $final_exit->post_type == 'post' ){ 
						$category = get_the_category($final_exit->ID);
						$link = get_permalink($final_exit->ID);
						$title = get_the_title($final_exit->ID);		
						echo '<span>'.$final_exit->post_excerpt.'</span>';
						echo '<a href="'.$link.'">'.get_the_post_thumbnail( $final_exit->ID, 'large' ).'</a>'.'<div><abbr><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></div>';
					} ?>

					<?php if ( $final_exit->post_type == 'um_review'){ um_fetch_user($array_aux_um_reviews[$ind_um_rev]);
						?>
						<div class="activity-content-review"><span>Has recibido un voto de <a href="<?php echo um_user_profile_url();?>"><?php echo um_user('display_name'); ?></a></span>
						<div class="um-reviews-widget-pic">
							<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $array_aux_um_reviews[$ind_um_rev], 50 ); ?></a>
						</div>
					<?php um_reset_user(); } ?>

					<?php if ( $final_exit->type == 'upgrade_role' ){ um_fetch_user($final_exit->user); ?>
						<div class="activity-content-upgrade_role">
							<div class="um-reviews-widget-pic">
								<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( um_user('id'), 70 ); ?></a>
							</div>
							<a href="<?php echo um_user_profile_url();?>"><?php echo um_user('display_name'); ?></a></span>
							<span> se apunto al <a href="https://www.bogadia.com/concurso/" title="Ir al Ranking">Concurso</a></span>
						</div>
					<?php um_reset_user(); } ?>


					<?php if ( $final_exit->user_id1 == $current_user ){ um_fetch_user($final_exit->user_id2); ?>
						<div class="um-reviews-widget-pic">
							<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $final_exit->user_id2, 70 ); ?></a>
						</div>
						<div class="activity-following-mes"><a href="<?php echo um_user_profile_url();?>"><?php echo um_user('display_name'); ?></a><span> esta siguiendote.</span></div><?php
					um_reset_user(); } ?>

					<!--Fecha-->
					<?php if( $final_exit->type == 'upgrade_role'){ ?>
						<span class="date-activity"><?php echo bbp_get_time_since( $final_exit->time ); ?></span> 
					<?php
					}else{
						if(time()-get_the_time( 'U', $final_exit ) > 1500000){ ?>
							<span class="date-activity"><?php echo get_the_time( 'd/m/Y', $final_exit ); echo " - ".get_the_time( 'U', $final_exit ); ?></span> 
						<?php }else{ ?>
							<span class="date-activity"><?php echo bbp_get_time_since( get_the_time( 'U', $final_exit ) ); echo " - ".get_the_time( 'U', $final_exit ); ?></span> 
					<?php } 
					}
					?>
			</li>

			<?php 
			$ind_um_rev = $ind_um_rev + 1;
			}; ?>

		</ul>	
		<?php
	}
		
	/***
	***	@Shortcode
	***/
	function ultimatemember_user_position( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 9999
		);

		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_total',
			'orderby' => 'meta_value',
			'order' => 'desc'
		);
		
		$query_args['meta_query'][] = array(
			'key' => 'role',
			'value' => 'concursante-portada-mayo-2015',
			'compare' => '='
		);

		$users = new WP_User_Query( $query_args );
		$sorted_users_ids = $um_reviews->api->it4_sort_users_by_meta_key( $users->results, '_reviews_total' );
		?>

		<?php 
		$i=0;
		foreach( $sorted_users_ids as $user_id ) {
			$i += 1;
			$current_user_id = get_current_user_id();

			if ($user_id == $current_user_id) {
				$position_user = $i;
				$count = round($um_reviews->api->get_rating( $user_id ));
		?>
				<h4>Tu posición en el concurso:</h4>
				<ul class="um-reviews-widget top-rated own-ranking top-rated-user">
					<li>
						<div class="um-reviews-widget-pic">
							<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 100 ); ?></a>
						</div>
						
						<div class="um-reviews-widget-user">
							<div class="phasionate-position"><?php echo $position_user; ?></div>
							<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
							<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="1" data-score="<?php echo $count; ?>"><span><?php if($count==1){ echo "LLevas ".$count." voto."; }else{ echo "LLevas ".$count." votos."; }; ?></span></div>
					
						</div>
						
						<div class='profile_share'>
							<a onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;" href="http://www.facebook.com/sharer.php?u=<?php echo um_user_profile_url(); ?>" class="post_share_facebook">
								<i class="icon-facebook"></i>
							</a>
							<a href="https://twitter.com/share?url=<?php echo um_user_profile_url(); ?>" class="post_share_twitter" onclick="javascript:window.open(this.href,
							'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;">
								<i class="icon-twitter"></i>
							</a>
							<a href="https://plus.google.com/share?url=<?php echo um_user_profile_url(); ?>" onclick="javascript:window.open(this.href,
							'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
								<i class="icon-gplus"></i>
							</a>
						</div>

						<div class="um-clear"></div>
					</li>
				</ul>
		<?php
				break;
			}
		}	

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/***
	***	@Shortcode
	***/
	function ultimatemember_top_50( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 99999
		);

		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();

		if (isset($_GET['members_page'])){
			$page_number = $_GET['members_page'];
		}else{
			$page_number = 1;
		}

		$total_participants_show_basic = 19;
		if($page_number>1){
			$total_participants_show = $total_participants_show_basic  + 1;
			$offset_query = (($page_number-1)*$total_participants_show)-1;
		}else{
			$total_participants_show = $total_participants_show_basic;
			$offset_query = ($page_number-1)*$total_participants_show;
		}

		if (isset($_GET['ordenado_por'])){
			$order_set = $_GET['ordenado_por'];
		}else{
			$order_set = 'mas_votados';
		}

		if ( $order_set == 'mas_votados' || $order_set == 'aleatorio' ){
			$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_total',
			'orderby' => 'meta_value',
			'order' => 'desc',
			'offset' => $offset_query
			);
			$query_args['meta_query'][] = array(
				'key' => 'role',
				'value' => 'concursante-portada-mayo-2015',
				'compare' => '='
			);
		}else if ( $order_set == 'mas_recientes' ){
			$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'orderby' => 'user_registered',
			'order' => 'desc',
			'offset' => $offset_query
			);
			$query_args['meta_query'][] = array(
				'key' => 'role',
				'value' => 'concursante-portada-mayo-2015',
				'compare' => '='
			);
		}

		$users = new WP_User_Query( $query_args );

		if ( $order_set == 'mas_votados' ){
			$sorted_users_ids = $um_reviews->api->it4_sort_users_by_meta_key( $users->results, '_reviews_total' );
		}else if ( $order_set == 'mas_recientes'){
			$sorted_users_total = $um_reviews->api->it4_sort_users_by_meta_key( $users->results, '_reviews_total' );
			$sorted_users_ids =  $users->results;
		}else if ( $order_set == 'aleatorio' ){
			$sorted_users_total = $um_reviews->api->it4_sort_users_by_meta_key( $users->results, '_reviews_total' );
			$sorted_users_ids = $users->results;
			shuffle($sorted_users_ids);
		}

		$total_participants = count($users->results) + $offset_query;
		$n_pages = ceil($total_participants/$total_participants_show_basic);

		?>

		<?php
			global $ultimatemember;
		?>

		<div class="selectBox selectBoxup">
			<span> Ordenar por: </span>
			<select onChange="window.location.href=this.value" class="um-s1" style="width: 300px">
				<option value="<?php bloginfo('wpurl'); ?>/concurso-portada-de-mayo/?ordenado_por=mas_votados" <?php if($order_set == 'mas_votados'){echo 'selected';}?>>Más votados</option>
				<option value="<?php bloginfo('wpurl'); ?>/concurso-portada-de-mayo/?ordenado_por=aleatorio" <?php if($order_set == 'aleatorio'){echo 'selected';}?>>Aleatorio</option>
				<option value="<?php bloginfo('wpurl'); ?>/concurso-portada-de-mayo/?ordenado_por=mas_recientes" <?php if($order_set == 'mas_recientes'){echo 'selected';}?>>Recien llegados</option>
			</select>
		</div>
		
		<?php
		if ($order_set != "aleatorio"){
		?>

		<div class="selectBox selectBoxup">
			<span> Muestra página: </span>
			<select onChange="window.location.href=this.value" class="um-s1" style="width: 100px">
				<?php
				for( $g=1; $g<=$n_pages; $g++ ){
					if ($g != $page_number){
				?>
						<option value="<?php echo $ultimatemember->permalinks->add_query( 'members_page', $g ); ?>"><?php echo $g; ?></option>
				<?php	
					}else{
				?>		
						<option value="<?php echo $ultimatemember->permalinks->add_query( 'members_page', $g ); ?>" selected><?php echo $g; ?></option>
				<?php
					}
				}
				?>
			</select>
		</div>

		<?php
		}else{
		?>

		<div class="randomAgainButton"><a href="<?php bloginfo('wpurl'); ?>/concurso-portada-de-mayo/?ordenado_por=aleatorio" title="Nuevos aleatorios">
		<img src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/dices.png" alt="Nuevos aleatorios"/>
		</a></div>

		<?php
		}	
		?>

		<ul class="um-reviews-widget top-rated top_portada_mayo <?php if($page_number == 1){ echo "first_page_ranking_list"; }?>">
		
			<?php 
			$i = $offset_query+1;
			$current_user_id = get_current_user_id();
			foreach( $sorted_users_ids as $user_id ) {
				$count = round($um_reviews->api->get_rating( $user_id ));
				get_avatar( $user_id, 100 );
			?>
			
					<li class="<?php if ($user_id == $current_user_id){ ?> current-user-in-top-list <?php } ?>">

						<div class="um-reviews-widget-pic">
							<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 100 ); ?></a>
						</div>
						
						<div class="um-reviews-widget-user">
							<?php
							if ($order_set != "mas_votados"){
								$g = 0;
								foreach( $sorted_users_total as $user_id_look ) {
									$g += 1;
									$current_user_id = get_current_user_id();

									if ($user_id_look == $user_id) {
										$position_user = $g;
										?>
										<div class="phasionate-position"><?php echo $position_user?></div>
										<?php
									}
								}
							}else{
							?>
								<div class="phasionate-position"><?php echo $i?></div>
							<?php
							}
							?>
							<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
							
							<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="1" data-score="<?php echo $count; ?>"><span><?php echo "LLeva <span id='phasionate-score".$user_id."'>".$count."</span> "; if($count==1){ echo "voto."; }else{ echo "votos."; } ?></span></span></div>
					
							<?php
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
							<div id="ya-votado-<?php echo $user_id ?>" class="ya-votado" style="display: none;"><span>¡Vuelve a votarle mañana!</span></div>
							<div id="spinner-place-<?php echo $user_id ?>" class="spinner-place"></div>
							<?php
							}elseif ($user_id == get_current_user_id()){
								?><div id="ya-votado-<?php echo $user_id ;?>"><span></span></div><?php
							}else{
								?><div id="ya-votado-<?php echo $user_id ;?>" class="ya-votado"><span>¡Vuelve a votarle mañana!</span></div><?php
							}?>

						</div>

						<div class='profile_share'>
							<a onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;" href="http://www.facebook.com/sharer.php?u=<?php echo um_user_profile_url(); ?>" class="post_share_facebook">
								<i class="icon-facebook"></i>
							</a>
							<a href="https://twitter.com/share?url=<?php echo um_user_profile_url(); ?>" class="post_share_twitter" onclick="javascript:window.open(this.href,
							'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;">
								<i class="icon-twitter"></i>
							</a>
							<a href="https://plus.google.com/share?url=<?php echo um_user_profile_url(); ?>" onclick="javascript:window.open(this.href,
							'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
								<i class="icon-gplus"></i>
							</a>
						</div>
						
					</li>
			
			<?php   
				$i += 1;
				if ( $i-$offset_query>$total_participants_show ){
					break;
				}
			}
			?>
			
		</ul>
		
		<?php
		if ($order_set != "aleatorio"){
		?>

		<div class="selectBox selectBoxdown">
			<span> Muestra página: </span>
			<select onChange="window.location.href=this.value" class="um-s1" style="width: 100px">
				<?php
				for( $g=1; $g<=$n_pages; $g++ ){
					if ($g != $page_number){
				?>
						<option value="<?php echo $ultimatemember->permalinks->add_query( 'members_page', $g ); ?>"><?php echo $g; ?></option>
				<?php	
					}else{
				?>		
						<option value="<?php echo $ultimatemember->permalinks->add_query( 'members_page', $g ); ?>" selected><?php echo $g; ?></option>
				<?php
					}
				}
				?>
			</select>
		</div>

		<?php
		}
		?>

		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/***
	***	@Shortcode
	***/
	function ultimatemember_most_rated( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 5
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_total',
			'orderby' => 'meta_value',
			'order' => 'desc'
		);

		if ( isset( $roles ) && $roles != 'all' ) {
			$query_args['meta_query'][] = array(
				'key' => 'role',
				'value' => $roles,
				'compare' => '='
			);
		}

		$users = new WP_User_Query( $query_args );

		?>
		
		<ul class="um-reviews-widget top-rated">
		
			<?php foreach( $users->results as $user_id ) {

				$count = $um_reviews->api->get_reviews_count( $user_id ); ?>
			
			<li>
			
				<div class="um-reviews-widget-pic">
					<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 40 ); ?></a>
				</div>
				
				<div class="um-reviews-widget-user">
				
					<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
					
					<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="1" data-score="<?php echo $um_reviews->api->get_rating( $user_id ); ?>"><span id="phasionate-score"><?php echo $count; ?></span></span></div>

					<?php if ( $count == 1 ) { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le ha votado %s phasionista','um-reviews'), $count ); ?></div>
					<?php } else { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le han votado %s phasionistas','um-reviews'), $count ); ?></div>
					<?php } ?>
			
				</div><div class="um-clear"></div>
				
			</li>
			
			<?php } ?>
			
		</ul>
		
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}





	/***
	***	@Shortcode
	***/
	function ultimatemember_top_rated( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 5
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_avg',
			'orderby' => 'meta_value',
			'order' => 'desc'
		);
		
		if ( isset( $roles ) && $roles != 'all' ) {
			$query_args['meta_query'][] = array(
				'key' => 'role',
				'value' => $roles,
				'compare' => '='
			);
		}

		$users = new WP_User_Query( $query_args );

		?>
		
		<ul class="um-reviews-widget top-rated">
		
			<?php foreach( $users->results as $user_id ) {

				$count = $um_reviews->api->get_reviews_count( $user_id ); ?>
			
			<li>
			
				<div class="um-reviews-widget-pic">
					<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 40 ); ?></a>
				</div>
				
				<div class="um-reviews-widget-user">
				
					<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
					
					<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="1" data-score="<?php echo $um_reviews->api->get_rating( $user_id ); ?>"><span id="phasionate-score"><?php echo $count; ?></span></span></div>

					<?php if ( $count == 1 ) { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le ha votado %s phasionista','um-reviews'), $count ); ?></div>
					<?php } else { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le han votado %s phasionistas','um-reviews'), $count ); ?></div>
					<?php } ?>
			
				</div><div class="um-clear"></div>
				
			</li>
			
			<?php } ?>
			
		</ul>
		
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/***
	***	@Shortcode
	***/
	function ultimatemember_lowest_rated( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 5
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		ob_start();
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_avg',
			'orderby' => 'meta_value',
			'order' => 'asc'
		);
		
		if ( isset( $roles ) && $roles != 'all' ) {
			$query_args['meta_query'][] = array(
				'key' => 'role',
				'value' => $roles,
				'compare' => '='
			);
		}

		$users = new WP_User_Query( $query_args );

		?>
		
		<ul class="um-reviews-widget top-rated">
		
			<?php foreach( $users->results as $user_id ) {

				$count = $um_reviews->api->get_reviews_count( $user_id ); ?>
			
			<li>
			
				<div class="um-reviews-widget-pic">
					<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 40 ); ?></a>
				</div>
				
				<div class="um-reviews-widget-user">
				
					<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
					
					<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="1" data-score="<?php echo $um_reviews->api->get_rating( $user_id ); ?>"><span id="phasionate-score"><?php echo $count; ?></span></span></div>

					<?php if ( $count == 1 ) { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le ha votado %s phasionista','um-reviews'), $count ); ?></div>
					<?php } else { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le han votado %s phasionistas','um-reviews'), $count ); ?></div>
					<?php } ?>
			
				</div><div class="um-clear"></div>
				
			</li>
			
			<?php } ?>
			
		</ul>
		
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

		/***
	***	@Shortcode
	***/
	function ultimatemember_bases( $args = array() ) {
		global $um_reviews;
		
		$current_user_id = get_current_user_id();

		$role = get_user_meta( $current_user_id, 'role', true );

		if ($role == 'concursante-portada-mayo-2015'){
			?>
			<a href="<?php bloginfo('wpurl'); ?>/wp-content/uploads/pdf/bases_legales_concurso_bogadia.pdf" target="_blank">Bases del concurso</a>
			<?php
		}
	}
	

}

