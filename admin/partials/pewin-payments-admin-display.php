<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://bradb.net
 * @since      1.0.0
 *
 * @package    Pewin_Payments
 * @subpackage Pewin_Payments/admin/partials
 */
?>

<?php
if (isset($_POST['save'])) {
    // print_r($_REQUEST);
    if ($_POST['save'] === 'Save Stripe Settings') {
        update_option('stripe_secret_key', $_POST['stripe_secret_key'], true);
        update_option('stripe_publishable_key', $_POST['stripe_publishable_key'], true);
        update_option('stripe_test_secret_key', $_POST['stripe_test_secret_key'], true);
        update_option('stripe_test_publishable_key', $_POST['stripe_test_publishable_key'], true);
        update_option('stripe_test_mode', $_POST['stripe_test_mode']);
    }
    if ($_POST['save'] === 'Save Redirect Settings') {
        update_option('redirect_url', $_POST['redirect_url']);
	}
	?>
	<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
		<p><strong>Settings saved.</strong></p>
		<button type="button" class="notice-dismiss">
			<span class="screen-reader-text">Dismiss this notice.</span>
		</button>
	</div>
	<?php
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap pewin-payments-admin-form">
    <h1>Pewin Stripe Payments Integration</h1>
    <div class="metabox-holder">
    	<div class="postbox-container">
            <div class="postbox">
                <h2 class="hndle ui-sortable-handle"><span><span>Stripe Settings</span></span></h2>
                <div class="inside">
                    <form name="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" class="initial-form">
                        <div>
                            <label for="stripe_secret_key">
                                Stripe Secret Key
                            </label>
                    		<div class="input-text-wrap">
                    			<input name="stripe_secret_key" type="text" placeholder="Stripe Secret Key" value="<?php echo get_option('stripe_secret_key'); ?>">
                    		</div>
                        </div>
                        <div>
                            <label for="stripe_publishable_key">
                                Stripe Publishable Key
                            </label>
                    		<div class="input-text-wrap">
                    			<input name="stripe_publishable_key" type="text" placeholder="Stripe Publishable Key" value="<?php echo get_option('stripe_publishable_key'); ?>">
                    		</div>
                        </div>
                        <div>
                            <label for="stripe_secret_key">
                                Stripe Test Secret Key
                            </label>
                    		<div class="input-text-wrap">
                    			<input name="stripe_test_secret_key" type="text" placeholder="Stripe Test Secret Key"  value="<?php echo get_option('stripe_test_secret_key'); ?>">
                    		</div>
                        </div>
                        <div>
                            <label for="stripe_publishable_key">
                                Stripe Test Publishable Key
                            </label>
                    		<div class="input-text-wrap">
                    			<input name="stripe_test_publishable_key" type="text" placeholder="Stripe Test Publishable Key" value="<?php echo get_option('stripe_test_publishable_key'); ?>">
                    		</div>
                        </div>
                        <div>
                            <div class="input-checkbox-wrap">
                                <input name="stripe_test_mode" type="checkbox" <?php echo get_option('stripe_test_mode') ? 'checked' : ''; ?>>
                                <label for="stripe_test_mode">
                                    Enable Stripe Test Mode
                                </label>
                            </div>
                        </div>
                		<p class="submit">
                			<input name="save" class="button button-primary" value="Save Stripe Settings" type="submit">
                            <br class="clear">
                		</p>
                    </form>
    	        </div>
            </div>
        </div>
        <div class="postbox-container">
            <div class="postbox">
                <h2 class="hndle ui-sortable-handle"><span><span>Redirect Settings</span></span></h2>
                <div class="inside">
                    <form name="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" class="initial-form">
                        <div>
                            <label for="stripe_secret_key">
                                Redirect URL
                            </label>
                            <div class="input-text-wrap">
                                <input name="redirect_url" type="text" placeholder="Redirect URL" value="<?php echo get_option('redirect_url'); ?>">
                            </div>
                        </div>
                        <p class="submit">
                            <input name="save" class="button button-primary" value="Save Redirect Settings" type="submit">
                            <br class="clear">
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
