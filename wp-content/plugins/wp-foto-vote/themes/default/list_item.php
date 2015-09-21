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
 * $hide_votes - NEED HIDE VOTES? (bool)
 */
?>

<div class="sv_unit contest-block" style="width: <?php echo ( !$leaders )? $fv_block_width . 'px' : $fv_block_width . '%' ; ?>;">
    <a name="photo-<?php echo $id?>" ></a>
    <div class="sv_unit_bg" id="sv_unit_<?php echo $id?>">
        <div align="center" class="unit_pic">
            <a name="photo-<?php echo $id?>"  data-id="<?php echo $id; ?>" class="<?php if( !fv_photo_in_new_page($theme) ): ?>fv_lightbox nolightbox<?php endif; ?>" rel="fw" href="<?php echo $image_full ?>" title="<?php echo htmlspecialchars(stripslashes($name)) ?>" style="cursor: pointer;">
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
            </a>
        </div>
        <div class="sv_title">
            <div class="clearfix"></div>
            <div class="sv_name"><?php echo mb_substr($name, 0, 30, 'UTF-8') ?></div>
            <?php if( $hide_votes == false ): ?>
                <div class="sv_votes"> <span class="sv_votes_<?php echo $id?>" title="<?php echo $public_translated_messages['vote_count_text']; ?>: "> <?php echo $votes ?> </span> </div>
            <?php endif; ?>
            <div style="clear:both;"> </div>
        </div>
    </div>
    <div class="clearfix"></div>

	<div class="fv_button">
        <?php if ($konurs_enabled): ?>
            <input type="button" class="fv_vote"  id="action_button" value="<?php echo $public_translated_messages['vote_button_text']; ?>" onclick="sv_vote(<?php echo $id?>)" />
        <?php endif; ?>
        <a href="#" class="fv-small-action-btn fvicon-share" onclick="FvModal.goShare(<?php echo $id ?>); return false;" ></a>
    </div>

</div>