<?php
/*
Plugin Name: Interstitial
Description: ¡Solo funciona con adrotate! Si se activa sin adrotate romperá wordpress
*/

function insert_my_footer() {
    include 'instertitial.php';
}
add_action('kleo_header', 'insert_my_footer');
?>