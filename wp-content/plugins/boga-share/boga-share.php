<?php
/*
Plugin Name: BogaShare
Description: Muestra el cajon de compartir a traves de api para el concurso de share
*/

function insert_my_footer() {
    include 'share.php';
}
add_action('wp_footer', 'insert_my_footer');
?>