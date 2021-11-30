<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 * @author     Harshal Sabale <harshalsabale004@gmail.com>
 */
class Wp_Book_Public {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-book-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-book-public.js', array( 'jquery' ), $this->version, false );

	}


	public function render_content_book( $content ) {
		$currency = get_option( 'currency' );

		$book_id = get_the_ID(  );
		$price = intval($this-> get_book_meta( $book_id, '_book_price', true ) );

		if( $currency == 'usd' ) {
			$price =  round( $price / 75.12, 2 );
		}
		if( is_singular( ) && in_the_loop() && is_main_query( ) && ! is_page( ) ) {
			return $content . "<br> <h5> Price: ". strtoupper($currency)." ". $price ." </h5>";
		}
		return $content;
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

	/*******************
	* Create a shortcode [book] to display the book(s) information.
	*******************/
	public function book_shortcode( $atts ) {
		if( ! is_page() ) return;
		$str = '';
		$books_per_page = intval(get_option( 'books_per_page' ));
		$posts = get_posts( [
			'post_type' => 'book',
			'numberposts' => $books_per_page
		] );
		foreach( $posts as $post ) {
			$category = '';
			$tags = '';
			$taxonomies = get_taxonomies( '', 'names' );
			$terms =  wp_get_post_terms( $post->ID, $taxonomies );

			foreach( $terms as $term ) {
				if(is_taxonomy_hierarchical( $term->taxonomy )) {
					$category .= $term->name . ", ";
				}
				else {
					$tags .= $term->name. ", ";
				}
			}

			$a = shortcode_atts( array(
				'id' => $post->ID,
				'author_name' => $this->get_book_meta( $post->ID, '_book_author', true ),
				'year' => $this->get_book_meta( $post->ID, '_book_year', true ),
				'category' => $category,
				'tag' => $tags,
				'publisher' => $this->get_book_meta( $post->ID, '_book_publisher', true )
			), $atts);
			$str .= "<table><tr>
					<td>ID :</td> <td>{$a['id']}</td>
				</tr>
				<tr>
					<td>Author Name :</td> <td>{$a['author_name']}</td>
				</tr>
				<tr>
					<td>Year :</td> <td>{$a['year']}</td>
				</tr>
				<tr>
					<td>Publisher :</td> <td>{$a['publisher']}</td>
				</tr>
				<tr>
					<td>Category :</td> <td>{$a['category']}</td>
				</tr>
				<tr>
					<td>Tags :</td> <td>{$a['tag']}</td>
				</tr>
				</table>";
		}
		return $str;
	}

	public function register_book_shortcode() {
		add_shortcode( 'book', array( $this, 'book_shortcode' ) );
	}



}
