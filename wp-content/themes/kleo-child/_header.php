<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
/* For wp-activate.php page */
if ( defined('WP_INSTALLING') && WP_INSTALLING == true && ! function_exists('kleo_setup') ) {
    require_once dirname( __FILE__ ) . '/functions.php';
}
?><!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="no-js lt-ie10" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1, minimum-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="verification" content="2056fc4811f8f62d488c5cd4dd876c90"/>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<!-- Fav and touch icons -->
	<?php if (sq_option_url('favicon')) { ?>
	<link rel="shortcut icon" href="<?php echo sq_option_url('favicon'); ?>">
	<?php } ?>
	<?php if (sq_option_url('apple57')) { ?>
	<link rel="apple-touch-icon-precomposed" href="<?php echo sq_option_url('apple57'); ?>">
	<?php } ?>   
	<?php if (sq_option_url('apple72')) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo sq_option_url('apple72'); ?>">
	<?php } ?>   
	<?php if (sq_option_url('apple114')) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo sq_option_url('apple114'); ?>">
	<?php } ?>   
	<?php if (sq_option_url('apple144')) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo sq_option_url('apple144'); ?>">
	<?php } ?>
	<?php /*if( is_front_page() ):?>
		<link rel="stylesheet" type="text/css" href="http://www.phasionate.com/wp-content/themes/kleo/assets/css/mag.min.css"/>
	<?php endif; */?>
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
	<![endif]-->

	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/fontello-ie7.css">
	<![endif]-->
	
	<?php if(function_exists('bp_is_active')) { bp_head(); } ?>
	
<script>
    document.cookie='resolution='+Math.max(screen.width,screen.height)+("devicePixelRatio" in window ? ","+devicePixelRatio : ",1")+'; path=/';
</script>	
	<?php wp_head(); ?>
</head>

<?php 
/***************************************************
:: Some header customizations
***************************************************/

$site_style = sq_option('site_style', 'wide') == 'boxed' ? ' page-boxed' : '';
$site_style = apply_filters('kleo_site_style', $site_style);
?>

<body <?php body_class(); ?>>
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-W5H2MK"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-W5H2MK');</script>
	<!-- End Google Tag Manager -->
	<!--<?php if( is_front_page() ): magazine_home_html(); endif;?>-->
	<?php do_action('kleo_after_body');?>

	<!-- HEADER WIDGET ZONE TOP
	================================================ -->
	<!---->
	<?php //title_post_magazine_home()?>
	<div id="header-home-sidebar" class="header-sidebar widget-area" role="complementary">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('header-home-widget') ) : ?>
		<?php endif; ?>
	</div>

	<!-- HEADER SECTION HOME
	================================================ -->
	
	<?php 
	/**
	 * Header section
	 * @hooked kleo_show_header
	 */
	/*if( is_front_page() ): do_action('kleo_header');
	endif; */ ?>

		
	<!-- PAGE LAYOUT
	================================================ -->
	<!--Attributes-->
	<?php /*if( is_front_page() ): echo '<article class="content">'; endif; */ ?>
	<div class="kleo-page<?php echo $site_style;?>">

	<!-- HEADER SECTION NOT-HOME
	================================================ -->
	
	<?php 
	/**
	 * Header section
	 * @hooked kleo_show_header
	 */
	if( !is_front_page() ): do_action('kleo_header');
	endif;

	?>
		

	<!-- MAIN SECTION
	================================================ -->
	<div id="main">

	<?php 
	/**
	 * Hook into this action if you want to display something before any Main content
	 * 
	 */
	do_action('kleo_before_main');
	?>