<?php
/*
Plugin Name: BogaShare
Description: Muestra el cajon de compartir a traves de api para el concurso de share
*/

function insert_my_footer() {
    if(is_single(11826)){
        include 'share.php';
    }
}
add_action('wp_footer', 'insert_my_footer');
?>