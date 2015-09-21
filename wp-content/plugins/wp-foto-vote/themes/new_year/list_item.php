<?php
defined('ABSPATH') or die("No script kiddies please!");
/*
 * === Variables passed to this script: ===
 *** PHOTO DATA ***
 * $id - PHOTO ID (int)
 * $thumbnail - PHOTO THUMBNAIL SRC (array [0] - src, [1] - width, [2] - height)
 * $image_full - PHOTO FULL SRC (string)
 * $name - PHOTO NAME (string)
 * $description - PHOTO DESCRIPTION (string)
 * $additional - PHOTO ADDITIONAL DESCRIPTION (string), uses as <code> mb_substr($additional, 0, 30, 'UTF-8') </code>
 * $votes - PHOTO VOTES COUNT (int)
 * $upload_info - json decoded Upload form fields*
*** OTHER ***
 * $leaders - is this leaders block? (bool)
 * $fv_block_width - contest block width (int)
 * $public_translated_messages - TRANSLATED MESSAGES (array)
 * $contest_id - CONTEST ID (int)
 * $page_url - PAGE URL (string)
 * $theme - USED THEME (string)
 * $konurs_enabled - IS CONTEST ENABLED (bool)
 */
?>

<div class="fv_constest_item contest-block" style="width: <?php echo $fv_block_width . 'px'; ?>;">
    <div class="fv_photo" style="width: <?php echo $thumbnail[1] ?>px;">
        <div class="go_vote_text"><?php echo $public_translated_messages['vote_button_text']; ?></div>
        <div class="fv_photo_votes">
            <?php if ($konurs_enabled): ?>  
                <a href="#" class="fv_vote"  onclick="sv_vote(<?php echo $id ?>); return false;">
                    <?php if( $hide_votes == false ): ?>
                    + <span class="sv_votes_<?php echo $id ?>"><?php echo $votes ?></span>
                    <?php else: ?>
                        + 1
                    <?php endif; ?>
                </a>
            <?php else: ?>  
                    + <span class="sv_votes_<?php echo $id ?>"><?php echo $votes ?></span>
            <?php endif; ?>               
        </div>
		 <a name="<?php echo 'photo-'.$id; ?>"  data-id="<?php echo $id; ?>"  class="<?php if( !fv_photo_in_new_page($theme) ): ?> fv_lightbox nolightbox <?php endif; ?>" rel="fw"
           href="<?php echo $image_full ?>" title="<?php echo htmlspecialchars(stripslashes($name)) ?>" style="cursor: pointer;">
            <img src="<?php echo $thumbnail[0] ?>" />
        </a>
    </div>
    
    <div class="fv_name">
        <span><?php echo $name ?></span>
    </div>
    
    <div class="fv_description"><?php echo $additional ?></div>    
    
    <div class="fv_social">
        <div class="fv_social_icons">
            <?php if (!get_option('fotov-voting-noshow-vk', false)): ?>
                <a href="#" onclick="return sv_vote_send('vk', this ,<?php echo $id ?>)" target="_blank"><img src="<?php echo plugins_url('wp-foto-vote/themes/new_year/img/soc-vk.png') ?>" /></a>
            <?php endif; ?>
            <?php if (!get_option('fotov-voting-noshow-fb', false)): ?>
                <a href="#" onclick="return sv_vote_send('fb', this,<?php echo $id ?>)" target="_blank"><img src="<?php echo plugins_url('wp-foto-vote/themes/new_year/img/soc-fb.png') ?>" /></a>
            <?php endif; ?>
            <?php if (!get_option('fotov-voting-noshow-tw', false)): ?>
                <a href="#" onclick="return sv_vote_send('tw', this,<?php echo $id ?>)" target="_blank"><img src="<?php echo plugins_url('wp-foto-vote/themes/new_year/img/soc-tw.png') ?>" /></a>
            <?php endif; ?>
            <?php if (!get_option('fotov-voting-noshow-ok', false)): ?>
                <a href="#" onclick="return sv_vote_send('ok', this,<?php echo $id ?>)" target="_blank"><img src="<?php echo plugins_url('wp-foto-vote/themes/new_year/img/soc-ok.png') ?>" /></a>
            <?php endif; ?>
            <?php if (!get_option('fotov-voting-noshow-gp', false)): ?>
                <a href="#" onclick="return sv_vote_send('gp', this,<?php echo $id ?>)" target="_blank"><img src="<?php echo plugins_url('wp-foto-vote/themes/new_year/img/soc-gp.png') ?>" /></a>
            <?php endif; ?>
            <?php if (!get_option('fotov-voting-noshow-pi', false)): ?>
                <a href="#" onclick="return sv_vote_send('pi', this,<?php echo $id ?>)" target="_blank"><img src="<?php echo plugins_url('wp-foto-vote/themes/new_year/img/soc-pi.png') ?>" /></a>
            <?php endif; ?>     
        </div>
    </div>
    
</div>