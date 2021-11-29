<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 * @author     Harshal Sabale <harshalsabale004@gmail.com>
 */
class Wp_Book_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		$table_name = $wpdb->prefix."book_meta";
		$wpdb->query( "DROP TABLE IF EXISTS $table_name;" );
	}

	public function delete_cutom_option() {
		delete_option( 'currency' );
		delete_option( 'books_per_page' );
	}

}
