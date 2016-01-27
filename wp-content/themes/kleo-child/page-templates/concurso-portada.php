<?php
/**
 * Template Name: Concurso de portada
 *
 * Description: Template withour sidebar
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

get_header();
?>

<?php
//create full width template
kleo_switch_layout('no');
?>

<?php get_template_part('page-parts/general-before-wrap-no-title'); ?>

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

    <div class="wrap" id="contest_edit">
        <?php do_action('fv_admin_notices'); ?>

        <style type="text/css">
            #contest_edit .dashicons {
                margin-top: 2px;
            }
            #contest_edit #side-sortables {
                min-height: 50px !important;
            }
            .box {
                width: 25px;
                float: right;
                height: 100%;
            }
            .tooltip {
                width: 25px;
            }
            .dashicons-info:before {
                content: "\f348";
            }
            .gadash-title {
                float: left;
                margin-right: 10px;
                margin-top: 2px;
            }
            #titlediv {
                margin-bottom: 4px;
            }
            #titlediv #title {
                line-height: 120%;
            }
            .clear_ip {
                text-align: left;
                margin-bottom: 15px;
            }
            .clear_ip:after {
                display: table;
                clear: both;
                content: ' ';
            }
            #sv_wrapper:after {
                clear: both;
                display: table;
                content: ' ';
            }

            .shortcode {
                width: 100%;
                display: block;
                font-size: 120%;
            }

            #titlediv {
                width: 100%;
            }
            input.datetime {
                width: 130px;
            }

            .col6 {
                width: 48%;
                float: left;
            }

            .curtime #timestamp:before {
                top: 3px;
            }

            #post-body:after {
                display: table;
                clear: both;
                content: ' ';
            }
            /* TABLE */
            #table_units td.votes_count, #table_units td.user_id, #table_units td.user_ip, #table_units td.added {
                text-align: center;
            }
            #table_units td.img {
                width: 45px;
                padding: 3px 2px;
                text-align: center;
                position: relative;
            }
            #table_units td.img.dropbox:before {
                position: absolute;
                left: 30%;
                top: 3px;
                background: url(<?php echo plugins_url('wp-foto-vote/assets/img/admin/dropbox.png') ?>);
                background-size: cover;
                width: 24px;
                height: 22px;
                content: '';
            }
            #table_units td.img.vimeo:before,
            #table_units td.img.youtube:before,
            #table_units td.img.cloudinary:before {
                font-family: 'icomoon_fv';
                speak: none;
                font-style: normal;
                font-weight: normal;
                font-variant: normal;
                text-transform: none;
                line-height: 1;
                -webkit-font-smoothing: antialiased;

                position: absolute;
                left: 35%;
                top: 3px;
                content: "\e60f";
                font-size: 24px;
                line-height: 26px;

                width: 24px;
                height: 22px;
                color: rgb(94, 232, 247);
            }
            #table_units td.img.cloudinary:before {
                content: "\e600";
            }
            #table_units td.img.cloudinary.rotated:before {
                content: "\e648";
            }

            #table_units td.votes_count {
                width: 70px;
            }
            #table_units td.user_id {
                width: 70px;
            }
            #table_units td.added {
                width: 70px;
            }
            #table_units td.actions {
                width: 140px;
                min-width: 160px;
                padding: 10px 4px;
            }

            @media (max-width: 1430px) {
                #table_units tbody tr td.user_id, #table_units thead tr th:nth-child(7) {
                    display: none;
                }
            }
            @media (max-width: 1340px) {
                #table_units tbody tr td.description, #table_units thead tr th:nth-child(3) {
                    display: none;
                }
            }
            @media (max-width: 1200px) {
                #table_units tbody tr td.upload_info, #table_units thead tr th:nth-child(5) {
                    display: none;
                }
            }


        </style>

        <form name="post" action="<?php echo admin_url( 'admin.php?page=fv&action=edit&contest=' ); ?><?php echo ($action == 'add') ? '-1' : $contest->id ?>" method="post" id="post">
            <?php wp_nonce_field( 'fv_edit_contest_action','fv_edit_contest_nonce' ); ?>
            <input type="hidden" name="contest_id" value="<?php echo ($action == 'add') ? '-1' : $contest->id ?>">

            <div id="poststuff">
                <div class="metabox-holder columns-1">
                    <div id="fv_votes_workplace" class="postbox ">
                        <div class="handlediv" title="Нажмите, чтобы переключить"><br></div>
                        <h3 class="hndle"><span><?php echo __('Contestants', 'fv'); ?></span></h3>
                        <div class="inside b-wrap">
                            <?php if ($action != 'add'): ?>
                                <div id="sv_table" class="table-responsive" >
                                    <table id="table_units" class="display">
                                        <thead>
                                        <tr>
                                            <th><?php echo __('Thumb', 'fv') ?></th>
                                            <th><?php echo __('Name', 'fv') ?></th>
                                            <th><?php echo __('Description', 'fv') ?></th>
                                            <th><?php echo __('Votes count', 'fv') ?></th>
                                            <th><?php echo __('Upload info', 'fv') ?></th>
                                            <th><?php echo __('User email', 'fv') ?></th>
                                            <th><?php echo __('User id', 'fv') ?></th>
                                            <th><?php echo __('User ip', 'fv') ?></th>
                                            <th><?php echo __('Status', 'fv') ?></th>
                                            <th><?php echo __('Added', 'fv') ?></th>
                                            <th><?php echo __('Actions', 'fv') ?></th>
                                        </tr>
                                        </thead>
                                        <?php
                                        $contestClass = new FV_Contest();
                                        $contest = $contestClass->get_contest($contest_id);
                                        $user_ID = get_current_user_id();

                                        foreach ($contest->items as $unit) :
                                            /*
                                             ** Params $unit - contestant item
                                             */
                                            if ($unit->user_id == $user_ID){
                                                //$image_src = ($unit->image_id)? wp_get_attachment_image_src($unit->image_id) : '';
                                                FV_Admin::assets_page_edit_contest();
                                                $image_src = FvFunctions::getPhotoThumbnailArr($unit);
                                                $img_class = '';
                                                if ( isset($image_src[4]) ) {
                                                    $img_class= $image_src[4];
                                                } elseif ( isset($unit->options['provider']) ) {
                                                    $img_class = $unit->options['provider'];
                                                }
                                                ?>
                                                <tbody>
                                                    <tr class="id<?php echo $unit->id ?> status<?php echo $unit->status ?> <?php echo ( isset($edit) )? 'edited' : ''; ?>">
                                                        <td class="img <?php echo $img_class ?>"><a href="<?php echo $unit->url ?>" target="_blank"><img src="<?php echo ( is_array($image_src) )? $image_src[0] : ''; ?>" width="50" /></a></td>
                                                        <td class="name"><?php echo $unit->name ?></td>
                                                        <td class="description"><?php echo $unit->description ?></td>
                                                        <td class="votes_count"><?php echo $unit->votes_count ?></td>
                                                        <td class="upload_info"><?php echo FvFunctions::showUploadInfo($unit->upload_info); ?></td>
                                                        <td class="user_email"><?php echo $unit->user_email ?></td>
                                                        <td class="user_id"><a href="><?php echo $unit->user_id ?></a></td>
                                                        <td class="user_ip"><?php echo $unit->user_ip ?></td>
                                                        <td><?php echo __(fv_get_status_name($unit->status), 'fv') ?></td>
                                                        <td class="added"><?php echo date('d/m/Y',$unit->added_date) ?></td>
                                                        <td class="actions">
                                                            <a href="#0" onclick="fv_form_contestant(this, <?php echo $unit->contest_id ?>, <?php echo $unit->id ?>, '<?php echo wp_create_nonce('fv_nonce') ?>'); return false;"><?php _e('Edit', 'fv') ?></a>
                                                            / <a href="#0" onclick="fv_delete_contestant(this, <?php echo $unit->id ?>, <?php echo $unit->contest_id ?>, '<?php echo wp_create_nonce('fv_nonce') ?>'); return false;"><?php _e('Delete', 'fv') ?></a>
                                                            <a href="#0" title="<?php _e("rotate right", 'fv') ?>" onclick="fv_rotate_image(this, 270, <?php echo $unit->contest_id ?>, <?php echo $unit->id ?>, '<?php echo wp_create_nonce('fv_nonce') ?>'); return false;"><span class="dashicons dashicons-imgedit-rright rotate_img"></span></a>

                                                            <a href="#0" title="<?php _e("rotate left", 'fv') ?>" onclick="fv_rotate_image(this, 90, <?php echo $unit->contest_id ?>, <?php echo $unit->id ?>, '<?php echo wp_create_nonce('fv_nonce') ?>'); return false;"><span class="dashicons dashicons-imgedit-rleft rotate_img"></span></a>
                                                        </td>
                                                    </tr>
                                                </tbody>

                                            <?php }
                                        endforeach; ?>
                                    </table>
                                </div>

                                <button type="button" onclick="fv_form_contestant(this, <?php echo $contest->id ?>, '', '<?php echo wp_create_nonce('fv_nonce') ?>'); return false;" class="button">
                                    <span class="dashicons dashicons-welcome-add-page"></span><?php echo __('Add one photo', 'fv'); ?>
                                </button>
                                <button type="button" onclick="fv_many_contestants(this, <?php echo $contest->id ?>, '<?php echo wp_create_nonce('fv_nonce') ?>'); return false;" class="button">
                                    <span class="dashicons dashicons-welcome-add-page"></span><?php echo __('Add many photos (test mode)', 'fv'); ?>
                                </button>
                                <input type="button" onclick="contestTable.draw(); return false;" value="<?php echo __('Redraw table', 'fv'); ?>" class="button">
                            <?php else: ?>
                                <h2><?php echo __('Save contest for editing contestants!', 'fv'); ?></h2>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <br class="clear">
            </div><!-- /poststuff -->
        </form>

    </div>  <!-- .wrap :: END -->

    <!-- edit contestat popup -->
    <div class="modal fade b-wrap" id="fv_popup" tabindex="-1" role="dialog" aria-labelledby="fv_popup_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>


<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>