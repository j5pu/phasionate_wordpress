<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 *
 * Nota: Se ha modificado los title widgets, en  Kleo/kleo-framework/lib/class-multiple-sidebars.php antes salian <h5>
 */
?>
<?php
	$sidebar_classes = apply_filters('kleo_sidebar_classes', '');
	$categoria = get_the_category(); //para saber cual es la categoria padre
	//echo get_cat_name($categoria[0]->category_parent);
	if( !is_category() && is_archive() || is_category( array ( 'lo-ultimo' )) ){
		$sidebar_name = apply_filters('kleo_sidebar_name', 'Seccion');
	}elseif( is_single() ){
		$sidebar_name = apply_filters('kleo_sidebar_name', 'Post'); //cambiar si queremos que salga la sb, de la cat padre
	}elseif( is_category() ){
		$sidebar_name = apply_filters('kleo_sidebar_name', get_cat_name($categoria[0]->category_parent));
	}else{
		$sidebar_name = apply_filters('kleo_sidebar_name', '0');
	}		
 ?>
<div class="sidebar sidebar-main <?php echo $sidebar_classes; ?>">
<div class="clear"></div>
	<div class="inner-content widgets-container">
		<?php generated_dynamic_sidebar($sidebar_name);?>
	</div><!--end inner-content-->
</div><!--end sidebar-->

