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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script>
		document.cookie='resolution='+Math.max(screen.width,screen.height)+("devicePixelRatio" in window ? ","+devicePixelRatio : ",1")+'; path=/';
	</script>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<meta name="verification" content="6c2c0d0251a189774a6fe4252ce561a5" /><!-- Código de verifiación para zanox -->
	<!-- Código de verificación para Google Analitycs -->
	<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-55975132-1', 'auto');
		  ga('send', 'pageview');

	</script>
	<!-- Código de verificación para Google Analitycs -->
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

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
	<![endif]-->

	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/fontello-ie7.css">
	<![endif]-->
	
	<?php if(function_exists('bp_is_active')) { bp_head(); } ?>	
	
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
	
	<?php do_action('kleo_after_body');?>
	
	<!-- PAGE LAYOUT
	================================================ -->
	<!--Attributes-->
	<div class="kleo-page<?php echo $site_style;?>">


	<!-- HEADER SECTION
	================================================ -->
	<?php 
	/**
	 * Header section
	 * @hooked kleo_show_header
	 */
	do_action('kleo_header');
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