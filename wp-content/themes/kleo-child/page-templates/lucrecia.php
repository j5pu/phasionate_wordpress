<?php
/**
 * Template Name: Lucrecia
 *
 * Description: Template withour sidebar
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

add_filter('body_class','woocommerce_body_class');

function lucrecia_content(){
	?>

	<script src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/js/jssor.slider.mini.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                              //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $Loop: 0,                                       //[Optional] Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 5, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $Loop: 2,                                       //[Optional] Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind, default value is 1
                    $AutoCenter: 3,                                 //[Optional] Auto center thumbnail items in the thumbnail navigator container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 3
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange thumbnails, default value is 1
                    $SpacingX: 4,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $SpacingY: 4,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 4,                              //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 0,                            //[Optional] The offset position to park thumbnail
                    $Orientation: 2,                                //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1
                    $DisableDrag: false                             //[Optional] Disable drag or not, default value is false
                }
            };

            var jssor_sliderShop = new $JssorSlider$("sliderShop_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_sliderShop.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    var sliderWidth = parentWidth;

                    //keep the slider width no more than 964
                    sliderWidth = Math.min(sliderWidth, 964);

                    jssor_sliderShop.$ScaleWidth(sliderWidth);
                }
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
	</script>
    <div id="sliderShop_container" style="position: relative; width: 964px; height: 377px; overflow: hidden; ">
		
        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

		<!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 754px; height: 377px;
            overflow: hidden;">
            <div>
                <img u="image" src="<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/lucrecia-foto-bio.jpg" />
                <div u="thumb">
                    <img class="i" src="<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/lucrecia-foto-bio.jpg" /><div class="t">Lucrecia</div>
                    <div class="c">Colecciones exclusivos, productos únicos</div>
                </div>
            </div>
            <div>
                <img u="image" src="<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/1924333_405669549582605_8558251574712934406_n-400x400.jpg" />
                <div u="thumb">
                    <img class="i" src="<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/1924333_405669549582605_8558251574712934406_n-400x400.jpg" /><div class="t">Prema</div>
                    <div class="c">Bolsos azul de flecos</div>
                </div>
            </div>
            <div>
                <img u="image" src="<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/64276_407759982706895_5086998257539180685_n-400x400.jpg" />
                <div u="thumb">
                    <img class="i" src="<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/64276_407759982706895_5086998257539180685_n-400x400.jpg" /><div class="t">Abega</div>
                    <div class="c">Bolso redondo. ¡Mu flamenco!</div>
                </div>
            </div>
            <div>
                <img u="image" src="<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/10413416_408576772625216_2049085514777740177_n-400x400.jpg" />
                <div u="thumb">
                    <img class="i" src="<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/10413416_408576772625216_2049085514777740177_n-400x400.jpg" /><div class="t">Pyasan</div>
                    <div class="c">Bolso rojo pasión</div>
                </div>
            </div>
            <div>
                <img u="image" src="<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/1503321_408122239337336_1661342671311810098_n-400x400.jpg" />
                <div u="thumb">
                    <img class="i" src="<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/1503321_408122239337336_1661342671311810098_n-400x400.jpg" /><div class="t">Avada</div>
                    <div class="c">Bolso elegante de tonos grises</div>
                </div>
            </div>
        </div>
 		<!--#region ThumbnailNavigator Skin Begin -->
        <style>
            /* jssor slider thumbnail navigator skin 11 css */
            /*
                .jssort11 .p            (normal)
                .jssort11 .p:hover      (normal mouseover)
                .jssort11 .pav          (active)
                .jssort11 .pav:hover    (active mouseover)
                .jssort11 .pdn          (mousedown)
                */

            #sliderShop_container{
            	margin: 20px auto;
            }
            .jssort11 {
                position: absolute;
                width: 200px;
                height: 377px;
                font-family: Arial, Helvetica, sans-serif;
                -moz-user-select: none;
                -webkit-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background-color: #000;
            }

                .jssort11 .p {
                    position: absolute;
                    width: 200px;
                    height: 88px;
                    background: #181818;
                }

                .jssort11 .tp {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    border: none;
                }

                .jssort11 .i, .jssort11 .pav:hover .i {
                    position: absolute;
                    top: 3px;
                    left: 3px;
                    width: 60px;
                    height: 30px;
                    border: white 1px dashed;
                }

                * html .jssort11 .i {
                    width /**/: 62px;
                    height /**/: 32px;
                }

                .jssort11 .pav .i {
                    border: white 1px solid;
                }

                .jssort11 .t, .jssort11 .pav:hover .t {
                    position: absolute;
                    top: 3px;
                    left: 68px;
                    width: 129px;
                    height: 32px;
                    line-height: 32px;
                    text-align: center;
                    color: #fc9835;
                    font-size: 20px;
                    font-weight: 700;
                    font-family: Playfair Display;
                    text-transform: uppercase;
                }

                .jssort11 .pav .t, .jssort11 .p:hover .t {
                    color: #fff;
                }

                .jssort11 .c, .jssort11 .pav:hover .c {
                    position: absolute;
                    top: 38px;
                    left: 3px;
                    width: 197px;
                    height: 31px;
                    line-height: 31px;
                    color: #fff;
                    font-size: 12px;
                    font-weight: 400;
                    overflow: hidden;
                }

                .jssort11 .pav .c, .jssort11 .p:hover .c {
                    color: #fc9835;
                }

                .jssort11 .t, .jssort11 .c {
                    transition: color 2s;
                    -moz-transition: color 2s;
                    -webkit-transition: color 2s;
                    -o-transition: color 2s;
                }

                .jssort11 .p:hover .t, .jssort11 .pav:hover .t, .jssort11 .p:hover .c, .jssort11 .pav:hover .c {
                    transition: none;
                    -moz-transition: none;
                    -webkit-transition: none;
                    -o-transition: none;
                }

                .jssort11 .p:hover, .jssort11 .pav:hover {
                    background: #333;
                    cursor:pointer;
                }

                .jssort11 .pav, .jssort11 .p.pdn {
                    background: #902828;
                }
        </style>
        <div u="thumbnavigator" class="jssort11" style="left: 760px; top:0px;">
            <!-- Thumbnail Item Skin Begin -->
            <div u="slides" style="cursor: default;">
                <div u="prototype" class="p" style="top: 0; left: 0;">
                    <div u="thumbnailtemplate" class="tp"></div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div> 
        <!--#endregion ThumbnailNavigator Skin End -->
        <a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a>
	</div>

	<?php
}
add_shortcode( 'lucreciaContent', 'lucrecia_content' );

get_header(); ?>

<?php
//create full width template
kleo_switch_layout('no');
?>

<?php
if ( have_posts() ) :
    // Start the Loop.
    while ( have_posts() ) : the_post();

        /*
         * Include the post format-specific template for the content. If you want to
         * use this in a child theme, then include a file called called content-___.php
         * (where ___ is the post format) and that will be used instead.
         */
        get_template_part( 'content', 'page' );
        ?>

        <?php if ( sq_option( 'page_comments', 0 ) == 1 ): ?>

            <!-- Begin Comments -->
            <?php comments_template( '', true ); ?>
            <!-- End Comments -->

        <?php endif; ?>

    <?php endwhile;

endif;
?>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>
