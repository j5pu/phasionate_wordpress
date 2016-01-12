<table class="form-table">

    <!-- ============ Upload BLOCK ============ -->
    <tr valign="top" class="no-padding">
        <td colspan="3"><h3><?php _e('Uploading', 'fv') ?></h3></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Only logged in users can upload photos:', 'fv') ?></th>
        <?php echo fv_get_td_tooltip_code( __('This will hide upload form to un-logged users', 'fv') ); ?>
        <td>
            <input type="checkbox" name="fotov-upload-autorize" <?php echo ( get_option('fotov-upload-autorize', false) ) ? 'checked' : ''; ?>/> <?php _e('Yes', 'fv') ?>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Show default login form, if user not logged in:', 'fv') ?></th>
        <?php echo fv_get_td_tooltip_code( __('You may need add some styles for it looks better', 'fv') ); ?>
        <td>
            <input type="checkbox" name="fv[upload-show-login-form]" <?php checked( FvFunctions::ss('upload-show-login-form') ); ?>/> <?php _e('Yes', 'fv') ?>
            <small>(Note: you can also install <a href="https://wordpress.org/plugins/wordpress-social-login/" target="_blank">wordpress-social-login</a> plugin and social login buttons will automatically shows below form)</small>
        </td>
    </tr>

    <tr valign="top" class="no-padding">
        <td colspan="3"><h3><?php _e('Upload limit', 'fv') ?></h3></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Limit photo upload by email', 'fv') ?>:</th>
        <?php echo fv_get_td_tooltip_code( __('By one email user can`t upload more<br/> then set in contest options <br/>(The maximum number of one user upload photos)', 'fv') ); ?>
        <td>
            <?php fv_admin_echo_switch_toggle( 'fotov-upload-limit-email', get_option('fotov-upload-limit-email', true) ); ?>
            <?php _e('Yes', 'fv') ?> <?php _e('(your must have `email` field in upload form)', 'fv') ?>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row"><?php _e('Limit photo upload by ip', 'fv') ?>:</th>
        <td class="tooltip">
            <div class="box" title="<?php _e('By one ip user can`t upload more<br/> then set in contest options <br/>(The maximum number of one user upload photos)', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fotov-upload-limit-ip" <?php echo ( get_option('fotov-upload-limit-ip', false) ) ? 'checked' : ''; ?>/> <?php _e('Yes', 'fv') ?>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row"><?php _e('Limit photo upload by cookie', 'fv') ?>:</th>
        <td class="tooltip">
            <div class="box" title="<?php _e('In one browser user can`t upload more<br/> then set in contest options <br/>(The maximum number of one user upload photos)', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fotov-upload-limit-cookie" <?php echo ( get_option('fotov-upload-limit-cookie', false) ) ? 'checked' : ''; ?>/> <?php _e('Yes', 'fv') ?> <?php _e('(Not works in ie)', 'fv') ?>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row"><?php _e('Limit photo upload by user id', 'fv') ?>:</th>
        <?php echo fv_get_td_tooltip_code( __('In one browser user can`t upload more<br/> then set in contest options <br/>(The maximum number of one user upload photos)', 'fv') ); ?>
        <td>
            <input type="checkbox" name="fotov-upload-limit-userid" <?php echo ( get_option('fotov-upload-limit-userid', false) ) ? 'checked' : ''; ?>/> <?php _e('Yes', 'fv') ?> <?php _e('(works, if upload enabled only for autorized users AND user are autorized)', 'fv') ?>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Limit uploaded photo size', 'fv') ?>:</th>
        <?php echo fv_get_td_tooltip_code( __('If your did`t have a lot of hosting disc space,<br/> you may limit uploading photo size.<br/> If image will be bigger,<br/> he receive error message like `Photo size more than 2 megabytes!`.', 'fv') ); ?>
        <td>
            <input type="number" name="fotov-upload-photo-limit-size" value="<?php echo get_option('fotov-upload-photo-limit-size', 0); ?>" min="0" max="15000" step="10"/> Kb. <br/>
            <small><?php _e("Enter a valid max size in kilobytes, 1024 Kb = 1 Mb.", "fv") ?></small>
        </td>
    </tr>

    <tr valign="top" class="important">
        <th scope="row"><?php _e('Limit uploaded photo dimensions (not works in old browsers and mobile)', 'fv') ?>:</th>
        <?php echo fv_get_td_tooltip_code( __('Function, that used for retrieving thumbnail image.', 'fv') ); ?>
        <td>
            <select name="fv[upload-limit-dimensions]" class="form-control" onchange="fv_upload_limit_dimensions(this);">
                <option value="no" <?php selected( FvFunctions::ss('upload-limit-dimensions', 'no'), 'no' ); ?>>No</option>
                <option value="size" <?php selected( FvFunctions::ss('upload-limit-dimensions', 'no'), 'size' ); ?>>Size - Image must be smaller or larger then size</option>
                <option value="proportion" <?php selected( FvFunctions::ss('upload-limit-dimensions', 'no'), 'proportion' ); ?>>Proportion - Image must match proportions (like 2:3, 4:3, 16:9) +- 2%</option>
            </select>
            <?php $upl_limit_dimensions = FvFunctions::ss('upl-limit-dimensions'); ?>
            <div class="limit-dimensions-size dimensions-toggle" style="display: <?php echo FvFunctions::ss('upload-limit-dimensions', 'no') == 'size' ? 'block' : 'none'; ?>;">
                width more <input type="number" name="fv[upl-limit-dimensions][s-min-width]" value="<?php echo isset($upl_limit_dimensions['s-min-width'])? $upl_limit_dimensions['s-min-width'] : ''; ?>" min="0" max="6000"/> px.
                height more <input type="number" name="fv[upl-limit-dimensions][s-min-height]" value="<?php echo isset($upl_limit_dimensions['s-min-height'])? $upl_limit_dimensions['s-min-height'] : ''; ?>" min="0" max="6000"/> px.
                and <br/>
                width less <input type="number" name="fv[upl-limit-dimensions][s-max-width]" value="<?php echo isset($upl_limit_dimensions['s-max-width'])? $upl_limit_dimensions['s-max-width'] : ''; ?>" min="0" max="6000"/> px.
                height less <input type="number" name="fv[upl-limit-dimensions][s-max-height]" value="<?php echo isset($upl_limit_dimensions['s-max-height'])? $upl_limit_dimensions['s-max-height'] : ''; ?>" min="0" max="6000"/> px.
                <br/><small><?php _e("Leave empty or 0 values, that not need.", "fv") ?></small>
            </div>
            <div class="limit-dimensions-proportion dimensions-toggle" style="display: <?php echo FvFunctions::ss('upload-limit-dimensions', 'no') == 'proportion' ? 'block' : 'none'; ?>;">
                width: <input type="number" name="fv[upl-limit-dimensions][p-width]" value="<?php echo isset($upl_limit_dimensions['p-width'])? $upl_limit_dimensions['p-width'] : ''; ?>" min="0" max="6000"/> x
                height: <input type="number" name="fv[upl-limit-dimensions][p-height]" value="<?php echo isset($upl_limit_dimensions['p-height'])? $upl_limit_dimensions['p-height'] : ''; ?>" min="0" max="6000"/> (+-2%)
                <br/>
                <small>Example: 1024 * 768 proportion is 4:3.
                    <a target="_blank" href="<?php echo FV::$ASSETS_URL ?>img/aspect_ratio.gif">See more >></a></small>
            </div>
            <br/><small><a target="_blank" href="<?php echo admin_url( 'admin.php?page=fv-translation#upload_messages' ); ?>">Don't remember change message text in Translations!</a></small>
        </td>
    </tr>


    <!-- ============ Resize BLOCK ============ -->
    <tr valign="top" class="no-padding">
        <td><h3><?php _e('Resize images', 'fv') ?></h3></td>
        <td colspan="2">
            <em><?php _e('Automatically resize (i.e. scale down) images after uploading. Save disk space and preserve your layout. Thanks to Daniel Mores (http://mores.cc), A. Huizinga, Jacob Wyke', 'fv') ?></em>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Resize images at upload', 'fv') ?>?</th>
        <td class="tooltip">
            <div class="box" title="<?php _e('You can set the max width, and images
                        <br/>(JPEG, PNG or GIF) will be resized while they are uploaded.
                        <br/>There will not be a copy or backup with the original size.', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="checkbox" name="fotov-upload-photo-resize" <?php echo ( get_option('fotov-upload-photo-resize', false) ) ? 'checked' : ''; ?>/> <?php _e('Yes', 'fv') ?>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row"><?php _e('Max width (about, may vary within this range)', 'fv') ?>:</th>
        <td class="tooltip">
            <div class="box" title="<?php _e('Recommended use only one param - maxwidth or maxheight
                        <br/>, then image not be disproportionate', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="number" name="fotov-upload-photo-maxwidth" size="4" maxlength="4" value="<?php echo get_option('fotov-upload-photo-maxwidth', 0); ?>" min="0" max="3500" step="10"/> px. <br/>
            <small>Enter a valid max width in pixels (e.g. 500). Enter 0 if you only wish to resize to a max height only.</small>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row"><?php _e('Max height (about, may vary within this range)', 'fv') ?>:</th>
        <td class="tooltip">
            <div class="box" title="<?php _e('Recommended use only one param - maxwidth or maxheight
                        <br/>, then image not be disproportionate', 'fv') ?>" data-tipped-options="position: 'top'">
                <span class="dashicons dashicons-info"></span>
                <div class='position topleft'><i></i></div>
            </div>
        </td>
        <td>
            <input type="number" name="fotov-upload-photo-maxheight" value="<?php echo get_option('fotov-upload-photo-maxheight', 0); ?>" min="0" max="3500" step="10"/> px. <br/>
            <small>Enter a valid max height in pixels (e.g. 500). Enter 0 if you only wish to resize to a max width only.</small>
        </td>
    </tr>

    <!-- -->
    <tr valign="top" class="no-padding">
        <td colspan="3"><h3><?php _e('Upload folder', 'fv') ?></h3></td>
    </tr>

    <tr valign="top" class="important">
        <th scope="row"><?php _e('Save uploaded images into custom folder?', 'fv') ?></th>
        <?php echo fv_get_td_tooltip_code( __('If you need later download all images.', 'fv') ); ?>
        <td>
            <input type="checkbox" name="fv[upload-custom-folder]" <?php echo checked(FvFunctions::ss('upload-custom-folder', false)); ?>/> <?php _e('Yes', 'fv') ?> (images will be saved to "wp-content/fv-contest/")
        </td>
    </tr>

    <tr valign="top" class="no-padding">
        <td colspan="3"><hr/></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Enable upload debug?', 'fv') ?>:</th>
        <?php echo fv_get_td_tooltip_code( __('Will log upload process.', 'fv') ); ?>
        <td>
            <input type="checkbox" name="fv[debug-upload]" <?php checked( FvFunctions::ss('debug-upload', false) ); ?>/> <?php _e('Yes', 'fv') ?>
            &nbsp;<small>(This will save upload process info to Debug log. Please don't remember disable this, for do not pollute the log.)</small>
        </td>
    </tr>

</table>