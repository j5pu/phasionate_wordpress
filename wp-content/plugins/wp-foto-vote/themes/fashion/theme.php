<?php
// http://vnjs.net/www/project/freewall/

// if not Infinite pagination and AJAX action
if ( defined('DOING_AJAX') && DOING_AJAX == TRUE && FvFunctions::ss('pagination-type', 'default') == 'infinite' ) {
    return;
}

//wp_enqueue_script('fv_main_imagesloaded', plugins_url('wp-foto-vote/assets/js/imagesloaded.pkgd.min.js'), array('jquery'), '1.0');
wp_enqueue_script('masonry');
wp_enqueue_script('fv_theme_fashion', FvFunctions::get_theme_url ( $theme, 'fv_theme_fashion.js' ), array( 'jquery' ) , '1.0');


add_action('fv_before_shows_loop',  'fv_fashion_before_show');
add_action('fv_after_shows_loop',  'fv_fashion_after_show');

function fv_fashion_before_show() {
    echo '<ul class="grid effect-1" id="grid">';
}

function fv_fashion_after_show() {
    echo '</ul>';
}
