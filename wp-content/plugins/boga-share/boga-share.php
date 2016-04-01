<?php
/*
Plugin Name: BogaShare
Description: Muestra el cajon de compartir a traves de api para el concurso de share
*/

function show_bogashare_dialog() {
    if(is_single(11826)){
        include 'share.php';
    }
}
add_action('wp_footer', 'show_bogashare_dialog');
?>