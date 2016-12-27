<?php

/**
 * Fired during plugin activation
 *
 * @link       https://bradb.net
 * @since      1.0.0
 *
 * @package    Pewin_Payments
 * @subpackage Pewin_Payments/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Pewin_Payments
 * @subpackage Pewin_Payments/includes
 * @author     Brad Berger <brad@bradb.net>
 */
class Pewin_Payments_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {


		global $wpdb;

		$sql = sprintf("CREATE TABLE %s (
  			id mediumint(9) NOT NULL AUTO_INCREMENT,
  			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			event VARCHAR(255) NOT NULL,
			member VARCHAR(255) NOT NULL,
			currency VARCHAR(3) NOT NULL,
			fee SMALLINT NOT NULL,
			token VARCHAR(255) NOT NULL,
			charged TINYINT(1) NOT NULL,
  			PRIMARY KEY  (id)
		) %s;", Pewin_Payment::$table, $wpdb->get_charset_collate());

		// event name, currency, registration fee and registering member name

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

	}

}
