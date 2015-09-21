<div class="meta-box-sortables">
    <div id="fv_votes_workplace" class="postbox ">
        <div id="box-vote-settings" class="handlediv" title="Нажмите, чтобы переключить"><br></div>
        <h3 class="hndle"><span><?php echo __('Vote / design settings', 'fv') ?></span></h3>
        <div class="inside">
            <div id="sv_wrapper" class="b-wrap">

                <fieldset>
                    <div class="row">
                        <div class="form-group col-sm-8">
                                <label><i class="fvicon fvicon-share"></i> <?php echo __('Title contest for soc. networks ', 'fv') ?>
                                    <?php fv_get_tooltip_code(__('*name* will be replaced by name of the contestant.<br /> Only works for Vkontakte, Twitter and Pinterest, <br /> others socials take title from title page. <br /> <br /> If not specified - the name of the contestant taken', 'fv')) ?>
                                </label>
                                <input type="text" name="fv_social_title" class="form-control" value="<?php echo ($action == 'add') ? '' : stripcslashes($contest->soc_title) ?>">
                        </div>
                        <div class="form-group col-sm-8">
                                <label><?php echo __('Description contest for soc. networks', 'fv') ?>
                                    <?php fv_get_tooltip_code(__('*name* will be replaced by name of the contestant.<br /> Only works for Vkontakte and Twitter<br /> take the rest of the description of the description page. <br /> <br /> If not specified - soc. networks use at its discretion', 'fv')) ?>
                                </label>
                                <input type="text" name="fv_social_descr" class="form-control" value="<?php echo ($action == 'add') ? '' : stripcslashes($contest->soc_description) ?>">
                        </div><!-- .misc-pub-section -->

                        <div class="form-group col-sm-8">
                                <label><?php echo __('Picture for social networks', 'fv') ?>
                                    <?php fv_get_tooltip_code(__('Only works for Vkontakte and Pinterest.<br /><br /> If not specified - is taken from field `Image`', 'fv')) ?>
                                </label>
                                <input type="text" name="fv_social_photo" class="form-control" value="<?php echo ($action == 'add') ? '' : $contest->soc_picture ?>">
                        </div><!-- .misc-pub-section -->

                    </div>

                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label for="fv_timer">
                                <i class="fvicon fvicon-stopwatch"></i> </span><?php echo __('Timer', 'fv') ?>
                                <?php fv_get_tooltip_code(__('If you want show countdown timer, check this option', 'fv')) ?>
                            </label>
                            <select id="fv_timer" name="fv_timer" class="form-control">
                                <option value="no" <?php ( isset($contest->id) )? selected('no', $contest->timer) : ''?>> <?php _e('No show', 'fv') ?></option>
                                <?php foreach ($countdowns as $key => $countdown_title): ?>
                                    <option value="<?php echo $key ?>" <?php ( isset($contest->id) )?  selected($key, $contest->timer): ''; ?>><?php echo $countdown_title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-8">
                            <label for="lightbox_theme"><?php echo __('Lightbox theme', 'fv'); ?></label>
                            <select id="lightbox_theme" name="lightbox_theme" class="form-control">
                                <?php foreach (FvFunctions::getLightboxArr() as $lightbox => $theme_title): ?>
                                    <option value="<?php echo $lightbox ?>" <?php ( isset($contest->id) )? selected($lightbox, $contest->lightbox_theme): '' ?>><?php echo $theme_title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-8">
                            <label for="sorting"><?php echo __('Photo sorting', 'fv'); ?> <?php fv_get_tooltip_code(__('Output order of pictures on the page', 'fv')) ?></label>
                            <select id="sorting" name="sorting" class="form-control">
                                <?php foreach (fv_get_sotring_types_arr() as $key => $sort_title): ?>
                                    <option value="<?php echo $key ?>" <?php ( isset($contest->id) )?  selected($key, $contest->sorting): ''; ?>><?php echo $sort_title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div><legend><?php _e('Voting', 'fv') ?></legend></div>
                    <div class="row">

                         <div class="form-group col-sm-8">
                             <label><i class="fvicon fvicon-calendar"></i>
                                <?php echo __('Date start', 'fv'); ?>
                             </label>
                            <input type="text" class="datetime form-control" id="date_start" name="date_start" value="<?php echo ($action == 'add') ? date("Y-m-d H:i:s", time()) : $contest->date_start ?>">
                            <small><?php echo __('year-month-day h:m:s', 'fv') ?></small>

                        </div>

                        <div class="form-group col-sm-8">
                            <label><i class="fvicon fvicon-calendar"></i>
                                <?php echo __('Date finish', 'fv'); ?>
                                <?php fv_get_tooltip_code(__('When time ends, vote buttons will be hidden,<br/> and user can only see results', 'fv')) ?>
                            </label>
                            <input type="text" class="datetime form-control" id="date_finish" name="date_finish" value="<?php echo ($action == 'add') ? date("Y-m-d H:i:s", time() + 1209600) : $contest->date_finish ?>">
                            <small><?php echo __('year-month-day h:m:s', 'fv') ?></small>

                        </div>

                        <div class="form-group col-sm-8">
                            <label for="fv_voting_frequency">
                                <i class="fvicon fvicon-history"></i> <?php _e('Frequency of voting', 'fv') ?> <?php fv_get_tooltip_code(__('Select type of voting - how many user can vote in contest', 'fv')) ?>
                            </label>
                            <select id="fv_voting_frequency" name="fv_voting_frequency" class="form-control">
                                <option value="once" <?php ( isset($contest->id) )? selected('once', $contest->voting_frequency): '' ?>><?php _e('Once for one photo for all time', 'fv') ?></option>
                                <option value="onceF2" <?php ( isset($contest->id) )? selected('onceF2', $contest->voting_frequency) : ''?>><?php _e('Once for 2 photos for all time', 'fv') ?></option>
                                <option value="onceF3" <?php ( isset($contest->id) )? selected('onceF3', $contest->voting_frequency) : ''?>><?php _e('Once for 3 photos for all time', 'fv') ?></option>
                                <option value="onceF10" <?php ( isset($contest->id) )? selected('onceF10', $contest->voting_frequency) : ''?>><?php _e('Once for 10 photos for all time', 'fv') ?></option>
                                <option value="onceFall" <?php ( isset($contest->id) )? selected('onceFall', $contest->voting_frequency): '' ?>><?php _e('For each photo once', 'fv') ?></option>
                                <option value="24hFonce" <?php ( isset($contest->id) )? selected('24hFonce', $contest->voting_frequency): '' ?>><?php _e('For one photo once for 24 hours', 'fv') ?></option>
                                <option value="24hF2" <?php ( isset($contest->id) )? selected('24hF2', $contest->voting_frequency): '' ?>><?php _e('For 2 photos once for 24 hours', 'fv') ?></option>
                                <option value="24hF3" <?php ( isset($contest->id) )? selected('24hF3', $contest->voting_frequency): '' ?>><?php _e('For 3 photos once for 24 hours', 'fv') ?></option>
                                <option value="24hFall" <?php ( isset($contest->id) )? selected('24hFall', $contest->voting_frequency): '' ?>><?php _e('For all photos once for 24 hours', 'fv') ?></option>
                                <?php do_action('fv/admin/contest_settings/voting_frequency', $contest); ?>
                            </select>
                            <small><?php _e('how ofter user can vote', 'fv') ?></small>
                        </div>

                        <div class="clear"></div>

                    </div>

                </fieldset>


                <div class="form-group">
                        <span class="dashicons dashicons-shield-alt"></span> <label for="fv_security_type"><?php echo __('Contest security type', 'fv') ?>
                            <?php fv_get_tooltip_code(__('Select - how secure contest voting process?', 'fv')) ?></label>
                        <?php //defaultArecapcha  defaultAregistered ?>
                        <select id="fv_security_type" name="fv_security_type" class="pure-input">
                            <option value="default" <?php ( isset($contest->id) )? selected('default', $contest->security_type) : ''?>>IP + cookies + evercookie</option>
                            <option value="defaultArecaptcha" <?php ( isset($contest->id) )? selected('defaultArecaptcha', $contest->security_type): '' ?>>IP+cookies+evercookie + Recaptcha (required Recaptcha KEY)</option>
                            <option value="cookieArecaptcha" <?php ( isset($contest->id) )? selected('cookieArecaptcha', $contest->security_type): '' ?>>cookies+evercookie + Recaptcha (required Recaptcha KEY)</option>
                            <option value="defaultAsubscr" <?php ( isset($contest->id) )? selected('defaultAsubscr', $contest->security_type): '' ?>>IP+cookies+evercookie + Subscribe form</option>
                            <option value="defaultAfb" <?php ( isset($contest->id) )? selected('defaultAfb', $contest->security_type): '' ?>>IP+cookies+evercookie + Facebook Share (required FB app ID)</option>
                            <option value="defaultAsocial" <?php ( isset($contest->id) )? selected('defaultAsocial', $contest->security_type): '' ?>>IP+cookies+evercookie + Social autorization</option>
                            <option value="cookieAsocial" <?php ( isset($contest->id) )? selected('cookieAsocial', $contest->security_type): '' ?>>cookies+evercookie+ Social autorization</option>
                            <option value="cookieAregistered" <?php ( isset($contest->id) )? selected('cookieAregistered', $contest->security_type): '' ?>>cookies+evercookie + Autorized user</option>
                            <?php do_action('fv/admin/contest_settings/security_type', $contest); ?>
                        </select>
                </div>

            </div>
        </div>
    </div>
</div>