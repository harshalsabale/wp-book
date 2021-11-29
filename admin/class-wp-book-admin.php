<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 * @author     Harshal Sabale <harshalsabale004@gmail.com>
 */
class Wp_Book_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-book-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-book-admin.js', array( 'jquery' ), $this->version, false );

	}


	/************************
	* Register the "Book" custom post type
	************************/
	public function cpt_book() {
		register_post_type( 'book',
			array(
				'label' => __('Book', 'wp-book'),
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'menu_position' => 5,
				'show_in_admin_bar' => true,
				'show_in_nav_menus' => true,
				'supports' => array('title','editor','thumbnail'),   // what this cpt support
				'show_in_rest' => true                               // enable gutenberg block editor for cpt
			)
		);
	}


	/************************
	* Register the "Book Category " custom Taxonomy
	************************/
	function taxonomy_book_category() {
		$labels = array(
			'name' => _x( 'Categories', 'wp-book'),
			'singular_name' => _x( 'Category', 'wp-book'),
			'search_items'      => __( 'Search Category', 'wp-book' ),
			'all_items'         => __( 'All Categories', 'wp-book' ),
			'parent_item'       => __( 'Parent Category', 'wp-book' ),
			'parent_item_colon' => __( 'Parent Category:', 'wp-book' ),
			'edit_item'         => __( 'Edit Category', 'wp-book' ),
			'update_item'       => __( 'Update Category', 'wp-book' ),
			'add_new_item'      => __( 'Add New Category', 'wp-book' ),
			'new_item_name'     => __( 'New Book Category', 'wp-book' ),
			'menu_name'         => __( 'Book Category', 'wp-book' ),
		);
		$args = array(
			'hierarchical'      => true, // make it hierarchical (like categories)
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'book_category' ],
		);
		register_taxonomy( 'Book Category', [ 'book' ], $args );
	}



}
