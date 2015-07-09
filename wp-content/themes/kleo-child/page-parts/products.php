
<ul class="orderProducts">
	<li slug='precioBajo'>precio <span>&lt;</span></li>
	<li slug='precioAlto'>precio <span>&gt;</span></li>
	<li slug='novedades'>Novedades</li>
	<li slug='populares'>Populares</li>
</ul>

<?php
	
	require("../../../../wp-config.php");

	if (isset($_GET['type_attr'])){
		$type_attr = $_GET['type_attr'];
		$slug = $_GET['slug'];
		if($type_attr == 'pa_disenadora'){
			echo do_shortcode('[product_attribute attribute="pa_disenadora" filter="'.$slug.'" per_page="24" columns="4"]');
		}else if($type_attr == 'pa_coleccion'){
			echo do_shortcode('[product_attribute attribute="pa_coleccion" filter="'.$slug.'" per_page="24" columns="4"]');
		}else{
		echo do_shortcode('[product_category category="'.$slug.'" per_page="24" columns="4"]');
		}
	}

?>