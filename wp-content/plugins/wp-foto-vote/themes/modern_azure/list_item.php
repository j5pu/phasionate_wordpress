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

<div class="sv_unit contest-block" style="width: <?php echo ( !$leaders )? $fv_block_width . 'px' : $fv_block_width . '%' ; ?>;">
	<div align="center">
            <a name="<?php echo ( !$leaders )? 'photo-'.$id : ''; ?>" data-id="<?php echo $id; ?>" class="<?php if( !fv_photo_in_new_page($theme) ): ?> fv_lightbox nolightbox <?php endif; ?>" rel="fw" href="<?php echo $image_full ?>" title="<?php echo htmlspecialchars(stripslashes($name)) . ' <br/>' . $public_translated_messages['vote_count_text'] . ": <span class='sv_votes_{$id}'>" . $votes . '</span>'; ?>" style="cursor: pointer;">
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
	<div class="contest-block-title"><strong><?php echo $name; ?></strong></div>
	<div class="contest-block-description"><em><?php echo $additional; ?></em></div>
        <?php if ( !$leaders ): ?>
            <div class="contest-block-votes">
                <?php if( $hide_votes == false ): ?>
                    <?php echo $public_translated_messages['vote_count_text']; ?>:
                    &nbsp;<span class="contest-block-votes-count sv_votes_<?php echo $id ?>"><?php echo $votes ?></span>
                <?php endif; ?>
                <a href="#" class="fv-small-action-btn fvicon-share" onclick="FvModal.goShare(<?php echo $id ?>); return false;" ></a>
                <?php do_action('fv/contest_list_item/actions_hook', $photo, $konurs_enabled, $theme); ?>
            </div>

            <?php if ($konurs_enabled): ?>
			<div class="fv_button text-center">
                    <button class="fv_vote" id="action_button" onclick="sv_vote(<?php echo $id ?>)"><i class="hand"><?php echo $public_translated_messages['vote_button_text']; ?></i></button>
                </div>    
            <?php endif; ?>         
        <?php endif; ?>         
</div>