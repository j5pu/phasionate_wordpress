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

<div class="sv_unit contest-block" style="width: <?php echo get_option('fotov-block-width', FV_CONTEST_BLOCK_WIDTH) ; ?>px;">
    <a name="photo-<?php echo $id?>" ></a>
    <div class="sv_unit_bg" id="sv_unit_<?php echo$id ?>">
        <div align="center" class="contest-block--img">
            <a name="photo-<?php echo $id?>"  data-id="<?php echo $id; ?>" class="fv_lightbox" rel="fw" href="<?php echo $image_full ?>" title="<?php echo htmlspecialchars(stripslashes($name)) ?>"  style="cursor: pointer;">
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
        <div class="contest-block--title">
            <div class="contest-block--title-name"><?php echo $name; ?></div>
            <div class="contest-block--title-votes">
                <?php if( $hide_votes == false ): ?>
                    <span class="contest-block--title-votes-count sv_votes_<?php echo $id ?>" title="<?php echo $public_translated_messages['vote_count_text']; ?>: "> <?php echo $votes ?> </span>
                <?php endif; ?>
                <?php do_action('fv/contest_list_item/actions_hook', $photo, $konurs_enabled, $theme); ?>
            </div>

            <div style="clear:both;"> </div>
        </div>
    </div>
    
    <?php if ($konurs_enabled): ?>
	<div class="fv_button"><input type="button" class="fv_vote"  id="action_button" value="<?php echo $public_translated_messages['vote_button_text']; ?>" onclick="sv_vote(<?php echo $id ?>)" /></div>
    <?php endif; ?>
</div>

