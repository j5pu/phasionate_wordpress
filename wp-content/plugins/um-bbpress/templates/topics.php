<?php $loop = $ultimatemember->query->make('post_type=topic&posts_per_page=10&offset=0&author=' . um_user('ID') ); ?>

<?php if ( $loop->have_posts()) { ?>
			
	<?php require um_bbpress_path . 'templates/topics-single.php'; ?>
	
	<div class="um-ajax-items">
	
		<!--Ajax output-->
		
		<?php if ( $loop->found_posts >= 10 ) { ?>
		
		<div class="um-load-items">
			<a href="#" class="um-ajax-paginate um-button" data-hook="um_bbpress_load_topics" data-args="topic,10,10,<?php echo um_user('ID'); ?>"><?php _e('load more topics','um-bbpress'); ?></a>
		</div>
		
		<?php } ?>
		
	</div>
		
<?php } else { ?>

	<?php ( um_is_myprofile() ) ? _e('You have not created any topics.','um-bbpress') : _e('This user has not created any topics.','um-bbpress'); ?>

<?php } ?>