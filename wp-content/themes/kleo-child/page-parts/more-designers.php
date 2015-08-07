<?php
	require("../../../../wp-config.php");

	$user_query = new WP_User_Query( array( 'role' => 'disenador', 'number' => 3, 'offset' => $_GET['desigle'] ) );

	// Get the results
	$designers = $user_query->get_results();

	// Check for results
	if (!empty($designers)) {
	    // loop trough each author
	    foreach ($designers as $designer)
	    {
	    	$user_info = get_userdata($designer->ID);
	    	?>
		    <div class="boxDesigner">
		        <a href="<?php bloginfo('wpurl'); ?>/disenadores/<?php echo $user_info->nickname ; ?>/">
					<?php echo get_avatar( $designer->ID, 512 ); ?>
		            <p><?php echo $user_info->display_name; ?></p>
		        </a>
		    </div>
		    <?php
	    }
	}{
		?><div class="noMoreDesigners"></div><?php
	}
?>