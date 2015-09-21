<?php
defined('ABSPATH') or die("No script kiddies please!");
/*
 * === Variables passed to this script: ===
 *** PHOTO DATA ***
 * $photo - PHOTO (object)
 * $id - PHOTO ID (int)
 * $thumbnail - PHOTO THUMBNAIL SRC (array [0] - src, [1] - width, [2] - height)
 * $image_full - PHOTO FULL SRC (string)
 * $name - PHOTO NAME (string)
 * $description - PHOTO DESCRIPTION (string)
 * $additional - PHOTO ADDITIONAL DESCRIPTION (string), uses as <code> mb_substr($additional, 0, 30, 'UTF-8') </code>
 * $votes - PHOTO VOTES COUNT (int)
*** OTHER ***
 * $leaders - is this leaders block? (bool)
 * $fv_block_width - contest block width (int)
 * $public_translated_messages - TRANSLATED MESSAGES (array)
 * $contest_id - CONTEST ID (int)
 * $page_url - PAGE URL (string)
 * $theme - USED THEME (string)
 * $konurs_enabled - IS CONTEST ENABLED (bool)
 * $upload_info - json decoded Upload form fields
 * $hide_votes - NEED HIDE VOTES? (bool)
 */

?>

<div class="contest-block <?php echo (!$konurs_enabled)? 'ended': ''; ?>" style="width: <?php echo get_option('fotov-block-width', FV_CONTEST_BLOCK_WIDTH) ; ?>px;">

        <div class="spinner">
            <span class="fvicon-spinner icon rotate-animation"></span>
        </div>

        <?php
        if ( $leaders ) {
            echo sprintf('<img src="%s" class="attachment-thumbnail" />', $thumbnail[0]);
        } else {
            if ( !FvFunctions::lazyLoadEnabled($theme) ) {
                echo sprintf('<img src="%s" width="%s" class="attachment-thumbnail" />', $thumbnail[0], $thumbnail[1]);
            } else {
                echo sprintf('<img src="" data-original="%s" width="%s" class="attachment-thumbnail fv-lazy" />', $thumbnail[0], $thumbnail[1]);
            }
        }
        ?>
                    
        <div class="vote-heart fv_button fv_vote" onclick="sv_vote(<?php echo $id ?>, 'vote', this);">
            <span class="fvicon-heart"></span>
            <?php if( $hide_votes == false ): ?>
                <span class="sv_votes sv_votes_<?php echo $id ?><?php echo (!$konurs_enabled)? ' ended': ''; ?>"><?php echo $votes ?></span>
            <?php endif; ?>
        </div>
                 

        <a name="photo-<?php echo $id ?>"  data-id="<?php echo $id; ?>" class="fv_lightbox no-lightbox nolightbox" rel="fw" href="<?php echo $image_full ?>" title="<?php echo htmlspecialchars(stripslashes($name)) ?>" style="cursor: pointer;">
            <span class="fvicon-expand"></span>
        </a>

</div>