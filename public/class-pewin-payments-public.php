<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bradb.net
 * @since      1.0.0
 *
 * @package    Pewin_Payments
 * @subpackage Pewin_Payments/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pewin_Payments
 * @subpackage Pewin_Payments/public
 * @author     Brad Berger <brad@bradb.net>
 */
class Pewin_Payments_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pewin-payments-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script ( 'jquery-2', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', array(), $this->version, false);
        wp_enqueue_script ( 'stripe.js', 'https://js.stripe.com/v2/', array(), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pewin-payments-public.js', array('jquery-2', 'stripe.js'), $this->version, true );

	}

	public function register_payment_form_shortcode() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . '/public/partials/pewin-payments-form-shortcode.php';
	}

}
