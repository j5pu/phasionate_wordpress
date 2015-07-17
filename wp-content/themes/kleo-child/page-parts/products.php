
<select class="orderProducts">
    <option selected disabled>Ordenar por:</option>
	<option slug='precioBajo'>Precio Menor</option>
	<option slug='precioAlto'>Precio Mayor</option>
	<option slug='novedades'>Novedades</option>
	<option slug='populares'>Populares</option>
</select>

<hr/>

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