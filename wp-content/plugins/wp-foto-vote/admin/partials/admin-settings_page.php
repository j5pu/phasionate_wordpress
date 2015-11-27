<?php
defined('ABSPATH') or die("No script kiddies please!");

$settings_tabs = array(
    "general" => __("General", 'fv'),
    "voting" => __("Voting", 'fv'),
    "upload" => __("Upload", 'fv'),
    "upload_notify" => __("Upload notify", 'fv'),
    "additional" => __("Additional", 'fv'),
);

?>

<div class="wrap" id="fv-setting-page">
	<h2>WP Foto Vote settings <small>Circled tooltip box with blue color - are important</small></h2>

	<?php
	if (isset($_REQUEST['clear'])) {
		echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>' .
		__('Data deleted. Reactivate plugin!', 'fv') .
		'</strong></p></div>';
	}

	?>
    <div id="fv-settings-updated" class="updated settings-error" style="display: none;">
        <p>
            <strong><?php _e('Configuration saved.', 'fv') ?></strong>
        </p>
    </div>

    <div class="fv_content_wrapper">

		<div class="fv_content_cell fv-tabs" id="fv-content">
            <form method="post" action="options.php" onsubmit="fv_save_settings(this); return false;">
                <?php settings_fields('fotov-settings-group'); ?>
                <!-- Tabs -->
                <nav>
                    <ul class="fv-tabs-navigation">
                        <?php foreach ($settings_tabs as $group_slug => $group_name) : ?>
                            <li><a href="#<?php echo $group_slug; ?>" data-content="<?php echo $group_slug; ?>" class="<?php echo ($group_slug == 'general') ? 'selected' : ''; ?>">
                                    <?php echo $group_name; ?>
                                </a></li>
                        <?php endforeach; ?>
                    </ul> <!-- fv-tabs-navigation -->
                </nav>

                <!-- Tabs content / Generate ul list with tables for tabbed navigation -->
                <ul class="fv-tabs-content">
                    <?php foreach ($settings_tabs as $group_slug => $group_name) : ?>
                        <li data-content="<?php echo $group_slug; ?>" class="<?php echo ($group_slug == 'general') ? 'selected' : ''; ?>">
                            <?php include_once "settings/_tab_{$group_slug}.php"; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save all Changes', 'fv') ?>" />
				</p>
			</form>

			<?php if (current_user_can('install_plugins')): ?>
				<a onclick="return confirm('<?php _e('Are you sure to delete all contests & photos & votes data from database?', 'fv') ?>');" href="<?php echo admin_url('admin.php?page=fv-settings&action=clear'); ?>"><?php _e('Clear all plugin data in database.', 'fv') ?></a>
            <?php endif; ?>
		</div>  <!-- #fv_content :: END -->

		<div class="fv_content_cell" id="fv-sidebar">
            <?php include('_sidebar.php') ?>
        </div><!-- #fv-sidebar :: END -->


	</div>  <!-- .fv_content_wrapper :: END -->

	<style type="text/css">
        h2 small {
            font-size: 12px;
            color: #2ea2cc;
        }

		td.socials span {
			width: 120px;
			display: inline-block;
		}
		td.upload-additionals span {
			width: 110px;
			display: inline-block;
		}

        td.colorpicker {
            line-height: 35px;
        }

        .important .box .dashicons {
            color: #2ea2cc;
        }

		.box {
			width: 25px;
			float: right;
			height: 100%;
		}
		.tooltip {
			width: 25px;
		}
		.no-padding, .no-padding td {
			padding: 0;        
		}
		.no-padding h3 {
			margin: 5px 0;
			padding: 0 0 0 10px;
		}
		.dashicons-info:before {
			content: "\f348";
		}
		.fv_content_wrapper {
			display: table;
			width: 100%;
		}

		.fv_content_cell {
			display: table-cell;
			padding: 0;
			margin: 0;
			vertical-align: top;
		}

		#fv-content {
			min-width: 400px;
		}

		#fv-sidebar {
			display: none;
            width: 0;
		}
        @media only screen and (min-width: 960px) {
            #fv-sidebar {
                display: block;
                width: 270px;
                padding: 0 0 0 10px;
            }
        }
		#fv-sidebar .inside {
			margin: 6px 0 0;
		}
		#fv-sidebar h3 {
			font-size: 14px;
			padding: 8px 12px;
			margin: 0;
			line-height: 1.4;
		}
		.gadash-title {
			float: left;
			margin-right: 10px;
			margin-top: 2px;
		}

	</style>

</div>