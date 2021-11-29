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


	/************************
	* Register the "Book Tag " custom Taxonomy
	************************/
	function taxonomy_book_tag() {
		$labels = array(
			'name' => _x( 'Tags', 'wp-book' ),
			'singular_name' => _x( 'Tag', 'wp-book' ),
			'search_items'      => __( 'Search Tags', 'wp-book' ),
			'all_items'         => __( 'All Tags', 'wp-book' ),
			'edit_item'         => __( 'Edit Tag', 'wp-book' ),
			'update_item'       => __( 'Update Tag', 'wp-book' ),
			'add_new_item'      => __( 'Add New Tag', 'wp-book' ),
			'new_item_name'     => __( 'New Tag Name', 'wp-book' ),
			'menu_name'         => __( 'Book Tag', 'wp-book' ),
		);
		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'book_tag' ],
		);
		register_taxonomy( 'Book Tag', [ 'book' ], $args );
	}

	public function meta_box_book() {
		add_meta_box( 'book_meta_author', __( 'Book Author', 'wp-book' ), array( $this, 'meta_box_html_author' ), 'book', 'side' );
		add_meta_box( 'book_meta_price', __( 'Book Price', 'wp-book' ), array( $this, 'meta_box_html_price' ), 'book', 'side' );
		add_meta_box( 'book_meta_Publisher', __( 'Book Publisher', 'wp-book' ), array( $this, 'meta_box_html_publisher' ), 'book', 'side' );
		add_meta_box( 'book_meta_year', __( 'Book Year', 'wp-book' ), array( $this, 'meta_box_html_year' ), 'book', 'side' );
		add_meta_box( 'book_meta_edition', __( 'Book Edition', 'wp-book' ), array( $this, 'meta_box_html_edition' ), 'book', 'side' );
		add_meta_box( 'book_meta_url', __( 'Book URL', 'wp-book' ), array( $this, 'meta_box_html_url' ), 'book', 'side' );
	}

	public function meta_box_html_author( $post ) {
		$author = $this->get_book_meta( $post->ID, '_book_author', true );
		echo '<label for="author">'.
				_e( "Enter Author Name: " )
			.'</label>
			<input type="text" id="author" name="author" value="'. esc_attr( $author ).' "/>';
	}

	public function meta_box_html_price( $post ) {
		$price = $this->get_book_meta( $post->ID, '_book_price', true );
		echo '<label for="price">'.
				_e( "Enter Book Price (in Rupees): " )
			.'</label>
			<input type="text" id="price" name="price" value="'. esc_attr( $price ).' "/>';
	}

	public function meta_box_html_publisher( $post ) {
		$publisher = $this->get_book_meta( $post->ID, '_book_publisher', true );
		echo '<label for="publisher">'.
				_e( "Enter Publisher: " )
			.'</label>
			<input type="text" id="publisher" name="publisher" value="'. esc_attr( $publisher ).' "/>';
	}

	public function meta_box_html_year( $post ) {
		$year = $this->get_book_meta( $post->ID, '_book_year', true );
		echo '<label for="year">'.
				_e( "Enter Year of Publication: " )
			.'</label>
			<input type="text" id="year" name="year" value="'. esc_attr( $year ).' "/>';
	}

	public function meta_box_html_edition( $post ) {
		$edition = $this->get_book_meta( $post->ID, '_book_edition', true );
		echo '<label for="edition">'.
				_e( "Enter Edition: " )
			.'</label>
			<input type="text" id="edition" name="edition" value="'. esc_attr( $edition ).' "/>';
	}

	public function meta_box_html_url( $post ) {
		$url = $this->get_book_meta( $post->ID, '_book_url', true );
		echo '<label for="url">'.
				_e( "Enter URL: " )
			.'</label><br/>
			<input type="text" id="url" name="url" value="'. esc_attr( $url ).' "/>';
	}

	public function get_book_meta( $id, $meta_key, $single=true ) {
		global $wpdb;
		$table_name = $wpdb->prefix."book_meta";
		$meta_value = $wpdb->get_row( "SELECT meta_value FROM $table_name WHERE book_id = $id AND meta_key = '$meta_key'" );
		$meta_value = json_decode( json_encode( $meta_value ), true );
		if (gettype( $meta_value ) != 'NULL') {
			return $meta_value['meta_value'];
		}
		return '';
	}

	public function update_book_meta( $id, $meta_key, $value='' ) {
		global $wpdb;
		$table_name = $wpdb->prefix."book_meta";
		$meta_key_exists = $this->get_book_meta( $id, $meta_key, true );
		if ( $meta_key_exists == '' ) {
			$execute = $wpdb->query( $wpdb->prepare( "INSERT INTO $table_name ( meta_id, book_id, meta_key, meta_value ) values ( Null, $id, '$meta_key', '$value' ) ;" ) );
		}
		else {
			$execute = $wpdb->query( $wpdb->prepare( "UPDATE $table_name SET meta_value = '$value' WHERE book_id = $id AND meta_key = '$meta_key' ;" ) );
		}
	}



	/*******************
	* Save Post metadata
	*******************/
	function save_book_meta_data( $post_id ) {
		if ( array_key_exists( 'author', $_POST ) ) {
			$author = sanitize_text_field( $_POST['author'] );
			$this->update_book_meta( $post_id, '_book_author', $author );
		}
		if ( array_key_exists( 'price', $_POST ) ) {
			$price = sanitize_text_field( $_POST['price'] );
			$this->update_book_meta( $post_id, '_book_price', $price );
		}
		if ( array_key_exists( 'publisher', $_POST ) ) {
			$publisher = sanitize_text_field( $_POST['publisher'] );
			$this->update_book_meta( $post_id, '_book_publisher', $publisher );
		}
		if ( array_key_exists( 'year', $_POST ) ) {
			$year = sanitize_text_field( $_POST['year'] );
			$this->update_book_meta( $post_id, '_book_year', $year );
		}
		if ( array_key_exists( 'edition', $_POST ) ) {
			$edition = sanitize_text_field( $_POST['edition'] );
			$this->update_book_meta( $post_id, '_book_edition', $edition );
		}
		if ( array_key_exists( 'url', $_POST ) ) {
			$url = sanitize_text_field( $_POST['url'] );
			$this->update_book_meta( $post_id, '_book_url', $url );
		}
	}

}
