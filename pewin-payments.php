<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bradb.net
 * @since             1.0.0
 * @package           Pewin_Payments
 *
 * @wordpress-plugin
 * Plugin Name:       Pewin Stripe Payments Form
 * Plugin URI:        https://github.com/bradberger/pewin-payments
 * Description:       The Pewin Stripe Payments Plugin integrates payment form powered by Stripe.
 * Version:           1.0.0
 * Author:            Brad Berger
 * Author URI:        https://bradb.net
 * License:           Unlicensed
 * License URI:       
 * Text Domain:       pewin-payments
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pewin-payments-activator.php
 */
function activate_pewin_payments() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pewin-payments-activator.php';
	Pewin_Payments_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pewin-payments-deactivator.php
 */
function deactivate_pewin_payments() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pewin-payments-deactivator.php';
	Pewin_Payments_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pewin_payments' );
register_deactivation_hook( __FILE__, 'deactivate_pewin_payments' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pewin-payments.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pewin_payments() {

	$plugin = new Pewin_Payments();
	$plugin->run();

}
run_pewin_payments();
