<?php
defined('ABSPATH') or die("No script kiddies please!");
//data-history="false"
?>

<div id="modal-widget" >
    <h2>Share</h2>
    <!-- Notify block -->
    <div class="sw-message-box">
        <span class="sw-message-title"><span class="fvicon-spinner2 icon rotate-animation"></span> Voting</span>
        <span class="sw-message-text"></span>
    </div>

    <div class="sw-body hd-widget-body">
        <div class="sw-share">
            <div class="slogan"></div>
            <?php if (!get_option('fotov-voting-noshow-social', false)): ?>
                <ul class="sw-options">
                    <?php if (!get_option('fotov-voting-noshow-fb', false)): ?>
                        <li class="sw-facebook" title="" onclick="return sv_vote_send('fb', this);">
                            <span class="sw-share-button fvicon-facebook"></span>
                            <span class="sw-action"><?php _e("Post", "fv") ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if (!get_option('fotov-voting-noshow-tw', false)): ?>
                        <li class="sw-twitter" onclick="return sv_vote_send('tw', this);">
                            <span class="sw-share-button fvicon-twitter"></span>
                            <span class="sw-action"><?php _e("Tweet", "fv") ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if (!get_option('fotov-voting-noshow-gp', false)): ?>
                        <li class="sw-google-plus " onclick="return sv_vote_send('gp', this);">
                            <span class="sw-share-button fvicon-googleplus3"></span>
                            <span class="sw-action"><?php _e("Post", "fv") ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if (!get_option('fotov-voting-noshow-pi', false)): ?>
                        <li class="sw-pinterest" onclick="return sv_vote_send('pi', this);">
                            <span class="sw-share-button fvicon-pinterest3"></span>
                            <span class="sw-action"><?php _e("Pin it", "fv") ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if (!get_option('fotov-voting-noshow-vk', false)): ?>
                        <li class="sw-vk" onclick="return sv_vote_send('vk', this);">
                            <span class="sw-share-button fvicon-vk2"></span>
                            <span class="sw-action">Поделиться</span>
                        </li>
                    <?php endif; ?>
                    <?php if (!get_option('fotov-voting-noshow-ok', false)): ?>
                        <li class="sw-ok" onclick="return sv_vote_send('ok', this);">
                            <span class="sw-share-button">OK</span>
                            <span class="sw-action">Поделиться</span>
                        </li>
                    <?php endif; ?>
                    <?php if (!get_option('fotov-voting-noshow-email', false)): ?>
                        <li class="sw-email" onclick="FvModal.goEmailShare();return false;">
                            <span class="sw-share-button fvicon-envelope2"></span>
                            <span class="sw-action">Email</span>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>

            <div class="sw-link">
                <input data-url="<?php echo $page_url ?>=" id="photo_id" value="">
            </div>

        </div>
        <!-- END :: SHARE ICONS -->

        <!-- SUBSCRIBE FORM -->
        <div class="sw-subscribe">
            <div class="sw-subscribe-form">
                    <div class="frm-row">
                        <span class="frm-field">
                            <em class="frm-error-text"></em>
                            <label class="frm-field-label" for="stg-first-name"><?php echo $public_translated_messages['form_subsr_name'] ?></label>
                            <span class="frm-input">
                                <input id="stg-name" name="fv_name" class="fv_name" type="text" tabindex="1" maxlength="40" value="" pattern=".{2,20}">
                            </span>
                        </span>
                    </div>
                    <div class="frm-row">
                        <span class="frm-field">
                            <em class="frm-error-text"></em>
                            <label class="frm-field-label" for="stg-email"><?php echo $public_translated_messages['form_subsr_email'] ?></label>
                            <span class="frm-input">
                                <input id="stg-email" type="email" name="fv_email" class="fv_email" tabindex="2" value="" pattern=".{5,30}">
                            </span>
                        </span>
                    </div>
                  <div class="frm-row">
                        <span class="frm-field">
                            <button type="button" onclick="fvCheckSubscribeFormAndVote();"><?php echo $public_translated_messages['vote_button_text']; ?></button>
                        </span>
                  </div>
            </div>
        </div>
        <!-- END :: SUBSCRIBE FORM -->

        <!-- SUBSCRIBE FORM -->
        <div class="sw-fb-vote">
            <ul class="sw-options">
                <li class="sw-facebook" title="" onclick='sv_vote_send("fb", null, fv_current_id, true);'>
                    <span class="sw-share-button fvicon-facebook"></span>
                    <span class="sw-action"><?php _e("Share and vote", "fv") ?></span>
                </li>

            </ul>
        </div>
        <!-- END :: SUBSCRIBE FORM -->


        <!-- SOCIAL AUTHORIZATION -->
        <div class="sw-social-authorization">
                <ul class="sw-options">
                    <?php if (!get_option('fotov-voting-noshow-fb', false)): ?>
                        <li class="sw-facebook" title="" onclick="fv_soc_autorization('fb', this); return false;">
                            <span class="sw-share-button fvicon-facebook"></span>
                            <span class="sw-action">Login</span>
                        </li>
                    <?php endif; ?>
                    <?php if (!get_option('fotov-voting-noshow-tw', false)): ?>
                        <li class="sw-twitter" onclick="fv_soc_autorization('tw', this); return false;">
                            <span class="sw-share-button fvicon-twitter"></span>
                            <span class="sw-action">Login</span>
                        </li>
                    <?php endif; ?>
                    <?php if (!get_option('fotov-voting-noshow-gp', false)): ?>
                        <li class="sw-google-plus" onclick="fv_soc_autorization('gp', this); return false;">
                            <span class="sw-share-button fvicon-googleplus3"></span>
                            <span class="sw-action">Login</span>
                        </li>
                    <?php endif; ?>
                    <?php if (!get_option('fotov-voting-noshow-vk', false)): ?>
                        <li class="sw-vk" onclick="fv_soc_autorization('vk', this); return false;">
                            <span class="sw-share-button fvicon-vk2"></span>
                            <span class="sw-action">Вход</span>
                        </li>
                    <?php endif; ?>
                    <?php if (!get_option('fotov-voting-noshow-ok', false)): ?>
                        <li class="sw-ok" onclick="fv_soc_autorization('ok', this); return false;">
                            <span class="sw-share-button">OK</span>
                            <span class="sw-action">Вход</span>
                        </li>
                    <?php endif; ?>
                    <!--<li class="sw-email">
                            <span class="sw-share-button"></span>
                            <span class="sw-action">Email</span>
                    </li>-->
                </ul>



        </div>
        <!-- END :: SOCIAL AUTHORIZATION -->

        <!-- EMPTY AREA -->
        <div class="sw-empty"></div>
        <!-- END :: EMPTY AREA -->


        <div class="sw-email-share">
            <div class="sw-email-form">
                <div class="frm-row">
                        <span class="frm-field-half frm-field">
                            <em class="frm-error-text"></em>
                            <label class="frm-field-label" for="stg-first-name"><?php echo $public_translated_messages['form_share_name'] ?></label>
                            <span class="frm-input">
                                <input id="stg-name" class="fv_share_name" type="text" tabindex="1" maxlength="40" value="" pattern=".{2,20}">
                            </span>
                        </span>
                        <span class="frm-field-half frm-field">
                            <em class="frm-error-text"></em>
                            <label class="frm-field-label" for="stg-email"><?php echo $public_translated_messages['form_share_email'] ?></label>
                            <span class="frm-input">
                                <input id="stg-email" type="email" class="fv_share_email" tabindex="2" value="" autocomplete="true" pattern=".{5,30}">
                            </span>
                        </span>
                </div>
                <div>
                    <label class="frm-field-label" for="sw-email-share-to"><?php echo $public_translated_messages['form_share_emails_to'] ?></label>
                    <textarea id="sw-email-share-to" tabindex="3" rows="5" cols="22" spellcheck="false"></textarea>
                    <em class="frm-error-text"></em>
                </div>

                <div class="clearfix"> </div>
                <div class="g-recaptcha" id="sw-email-share-g-recaptcha"></div>
                <div class="clearfix"> </div>

                <!--<label class="sw-email-copy"><input type="checkbox">Send me a copy</label>-->
                <span class="sw-email-send sw-button hd-widget-button" tabindex="4" onclick="fvCheckEmailShareFormAndSubmit();">
                    <span id="fv_upload_preloader"> <span class="fvicon-spinner icon rotate-animation"></span> </span>
                    <?php echo $public_translated_messages['form_share_submit'] ?>
                </span>
            </div>
        </div>

        <!-- EMPTY AREA -->
        <div class="sw-vote-recaptcha">
            <div class="clearfix"> </div>
            <div class="g-recaptcha" id="sw-vote-g-recaptcha"></div>
            <div class="clearfix"> </div>
        </div>
        <!-- END :: EMPTY AREA -->

    </div>

    <span class="modal-widget-close fvicon-close"></span>
</div>

<?php if ($contest->security_type == "defaultAsocial" || $contest->security_type == "cookieAsocial"): ?>
    <script src="//ulogin.ru/js/ulogin.js"></script>

    <div class="uLogin"
         data-ulogin="display=panel;sort=default;fields=first_name,email;providers=vkontakte,twitter,google,odnoklassniki,facebook;hidden=other;redirect_uri=;callback=ulogin_data"></div>
<?php endif; ?>

<div id="fb-root"></div>

