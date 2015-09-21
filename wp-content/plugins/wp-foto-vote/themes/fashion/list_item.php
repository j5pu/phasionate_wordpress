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
*** OTHER ***
 * $leaders - is this leaders block? (bool)
 * $fv_block_width - contest block width (int)
 * $public_translated_messages - TRANSLATED MESSAGES (array)
 * $contest_id - CONTEST ID (int)
 * $page_url - PAGE URL (string)
 * $theme - USED THEME (string)
 * $konurs_enabled - IS CONTEST ENABLED (bool)
 * $upload_info - json decoded Upload form fields
 */
?>

<li class="wrap-post box- mosaic-2 column-3 pr-thumb-port contest-block">
    <div class="wrap-image">
        
        <div class="wrap-caption shape-10">
            <div class="caption-post entry-caption-1 animated-1">
                <div class="btn-caption">
                    <span class="btn-preview animated-1"  data-id="<?php echo $id; ?>" onclick="$jQ('a[name=photo-<?php echo $id ?>]').click();">
                        <i class="fvicon-expand"></i>
                    </span>
                    <?php if ($konurs_enabled): ?>
                        <span class="btn-permalink animated-1 fv_vote" onclick="sv_vote(<?php echo $id ?>)" title="<?php echo $public_translated_messages['vote_button_text'] ; ?>">
                            <i class="fvicon-heart"></i>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="caption-elements">
                    <a name="photo-<?php echo $id ?>"  data-id="<?php echo $id; ?>" rel="fw" class="caption-title fv_lightbox" href="<?php echo $image_full ?>">
                        <?php echo $name ?></a>
                    <?php if (mb_strlen($additional, 'UTF-8') > 0): ?>
                        <div class="caption-subtitle "><?php echo substr($additional, 0, 60, 'UTF-8') ?></div>
                    <?php endif;?>
                    <div class="meta-caption">
                        <span><?php echo $public_translated_messages['vote_count_text']; ?>: &nbsp;</span><span class="sv_votes_<?php echo $id ?>"><?php echo $votes ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="wrap-post-image">
            <div class="post-image hover-1" 
                style="background-image:<?php echo sprintf('url(%s);', $image_full); ?>); ">                     
            </div>                
        </div>    
        
    </div>
</li>
