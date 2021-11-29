<?php

/**
 * Fired during plugin activation
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 * @author     Harshal Sabale <harshalsabale004@gmail.com>
 */
class Wp_Book_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		global $wpdb;

		$this->intialize_options();

		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix."book_meta";

		if( count( $wpdb->get_var( "show tables like '$table_name'")) == 0 ) {
			$schema = "CREATE TABLE $table_name (
				meta_id bigint(20) Not Null AUTO_INCREMENT,
				book_id bigint(20) Not Null Default '0',
				meta_key varchar(255) Default Null,
				meta_value longtext,
				PRIMARY KEY(meta_id)
			) $charset_collate;" ;
			
			dbDelta( $schema );
	
			$wpdb->book_meta = $wpdb->prefix."book_meta";
		}

		ob_clean();
	}

	public function intialize_options() {
		add_option( 'currency', 'rs' );
		add_option( 'books_per_page', '10' );
	}

}
