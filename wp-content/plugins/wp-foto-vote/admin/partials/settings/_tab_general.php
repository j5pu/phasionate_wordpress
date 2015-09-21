<table class="form-table">

    <!-- ============ Design BLOCK ============ -->
    <tr valign="top" class="no-padding">
        <td colspan="3"><h3><?php _e('Design', 'fv') ?></h3></td>
    </tr>

    <tr valign="top" class="important">
        <th scope="row"><?php _e('Contest block design', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e('Select how your contest block will looks.', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>

        <td>
            <select name="fv[theme]" class="form-control">
                <?php foreach (fv_get_themes_arr() as $key => $theme_title): ?>
                    <option value="<?php echo $key ?>" <?php selected( FvFunctions::ss('theme', 'pinterest'), $key ); ?>><?php echo $theme_title ?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>

    <tr valign="top" class="important">
        <th scope="row"><?php _e('Contest block width (min. 180 px.)', 'fv') ?> </th>
        <td class="tooltip">
            <div class="box" title="<?php _e('Change to fit the width of the voting blocks your site', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="number" name="fotov-block-width" value="<?php echo get_option('fotov-block-width', FV_CONTEST_BLOCK_WIDTH); ?>" min="0" max="1000"/> px.
        </td>
    </tr>
    <tr valign="top" class="important">
        <th scope="row"><?php _e('Thumbnail image size <small>(used <a href="https://github.com/bfintal/bfi_thumb">BFI Thumb lib</a>, changes on the fly)</small>', 'fv') ?> </th>
        <td class="tooltip">
            <div class="box" title="<?php _e('Thumbnails size in photos list, better not much more than `Contest block size`', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td> width:<input type="number" name="fotov-image-width" value="<?php echo get_option('fotov-image-width', 220); ?>" min="0" max="1200"/> px. /
            height:<input type="number" name="fotov-image-height" value="<?php echo get_option('fotov-image-height', 220); ?>" min="0" max="1200"/> px.
            / <?php _e('jpeg quality', 'fv') ?>(0-100)
            <input type="number" name="fv[thumb-quality]" value="<?php echo FvFunctions::ss('thumb-quality', 80); ?>" min="10" max="100"/> %
            <br/>
            <?php _e('If you not need hard crop size, then set up one size to 0, as example 280*0 will not crop image by height.', 'fv') ?><br/>
            <small><?php _e('If you used Dropbox or Cloudinary, use this option for set hard crop:', 'fv') ?></small>
            <?php fv_get_tooltip_code(__('It means thumbnail size will be 100% equal (if checked) <br/>or proportional on the larger side.', 'fv')) ?>:
            <input type="checkbox" name="fotov-image-hardcrop" <?php echo checked( get_option('fotov-image-hardcrop', false), "on" ); ?>/>
            <br/><small><?php _e('Decrease image quality will decrease it size.', 'fv') ?></small>

        </td>
    </tr>

    <tr valign="top" class="important">
        <th scope="row"><?php _e('List contest block width (min. 180 px.) <small>Can be overridden in `fv_contests_list` shortcode</small>', 'fv') ?> </th>
        <td class="tooltip">
            <div class="box" title="<?php _e('Change to fit the width of the contest list blocks your site', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="number" name="fv[list-block-width]" value="<?php echo FvFunctions::ss('list-block-width', FV_CONTEST_BLOCK_WIDTH); ?>" min="0" max="1000"/> px.
        </td>
    </tr>
    <tr valign="top">
        <th scope="row"><?php _e('Contest list thumbnail image size <small>(used <a href="https://github.com/bfintal/bfi_thumb">BFI Thumb lib</a>, changes on the fly)</small>', 'fv') ?> </th>
        <td class="tooltip">
            <div class="box" title="<?php _e('Thumbnails size in photos list, better not much more than `Contest block size`', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td> width:<input type="number" name="fv[list-thumb-width]" value="<?php echo FvFunctions::ss('list-thumb-width', 200); ?>" min="0" max="1200"/> px. /
            height:<input type="number" name="fv[list-thumb-height]" value="<?php echo FvFunctions::ss('list-thumb-height', 200); ?>" min="0" max="1200"/> px.
            / <?php _e('jpeg quality', 'fv') ?>(0-100)
            <input type="number" name="fv[list-thumb-quality]" value="<?php echo FvFunctions::ss('list-thumb-quality', 80); ?>" min="10" max="100"/> %
            <br/><?php _e('If you not need hard crop size, then set up one size to 0, as example 280*0 will not crop image by height.', 'fv') ?><br/>
        </td>
    </tr>

    <tr valign="top" class="no-padding">
        <td colspan="3"><hr/></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Enable lazy load images?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e('If you enable this, on page load lads just 3 images, <br/>other just user scroll page', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fv[lazy-load]" <?php echo ( FvFunctions::ss('lazy-load') ) ? 'checked' : ''; ?>/> <?php _e('Yes', 'fv') ?>
            &nbsp;<small>(Not works in Pinterest, Flikr and Fashion theme)</small>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Hide votes count?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e('If you don`t want show to users votes count, check it', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fv[hide-votes]" <?php echo ( FvFunctions::ss('hide-votes') ) ? 'checked' : ''; ?>/> <?php _e('Hide', 'fv') ?>
            <small>(Don`t remember also remove votes count from "Lightbox title format")</small>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Enable cache support?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e('If you using cache plugins, after refresh page votes will not changes.<br/> For fix this plugin will AJAX update votes on page after it loaded.', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fv[cache-support]" <?php echo ( FvFunctions::ss('cache-support') ) ? 'checked' : ''; ?>/> <?php _e('Yes', 'fv') ?>
            &nbsp; <small>(Does not works, if in wp-config.php not defined "WP_CACHE")</small>
        </td>
    </tr>

    <tr valign="top" class="no-padding">
        <td colspan="3"><hr/></td>
    </tr>

    <tr valign="top" class="important">
        <th scope="row"><?php _e('Show toolbar (under contest)?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e('If want allow user change photos order and it looks good on your design, then enable it.', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fv[show-toolbar]" <?php checked( FvFunctions::ss('show-toolbar', false) ); ?>/> <?php _e('Yes', 'fv') ?>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Toolbar background color', 'fv') ?></th>
        <?php echo fv_get_td_tooltip_code( __('Toolbar background color', 'fv') ); ?>
        <td class="colorpicker">
            <input type="text" name="fv[toolbar-bg-color]" class="color" value="<?php echo FvFunctions::ss('toolbar-bg-color', '#232323', 7); ?>"/>
            Select color <button type="button" onclick="fv_reset_color(this, '#232323');">reset</button>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Toolbar text / links color', 'fv') ?></th>
        <?php echo fv_get_td_tooltip_code( __('Text and link color placed on Toolbar', 'fv') ); ?>
        <td class="colorpicker">
            <input type="text" name="fv[toolbar-text-color]" class="color" value="<?php echo FvFunctions::ss('toolbar-text-color', '#FFFFFF', 7); ?>"/>
            Select color <button type="button" onclick="fv_reset_color(this, '#FFFFFF');">reset</button>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Toolbar active links background', 'fv') ?></th>
        <?php echo fv_get_td_tooltip_code( __('Link active background color placed on Toolbar', 'fv') ); ?>
        <td class="colorpicker">
            <input type="text" name="fv[toolbar-link-abg-color]" class="color" value="<?php echo FvFunctions::ss('toolbar-link-abg-color', '#454545', 7); ?>"/>
            Select color <button type="button" onclick="fv_reset_color(this, '#454545');">reset</button>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Toolbar select color', 'fv') ?></th>
        <?php echo fv_get_td_tooltip_code( __('Input and select fields placed on Toolbar background color', 'fv') ); ?>
        <td class="colorpicker">
            <input type="text" name="fv[toolbar-select-color]" class="color" value="<?php echo FvFunctions::ss('toolbar-select-color', '#1f7f5c', 7); ?>"/>
            Select color <button type="button" onclick="fv_reset_color(this, '#1f7f5c');">reset</button>
        </td>
    </tr>

    <tr valign="top" class="no-padding">
        <td colspan="3"><hr/></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Show social buttons after voting?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e("If you don't want see a social buttons after voting - check it", 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fotov-voting-noshow-social" <?php echo ( get_option('fotov-voting-noshow-social', false) ) ? 'checked' : ''; ?>/> <?php _e('No show', 'fv') ?>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row"><?php _e('How social buttons not show?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e('Select - how social buttons not show after voting', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td class="socials">
            <span><?php _e('Vkontake', 'fv') ?>:</span> <input type="checkbox" name="fotov-voting-noshow-vk" <?php echo ( get_option('fotov-voting-noshow-vk', false) ) ? 'checked' : ''; ?>/> <?php _e('No show', 'fv') ?> <br />
            <span><?php _e('Facebook', 'fv') ?>:</span>  <input type="checkbox" name="fotov-voting-noshow-fb" <?php echo ( get_option('fotov-voting-noshow-fb', false) ) ? 'checked' : ''; ?>/> <?php _e('No show', 'fv') ?> <br />
            <span><?php _e('Twitter', 'fv') ?>:</span>  <input type="checkbox" name="fotov-voting-noshow-tw" <?php echo ( get_option('fotov-voting-noshow-tw', false) ) ? 'checked' : ''; ?>/> <?php _e('No show', 'fv') ?> <br />
            <span><?php _e('Odnoklasniki', 'fv') ?>:</span>  <input type="checkbox" name="fotov-voting-noshow-ok" <?php echo ( get_option('fotov-voting-noshow-ok', false) ) ? 'checked' : ''; ?>/> <?php _e('No show', 'fv') ?> <br />
            <span><?php _e('Google+', 'fv') ?>:</span>  <input type="checkbox" name="fotov-voting-noshow-gp" <?php echo ( get_option('fotov-voting-noshow-gp', false) ) ? 'checked' : ''; ?>/> <?php _e('No show', 'fv') ?> <br />
            <span><?php _e('Pinterest', 'fv') ?>:</span>  <input type="checkbox" name="fotov-voting-noshow-pi" <?php echo ( get_option('fotov-voting-noshow-pi', false) ) ? 'checked' : ''; ?>/> <?php _e('No show', 'fv') ?> <br />
            <span><?php _e('Email share', 'fv') ?>:</span>  <input type="checkbox" name="fotov-voting-noshow-email" <?php echo ( get_option('fotov-voting-noshow-email', false) ) ? 'checked' : ''; ?>/> <?php _e('No show', 'fv') ?> <small><?php _e('Required <a href="#0" onclick="jQuery(\'a[data-content=\x22additional\x22]\').click();">ReCaptcha Api key</a>', 'fv') ?></small>
        </td>
    </tr>

    <tr valign="top" class="no-padding">
        <td colspan="3"><hr/></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Open contest image in new page?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e("If did't want use lightbox or want add more description<br/> about photo - use this option.", 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fotov-photo-in-new-page" <?php echo ( get_option('fotov-photo-in-new-page', false) ) ? 'checked' : ''; ?>/> <?php _e('Yes', 'fv') ?>
            <small><?php _e('(Now works only in `new_year`, `flickr` and `default` theme) and not compatible with Ajax pagination', 'fv') ?></small>
        </td>
    </tr>

    <tr valign="top" class="no-padding">
        <td colspan="3"><hr/></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Pagination', 'fv') ?></th>
        <?php echo fv_get_td_tooltip_code( __('Break photos into pages', 'fv') ); ?>
        <td>
            <input type="number" name="fv[pagination]" value="<?php echo FvFunctions::ss('pagination', 0); ?>" min="0" max="200"/>
            <?php _e('Per page', 'fv') ?>
            &nbsp;<small>(if number < 8, pagination will be disabled)</small>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row"><?php _e('Pagination type', 'fv') ?></th>
        <?php echo fv_get_td_tooltip_code( __('Pagination type - simply or ajax', 'fv') ); ?>
        <td>
            <select name="fv[pagination-type]">
                <option value="default" <?php selected( FvFunctions::ss('pagination-type', 'default'), 'default' ); ?>>default</option>
                <option value="ajax" <?php selected( FvFunctions::ss('pagination-type', 'default'), 'ajax' ); ?>>ajax</option>
                <option value="infinite" <?php selected( FvFunctions::ss('pagination-type', 'default'), 'infinite' ); ?>>Infinite scroll</option>
            </select>
            &nbsp;<small>(ajax works faster without refresh page, but may not always works)</small>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Scroll to contest after go to next/prev page?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e('If you enable this, after clicking into page number, <br/>and reload page it will scrolled to photos', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fv[pagination-scroll-to-contest]" <?php echo ( FvFunctions::ss('pagination-scroll-to-contest') ) ? 'checked' : ''; ?>/> <?php _e('Yes', 'fv') ?>
        </td>
    </tr>

    <tr valign="top" class="no-padding">
        <td colspan="3">
            <hr/>
            <input type="submit" class="button-primary" value="<?php _e('Save all Changes', 'fv') ?>" /> &nbsp;<small>You can save here, if not wan't scroll to bottom.</small><br>
            <hr/>
        </td>
    </tr>
    <!-- ============ Leaders Vote ============ -->
    <tr valign="top" class="no-padding">
        <td colspan="3"><h3><?php _e('Voting leaders', 'fv') ?></h3></td>
    </tr>

    <tr valign="top" class="important">
        <th scope="row"><?php _e('Hide vote leaders block', 'fv') ?>:</th>
        <td class="tooltip">
            <div class="box" title="<?php _e('Check option, if you don`t want to show voting leaders', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fotov-leaders-hide" <?php echo ( get_option('fotov-leaders-hide', false) ) ? 'checked' : ''; ?>/> <?php _e('Yes', 'fv') ?>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('How many leaders show in page?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e('Select count of voting leaders', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <select name="fotov-leaders-count">
                <option value="3" <?php selected('3', get_option('fotov-leaders-count')); ?>><?php _e('Three', 'fv') ?></option>
                <option value="2" <?php selected('2', get_option('fotov-leaders-count')); ?>><?php _e('Two', 'fv') ?></option>
                <option value="1" <?php selected('1', get_option('fotov-leaders-count')); ?>><?php _e('One', 'fv') ?></option>
                <option value="4" <?php selected('4', get_option('fotov-leaders-count')); ?>><?php _e('Four', 'fv') ?></option>
            </select>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Leaders block type?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e('Select - how to display contest leaders?', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <select name="fotov-leaders-type">
                <option value="text" <?php selected('text', get_option('fotov-leaders-type')); ?>><?php _e('Text', 'fv') ?></option>
                <option value="block" <?php selected('block', get_option('fotov-leaders-type')); ?>><?php _e('Block', 'fv') ?></option>
                <option value="theme" <?php selected('theme', get_option('fotov-leaders-type')); ?>><?php _e('Theme styling', 'fv') ?></option>
            </select>
            <small><?php _e('Theme styling', 'fv') ?> - <?php _e('works not in all themes.', 'fv') ?></small>
        </td>
    </tr>

    <tr valign="top" class="no-padding">
        <td colspan="3"><hr/></td>
    </tr>
    <!-- ============ Lightbox BLOCK ============ -->
    <tr valign="top" class="no-padding">
        <td colspan="3"><h3><?php _e('Lightbox settings', 'fv') ?></h3></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Disable plugin lightbox?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e('If you have some conflicts with you standard lightbox(image preview plugin), check it', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fotov-voting-no-lightbox" <?php echo ( get_option('fotov-voting-no-lightbox', false) ) ? 'checked' : ''; ?>/> <?php _e('Disable', 'fv') ?>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Lightbox title format?', 'fv') ?></th>
        <td class="tooltip">
            <div class="box" title="<?php _e('You can change text, that show in lightbox', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input name="fv[lightbox-title-format]" class="all-options" value="<?php echo ( isset($settings['lightbox-title-format']) ) ? $settings['lightbox-title-format'] : '{name} <br/>{votes}'; ?>"/> <br/>
            <small>You can use {name}, {votes}, {description}</small>
        </td>
    </tr>

    <!-- ============ Custom CSS BLOCK ============ -->
    <tr valign="top" class="no-padding">
        <td colspan="3"><h3><?php _e('Custom CSS', 'fv') ?></h3></td>
    </tr>

    <tr valign="top">
        <th scope="row" style="vertical-align: middle;"><?php _e('Custom CSS styles', 'fv') ?>:</th>
        <td class="tooltip">
            <div class="box" title="<?php _e('If you want do little customization,<br/> use this textarea.', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <textarea name="fotov-custom-css" class="large-text" rows="5" cols="70"><?php echo get_option('fotov-custom-css', ''); ?></textarea> <br/>
            <small><?php _e('Add some styles. "Ctrl + Enter" to show autocomplete.', 'fv') ?></small>
        </td>
    </tr>


</table>