<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://bradb.net
 * @since      1.0.0
 *
 * @package    Pewin_Payments
 * @subpackage Pewin_Payments/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Pewin_Payments
 * @subpackage Pewin_Payments/includes
 * @author     Brad Berger <brad@bradb.net>
 */
class Pewin_Payments_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Get Saved page id.
				$saved_page_id = get_option( 'pewin_payments_page_id' );

				// Check if the saved page id exists.
				if ( $saved_page_id ) {

					// Delete saved page.
					wp_delete_post( $saved_page_id, true );

					// Delete saved page id record in the database.
					delete_option( 'pewin_payments_page_id' );

				}
	}

}
