<?php
if ( isset($_GET['search']) ){
	echo '[product_attribute attribute="disenadora" filter="'.$_GET['search'].'"]';
	echo do_shortcode( '[product_attribute attribute="disenador" filter='.$_GET['search'].']' );
}
?>