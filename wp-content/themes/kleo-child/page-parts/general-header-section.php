<?php
/**
 * Header section of our theme
 *
 * Displays all of the <div id="header"> section
 *
 * @package WordPress
 * @subpackage Phasionate
 * @since Kleo 1.0
 */

//set logo path
$logo_path = sq_option_url( 'logo' );
$logo_path = apply_filters( 'kleo_logo', $logo_path );
$social_icons = apply_filters( 'kleo_show_social_icons', sq_option( 'show_social_icons', 1 ) );
$top_bar = sq_option( 'show_top_bar', 1 );
$top_bar = apply_filters( 'kleo_show_top_bar', $top_bar );

$top_menu = wp_nav_menu( array(
        'theme_location'    => 'top',
        'depth'             => 2,
        'container'         => 'div',
        'container_class'   => 'top-menu col-sm-12 col-md-7 no-padd',
        'menu_class'        => '',
        'fallback_cb'       => '',
        'walker'            => new kleo_walker_nav_menu(),
        'echo'              => false
    )
);

$primary_menu = wp_nav_menu( array(
        'theme_location'    => 'primary',
        'depth'             => 3,
        'container'         => 'div',
        'container_class'   => 'collapse navbar-collapse nav-collapse pull-right',
        'menu_class'        => 'nav navbar-nav',
        'fallback_cb'       => 'kleo_walker_nav_menu::fallback',
        'walker'            => new kleo_walker_nav_menu(),
        'echo'              => false
    )
);

?>

<div id="header" class="header-color">
	
	<div class="navbar" role="navigation">

		<?php if ($top_bar == 1) { //top bar enabled ?>
		
		<!--Attributes-->
		<!--class = social-header inverse-->
        <div class="social-header header-color">
        <div class="container">
            <div class="top-bar">

                <div id="top-social" class="col-sm-12 col-md-5 no-padd">
                    <?php echo kleo_get_social_profiles(); ?>
                </div>

                <?php
                // Top menu
                echo $top_menu;
                ?>
  
            </div><!--end top-bar-->
        </div>
			</div>
		
			<?php } //end top bar condition ?>

			<div class="kleo-main-header">
				<div class="container">   
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<div class="kleo-mobile-switch">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
								<span class="sr-only"><?php _e("Toggle navigation",'kleo_framework');?></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						
						<div class="kleo-mobile-icons">
							
							<?php 
							/** kleo_mobile_header_icons - action
							 * You can put here various icons using this action
							 *
                             * @hooked kleo_bp_mobile_notify - 9
							 * @hooked kleo_woo_mobile_icon - 10
							 */
							do_action( 'kleo_mobile_header_icons' );
							?>
							
						</div>
						
						<strong class="logo">
							<a href="<?php echo home_url();?>">BOGADIA
								
								<?php /*COMENTADO if ($logo_path != '') { ?>
								
									<img id="logo_img" title="<?php bloginfo('name'); ?>" src="<?php echo $logo_path; ?>" alt="<?php bloginfo('name'); ?>">
									
								<?php } else { ?>
									
									<?php bloginfo('name'); ?>
									
								<?php }*/ ?>
									
							</a>
						</strong>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<?php
					// Main menu
					echo $primary_menu;
					?>
				</div><!--end container-->
			</div>
			<?php
			if ( in_array('woocommerce-page', get_body_class() ) ){
			?>
			<div class="submenu-shop">
				<ul>
					<li><a href="<?php bloginfo('wpurl'); ?>/disenadores-bogadia">diseñadores</a></li>
					<li><a href="<?php bloginfo('wpurl'); ?>/colecciones-bogadia">colecciones</a></li>
					<li><a href="#">ropa</a></li>
				</ul>
			</div>
			<?php
			}
			?>
	</div>

</div><!--end header-->