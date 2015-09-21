<table class="form-table">

    <!-- ============ Leaders Vote ============ -->
    <tr valign="top" class="no-padding">
        <td colspan="3"><h3><?php _e('Voting', 'fv') ?></h3></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Enable anti fraud system?', 'fv') ?> (beta):</th>
        <?php echo fv_get_td_tooltip_code( __('After enabling this, you can see in Votes Log fraud score', 'fv') ); ?>
        <td>
            <input type="checkbox" name="fv[anti-fraud]" <?php checked( FvFunctions::ss('anti-fraud', false) ); ?>/> <?php _e('Yes', 'fv') ?>
            &nbsp;<small>(This will add at least one query to voting process. <a target="_blank" href="http://docs.wp-vote.net/#anti-fraud-system">Read more</a>)</small>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e('Enable voting debug?', 'fv') ?>:</th>
        <?php echo fv_get_td_tooltip_code( __('Save all Unsuccessful Voting attempts to later inspect it.', 'fv') ); ?>
        <td>
            <input type="checkbox" name="fv[debug-vote]" <?php checked( FvFunctions::ss('debug-vote', false) ); ?>/> <?php _e('Yes', 'fv') ?>
            &nbsp;<small>(This will save all Unsuccessful Voting attempts with all data to Debug log. Please don't remember disable this, for do not pollute the log.)</small>
        </td>
    </tr>

</table>