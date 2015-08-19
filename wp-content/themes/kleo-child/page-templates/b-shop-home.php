<?php
/* Template Name: B-shop Home */
add_filter('body_class','woocommerce_body_class');
get_header();
kleo_switch_layout('no');
function is_mobile() {
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    return strpos($userAgent, 'mobile');
}

/* Does the UA string indicate this is a mobile? */

?>

<?php /*get_template_part('page-parts/general-before-wrap'); */?>
<section class="container-wrap main-color">
    <div id="main-container" class="<?php echo $container; ?>">
        <div class="row bshop-header">
<!--            <div class="col-sm-2 col-md-2" style="height: 150px;">
                <img class="img-responsive bshop-logo" width="150px" src="https://www.bogadia.com/wp-content/uploads/2015/07/simboloShop.jpg">
            </div>
            <div class="col-sm-8 col-md-8 text-center">
                <h1 id="cabecero-tienda">Colecciones exclusivas</h1>
            </div>-->
            <div class="col-md-12">
            <?php
            if(!is_mobile()){
            ?>
                <img class="img-responsive b-shop-banner" src="https://www.bogadia.com/wp-content/uploads/2015/08/redes-tienda2grandealargado.jpg">
            <?php
            } else {
            ?>
                <img class="img-responsive b-shop-banner b-shop-logo" height="150px" src="https://www.bogadia.com/wp-content/uploads/2015/08/redes-tienda2grandemovilcuadrada.jpg">
            <?php
            }
            ?>
            </div>

        </div>
        <div class="row">
<!--            phetnia-->
            <div id="phetnia" class="col-sm-6 col-md-6 b-shop-designer">
                <a href="https://www.bogadia.com/colecciones/phetnia">
                    <img class="img-responsive" src="https://www.bogadia.com/wp-content/uploads/2015/08/phetnia2-cuadrada.jpg">
                </a>

                <?php echo do_shortcode('[product_attribute attribute="coleccion" filter="phetnia" per_page="6" columns="2"]'); ?>

                <div class="row b-shop-designers">
                    <div class="col-xs-8 col-sm-8 col-md-8 b-shop-designers">
                        <a href="https://www.bogadia.com/disenadores/lucrecia">
                            <img class="img-responsive" src="https://www.bogadia.com/wp-content/uploads/2015/08/lucrecia-cuadrada.jpg">
                        </a>
                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4 text-center b-shop-designers">
                        <p> </p>
                        <a href="https://www.bogadia.com/disenadores/lucrecia">
                            <h3>Lucrecia PQ</h3>
                        </a>
                        <small>El arte y la moda de Málaga.</small>
                            <a href="https://www.bogadia.com/disenadores/lucrecia">
                                <i>Leer bio</i>
                        </a>
                    </div>
                </div>
            </div>
<!--            Neon-->
            <div class="col-sm-6 col-md-6 b-shop-designer">
                <a href="https://www.bogadia.com/colecciones/neon">
                    <img class="img-responsive" src="https://www.bogadia.com/wp-content/uploads/2015/08/neon2-cuadrada.jpg">
                </a>

                <?php echo do_shortcode('[product_attribute attribute="coleccion" filter="neon" per_page="6" columns="2"]'); ?>

                <div class="row b-shop-designers">
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <a href="https://www.bogadia.com/disenadores/cidfuentes">
                            <img class="img-responsive" src="https://www.bogadia.com/wp-content/uploads/2015/07/maria-foto-bio.jpg">
                        </a>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 text-center">
                        <p> </p>
                        <a href="https://www.bogadia.com/disenadores/cidfuentes">
                            <h3>María Cidfuentes</h3>
                        </a>
                        <small>Periodista, pero diseñadora de profesión.</small>
                            <a href="https://www.bogadia.com/disenadores/cidfuentes">
                                <i>Leer bio</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 b-shop-designers">
                <a href="https://www.bogadia.com/por-que-bogadia">
                    <img class="img-responsive" src="https://www.bogadia.com/wp-content/uploads/2015/08/redes-tienda2grande-con-boton.jpg">
                </a>
            </div>
        </div>

        <?php get_template_part('page-parts/general-after-wrap'); ?>

        <?php get_footer(); ?>
